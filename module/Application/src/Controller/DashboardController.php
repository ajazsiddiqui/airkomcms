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
		$stages = $this->entityManager->getRepository(LeadStage::class)
            ->findAll();
		
		$array = [];
		foreach ($stages as $s){
			$spt = $this->entityManager->getRepository(Spt::class)
            ->findBy(['stage'=>$s->getId()]);
			$array[$s->getName()] = count($spt);
		}
		
		$users = $this->entityManager->getRepository(User::class)
            ->findAll();
		
		return new ViewModel(['data'=>$array,'users'=>$users]);
    }
	
	 public function sptreportAction()
    {
		
		$this->layout()->setTemplate('layout/blank');
		
		$post = $this->getRequest()->getPost()->toArray();
		if(!$post){
			return;
		}
		
		$spreadsheet = new Spreadsheet();
		$spreadsheet->getProperties()->setCreator('AirkomCMS')->setLastModifiedBy('AirkomCMS')->setTitle('AirkomCMS');
		// Rename worksheet
		$spreadsheet->getActiveSheet()->setTitle('SPT Report');
		$spreadsheet->setActiveSheetIndex(0) 
		->setCellValue('A1', 'Stage')
		->setCellValue('B1', 'Prospect Name')
		->setCellValue('C1', 'Lead Source Name')
		->setCellValue('D1', 'ExecUtive')
		->setCellValue('E1', 'Offer No')
		->setCellValue('F1', 'Sales Stage')
		->setCellValue('G1', 'Product Series')
		->setCellValue('H1', 'Actual Product')
		->setCellValue('I1', 'Forecasted Booking Value ')
		->setCellValue('J1', 'Quantity')
		->setCellValue('K1', 'Expected Close Date')
		->setCellValue('L1', 'Expected Month')
		->setCellValue('M1', 'Close Probability')
		->setCellValue('N1', 'Next Action')
		->setCellValue('O1', 'Last Contacted Date')
		->setCellValue('P1', 'Remarks')
		->setCellValue('Q1', 'Contacted Type')
		->setCellValue('R1', 'Contact Name')
		->setCellValue('S1', 'Designation')
		->setCellValue('T1', 'City')
		->setCellValue('U1', 'Telephone')
		->setCellValue('V1', 'Email')
		->setCellValue('W1', 'Website')
		->setCellValue('X1', 'Date Created');
		
		
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
				$query->AndWhere('S.createdBy = :createdBy')
					->setParameter('createdBy', $post['s_user']);
			
				$spt = $query->getQuery()->getArrayResult();

				if (!empty($spt)){
					$n = 1;

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
	
	public function dcrreportAction()
    {
		$this->layout()->setTemplate('layout/blank');
		
		$post = $this->getRequest()->getPost()->toArray();
		if(!$post){
			return;
		}
		
		$spreadsheet = new Spreadsheet();
		$spreadsheet->getProperties()->setCreator('AirkomCMS')->setLastModifiedBy('AirkomCMS')->setTitle('AirkomCMS');
		// Rename worksheet
		$spreadsheet->getActiveSheet()->setTitle('DCR Report');
		$spreadsheet->setActiveSheetIndex(0) 
			->setCellValue('A1', 'Visit Date')
			->setCellValue('B1', 'DCR No')
			->setCellValue('C1', 'Call Type')
			->setCellValue('D1', 'Call Count')
			->setCellValue('E1', 'Customer Name')
			->setCellValue('F1', 'City')
			->setCellValue('G1', 'Company Name')
			->setCellValue('H1', 'Contact No')
			->setCellValue('I1', 'Product')
			->setCellValue('J1', 'Model')
			->setCellValue('K1', 'Qty')
			->setCellValue('L1', 'Order Value (Basic)')
			->setCellValue('M1', 'Sales Stage')
			->setCellValue('N1', 'Next Action')
			->setCellValue('O1', 'Remarks')
			->setCellValue('P1', 'Bike Reading KM Start')
			->setCellValue('Q1', 'Bike Reading KM End')
			->setCellValue('R1', 'Distance Travelled')
			->setCellValue('S1', 'Amount 1')
			->setCellValue('T1', 'Local Travel Mode')
			->setCellValue('U1', 'Amount 2')
			->setCellValue('V1', 'Date Created');
		
		
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
					->setParameter('createdBy', $post['s_user']);
					
				$dcr = $query->getQuery()->getArrayResult();

				if (!empty($dcr)){
					$n = 1;

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
	
	public function roadmapreportAction()
    {
		$this->layout()->setTemplate('layout/blank');
		
		$post = $this->getRequest()->getPost()->toArray();
		if(!$post){
			return;
		}
		
		$spreadsheet = new Spreadsheet();
		$spreadsheet->getProperties()->setCreator('AirkomCMS')->setLastModifiedBy('AirkomCMS')->setTitle('AirkomCMS');
		// Rename worksheet
		$spreadsheet->getActiveSheet()->setTitle('Roadmap Report');
		$spreadsheet->setActiveSheetIndex(0) 
			->setCellValue('A1', 'Market Segment')
			->setCellValue('B1', 'Prospect Name')
			->setCellValue('C1', 'Prospect City ')
			->setCellValue('D1', 'Prospect Machine')
			->setCellValue('E1', 'Product')
			->setCellValue('F1', 'Product Series')
			->setCellValue('G1', 'Product Model')
			->setCellValue('H1', 'Action Plan')
			->setCellValue('I1', 'Exepected Qty')
			->setCellValue('J1', 'Expected Potential Order Value')
			->setCellValue('K1', 'Date Created');
		
		
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
				$query->AndWhere('R.createdBy = :createdBy')
					->setParameter('createdBy', $post['s_user']);
					
				$roadmap = $query->getQuery()->getArrayResult();

				if (!empty($roadmap)){
					$n = 1;

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
}
