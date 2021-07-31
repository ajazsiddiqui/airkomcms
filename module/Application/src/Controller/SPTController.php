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
use Laminas\View\Model\JsonModel;
use Application\Entity\Pipeline;

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
	
	public function getContactAction()
    {
		$id = $this->params()->fromQuery('contactid', 0);
        $this->cors();
		$contact = $this->entityManager->getRepository(Contacts::class)
            ->findOneBY(['id'=>$id]);
			
		if(empty($contact)){
			return new JsonModel([]);
		}
        $array = ['name'=>$contact->getName()];

        return new JsonModel($array);
    }
	
    public function indexAction()
    {
        $form = new SPTForm();
        
		$user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['email' => $this->authService->getIdentity()]);
			
		$paginator['page'] = $this->params()->fromQuery('page', 1);
		$paginator['per_page'] = 10;
			
		if($user->getUserType() == 1){
			$paginator['count'] = $this->entityManager->getUnitOfWork()->getEntityPersister(Spt::class)->count();
			$offset = $paginator['page'] * $paginator['per_page'] - $paginator['per_page'];
			
			$spt = $this->entityManager->getRepository(Spt::class)
            ->findBy([], ['id' => 'DESC'], $paginator['per_page'], $offset);
		}else{
			$spt = $this->entityManager->getRepository(Spt::class)
            ->findBy(['createdBy'=>$user->getId()]);
			
			$paginator['count'] = count($spt);
			$offset = $paginator['page'] * $paginator['per_page'] - $paginator['per_page'];
		}
		
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
		$form->get('propect_name')->setValueOptions($this->ExtranetUtilities->getContactsList());
		$form->get('contacted_type')->setValueOptions($this->ExtranetUtilities->getContactedTypeList());
		
        $request = $this->getRequest();
        $user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['email' => $this->authService->getIdentity()]);

        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            $form->setData($post);
            if ($form->isValid()) {
                $data = $form->getData();
				
			// $spt = $this->entityManager->getRepository(Spt::class)
					// ->findOneBy(['propectName' => $data['propect_name']]);	
			
			// if(!empty($spt)){			
				// $this->flashMessenger()->addErrorMessage('Prospect already there in SPT.');
				// return $this->redirect()->toRoute('spt');
			// }
			
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
					$spt->setDiscountOffered((float)($data['discount_offered']));
					$spt->setQuanitity($data['quanitity']);
					$spt->setExpectedCloseDate($this->ExtranetUtilities->makeDate($data['expected_close_date']));
					$spt->setExpectedMonth($data['expected_month']);
					$spt->setCloseProbability($data['close_probability']);
					$spt->setNextAction($data['next_action']);
					$spt->setLastContactedDate($this->ExtranetUtilities->makeDate($data['last_contacted_date']));
					$spt->setRemarks($data['remarks']);
					$spt->setContactedType($data['contacted_type']);
					$spt->setContact($data['contact']);
					$spt->setCreatedBy($user->getId());
                    $this->entityManager->persist($spt);
                    $this->entityManager->flush();
					
					//Add to Pipeline
					$pipeline = new Pipeline();
					$pipeline->setContact($data['propect_name']);
					$pipeline->setSptId($spt->getId());
					$pipeline->setStage($data['stage']);
					$pipeline->setCreatedBy($user->getId());
					$this->entityManager->persist($pipeline);
					$this->entityManager->flush();
					
					$this->flashMessenger()->addSuccessMessage('SPT Added '.$data['propect_name']);
                } catch (Exception $e) {
                    $this->logger->info('Caught exception: ', $e->getMessage(), "\n");
                }

                $log = $this->logManager;
                $log->setlog('SPT Added', $data['propect_name'], $this->authService->getIdentity());
            } else {
                print_r($form->getMessages());
            }
            

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
		$form->get('propect_name')->setValueOptions($this->ExtranetUtilities->getContactsList());
		$form->get('contacted_type')->setValueOptions($this->ExtranetUtilities->getContactedTypeList());
		
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();

                try {
					$spt->setStage($spt->getStage());
					//$spt->setPropectName($data['propect_name']);
					$spt->setLeadSource($data['lead_source']);
					$spt->setExecutive($data['executive']);
					$spt->setOfferNo($data['offer_no']);
					$spt->setSalesStage($data['sales_stage']);
					$spt->setProductSeries($data['product_series']);
					$spt->setProductModel($data['product_model']);
					$spt->setActualProduct($data['actual_product']);
					$spt->setForecastedBookingValue((float)($data['forecasted_booking_value']));
					$spt->setDiscountOffered((float)($data['discount_offered']));
					$spt->setQuanitity($data['quanitity']);
					$spt->setExpectedCloseDate($this->ExtranetUtilities->makeDate($data['expected_close_date']));
					$spt->setExpectedMonth($data['expected_month']);
					$spt->setCloseProbability($data['close_probability']);
					$spt->setNextAction($data['next_action']);
					$spt->setLastContactedDate($this->ExtranetUtilities->makeDate($data['last_contacted_date']));
					$spt->setRemarks($data['remarks']);
					$spt->setContactedType($data['contacted_type']);
					$spt->setContact($data['contact']);
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
            print_r($form->getMessages());
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
			'discount_offered' => $spt->getDiscountOffered(),
			'quanitity' => $spt->getQuanitity(),
			'expected_close_date' => $spt->getExpectedCloseDate()->format('dd/mm/Y'),
			'expected_month' => $spt->getExpectedMonth(),
			'close_probability' => $spt->getCloseProbability(),
			'next_action' => $spt->getNextAction(),
			'last_contacted_date' => $spt->getLastcontactedDate()->format('dd/mm/Y'),
			'remarks' => $spt->getRemarks(),
			'contacted_type' => $spt->getContactedType(),
			'contact' => $spt->getContact(),
                ]
            );
        }

		$settings = $this->entityManager->getRepository(Settings::class)
            ->find(['id' =>1]);
		
        return new ViewModel(['form' => $form,'stage'=>$spt->getStage()]);

    }
	
	public function deleteAction()
    {
		$id = (int) $this->params()->fromRoute('id', -1);
        $spt = $this->entityManager->getRepository(Spt::class)
            ->find($id);
        $Sptid = $spt->getPropectName();
        $this->entityManager->remove($spt);
        $this->entityManager->flush();
		
        $pipeline = $this->entityManager->getRepository(Pipeline::class)
            ->findOneBy(['sptId'=>$id]);
        $this->entityManager->remove($pipeline);
        $this->entityManager->flush();

        $log = $this->logManager;
        $log->setlog('SPT Deleted', $Sptid, $this->authService->getIdentity());

        $this->flashMessenger()->addSuccessMessage('SPT deleted '.$Sptid);

        return $this->redirect()->toRoute('spt');
       
    }
}
