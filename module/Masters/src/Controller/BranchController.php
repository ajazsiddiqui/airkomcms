<?php

namespace Masters\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Masters\Entity\Branch;
use Masters\Form\BranchForm;
use User\Entity\User;

class BranchController extends AbstractActionController
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
        $paginator['count'] = $this->entityManager->getUnitOfWork()->getEntityPersister(Branch::class)->count();
        $paginator['per_page'] = 10;
        $offset = $paginator['page'] * $paginator['per_page'] - $paginator['per_page'];

        $form = new BranchForm();
        $branches = $this->entityManager->getRepository(Branch::class)
            ->findBy([], ['id' => 'ASC'], $paginator['per_page'], $offset);

        return new ViewModel(['branches' => $branches, 'form' => $form, 'paginator' => $paginator]);
    }

    public function addAction()
    {
        $form = new BranchForm();
        $request = $this->getRequest();
        $user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['email' => $this->authService->getIdentity()], ['id' => 'ASC']);

        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            $form->setData($post);
            if ($form->isValid()) {
                $data = $form->getData();

                try {
                    $branch = new Branch();
                    $branch->setName($data['name']);
                    $branch->setStatus($data['status']);
                    $branch->setCreatedBy($user->getId());
                    $this->entityManager->persist($branch);
                    $this->entityManager->flush();
                } catch (Exception $e) {
                    $this->logger->info('Caught exception: ', $e->getMessage(), "\n");
                }

                $log = $this->logManager;
                $log->setlog('Branch Added', $data['name'], $this->authService->getIdentity());
            } else {
                $this->logger->info('form validator: ', $form->getMessages(), "\n");
            }
            $this->flashMessenger()->addSuccessMessage('Branch Added '.$data['name']);

            return $this->redirect()->toRoute('branch', ['action' => 'index']);
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

        $branch = $this->entityManager->getRepository(Branch::class)
            ->find($id);

        if (null == $branch) {
            $this->getResponse()->setStatusCode(404);

            return;
        }

        $form = new BranchForm();

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();

                try {
                    $branch->setName($data['name']);
                    $branch->setStatus($data['status']);
                    $branch->setCreatedBy($user->getId());
                    $this->entityManager->persist($branch);
                    $this->entityManager->flush();
                } catch (Exception $e) {
                    $this->logger->info('Caught exception: ', $e->getMessage(), "\n");
                }

                $log = $this->logManager;
                $log->setlog('Branch Edited', $data['name'], $this->authService->getIdentity());

                $this->flashMessenger()->addSuccessMessage('Branch Edited '.$data['name']);

                return $this->redirect()->toRoute('branch', ['action' => 'index']);
            }
            $this->logger->info('form validator: ', $form->getMessages(), "\n");
        } else {
            $form->setData(
                [
                    'name' => $branch->getName(),
                    'status' => $branch->getStatus(),
                ]
            );
        }

        return new ViewModel(['form' => $form]);
    }

    public function setstatusAction()
    {
        $id = (int) $this->params()->fromRoute('id', -1);
        $branch = $this->entityManager->getRepository(Branch::class)
            ->findOneBy(['id' => $id]);
			
        $name = $branch->getName();
        $status = $branch->getStatus();
        if (1 == $status) {
            $branch->setStatus('0');
        } else {
            $branch->setStatus('1');
        }
        $this->entityManager->persist($branch);
        $this->entityManager->flush();

        $this->flashMessenger()->addSuccessMessage('Branch Status of '.$name.'  Changed');

        return $this->redirect()->toRoute('branch');
    }
	
	public function deleteAction()
    {
		$id = (int) $this->params()->fromRoute('id', -1);
        $branch = $this->entityManager->getRepository(Branch::class)
            ->find($id);
        $name = $branch->getName();
        $this->entityManager->remove($branch);
        $this->entityManager->flush();

        $log = $this->logManager;
        $log->setlog('Call Type Deleted', $name, $this->authService->getIdentity());

        $this->flashMessenger()->addSuccessMessage('Call Type deleted '.$name);

        return $this->redirect()->toRoute('branch');
       
    }
}
