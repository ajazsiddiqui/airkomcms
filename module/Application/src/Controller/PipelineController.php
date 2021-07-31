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
use Laminas\View\Model\JsonModel;
use Application\Entity\Spt;
use Application\Entity\Dcr;
use Application\Entity\Pipeline;
use Application\Entity\Contacts;
use User\Entity\User;
use Settings\Entity\Settings;
use Masters\Entity\LeadStage;

class PipelineController extends AbstractActionController
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
		$this->cors();
    }
	
	    public function cors()
    {
        // Allow from any origin
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
            header('Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept');
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');    // cache for 1 day
        }
        // Access-Control headers are received during OPTIONS requests
        if ('OPTIONS' == $_SERVER['REQUEST_METHOD']) {
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
                // may also be using PUT, PATCH, HEAD etc
                header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
            }
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
                header('Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept');
            }

            exit(0);
        }
    }
	
    public function indexAction()
    {
		// $spt = $this->entityManager->getRepository(Spt::class)
            // ->findAll();
		// $user = $this->entityManager->getRepository(User::class)
            // ->findOneBy(['email' => $this->authService->getIdentity()]);
			
		// foreach ($spt as $s){
			// $pipeline = new Pipeline();
			// $pipeline->setContact($s->getPropectName());
			// $pipeline->setSptId($s->getId());
			// $pipeline->setStage($s->getStage());
			// $pipeline->setCreatedBy($user->getId());
			// $this->entityManager->persist($pipeline);
			// $this->entityManager->flush();
		// }
		
		$user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['email' => $this->authService->getIdentity()]);
			
		$query = $this->entityManager->createQueryBuilder()->select('P, P.id, P.contact, P.sptId, MAX(P.stage) AS stage')
            ->from('Application\Entity\Pipeline', 'P')
            ->groupBy("P.sptId")
            ->addOrderBy('P.id', 'ASC');
			
		if($user->getUserType() != 1){
			$query->Where('P.createdBy >= :createdBy')
					->setParameter('createdBy', $user->getId());
		}
		
        $pipeline = $query->getQuery()->getResult();
			
		$stages = $this->entityManager->getRepository(LeadStage::class)
            ->findAll();

        return new ViewModel(['pipeline' => $pipeline, 'stages' => $stages, 'user'=>$user->getId()]);
    }
	
	public function changeStageAction(){
		
		$stage = $_GET['stage'];
		$pipelineid = $_GET['pipeline'];
		$spt = $_GET['spt'];
		$user = $_GET['user'];
		
		$pipeline = $this->entityManager->getRepository(Pipeline::class)
            ->findOneBy(['sptId'=>$spt,'stage'=>$stage]);
			
		if(empty($pipeline)){
			$p = $this->entityManager->getRepository(Pipeline::class)
            ->findOneBy(['id'=>$pipelineid]);
			
			$pipeline = new Pipeline();
			$pipeline->setContact($p->getContact());
			$pipeline->setSptId($p->getSptId());
			$pipeline->setStage($stage);
			$pipeline->setCreatedBy($user);
		}else{
			$pipeline->setDateCreated(new \DateTime());
		}
		
		$this->entityManager->persist($pipeline);
		$this->entityManager->flush();
		
		
		//check all pipeline if stage and delete all greater stage in case stage moved to lower stage
		$pipelines = $this->entityManager->getRepository(Pipeline::class)
            ->findBy(['sptId'=>$spt]);
			
		foreach($pipelines as $p){
			$pipeline = $this->entityManager->getRepository(Pipeline::class)
				->findOneBy(['id'=>$p->getId()]);
			if($p->getStage() > $stage){
				$this->entityManager->remove($pipeline);
				$this->entityManager->flush();
			}
		}
		
		
		//update SPT
		$spts = $this->entityManager->getRepository(Spt::class)
            ->findOneBy(['id'=>$spt]);
		$spts->setStage($stage);
		$this->entityManager->persist($spts);
		$this->entityManager->flush();
		
		return new JsonModel(['status'=>'ok']);
	}
}
