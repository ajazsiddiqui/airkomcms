<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use User\Entity\User;
use Masters\Entity\CallType;
use Masters\Entity\TravelType;

class ReportsController extends AbstractActionController
{
    private $authService;
    private $entityManager;
    private $logManager;
    private $ExtranetUtilities;
    private $airkom;
    private $BookingUtilities;

    public function __construct($authService, $entityManager, $logManager, $ExtranetUtilities, $airkom)
    {
        $this->authService = $authService;
        $this->entityManager = $entityManager;
        $this->logManager = $logManager;
        $this->ExtranetUtilities = $ExtranetUtilities;
        $this->airkom = $airkom;
    }
	
    public function indexAction()
    {
		$request = $this->getRequest();

        $post = $request->getPost()->toArray();

		$selectedUser = !empty($post['s_user'])?$post['s_user']:'';
		$selectedDate = !empty($post['s_daterange'])?$post['s_daterange']:'';

		$user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['email' => $this->authService->getIdentity()]);
			
		$query = $this->entityManager->createQueryBuilder()->select('P, P.id, P.contact, P.sptId, MAX(P.stage) AS stage')
            ->from('Application\Entity\Pipeline', 'P')
            ->groupBy("P.sptId")
            ->addOrderBy('P.id', 'ASC');
			
		if($user->getUserType() == 1){
			$users = $this->entityManager->getRepository(User::class)
            ->findBy([], ['fullName' => 'ASC']);
		}else{
			$users = $this->entityManager->getRepository(User::class)
            ->findBy(['id'=>$user->getId()]);
		}
						
		$calltypes = $this->entityManager->getRepository(CallType::class)
            ->findAll();
		
		$traveltypes = $this->entityManager->getRepository(TravelType::class)
            ->findAll();
			
		
		$calls_array = [];
		$travels_array = [];
		$distance_array = [];
		$sales_array = [];
		
		$post = $this->getRequest()->getPost()->toArray();
		
