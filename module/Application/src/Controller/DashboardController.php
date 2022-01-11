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
		$dates = $post['s_dates'] ?? 0;

		$spts = $this->ExtranetUtilities->getSPTs($current_user,$user,$dates);
		
		//Early
		$array['Early'] = count($spts['Early']);
		$array['f_Early'] = array_sum(array_column($spts['Early'],'forecasted_booking_value'));
		
		//Active
		$array['Active'] = count($spts['Active']);
		$array['f_Active'] = array_sum(array_column($spts['Active'],'forecasted_booking_value'));
		
		//close
		$array['Close'] = count($spts['Close']);
		$array['f_Close'] = array_sum(array_column($spts['Close'],'forecasted_booking_value'));
		
		//offline
		$array['Offline'] = count($spts['Offline']);
		$array['f_Offline'] = array_sum(array_column($spts['Offline'],'forecasted_booking_value'));
		
		//lead
		$array['Lead'] = count($spts['Lead']);
		$array['f_Lead'] = array_sum(array_column($spts['Lead'],'forecasted_booking_value'));
		
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
		$dates = $post['s_daterange'] ?? 0;
		
		if($user != 0){
			$user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['id' => $post['s_user']]);
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
		
		
		$user = $post['s_user'] ?? 0;
		$dates = $post['s_daterange'] ?? 0;
		
		$spts = $this->ExtranetUtilities->getSPTs($current_user,$user,$dates, true);
		
		$spt = [];
		
		$i = 0;
		foreach($spts as $sp){
			foreach($sp as $s){
				$spt[$i] = $s;
				$i++;
			}
		}
		
		
		$spreadsheet->setActiveSheetIndex(0) 
					->setCellValue('A4', 'Total FBV')
					->setCellValue('B4', array_sum(array_column($spt,'forecasted_booking_value')));
		

				if (!empty($spt)){
					$n = 5;

					$count = count($spt);

					for ($i=0;$i<$count;$i++) {
						
						$contact = $this->entityManager->getRepository(Contacts::class)
									->findOneBy(['id' => $spt[$i]['propect_name']]);
						$spreadsheet->setActiveSheetIndex(0)
						  ->setCellValue('A' . (string)($n + 1), $this->ExtranetUtilities->getStageName($spt[$i]['stage']))
						  ->setCellValue('B' . (string)($n + 1), $this->ExtranetUtilities->getProspectName($spt[$i]['propect_name']))
						  ->setCellValue('C' . (string)($n + 1), $this->ExtranetUtilities->getLeadSourceName($spt[$i]['lead_source']))
						  ->setCellValue('D' . (string)($n + 1), $this->ExtranetUtilities->getExecutiveName($spt[$i]['executive']))
						  ->setCellValue('E' . (string)($n + 1), $spt[$i]['offer_no'])
						  ->setCellValue('F' . (string)($n + 1), $this->ExtranetUtilities->getSalesStageName($spt[$i]['sales_stage']))
						  ->setCellValue('G' . (string)($n + 1), $this->ExtranetUtilities->getProductSeriesName($spt[$i]['product_series']))
						  ->setCellValue('H' . (string)($n + 1), $this->ExtranetUtilities->getActualProductName($spt[$i]['actual_product']))
						  ->setCellValue('I' . (string)($n + 1), $spt[$i]['forecasted_booking_value'])
						  ->setCellValue('J' . (string)($n + 1), $spt[$i]['quanitity'])
						  ->setCellValue('K' . (string)($n + 1), $spt[$i]['expected_close_date'])
						  ->setCellValue('L' . (string)($n + 1), $this->ExtranetUtilities->getExpectedMonthName($spt[$i]['expected_month']))
						  ->setCellValue('M' . (string)($n + 1), $this->ExtranetUtilities->getClosePropabilityName($spt[$i]['close_probability']))
						  ->setCellValue('N' . (string)($n + 1), $this->ExtranetUtilities->getNextActionName($spt[$i]['next_action']))
						  ->setCellValue('O' . (string)($n + 1), $spt[$i]['last_contacted_date'])
						  ->setCellValue('P' . (string)($n + 1), $spt[$i]['remarks'])
						  ->setCellValue('Q' . (string)($n + 1), $this->ExtranetUtilities->getContactedTypeName($spt[$i]['contacted_type']))
						  ->setCellValue('R' . (string)($n + 1), $spt[$i]['contact'])
						  ->setCellValue('S' . (string)($n + 1), !empty($contact)?$contact->getDesignation():'')
						  ->setCellValue('T' . (string)($n + 1), !empty($contact)?$contact->getCity():'')
						  ->setCellValue('U' . (string)($n + 1), !empty($contact)?$contact->getTelephone():'')
						  ->setCellValue('V' . (string)($n + 1), !empty($contact)?$contact->getEmail():'')
						  ->setCellValue('W' . (string)($n + 1), !empty($contact)?$contact->getWebsite():'')
						  ->setCellValue('X' . (string)($n + 1), $spt[$i]['date_created']);
						$n++;
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
		$dates = $post['s_daterange'] ?? 0;
		
		$spts = $this->ExtranetUtilities->getSPTs($current_user,$user,$dates, true);
		
		

		$spt = [];

		if (!empty($spts)){
			$i = 0;
			foreach ($spts as $key => $values) {
				foreach ($values as $k => $v) {
					
					$contact = $this->entityManager->getRepository(Contacts::class)
								->findOneBy(['id' => $v['propect_name']]);
					$spt[$i]['id'] = $v['id'];
					$spt[$i]['stage'] = $this->ExtranetUtilities->getStageName($v['stage']);
					$spt[$i]['propect_name'] = $this->ExtranetUtilities->getProspectName($v['propect_name']);
					$spt[$i]['lead_source'] = $this->ExtranetUtilities->getLeadSourceName($v['lead_source']);
					$spt[$i]['executive'] = $this->ExtranetUtilities->getExecutiveName($v['executive']);
					$spt[$i]['offer_no'] = $v['offer_no'];
					$spt[$i]['sales_stage'] = $this->ExtranetUtilities->getSalesStageName($v['sales_stage']);
					$spt[$i]['product_series'] = $this->ExtranetUtilities->getProductSeriesName($v['product_series']);
					$spt[$i]['actual_product'] = $this->ExtranetUtilities->getActualProductName($v['actual_product']);
					$spt[$i]['forecasted_booking_value'] = $v['forecasted_booking_value'];
					$spt[$i]['quanitity'] = $v['quanitity'];
					$spt[$i]['expected_close_date'] = $v['expected_close_date'];
					$spt[$i]['expected_month'] = $this->ExtranetUtilities->getExpectedMonthName($v['expected_month']);
					$spt[$i]['close_probability'] = $this->ExtranetUtilities->getClosePropabilityName($v['close_probability']);
					$spt[$i]['next_action'] = $this->ExtranetUtilities->getNextActionName($v['next_action']);
					$spt[$i]['last_contacted_date'] = $v['last_contacted_date'];
					$spt[$i]['remarks'] = $v['remarks'];
					$spt[$i]['contacted_type'] = $this->ExtranetUtilities->getContactedTypeName($v['contacted_type']);
					$spt[$i]['contact'] = $v['contact'];
					$spt[$i]['designation'] = !empty($contact)?$contact->getDesignation():'';
					$spt[$i]['city'] = !empty($contact)?$contact->getCity():'';
					$spt[$i]['telephone'] = !empty($contact)?$contact->getTelephone():'';
					$spt[$i]['email'] = !empty($contact)?$contact->getEmail():'';
					$spt[$i]['website'] = !empty($contact)?$contact->getWebsite():'';
					$spt[$i]['date_created'] = $v['date_created'];
					$spt[$i]['date_modified'] = $v['date_modified'];
					$i++;
				}
			}
		}
		
		$fbv = [];
		foreach($spts as $k => $v){
			$fbv[] = ['stage' => $k, 'fbv' => array_sum(array_column($spts[$k],'forecasted_booking_value'))];
		}
		$total_fbv = array_sum(array_column($fbv,'fbv'));

		return ['total_fbv'=>$total_fbv,'fbv'=>$fbv,'data'=>$spt,'user'=>$user,'daterange'=>$dates];
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
