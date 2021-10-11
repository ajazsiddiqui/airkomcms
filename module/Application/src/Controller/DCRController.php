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
use Application\Form\DCRForm;
use Application\Entity\Dcr;
use Application\Entity\Contacts;
use User\Entity\User;
use Settings\Entity\Settings;

class DCRController extends AbstractActionController
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
        $post = $this->getRequest()->getPost()->toArray();
		$form = new DCRForm();
		
        $user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['email' => $this->authService->getIdentity()]);
			
		$query = $this->entityManager->createQueryBuilder()->select('D')
				->from('Application\Entity\Dcr', 'D')
				->join('Application\Entity\Contacts', 'C', 'WITH', 'C.id = D.contactId');
		
		if($user->getUserType() != 1){
			$query->AndWhere('D.createdBy = :createdBy')
				->setParameter('createdBy', $user->getId());
		}
		
		if (!empty($post['s_company'])) {
			
			$query->AndWhere('C.company like :company')
				->setParameter('company',  '%'.$post['s_company'].'%');
		}
		
		$paginator['page'] = $this->params()->fromQuery('page', 1);
        $paginator['count'] = count($query->getQuery()->getScalarResult());
        $paginator['per_page'] = 10;
        $offset = $paginator['page'] * $paginator['per_page'] - $paginator['per_page'];

        $query->setFirstResult($offset)->setMaxResults($paginator['per_page'])->add('orderBy', 'D.id DESC');

        $dcr = $query->getQuery()->getResult();
		
		
        return new ViewModel(['dcr' => $dcr, 'form' => $form, 'paginator' => $paginator]);
    }
	
	public function addAction()
    {
		$form = new DCRForm();
		$form->get('travel_type')->setValueOptions($this->ExtranetUtilities->getTravelTypeList());
		$form->get('call_type')->setValueOptions($this->ExtranetUtilities->getCallTypeList());
		$form->get('contact_id')->setValueOptions($this->ExtranetUtilities->getContactsList());
		$form->get('product_series')->setValueOptions($this->ExtranetUtilities->getProductSeriesList());
		$form->get('product_model')->setValueOptions($this->ExtranetUtilities->getProductModelsList());
		$form->get('product_id')->setValueOptions($this->ExtranetUtilities->getProductsList());
		$form->get('sales_stage')->setValueOptions($this->ExtranetUtilities->getSalesStageList());
		$form->get('next_action')->setValueOptions($this->ExtranetUtilities->getNextActionList());
		$form->get('travel_mode')->setValueOptions($this->ExtranetUtilities->getTravelModeList());
		$form->get('call_count')->setValue(1)->setAttributes(['readonly'=>true]);
		$form->get('Bike_km_reading_start')->setValue(0);
		$form->get('bike_km_reading_end')->setValue(0);
		
		$settings = $this->entityManager->getRepository(Settings::class)
            ->find(['id' =>1]);
		
		$distance_travel_percentage = $settings->getDistanceTravelPercentage();
		
        $request = $this->getRequest();
        $user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['email' => $this->authService->getIdentity()], ['id' => 'ASC']);

        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            $form->setData($post);
            if ($form->isValid()) {
                $data = $form->getData();

                try {
                    $dcr = new Dcr();
					$dcr->setVisitDate($this->ExtranetUtilities->makeDate($data['visit_date']));
					$dcr->setStartPeriod($this->ExtranetUtilities->makeDate($data['start_period']));
					$dcr->setEndPeriod($this->ExtranetUtilities->makeDate($data['end_period']));
					$dcr->setDcrNo($data['dcr_no']);
					$dcr->setTravelType($data['travel_type']);
					$dcr->setCallType($data['call_type']);
					$dcr->setCallCount($data['call_count']);
					$dcr->setContactId($data['contact_id']);
					$dcr->setProductSeries($data['product_series']);
					$dcr->setProductModel($data['product_model']);
					$dcr->setProductId($data['product_id']);
					$dcr->setQuanitity($data['quanitity']);
					$dcr->setOrderValue((int)$data['order_value']);
					$dcr->setSalesStage($data['sales_stage']);
					$dcr->setNextAction($data['next_action']);
					$dcr->setRemarks($data['remarks']);
					$dcr->setBikeKmReadingStart($data['Bike_km_reading_start']);
					$dcr->setBikeKmReadingEnd($data['bike_km_reading_end']);
					$dcr->setDistanceTravelled($data['distance_travelled']);
					$dcr->setAmountOne((int)$data['amount_one']);
					$dcr->setTravelMode($data['travel_mode']);
					$dcr->setAmountTwo((int)$data['amount_two']);
					$dcr->setCreatedBy($user->getId());
                    $this->entityManager->persist($dcr);
                    $this->entityManager->flush();
                } catch (Exception $e) {
                    $this->logger->info('Caught exception: ', $e->getMessage(), "\n");
                }

                $log = $this->logManager;
                $log->setlog('DCR Added', $data['dcr_no'], $this->authService->getIdentity());
            } else {
                $this->logger->info('form validator: ', $form->getMessages(), "\n");
            }
            $this->flashMessenger()->addSuccessMessage('DCR Added '.$data['dcr_no']);

            return $this->redirect()->toRoute('dcr');
        }

        return new ViewModel(['form' => $form,'distance_travel_percentage' => $distance_travel_percentage]);
    }
	
	public function editAction()
    {
		$user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['email' => $this->authService->getIdentity()], ['id' => 'ASC']);

        $id = (int) $this->params()->fromRoute('id', -1);
        if ($id < 1) {
            $this->getResponse()->setStatusCode(404);

            return;
        }

        $dcr = $this->entityManager->getRepository(Dcr::class)
            ->find($id);

        if (null == $dcr) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $form = new DCRForm();
		$form->get('travel_type')->setValueOptions($this->ExtranetUtilities->getTravelTypeList());
		$form->get('call_type')->setValueOptions($this->ExtranetUtilities->getCallTypeList());
		$form->get('contact_id')->setValueOptions($this->ExtranetUtilities->getContactsList());
		$form->get('product_series')->setValueOptions($this->ExtranetUtilities->getProductSeriesList());
		$form->get('product_model')->setValueOptions($this->ExtranetUtilities->getProductModelsList());
		$form->get('product_id')->setValueOptions($this->ExtranetUtilities->getProductsList());
		$form->get('sales_stage')->setValueOptions($this->ExtranetUtilities->getSalesStageList());
		$form->get('next_action')->setValueOptions($this->ExtranetUtilities->getNextActionList());
		$form->get('travel_mode')->setValueOptions($this->ExtranetUtilities->getTravelModeList());
		$form->get('call_count')->setValue(1)->setAttributes(['readonly'=>true]);
		$form->get('Bike_km_reading_start')->setValue(0);
		$form->get('bike_km_reading_end')->setValue(0);
		
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();

                try {
					$dcr->setVisitDate($this->ExtranetUtilities->makeDate($data['visit_date']));
					$dcr->setStartPeriod($this->ExtranetUtilities->makeDate($data['start_period']));
					$dcr->setEndPeriod($this->ExtranetUtilities->makeDate($data['end_period']));
					$dcr->setDcrNo($data['dcr_no']);
					$dcr->setTravelType($data['travel_type']);
					$dcr->setCallType($data['call_type']);
					$dcr->setCallCount($data['call_count']);
					$dcr->setContactId($data['contact_id']);
					$dcr->setProductSeries($data['product_series']);
					$dcr->setProductModel($data['product_model']);
					$dcr->setProductId($data['product_id']);
					$dcr->setQuanitity($data['quanitity']);
					$dcr->setOrderValue((int)$data['order_value']);
					$dcr->setSalesStage($data['sales_stage']);
					$dcr->setNextAction($data['next_action']);
					$dcr->setRemarks($data['remarks']);
					$dcr->setBikeKmReadingStart($data['Bike_km_reading_start']);
					$dcr->setBikeKmReadingEnd($data['bike_km_reading_end']);
					$dcr->setDistanceTravelled($data['distance_travelled']);
					$dcr->setAmountOne((int)$data['amount_one']);
					$dcr->setTravelMode($data['travel_mode']);
					$dcr->setAmountTwo((int)$data['amount_two']);
					$dcr->setCreatedBy($user->getId());
                    $this->entityManager->persist($dcr);
                    $this->entityManager->flush();
                } catch (Exception $e) {
                    $this->logger->info('Caught exception: ', $e->getMessage(), "\n");
                }

                $log = $this->logManager;
                $log->setlog('DCR Edited', $data['dcr_no'], $this->authService->getIdentity());

                $this->flashMessenger()->addSuccessMessage('DCR Edited '.$data['dcr_no']);

                return $this->redirect()->toRoute('dcr');
            }
            $this->logger->info('form validator: ', $form->getMessages(), "\n");
        } else {
            $form->setData(
                [
				'visit_date' => $dcr->getVisitdate()->format('dd/mm/Y'),
				'start_period' => $dcr->getStartperiod()->format('dd/mm/Y'),
				'end_period' => $dcr->getEndperiod()->format('dd/mm/Y'),
				'dcr_no' => $dcr->getDcrno(),
				'travel_type' => $dcr->getTraveltype(),
				'call_type' => $dcr->getCalltype(),
				'call_count' => $dcr->getCallcount(),
				'contact_id' => $dcr->getContactid(),
				'product_series' => $dcr->getProductseries(),
				'product_model' => $dcr->getProductmodel(),
				'product_id' => $dcr->getProductid(),
				'quanitity' => $dcr->getQuanitity(),
				'order_value' => $dcr->getOrdervalue(),
				'sales_stage' => $dcr->getSalesstage(),
				'next_action' => $dcr->getNextaction(),
				'remarks' => $dcr->getRemarks(),
				'Bike_km_reading_start' => $dcr->getBikeKmReadingStart(),
				'bike_km_reading_end' => $dcr->getBikeKmReadingEnd(),
				'distance_travelled' => $dcr->getDistancetravelled(),
				'amount_one' => $dcr->getAmountone(),
				'travel_mode' => $dcr->getTravelmode(),
				'amount_two' => $dcr->getAmounttwo()
                ]
            );
        }

		$settings = $this->entityManager->getRepository(Settings::class)
            ->find(['id' =>1]);
		
		$distance_travel_percentage = $settings->getDistanceTravelPercentage();
		
        return new ViewModel(['form' => $form,'distance_travel_percentage' => $distance_travel_percentage]);

    }
	
	public function deleteAction()
    {
		$id = (int) $this->params()->fromRoute('id', -1);
        $dcr = $this->entityManager->getRepository(Dcr::class)
            ->find($id);
        $Dcrid = $dcr->getDcrno();
        $this->entityManager->remove($dcr);
        $this->entityManager->flush();

        $log = $this->logManager;
        $log->setlog('DCR Deleted', $Dcrid, $this->authService->getIdentity());

        $this->flashMessenger()->addSuccessMessage('DCR deleted '.$Dcrid);

        return $this->redirect()->toRoute('dcr');
       
    }
}
