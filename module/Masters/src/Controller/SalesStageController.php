<?php

namespace Masters\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Masters\Entity\SalesStage;
use Masters\Form\SalesStageForm;
use User\Entity\User;

class SalesStageController extends AbstractActionController
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
        $paginator['count'] = $this->entityManager->getUnitOfWork()->getEntityPersister(SalesStage::class)->count();
        $paginator['per_page'] = 10;
        $offset = $paginator['page'] * $paginator['per_page'] - $paginator['per_page'];

        $form = new SalesStageForm();
        $sales_stage = $this->entityManager->getRepository(SalesStage::class)
            ->findBy([], ['id' => 'ASC'], $paginator['per_page'], $offset);

        return new ViewModel(['sales_stage' => $sales_stage, 'form' => $form, 'paginator' => $paginator]);
    }

    public function addAction()
    {
        $form = new SalesStageForm();
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
                    $SalesStage = new SalesStage();
                    $SalesStage->setName($data['name']);
                    $SalesStage->setStatus($data['status']);
                    $SalesStage->setCreatedBy($user->getId());
                    $this->entityManager->persist($SalesStage);
                    $this->entityManager->flush();
                } catch (Exception $e) {
                    $this->logger->info('Caught exception: ', $e->getMessage(), "\n");
                }

                $log = $this->logManager;
                $log->setlog('SalesStage Added', $data['name'], $this->authService->getIdentity());
            } else {
                $this->logger->info('form validator: ', $form->getMessages(), "\n");
            }
            $this->flashMessenger()->addSuccessMessage('SalesStage Added '.$data['name']);

            return $this->redirect()->toRoute('sales-stage', ['action' => 'index']);
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

        $SalesStage = $this->entityManager->getRepository(SalesStage::class)
            ->find($id)
        ;

        if (null == $SalesStage) {
            $this->getResponse()->setStatusCode(404);

            return;
        }

        $form = new SalesStageForm();

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();

                try {
                    $SalesStage->setName($data['name']);
                    $SalesStage->setStatus($data['status']);
                    $SalesStage->setCreatedBy($user->getId());
                    $this->entityManager->persist($SalesStage);
                    $this->entityManager->flush();
                } catch (Exception $e) {
                    $this->logger->info('Caught exception: ', $e->getMessage(), "\n");
                }

                $log = $this->logManager;
                $log->setlog('SalesStage Edited', $data['name'], $this->authService->getIdentity());

                $this->flashMessenger()->addSuccessMessage('SalesStage Edited '.$data['name']);

                return $this->redirect()->toRoute('sales-stage', ['action' => 'index']);
            }
            $this->logger->info('form validator: ', $form->getMessages(), "\n");
        } else {
            $form->setData(
                [
                    'name' => $SalesStage->getName(),
                    'status' => $SalesStage->getStatus(),
                ]
            );
        }

        return new ViewModel(['form' => $form]);
    }

    public function setstatusAction()
    {
        $id = (int) $this->params()->fromRoute('id', -1);
        $SalesStage = $this->entityManager->getRepository(SalesStage::class)
            ->findOneBy(['id' => $id]);
			
        $name = $SalesStage->getName();
        $status = $SalesStage->getStatus();
        if (1 == $status) {
            $SalesStage->setStatus('0');
        } else {
            $SalesStage->setStatus('1');
        }
        $this->entityManager->persist($SalesStage);
        $this->entityManager->flush();

        $this->flashMessenger()->addSuccessMessage('Sales Stage Status of '.$name.'  Changed');

        return $this->redirect()->toRoute('sales-stage');
    }
	
		public function deleteAction()
    {
		$id = (int) $this->params()->fromRoute('id', -1);
        $SalesStage = $this->entityManager->getRepository(SalesStage::class)
            ->find($id);
        $name = $SalesStage->getName();
        $this->entityManager->remove($SalesStage);
        $this->entityManager->flush();

        $log = $this->logManager;
        $log->setlog('Sales Stage Deleted', $name, $this->authService->getIdentity());

        $this->flashMessenger()->addSuccessMessage('Sales Stage deleted '.$name);

        return $this->redirect()->toRoute('sales-stage');
       
    }
}
