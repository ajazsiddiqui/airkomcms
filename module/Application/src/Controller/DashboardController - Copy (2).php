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
use Application\Entity\Spt;
use Application\Entity\Dcr;
use Application\Entity\Roadmap;
use Application\Entity\Contacts;
use User\Entity\User;
use Masters\Entity\LeadStage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DashboardController extends AbstractActionController
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
		$array = [];
		
		$post = $this->getRequest()->getPost()->toArray();
		
		$current_user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['email' => $this->authService->getIdentity()]);
			
		if($current_user->getUserType() == 1){
			$users = $this->entityManager->getRepository(User::class)
				->findBy(['status'=>1]);
		}else{
			$users = $this->entityManager->getRepository(User::class)
				->findBy(['id'=>$current_user->getId()]);
		}
		$user = $post['s_user'] ?? 0;	
		$month = 0;
		
		if(isset($post['s_dates'])){
			$dates = explode("-",$post['s_dates']);
			$month = $dates[1];
			$year = $dates[0];
		}
		
		$dateprefix = ($month != 0)?'AND MONTH(`date_created`) <= '.$month.' AND YEAR(`date_created`) <= '.$year:'';
		$dateprefix2 = ($month != 0)?'WHERE MONTH(`date_created`) <= '.$month.' AND YEAR(`date_created`) <= '.$year:'';
		$dateprefix3 = ($month != 0)?'AND MONTH(`date_modified`) = '.$month.' AND YEAR(`date_modified`) = '.$year:'';
		$userprefix = $user !=0 ? "AND created_by = ".$post['s_user'] :($current_user->getUserType() == 1 ? '' : "AND created_by = ".$current_user->getId()) ;
		
		//Early
		$early = "SELECT * from spt WHERE stage = 1 ".$dateprefix." ".$userprefix;
		$e = $this->entityManager->getConnection()->prepare($early);
		$e->execute();
		$earlyLeads =  $e->fetchAll();
		$array['Early'] = $e->rowCount();
		$array['f_Early'] = array_sum(array_column($earlyLeads,'forecasted_booking_value'));
		
		//Active
		$active = "select * from spt where id in (select spt_id from pipeline ".$dateprefix2." ".$userprefix." group by spt_id having max(stage) = 2)";
		$a = $this->entityManager->getConnection()->prepare($active);
		$a->execute();
		$activeLeads =  $a->fetchAll();
		$array['Active'] = $a->rowCount();
		$array['f_Active'] = array_sum(array_column($activeLeads,'forecasted_booking_value'));
		
		//close
		$close = "select * from spt where stage = 3 ".$dateprefix3." ".$userprefix;
		$c = $this->entityManager->getConnection()->prepare($close);
		$c->execute();
		$closeLeads =  $c->fetchAll();
		$array['Close'] = $c->rowCount();
		$array['f_Close'] = array_sum(array_column($closeLeads,'forecasted_booking_value'));
		
		//offline
		$offline = "select * from spt where stage = 4 ".$dateprefix3." ".$userprefix;		
		$o = $this->entityManager->getConnection()->prepare($offline);
		$o->execute();
		$offlineLeads =  $o->fetchAll();
		$array['Offline'] = $o->rowCount();
		$array['f_Offline'] = array_sum(array_column($offlineLeads,'forecasted_booking_value'));
		
		//lead
		$lead = "select * from spt where stage = 5 ".$dateprefix3." ".$userprefix;
		$l = $this->entityManager->getConnection()->prepare($lead);
		$l->execute();
		$lead =  $l->fetchAll();
		$array['Lead'] = $l->rowCount();
		$array['f_Lead'] = array_sum(array_column($lead,'forecasted_booking_value'));
		
		$totalLeads = ($array['Early'] ?? 0) + ($array['Active'] ?? 0) + ($array['Close'] ?? 0) + ($array['Offline'] ?? 0);
		$totalFBV = ($array['f_Early'] ?? 0) + ($array['f_Active'] ?? 0) + ($array['f_Close'] ?? 0);
		
		return new ViewModel(['data'=>$array,'users'=>$users,'user'=>$user,'totalFBV'=>$totalFBV,'totalLeads'=>$totalLeads]);

 }
	

	
	 public function sptreportAction()
    {
		
		$post = $this->getRequest()->getPost()->toArray();
		if(!$post){
			return;
		}
		
		if(isset($post['view'])){
			$data = $this->getSptView($post);
			return new ViewModel($data);
		}
		
		$this->layout()->setTemplate('layout/blank');
		
		$user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['id' => $post['s_user']]);
			
		if($post['s_user'] == 0){
			$user = $this->entityManager->getRepository(User::class)
            ->findBy(['status'=>1]);
		}
		
		$spreadsheet = new Spreadsheet();
		$spreadsheet->getProperties()->setCreator('AirkomCMS')->setLastModifiedBy('AirkomCMS')->setTitle('AirkomCMS');
		// Rename worksheet
		$spreadsheet->getActiveSheet()->setTitle('SPT Report');

		$spreadsheet->setActiveSheetIndex(0) 
		->setCellValue('A1', 'Engineer')
		->setCellValue('B1', $post['s_user'] == 0?'All Users':$user->getFullName())
		->setCellValue('A2', 'Branch')
		->setCellValue('B2', $post['s_user'] == 0?'All Branches':$this->ExtranetUtilities->getBranchName($user->getBranch()))
		->setCellValue('A3', 'Date Range')
		->setCellValue('B3', $post['s_daterange']);
		
		$spreadsheet->setActiveSheetIndex(0) 
		->setCellValue('A5', 'Stage')
		->setCellValue('B5', 'Prospect Name')
		->setCellValue('C5', 'Lead Source Name')
		->setCellValue('D5', 'Executive')
		->setCellValue('E5', 'Offer No')
		->setCellValue('F5', 'Sales Stage')
		->setCellValue('G5', 'Product Series')
		->setCellValue('H5', 'Actual Product')
		->setCellValue('I5', 'Forecasted Booking Value ')
		->setCellValue('J5', 'Quantity')
		->setCellValue('K5', 'Expected Close Date')
		->setCellValue('L5', 'Expected Month')
		->setCellValue('M5', 'Close Probability')
		->setCellValue('N5', 'Next Action')
		->setCellValue('O5', 'Last Contacted Date')
		->setCellValue('P5', 'Remarks')
		->setCellValue('Q5', 'Contacted Type')
		->setCellValue('R5', 'Contact Name')
		->setCellValue('S5', 'Designation')
		->setCellValue('T5', 'City')
		->setCellValue('U5', 'Telephone')
		->setCellValue('V5', 'Email')
		->setCellValue('W5', 'Website')
		->setCellValue('X5', 'Date Created');
		
		
		$query = $this->entityManager->createQueryBuilder()->select('S')
				->from('Application\Entity\Spt', 'S');
		if (!empty($post['s_daterange'])) {
				$dates = explode(" - ", $post['s_daterange']);
				$startdate = $this->ExtranetUtilities->makeDBDate($dates[0]);
				$enddate = $this->ExtranetUtilities->makeDBDate($dates[1]);

				$query->AndWhere('S.dateCreated >= :startdate')
					->setParameter('startdate', $startdate);
				$query->AndWhere('S.dateCreated <= :enddate')
					->setParameter('enddate', $enddate);
				
				if($post['s_user'] != 0){
					$query->AndWhere('S.createdBy = :createdBy')
						->setParameter('createdBy', $post['s_user']);
				}
			
				$spt = $query->getQuery()->getArrayResult();
				
				$spreadsheet->setActiveSheetIndex(0) 
					->setCellValue('A4', 'Total FBV')
					->setCellValue('B4', array_sum(array_column($spt,'forecastedBookingValue')));
		

				if (!empty($spt)){
					$n = 5;

					$count = count($spt);

					for ($i=0;$i<$count;$i++) {
						
						$contact = $this->entityManager->getRepository(Contacts::class)
									->findOneBy(['id' => $spt[$i]['propectName']]);
						$spreadsheet->setActiveSheetIndex(0)
						  ->setCellValue('A' . (string)($n + 1), $this->ExtranetUtilities->getStageName($spt[$i]['stage']))
						  ->setCellValue('B' . (string)($n + 1), $this->ExtranetUtilities->getProspectName($spt[$i]['propectName']))
						  ->setCellValue('C' . (string)($n + 1), $this->ExtranetUtilities->getLeadSourceName($spt[$i]['leadSource']))
						  ->setCellValue('D' . (string)($n + 1), $this->ExtranetUtilities->getExecutiveName($spt[$i]['executive']))
						  ->setCellValue('E' . (string)($n + 1), $spt[$i]['offerNo'])
						  ->setCellValue('F' . (string)($n + 1), $this->ExtranetUtilities->getSalesStageName($spt[$i]['salesStage']))
						  ->setCellValue('G' . (string)($n + 1), $this->ExtranetUtilities->getProductSeriesName($spt[$i]['productSeries']))
						  ->setCellValue('H' . (string)($n + 1), $this->ExtranetUtilities->getActualProductName($spt[$i]['actualProduct']))
						  ->setCellValue('I' . (string)($n + 1), $spt[$i]['forecastedBookingValue'])
						  ->setCellValue('J' . (string)($n + 1), $spt[$i]['quanitity'])
						  ->setCellValue('K' . (string)($n + 1), $spt[$i]['expectedCloseDate'])
						  ->setCellValue('L' . (string)($n + 1), $this->ExtranetUtilities->getExpectedMonthName($spt[$i]['expectedMonth']))
						  ->setCellValue('M' . (string)($n + 1), $this->ExtranetUtilities->getClosePropabilityName($spt[$i]['closeProbability']))
						  ->setCellValue('N' . (string)($n + 1), $this->ExtranetUtilities->getNextActionName($spt[$i]['nextAction']))
						  ->setCellValue('O' . (string)($n + 1), $spt[$i]['lastContactedDate'])
						  ->setCellValue('P' . (string)($n + 1), $spt[$i]['remarks'])
						  ->setCellValue('Q' . (string)($n + 1), $this->ExtranetUtilities->getContactedTypeName($spt[$i]['contactedType']))
						  ->setCellValue('R' . (string)($n + 1), $spt[$i]['contact'])
						  ->setCellValue('S' . (string)($n + 1), !empty($contact)?$contact->getDesignation():'')
						  ->setCellValue('T' . (string)($n + 1), !empty($contact)?$contact->getCity():'')
						  ->setCellValue('U' . (string)($n + 1), !empty($contact)?$contact->getTelephone():'')
						  ->setCellValue('V' . (string)($n + 1), !empty($contact)?$contact->getEmail():'')
						  ->setCellValue('W' . (string)($n + 1), !empty($contact)?$contact->getWebsite():'')
						  ->setCellValue('X' . (string)($n + 1), $spt[$i]['dateCreated']);
						$n++;
					}
				}
		}
		
		//Excel Stylings
		$spreadsheet->getActiveSheet()->freezePane('E6');
		$spreadsheet
		->getActiveSheet()
		->getStyle('A5:X5')
		->getFill()
		->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
		->getStartColor()
		->setARGB('FFFF00');
		
		foreach (range('A','X') as $col) {
		   $spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
		}
		
		$spreadsheet->getActiveSheet()->getStyle('A5:X5')->getFont()->setBold(true);
		$spreadsheet->getActiveSheet()->getStyle('A1:A4')->getFont()->setBold(true);
		
		// Redirect output to a clientâ€™s web browser (Xlsx)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Airkom_SPTReport.xlsx"');
		header('Cache-Control: max-age=0');
		header('Cache-Control: max-age=1');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
		header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header('Pragma: public'); // HTTP/1.0
		ob_end_clean();		
		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('php://output');
		
    }
	
	
	 public function getSptView($post)
    {
		
		$post = $this->getRequest()->getPost()->toArray();
		if(!$post){
			return;
		}
		
		$user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['id' => $post['s_user']]);
		
		if($post['s_user'] == 0){
			$user = $this->entityManager->getRepository(User::class)
            ->findBy(['status'=>1]);
		}
		
		$daterange =  '';
		
		$query = $this->entityManager->createQueryBuilder()->select('S')
				->from('Application\Entity\Spt', 'S');
		if (!empty($post['s_daterange'])) {
				$dates = explode(" - ", $post['s_daterange']);
				$startdate = $this->ExtranetUtilities->makeDBDate($dates[0]);
				$enddate = $this->ExtranetUtilities->makeDBDate($dates[1]);

				$query->AndWhere('S.dateCreated >= :startdate')
					->setParameter('startdate', $startdate);
				$query->AndWhere('S.dateCreated <= :enddate')
					->setParameter('enddate', $enddate);
				if($post['s_user'] != 0){
					$query->AndWhere('S.createdBy = :createdBy')
						->setParameter('createdBy', $post['s_user']);
				}
			
				$spt = $query->getQuery()->getArrayResult();

				$daterange = $post['s_daterange']; 
		}
		
		$data = [];
		
		if (!empty($spt)){

			foreach ($spt as $k => $v) {
				
				$contact = $this->entityManager->getRepository(Contacts::class)
							->findOneBy(['id' => $spt[$k]['propectName']]);
				$spt[$k]['stage'] = $this->ExtranetUtilities->getStageName($spt[$k]['stage']);
				$spt[$k]['propectName'] = $this->ExtranetUtilities->getProspectName($spt[$k]['propectName']);
				$spt[$k]['leadSource'] = $this->ExtranetUtilities->getLeadSourceName($spt[$k]['leadSource']);
				$spt[$k]['executive'] = $this->ExtranetUtilities->getExecutiveName($spt[$k]['executive']);
				//$spt[$k]['offerNo'] = $spt[$k]['offerNo']);
				$spt[$k]['salesStage'] = $this->ExtranetUtilities->getSalesStageName($spt[$k]['salesStage']);
				$spt[$k]['productSeries'] = $this->ExtranetUtilities->getProductSeriesName($spt[$k]['productSeries']);
				$spt[$k]['actualProduct'] = $this->ExtranetUtilities->getActualProductName($spt[$k]['actualProduct']);
				//$spt[$k]['forecastedBookingValue'] = $spt[$k]['forecastedBookingValue']);
				//$spt[$k]['quanitity'] = $spt[$k]['quanitity']);
				$spt[$k]['expectedCloseDate'] = $spt[$k]['expectedCloseDate']->format('d-m-Y');
				$spt[$k]['expectedMonth'] = $this->ExtranetUtilities->getExpectedMonthName($spt[$k]['expectedMonth']);
				$spt[$k]['closeProbability'] = $this->ExtranetUtilities->getClosePropabilityName($spt[$k]['closeProbability']);
				$spt[$k]['nextAction'] = $this->ExtranetUtilities->getNextActionName($spt[$k]['nextAction']);
				$spt[$k]['lastContactedDate'] = $spt[$k]['lastContactedDate']->format('d-m-Y');
				//$spt[$k]['remarks'] = $spt[$k]['remarks']);
				$spt[$k]['contactedType'] = $this->ExtranetUtilities->getContactedTypeName($spt[$k]['contactedType']);
				//$spt[$k]['contact'] = $spt[$k]['contact']);
				$spt[$k]['designation'] = !empty($contact)?$contact->getDesignation():'';
				$spt[$k]['city'] = !empty($contact)?$contact->getCity():'';
				$spt[$k]['telephone'] = !empty($contact)?$contact->getTelephone():'';
				$spt[$k]['email'] = !empty($contact)?$contact->getEmail():'';
				$spt[$k]['website'] = !empty($contact)?$contact->getWebsite():'';
				$spt[$k]['dateCreated'] = $spt[$k]['dateCreated']->format('d-m-Y');
			}
		}
		$u = (gettype($user) == 'object')?"and `created_by` = ".$user->getId():'';
		$sql = "SELECT (SELECT `name` FROM `lead_stage` WHERE `id` = `stage`) as `stage`, sum(`forecasted_booking_value`) as `fbv` from `spt` where `date_created` >= '".$startdate."' and `date_created` <= '".$enddate."' ".$u." group by `stage`";

		$stmt = $this->entityManager->getConnection()->prepare($sql);
		$stmt->execute();
		$fbv =  $stmt->fetchAll();
		
		$total_fbv = array_sum(array_column($fbv,'fbv'));
		
		return ['total_fbv'=>$total_fbv,'fbv'=>$fbv,'data'=>$spt,'user'=>$user,'daterange'=>$daterange];
    }
	
	public function dcrreportAction()
    {
		
		$post = $this->getRequest()->getPost()->toArray();
		if(!$post){
			return;
		}
		
		if(isset($post['view'])){
			$data = $this->getDcrView($post);
			return new ViewModel($data);
		}
		
		$this->layout()->setTemplate('layout/blank');
		
		$user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['id' => $post['s_user']]);
		
		if($post['s_user'] == 0){
			$user = $this->entityManager->getRepository(User::class)
            ->findBy(['status'=>1]);
		}
		
		$spreadsheet = new Spreadsheet();
		$spreadsheet->getProperties()->setCreator('AirkomCMS')->setLastModifiedBy('AirkomCMS')->setTitle('AirkomCMS');
		// Rename worksheet
		$spreadsheet->getActiveSheet()->setTitle('DCR Report');
		
		$spreadsheet->setActiveSheetIndex(0) 
		->setCellValue('A1', 'Engg')
		->setCellValue('B1', $post['s_user'] == 0?'All Users':$user->getFullName())
		->setCellValue('A2', 'Branch')
		->setCellValue('B2', $post['s_user'] == 0?'All Branches':$this->ExtranetUtilities->getBranchName($user->getBranch()))
		->setCellValue('A3', 'Date Range')
		->setCellValue('B3', $post['s_daterange']);
		
		$spreadsheet->setActiveSheetIndex(0) 
			->setCellValue('A5', 'Visit Date')
			->setCellValue('B5', 'DCR No')
			->setCellValue('C5', 'Call Type')
			->setCellValue('D5', 'Call Count')
			->setCellValue('E5', 'Customer Name')
			->setCellValue('F5', 'City')
			->setCellValue('G5', 'Company Name')
			->setCellValue('H5', 'Contact No')
			->setCellValue('I5', 'Product')
			->setCellValue('J5', 'Model')
			->setCellValue('K5', 'Qty')
			->setCellValue('L5', 'Order Value (Basic)')
			->setCellValue('M5', 'Sales Stage')
			->setCellValue('N5', 'Next Action')
			->setCellValue('O5', 'Remarks')
			->setCellValue('P5', 'Bike Reading KM Start')
			->setCellValue('Q5', 'Bike Reading KM End')
			->setCellValue('R5', 'Distance Travelled')
			->setCellValue('S5', 'Amount 1')
			->setCellValue('T5', 'Local Travel Mode')
			->setCellValue('U5', 'Amount 2')
			->setCellValue('V5', 'Date Created');
		
		
		$query = $this->entityManager->createQueryBuilder()->select('D')
				->from('Application\Entity\Dcr', 'D');
		if (!empty($post['s_daterange'])) {
				$dates = explode(" - ", $post['s_daterange']);
				$startdate = $this->ExtranetUtilities->makeDBDate($dates[0]);
				$enddate = $this->ExtranetUtilities->makeDBDate($dates[1]);

				$query->AndWhere('D.visitDate >= :startdate')
					->setParameter('startdate', $startdate);
				$query->AndWhere('D.visitDate <= :enddate')
					->setParameter('enddate', $enddate);
				if($post['s_user'] != 0){
					$query->AndWhere('D.createdBy = :createdBy')
						->setParameter('createdBy', $post['s_user']);
				}
					
				$dcr = $query->getQuery()->getArrayResult();
				
				$spreadsheet->setActiveSheetIndex(0) 
					->setCellValue('A4', 'Total Order Value')
					->setCellValue('B4', array_sum(array_column($dcr,'orderValue')));

				if (!empty($dcr)){
					$n = 5;

					$count = count($dcr);

					for ($i=0;$i<$count;$i++) {
						
						$contact = $this->entityManager->getRepository(Contacts::class)
									->findOneBy(['id' => $dcr[$i]['contactId']]);
						$spreadsheet->setActiveSheetIndex(0)
						  ->setCellValue('A' . (string)($n + 1), $dcr[$i]['visitDate'])
						  ->setCellValue('B' . (string)($n + 1), $dcr[$i]['dcrNo'])
						  ->setCellValue('C' . (string)($n + 1), $this->ExtranetUtilities->getCallTypeName($dcr[$i]['callType']))
						  ->setCellValue('D' . (string)($n + 1), $dcr[$i]['callCount'])
						  ->setCellValue('E' . (string)($n + 1), $contact->getName())
						  ->setCellValue('F' . (string)($n + 1), $contact->getCity())
						  ->setCellValue('G' . (string)($n + 1), $contact->getCompany())
						  ->setCellValue('H' . (string)($n + 1), $contact->getTelephone())
						  ->setCellValue('I' . (string)($n + 1), $this->ExtranetUtilities->getActualProductName($dcr[$i]['productId']))
						  ->setCellValue('J' . (string)($n + 1), $this->ExtranetUtilities->getProductModelName($dcr[$i]['productModel']))
						  ->setCellValue('K' . (string)($n + 1), $dcr[$i]['quanitity'])
						  ->setCellValue('L' . (string)($n + 1), $dcr[$i]['orderValue'])
						  ->setCellValue('M' . (string)($n + 1), $this->ExtranetUtilities->getSalesStageName($dcr[$i]['salesStage']))
						  ->setCellValue('N' . (string)($n + 1), $this->ExtranetUtilities->getNextActionName($dcr[$i]['nextAction']))
						  ->setCellValue('O' . (string)($n + 1), $dcr[$i]['remarks'])
						  ->setCellValue('P' . (string)($n + 1), $dcr[$i]['bikeKmReadingStart'])
						  ->setCellValue('Q' . (string)($n + 1), $dcr[$i]['bikeKmReadingEnd'])
						  ->setCellValue('R' . (string)($n + 1), $dcr[$i]['distanceTravelled'])
						  ->setCellValue('S' . (string)($n + 1), $dcr[$i]['amountOne'])
						  ->setCellValue('T' . (string)($n + 1), $this->ExtranetUtilities->getTravelModeName($dcr[$i]['travelMode']))
						  ->setCellValue('U' . (string)($n + 1), $dcr[$i]['amountTwo'])
						  ->setCellValue('V' . (string)($n + 1), $dcr[$i]['dateCreated']);
						$n++;
					}
				}
		}
		
		//Excel Stylings
		$spreadsheet->getActiveSheet()->freezePane('F6');
		$spreadsheet
		->getActiveSheet()
		->getStyle('A5:V5')
		->getFill()
		->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
		->getStartColor()
		->setARGB('FFFF00');
		
		foreach (range('A','V') as $col) {
		   $spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
		}
		
		$spreadsheet->getActiveSheet()->getStyle('A5:V5')->getFont()->setBold(true);
		$spreadsheet->getActiveSheet()->getStyle('A1:A4')->getFont()->setBold(true);

		// Redirect output to a clientâ€™s web browser (Xlsx)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Airkom_DCRReport.xlsx"');
		header('Cache-Control: max-age=0');
		header('Cache-Control: max-age=1');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
		header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header('Pragma: public'); // HTTP/1.0
		ob_end_clean();		
		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('php://output');
    }
	
	
	public function getDcrView($post)
    {
		
		$post = $this->getRequest()->getPost()->toArray();
		if(!$post){
			return;
		}
		
		$user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['id' => $post['s_user']]);
		
		if($post['s_user'] == 0){
			$user = $this->entityManager->getRepository(User::class)
            ->findBy(['status'=>1]);
		}
		
		$daterange =  '';
		
		$query = $this->entityManager->createQueryBuilder()->select('D')
				->from('Application\Entity\Dcr', 'D');
				
		if (!empty($post['s_daterange'])) {
				$dates = explode(" - ", $post['s_daterange']);
				$startdate = $this->ExtranetUtilities->makeDBDate($dates[0]);
				$enddate = $this->ExtranetUtilities->makeDBDate($dates[1]);

				$query->AndWhere('D.visitDate >= :startdate')
					->setParameter('startdate', $startdate);
				$query->AndWhere('D.visitDate <= :enddate')
					->setParameter('enddate', $enddate);
				
				if($post['s_user'] != 0){
					$query->AndWhere('D.createdBy = :createdBy')
						->setParameter('createdBy', $post['s_user']);
				}
				
				$daterange = $post['s_daterange'];
					
				$dcr = $query->getQuery()->getArrayResult();
		}
		
		$data = [];
		
		if (!empty($dcr)){

			foreach ($dcr as $k => $v) {
				
				$contact = $this->entityManager->getRepository(Contacts::class)
							->findOneBy(['id' => $dcr[$k]['contactId']]);
							
				$dcr[$k]['visitDate'] = $dcr[$k]['visitDate']->format('d/m/Y');
				$dcr[$k]['dcrNo'] = $dcr[$k]['dcrNo'];
				$dcr[$k]['callType'] = $this->ExtranetUtilities->getCallTypeName($dcr[$k]['callType']);
				$dcr[$k]['callCount'] = $dcr[$k]['callCount'];
				$dcr[$k]['name'] = $contact->getName();
				$dcr[$k]['city'] = $contact->getCity();
				$dcr[$k]['company'] = $contact->getCompany();
				$dcr[$k]['telephone'] = $contact->getTelephone();
				$dcr[$k]['productId'] = $this->ExtranetUtilities->getActualProductName($dcr[$k]['productId']);
				$dcr[$k]['productModel'] = $this->ExtranetUtilities->getProductModelName($dcr[$k]['productModel']);
				$dcr[$k]['quanitity'] = $dcr[$k]['quanitity'];
				$dcr[$k]['orderValue'] = $dcr[$k]['orderValue'];
				$dcr[$k]['salesStage'] = $this->ExtranetUtilities->getSalesStageName($dcr[$k]['salesStage']);
				$dcr[$k]['nextAction'] = $this->ExtranetUtilities->getNextActionName($dcr[$k]['nextAction']);
				$dcr[$k]['remarks'] = $dcr[$k]['remarks'];
				$dcr[$k]['bikeKmReadingStart'] = $dcr[$k]['bikeKmReadingStart'];
				$dcr[$k]['bikeKmReadingEnd'] = $dcr[$k]['bikeKmReadingEnd'];
				$dcr[$k]['distanceTravelled'] = $dcr[$k]['distanceTravelled'];
				$dcr[$k]['amountOne'] = $dcr[$k]['amountOne'];
				$dcr[$k]['travelMode'] = $this->ExtranetUtilities->getTravelModeName($dcr[$k]['travelMode']);
				$dcr[$k]['amountTwo'] = $dcr[$k]['amountTwo'];
				$dcr[$k]['dateCreated'] = $dcr[$k]['dateCreated']->format('d/m/Y');
			}
		}
		
		
		$sql = "SELECT (SELECT `name` FROM `call_type` WHERE `id` = `call_type`) as `calltype`, sum(`order_value`) as `ov` from `dcr` where `date_created` >= '".$startdate."' and `date_created` <= '".$enddate."' group by `call_type`";

		$stmt = $this->entityManager->getConnection()->prepare($sql);
		$stmt->execute();
		$ov =  $stmt->fetchAll();
		
		$total_ov = array_sum(array_column($ov,'ov'));
		
		return ['total_ov' => $total_ov, 'ov'=>$ov,'data'=>$dcr,'user'=>$user,'daterange'=>$daterange];
    }
	
	
	public function roadmapreportAction()
    {
		
		$post = $this->getRequest()->getPost()->toArray();
		if(!$post){
			return;
		}
		
		if(isset($post['view'])){
			$data = $this->getRoadmapView($post);
			return new ViewModel($data);
		}
		
		$this->layout()->setTemplate('layout/blank');
		
		$user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['id' => $post['s_user']]);
		
		if($post['s_user'] == 0){
			$user = $this->entityManager->getRepository(User::class)
            ->findBy(['status'=>1]);
		}
		
		$spreadsheet = new Spreadsheet();
		$spreadsheet->getProperties()->setCreator('AirkomCMS')->setLastModifiedBy('AirkomCMS')->setTitle('AirkomCMS');
		// Rename worksheet
		$spreadsheet->getActiveSheet()->setTitle('Roadmap Report');
		
		$spreadsheet->setActiveSheetIndex(0) 
		->setCellValue('A1', 'Engg')
		->setCellValue('B1', $post['s_user'] == 0?'All Users':$user->getFullName())
		->setCellValue('A2', 'Branch')
		->setCellValue('B2', $post['s_user'] == 0?'All Branches':$this->ExtranetUtilities->getBranchName($user->getBranch()))
		->setCellValue('A3', 'Date Range')
		->setCellValue('B3', $post['s_daterange']);
		
		$spreadsheet->setActiveSheetIndex(0) 
			->setCellValue('A5', 'Market Segment')
			->setCellValue('B5', 'Prospect Name')
			->setCellValue('C5', 'Prospect City')
			->setCellValue('D5', 'Prospect Machine')
			->setCellValue('E5', 'Product')
			->setCellValue('F5', 'Product Series')
			->setCellValue('G5', 'Product Model')
			->setCellValue('H5', 'Action Plan')
			->setCellValue('I5', 'Exepected Qty')
			->setCellValue('J5', 'Expected Potential Order Value')
			->setCellValue('K5', 'Date Created');
		
		
		$query = $this->entityManager->createQueryBuilder()->select('R')
				->from('Application\Entity\Roadmap', 'R');
		if (!empty($post['s_daterange'])) {
				$dates = explode(" - ", $post['s_daterange']);
				$startdate = $this->ExtranetUtilities->makeDBDate($dates[0]);
				$enddate = $this->ExtranetUtilities->makeDBDate($dates[1]);

				$query->AndWhere('R.dateCreated >= :startdate')
					->setParameter('startdate', $startdate);
				$query->AndWhere('R.dateCreated <= :enddate')
					->setParameter('enddate', $enddate);
				if($post['s_user'] != 0){
					$query->AndWhere('R.createdBy = :createdBy')
						->setParameter('createdBy', $post['s_user']);
				}
					
				$roadmap = $query->getQuery()->getArrayResult();
				
				$spreadsheet->setActiveSheetIndex(0) 
					->setCellValue('A4', 'Total Potential Value')
					->setCellValue('B4', array_sum(array_column($roadmap,'expectedPotentialOrderValue')));

				if (!empty($roadmap)){
					$n = 5;

					$count = count($roadmap);

					for ($i=0;$i<$count;$i++) {
						
						$contact = $this->entityManager->getRepository(Contacts::class)
									->findOneBy(['id' => $roadmap[$i]['prospectName']]);
						$spreadsheet->setActiveSheetIndex(0)
						  ->setCellValue('A' . (string)($n + 1), $this->ExtranetUtilities->getMarketSegmentName($roadmap[$i]['marketSegment']))
						  ->setCellValue('B' . (string)($n + 1), $contact->getCompany())
						  ->setCellValue('C' . (string)($n + 1), $roadmap[$i]['prospectCity'])
						  ->setCellValue('D' . (string)($n + 1), $roadmap[$i]['propspectMachine'])
						  ->setCellValue('E' . (string)($n + 1), $this->ExtranetUtilities->getActualProductName($roadmap[$i]['product']))
						  ->setCellValue('F' . (string)($n + 1), $this->ExtranetUtilities->getProductSeriesName($roadmap[$i]['productSeries']))
						  ->setCellValue('G' . (string)($n + 1), $this->ExtranetUtilities->getProductModelName($roadmap[$i]['productModel']))
						  ->setCellValue('H' . (string)($n + 1), $this->ExtranetUtilities->getNextActionName($roadmap[$i]['nextAction']))
						  ->setCellValue('I' . (string)($n + 1), $roadmap[$i]['expectedQuanitity'])
						  ->setCellValue('J' . (string)($n + 1), $roadmap[$i]['expectedPotentialOrderValue'])
						  ->setCellValue('K' . (string)($n + 1), $roadmap[$i]['dateCreated']);
						$n++;
					}
				}
		}
		
		
		//Excel Stylings
		$spreadsheet->getActiveSheet()->freezePane('D6');
		$spreadsheet
		->getActiveSheet()
		->getStyle('A5:K5')
		->getFill()
		->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
		->getStartColor()
		->setARGB('FFFF00');
		
		foreach (range('A','K') as $col) {
		   $spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
		}
		
		$spreadsheet->getActiveSheet()->getStyle('A5:K5')->getFont()->setBold(true);
		$spreadsheet->getActiveSheet()->getStyle('A1:A4')->getFont()->setBold(true);
		

		// Redirect output to a clientâ€™s web browser (Xlsx)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Airkom_RoadmapReport.xlsx"');
		header('Cache-Control: max-age=0');
		header('Cache-Control: max-age=1');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
		header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header('Pragma: public'); // HTTP/1.0
		ob_end_clean();		
		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('php://output');
    }

	public function getRoadmapView($post)
    {
		
		$post = $this->getRequest()->getPost()->toArray();
		if(!$post){
			return;
		}
		
		$user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['id' => $post['s_user']]);
		
		if($post['s_user'] == 0){
			$user = $this->entityManager->getRepository(User::class)
            ->findBy(['status'=>1]);
		}
		
		$daterange =  '';
		
		$query = $this->entityManager->createQueryBuilder()->select('R')
				->from('Application\Entity\Roadmap', 'R');
		if (!empty($post['s_daterange'])) {
				$dates = explode(" - ", $post['s_daterange']);
				$startdate = $this->ExtranetUtilities->makeDBDate($dates[0]);
				$enddate = $this->ExtranetUtilities->makeDBDate($dates[1]);

				$query->AndWhere('R.dateCreated >= :startdate')
					->setParameter('startdate', $startdate);
				$query->AndWhere('R.dateCreated <= :enddate')
					->setParameter('enddate', $enddate);
				if($post['s_user'] != 0){
					$query->AndWhere('R.createdBy = :createdBy')
						->setParameter('createdBy', $post['s_user']);
				}
					
				$roadmap = $query->getQuery()->getArrayResult();

				$daterange = $post['s_daterange']; 
		}
		
		$data = [];
		
		if (!empty($roadmap)){
			
					foreach ($roadmap as $k => $v) {
						
						$contact = $this->entityManager->getRepository(Contacts::class)
									->findOneBy(['id' => $roadmap[$k]['prospectName']]);
									
						$roadmap[$k]['marketSegment'] = $this->ExtranetUtilities->getMarketSegmentName($roadmap[$k]['marketSegment']);
						$roadmap[$k]['company'] = $contact->getCompany();
						$roadmap[$k]['prospectCity'] = $roadmap[$k]['prospectCity'];
						$roadmap[$k]['propspectMachine'] = $roadmap[$k]['propspectMachine'];
						$roadmap[$k]['product'] = $this->ExtranetUtilities->getActualProductName($roadmap[$k]['product']);
						$roadmap[$k]['productSeries'] = $this->ExtranetUtilities->getProductSeriesName($roadmap[$k]['productSeries']);
						$roadmap[$k]['productModel'] = $this->ExtranetUtilities->getProductModelName($roadmap[$k]['productModel']);
						$roadmap[$k]['nextAction'] = $this->ExtranetUtilities->getNextActionName($roadmap[$k]['nextAction']);
						$roadmap[$k]['expectedQuanitity'] = $roadmap[$k]['expectedPotentialOrderValue'];
						$roadmap[$k]['expectedPotentialOrderValue'] = $roadmap[$k]['expectedPotentialOrderValue'];
						$roadmap[$k]['dateCreated'] = $roadmap[$k]['dateCreated']->format('d/m/Y');
					}
				}
				
		$sql = "SELECT (SELECT `name` FROM `next_action` WHERE `id` = `next_action`) as `nextaction`, sum(`expected_potential_order_value`) as `epov` from `roadmap` where `date_created` >= '".$startdate."' and `date_created` <= '".$enddate."' group by `next_action`";

		$stmt = $this->entityManager->getConnection()->prepare($sql);
		$stmt->execute();
		$epov =  $stmt->fetchAll();
		$total_pv = array_sum(array_column($epov,'epov'));
		return ['total_pv'=>$total_pv,'epov'=>$epov,'data'=>$roadmap,'user'=>$user,'daterange'=>$daterange];

    }	
}
