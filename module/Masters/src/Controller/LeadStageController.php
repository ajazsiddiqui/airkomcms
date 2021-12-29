<?php

namespace Masters\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Masters\Entity\LeadStage;
use Masters\Form\LeadStageForm;
use User\Entity\User;

class LeadStageController extends AbstractActionController
{
    private $authService;
    private $entityManager;
    private $logManager;

    public function __construct($authService, $entityManager, $logManager)
    {
        $this->authService = $authService;
        $this->entityManager = $entityManager;
        $this->logManager = $logManager;
    }

    public function indexAction()
    {
        $paginator['page'] = $this->params()->fromQuery('page', 1);
        $paginator['count'] = $this->entityManager->getUnitOfWork()->getEntityPersister(LeadStage::class)->count();
        $paginator['per_page'] = 10;
        $offset = $paginator['page'] * $paginator['per_page'] - $paginator['per_page'];

        $form = new LeadStageForm();
        $lead_stage = $this->entityManager->getRepository(LeadStage::class)
            ->findBy([], ['id' => 'ASC'], $paginator['per_page'], $offset);

        return new ViewModel(['lead_stage' => $lead_stage, 'form' => $form, 'paginator' => $paginator]);
    }

    public function addAction()
    {
        $form = new LeadStageForm();
        $request = $this->getRequest();
        $user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['email' => $this->authService->getIdentity()], ['id' => 'ASC'])
        ;

        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            $form->setData($post);
            if ($form->isValid()) {
                $data = $form->getData();

                try {
                    $LeadStage = new LeadStage();
                    $LeadStage->setName($data['name']);
                    $LeadStage->setStatus($data['status']);
                    $LeadStage->setCreatedBy($user->getId());
                    $this->entityManager->persist($LeadStage);
                    $this->entityManager->flush();
                } catch (Exception $e) {
                    $this->logger->info('Caught exception: ', $e->getMessage(), "\n");
                }

                $log = $this->logManager;
                $log->setlog('LeadStage Added', $data['name'], $this->authService->getIdentity());
            } else {
                $this->logger->info('form validator: ', $form->getMessages(), "\n");
            }
            $this->flashMessenger()->addSuccessMessage('LeadStage Added '.$data['name']);

            return $this->redirect()->toRoute('lead-stage', ['action' => 'index']);
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

        $LeadStage = $this->entityManager->getRepository(LeadStage::class)
            ->find($id)
        ;

        if (null == $LeadStage) {
            $this->getResponse()->setStatusCode(404);

            return;
        }

        $form = new LeadStageForm();

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();

                try {
                    $LeadStage->setName($data['name']);
                    $LeadStage->setStatus($data['status']);
                    $LeadStage->setCreatedBy($user->getId());
                    $this->entityManager->persist($LeadStage);
                    $this->entityManager->flush();
                } catch (Exception $e) {
                    $this->logger->info('Caught exception: ', $e->getMessage(), "\n");
                }

                $log = $this->logManager;
                $log->setlog('LeadStage Edited', $data['name'], $this->authService->getIdentity());

                $this->flashMessenger()->addSuccessMessage('LeadStage Edited '.$data['name']);

                return $this->redirect()->toRoute('lead-stage', ['action' => 'index']);
            }
            $this->logger->info('form validator: ', $form->getMessages(), "\n");
        } else {
            $form->setData(
                [
                    'name' => $LeadStage->getName(),
                    'status' => $LeadStage->getStatus(),
                ]
            );
        }

        return new ViewModel(['form' => $form]);
    }

    public function setstatusAction()
    {
        $id = (int) $this->params()->fromRoute('id', -1);
        $LeadStage = $this->entityManager->getRepository(LeadStage::class)
            ->findOneBy(['id' => $id]);
			
        $name = $LeadStage->getName();
        $status = $LeadStage->getStatus();
        if (1 == $status) {
            $LeadStage->setStatus('0');
        } else {
            $LeadStage->setStatus('1');
        }
        $this->entityManager->persist($LeadStage);
        $this->entityManager->flush();

        $this->flashMessenger()->addSuccessMessage('LeadStage Status of '.$name.'  Changed');

        return $this->redirect()->toRoute('lead-stage');
    }
	
		// public function deleteAction()
    // {
		// $id = (int) $this->params()->fromRoute('id', -1);
        // $LeadStage = $this->entityManager->getRepository(LeadStage::class)
            // ->find($id);
        // $name = $LeadStage->getName();
        // $this->entityManager->remove($LeadStage);
        // $this->entityManager->flush();

        // $log = $this->logManager;
        // $log->setlog('LeadStage Deleted', $name, $this->authService->getIdentity());

        // $this->flashMessenger()->addSuccessMessage('LeadStage deleted '.$name);

        // return $this->redirect()->toRoute('lead-stage');
       
    // }
}