		if($post){
			$query = $this->entityManager->createQueryBuilder()->select('D')
				->from('Application\Entity\Dcr', 'D');
			if (!empty($post['s_daterange'])) {
				$dates = explode(" - ", $post['s_daterange']);
				$startdate = $this->ExtranetUtilities->makeDBDate($dates[0]);
				$enddate = $this->ExtranetUtilities->makeDBDate($dates[1]);

				$query->AndWhere('D.dateCreated >= :startdate')
					->setParameter('startdate', $startdate);
				$query->AndWhere('D.dateCreated <= :enddate')
					->setParameter('enddate', $enddate);
				$query->AndWhere('D.createdBy = :createdBy')
					->setParameter('createdBy', $selectedUser);
			
				$dcr = $query->getQuery()->getArrayResult();
				
				$sptquery = $this->entityManager->createQueryBuilder()->select('S')
						->from('Application\Entity\Spt', 'S');
				$sptquery->AndWhere('S.dateCreated >= :startdate')
					->setParameter('startdate', $startdate);
				$sptquery->AndWhere('S.dateCreated <= :enddate')
					->setParameter('enddate', $enddate);
				$sptquery->AndWhere('S.createdBy = :createdBy')
					->setParameter('createdBy', $selectedUser);
			
				$spt = $sptquery->getQuery()->getArrayResult();
		
				foreach ($calltypes as $c){
					$calls = array_count_values(array_column($dcr, 'callType'));
					$calls_array[$c->getName()]['target'] = $this->ExtranetUtilities->getTargetByUser($selectedUser, $c->getId());
					$calls_array[$c->getName()]['performed'] = isset($calls[$c->getId()])?$calls[$c->getId()]:0;
					$calls_array[$c->getName()]['efficiency'] = @($calls_array[$c->getName()]['performed'] / $calls_array[$c->getName()]['target']) * 100;
				}
				$calls_array['uptodate_call_efficiency']['target'] = array_sum(array_column($calls_array,'target'));
				$calls_array['uptodate_call_efficiency']['performed'] = array_sum(array_column($calls_array,'performed'));
				//$calls_array['uptodate_call_efficiency']['efficiency'] = array_sum(array_column($calls_array,'efficiency'));
				$calls_array['uptodate_call_efficiency']['efficiency'] = round($calls_array['uptodate_call_efficiency']['performed'] / $calls_array['uptodate_call_efficiency']['target'] * 100, 2);
				
				
				foreach ($traveltypes as $t){
					$travels = array_count_values(array_column($dcr, 'travelType'));
					
					$id = $t->getId() == 1 ? 97 : 98; 
					
					$travels_array[$t->getName()]['target'] = $this->ExtranetUtilities->getTargetByUser($selectedUser, $id);
					$travels_array[$t->getName()]['performed'] = isset($travels[$t->getId()])?$travels[$t->getId()]:0;
					$travels_array[$t->getName()]['efficiency'] = round($travels_array[$t->getName()]['performed'] / $travels_array[$t->getName()]['target'] * 100, 2);
				}
				$travels_array['total_call_efficiency']['target'] = array_sum(array_column($travels_array,'target'));
				$travels_array['total_call_efficiency']['performed'] = array_sum(array_column($travels_array,'performed'));
				
				$travels_array['total_call_efficiency']['efficiency'] = round($travels_array['total_call_efficiency']['performed'] / $travels_array['total_call_efficiency']['target'] * 100, 2);
				
				
				//$travels_array['total_call_efficiency']['efficiency'] = array_sum(array_column($travels_array,'efficiency'));
				
				$distance_array['travelled'] = array_sum(array_column($dcr,'distanceTravelled'));
				$distance_array['amountone'] = array_sum(array_column($dcr,'amountOne'));
				$distance_array['amounttwo'] = array_sum(array_column($dcr,'amountTwo'));
				$distance_array['total'] = $distance_array['amountone'] + $distance_array['amounttwo'];
				
				
				
				$salesprospect = 0;
				$targetbooking = 0;
				
				foreach ($spt as $s){
					//all but offline leads from lead stage table
					if($s['stage'] != 4){
						$salesprospect += $s['forecastedBookingValue'];
					}
					//only closed leads from lead stage table
					if($s['stage'] == 3){
						$targetbooking += $s['forecastedBookingValue'];
					}
				}
				
				$sales_array['sales_prospect']['target'] = $this->ExtranetUtilities->getTargetByUser($selectedUser, 99);
				$sales_array['sales_prospect']['performed'] = $salesprospect;
				$sales_array['sales_prospect']['efficiency'] = round($sales_array['sales_prospect']['performed'] / $sales_array['sales_prospect']['target'] * 100, 2);
				$sales_array['target_booking']['target'] = $this->ExtranetUtilities->getTargetByUser($selectedUser, 100);
				$sales_array['target_booking']['performed'] = $targetbooking;
				$sales_array['target_booking']['efficiency'] = round($sales_array['target_booking']['performed'] / $sales_array['target_booking']['target'] * 100, 2);
				
				$sales_array['total_sales_efficiency']['target'] = 0;
				$sales_array['total_sales_efficiency']['performed'] = 0;
				$sales_array['total_sales_efficiency']['efficiency'] = 0;

				$overall_efficency = 0;
				if($salesprospect > 0){

					$sales_array['total_sales_efficiency']['target'] = array_sum(array_column($sales_array,'target'));
					$sales_array['total_sales_efficiency']['performed'] = array_sum(array_column($sales_array,'performed'));
					//$sales_array['total_sales_efficiency']['efficiency'] = array_sum(array_column($sales_array,'efficiency'));
					$sales_array['total_sales_efficiency']['efficiency'] = round($sales_array['total_sales_efficiency']['performed'] / $sales_array['total_sales_efficiency']['target'] * 100, 2);
					
					//$overall_efficency = (($sales_array['sales_prospect']['target'] + $sales_array['target_booking']['target']) / 
						//				($salesprospect + $targetbooking)) * 100;
				}
				//$sales_array['overall_efficency'] = round($overall_efficency, 2);
			}
		}
		
		
		//echo array_count_values(array_column($dcr, 'callType'))[3];


        return new ViewModel(['selectedUser'=>$selectedUser,'selectedDate' =>$selectedDate, 'users' => $users,'calls_array'=>$calls_array,'travels_array'=>$travels_array,'distance_array'=>$distance_array,'sales_array'=>$sales_array]);
    }
}
