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
use Application\Form\SPTForm;
use Application\Entity\Spt;
use Application\Entity\Contacts;
use User\Entity\User;
use Settings\Entity\Settings;

class SPTController extends AbstractActionController
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
		$paginator['page'] = $this->params()->fromQuery('page', 1);
        $paginator['count'] = $this->entityManager->getUnitOfWork()->getEntityPersister(SPT::class)->count();
        $paginator['per_page'] = 10;
        $offset = $paginator['page'] * $paginator['per_page'] - $paginator['per_page'];

        $form = new SPTForm();
        $spt = $this->entityManager->getRepository(Spt::class)
            ->findBy([], ['id' => 'ASC'], $paginator['per_page'], $offset);

        return new ViewModel(['spt' => $spt, 'form' => $form, 'paginator' => $paginator]);
    }
	
	public function addAction()
    {
		$form = new SPTForm();
		$form->get('stage')->setValueOptions($this->ExtranetUtilities->getLeadStageList());
		$form->get('executive')->setValueOptions($this->ExtranetUtilities->getExecutiveList());
		$form->get('lead_source')->setValueOptions($this->ExtranetUtilities->getLeadSourceList());
		$form->get('sales_stage')->setValueOptions($this->ExtranetUtilities->getSalesStageList());
		$form->get('product_series')->setValueOptions($this->ExtranetUtilities->getProductSeriesList());
		$form->get('product_model')->setValueOptions($this->ExtranetUtilities->getProductModelsList());
		$form->get('actual_product')->setValueOptions($this->ExtranetUtilities->getProductsList());
		$form->get('close_probability')->setValueOptions($this->ExtranetUtilities->getProbabilityList());
		$form->get('next_action')->setValueOptions($this->ExtranetUtilities->getNextActionList());
		$form->get('contact_id')->setValueOptions($this->ExtranetUtilities->getContactsList());
		$form->get('contacted_type')->setValueOptions($this->ExtranetUtilities->getContactedTypeList());
		
        $request = $this->getRequest();
        $user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['email' => $this->authService->getIdentity()], ['id' => 'ASC']);

        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            $form->setData($post);
            if ($form->isValid()) {
                $data = $form->getData();
                try {
                    $spt = new Spt();
					$spt->setStage($data['stage']);
					$spt->setPropectName($data['propect_name']);
					$spt->setLeadSource($data['lead_source']);
					$spt->setExecutive($data['executive']);
					$spt->setOfferNo($data['offer_no']);
					$spt->setSalesStage($data['sales_stage']);
					$spt->setProductSeries($data['product_series']);
					$spt->setProductModel($data['product_model']);
					$spt->setActualProduct($data['actual_product']);
					$spt->setForecastedBookingValue((float)($data['forecasted_booking_value']));
					$spt->setQuanitity($data['quanitity']);
					$spt->setExpectedCloseDate($this->ExtranetUtilities->makeDate($data['expected_close_date']));
					$spt->setExpectedMonth($data['expected_month']);
					$spt->setCloseProbability($data['close_probability']);
					$spt->setNextAction($data['next_action']);
					$spt->setLastContactedDate($this->ExtranetUtilities->makeDate($data['last_contacted_date']));
					$spt->setRemarks($data['remarks']);
					$spt->setContactedType($data['contacted_type']);
					$spt->setContactId($data['contact_id']);
					$spt->setCreatedBy($user->getId());
                    $this->entityManager->persist($spt);
                    $this->entityManager->flush();
                } catch (Exception $e) {
                    $this->logger->info('Caught exception: ', $e->getMessage(), "\n");
                }

                $log = $this->logManager;
                $log->setlog('SPT Added', $data['propect_name'], $this->authService->getIdentity());
            } else {
                $this->logger->info('form validator: ', $form->getMessages(), "\n");
            }
            $this->flashMessenger()->addSuccessMessage('SPT Added '.$data['propect_name']);

            return $this->redirect()->toRoute('spt');
        }

        return new ViewModel(['form' => $form]);
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

        $spt = $this->entityManager->getRepository(Spt::class)
            ->find($id);

        if (null == $spt) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $form = new SPTForm();
		$form->get('stage')->setValueOptions($this->ExtranetUtilities->getLeadStageList());
		$form->get('executive')->setValueOptions($this->ExtranetUtilities->getExecutiveList());
		$form->get('lead_source')->setValueOptions($this->ExtranetUtilities->getLeadSourceList());
		$form->get('sales_stage')->setValueOptions($this->ExtranetUtilities->getSalesStageList());
		$form->get('product_series')->setValueOptions($this->ExtranetUtilities->getProductSeriesList());
		$form->get('product_model')->setValueOptions($this->ExtranetUtilities->getProductModelsList());
		$form->get('actual_product')->setValueOptions($this->ExtranetUtilities->getProductsList());
		$form->get('close_probability')->setValueOptions($this->ExtranetUtilities->getProbabilityList());
		$form->get('next_action')->setValueOptions($this->ExtranetUtilities->getNextActionList());
		$form->get('contact_id')->setValueOptions($this->ExtranetUtilities->getContactsList());
		$form->get('contacted_type')->setValueOptions($this->ExtranetUtilities->getContactedTypeList());
		
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();

                try {
					$spt->setStage($data['stage']);
					$spt->setPropectName($data['propect_name']);
					$spt->setLeadSource($data['lead_source']);
					$spt->setExecutive($data['executive']);
					$spt->setOfferNo($data['offer_no']);
					$spt->setSalesStage($data['sales_stage']);
					$spt->setProductSeries($data['product_series']);
					$spt->setProductModel($data['product_model']);
					$spt->setActualProduct($data['actual_product']);
					$spt->setForecastedBookingValue((float)($data['forecasted_booking_value']));
					$spt->setQuanitity($data['quanitity']);
					$spt->setExpectedCloseDate($this->ExtranetUtilities->makeDate($data['expected_close_date']));
					$spt->setExpectedMonth($data['expected_month']);
					$spt->setCloseProbability($data['close_probability']);
					$spt->setNextAction($data['next_action']);
					$spt->setLastContactedDate($this->ExtranetUtilities->makeDate($data['last_contacted_date']));
					$spt->setRemarks($data['remarks']);
					$spt->setContactedType($data['contacted_type']);
					$spt->setContactId($data['contact_id']);
					$spt->setCreatedBy($user->getId());
                    $this->entityManager->persist($spt);
                    $this->entityManager->flush();
                } catch (Exception $e) {
                    $this->logger->info('Caught exception: ', $e->getMessage(), "\n");
                }

                $log = $this->logManager;
                $log->setlog('SPT Edited', $data['propect_name'], $this->authService->getIdentity());

                $this->flashMessenger()->addSuccessMessage('SPT Edited '.$data['propect_name']);

                return $this->redirect()->toRoute('spt');
            }
            $this->logger->info('form validator: ', $form->getMessages(), "\n");
        } else {
            $form->setData(
                [
			'stage' => $spt->getStage(),
			'propect_name' => $spt->getPropectName(),
			'lead_source' => $spt->getLeadSource(),
			'executive' => $spt->getExecutive(),
			'offer_no' => $spt->getOfferNo(),
			'sales_stage' => $spt->getSalesStage(),
			'product_series' => $spt->getProductSeries(),
			'product_model' => $spt->getProductModel(),
			'actual_product' => $spt->getActualProduct(),
			'forecasted_booking_value' => $spt->getForecastedBookingValue(),
			'quanitity' => $spt->getQuanitity(),
			'expected_close_date' => $spt->getExpectedCloseDate()->format('dd/mm/Y'),
			'expected_month' => $spt->getExpectedMonth(),
			'close_probability' => $spt->getCloseProbability(),
			'next_action' => $spt->getNextAction(),
			'last_contacted_date' => $spt->getLastcontactedDate()->format('dd/mm/Y'),
			'remarks' => $spt->getRemarks(),
			'contacted_type' => $spt->getContactedType(),
			'contact_id' => $spt->getContactId(),
                ]
            );
        }

		$settings = $this->entityManager->getRepository(Settings::class)
            ->find(['id' =>1]);
		
        return new ViewModel(['form' => $form]);

    }
	
	public function deleteAction()
    {
		$id = (int) $this->params()->fromRoute('id', -1);
        $spt = $this->entityManager->getRepository(Spt::class)
            ->find($id);
        $Sptid = $spt->getPropectName();
        $this->entityManager->remove($spt);
        $this->entityManager->flush();

        $log = $this->logManager;
        $log->setlog('SPT Deleted', $Sptid, $this->authService->getIdentity());

        $this->flashMessenger()->addSuccessMessage('SPT deleted '.$Sptid);

        return $this->redirect()->toRoute('spt');
       
    }
}
