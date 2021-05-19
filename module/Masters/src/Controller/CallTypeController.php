<?php

namespace Masters\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Masters\Entity\CallType;
use Masters\Form\CallTypeForm;
use User\Entity\User;

class CallTypeController extends AbstractActionController
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
        $paginator['count'] = $this->entityManager->getUnitOfWork()->getEntityPersister(CallType::class)->count();
        $paginator['per_page'] = 10;
        $offset = $paginator['page'] * $paginator['per_page'] - $paginator['per_page'];

        $form = new CallTypeForm();
        $call_type = $this->entityManager->getRepository(CallType::class)
            ->findBy([], ['id' => 'ASC'], $paginator['per_page'], $offset);

        return new ViewModel(['call_type' => $call_type, 'form' => $form, 'paginator' => $paginator]);
    }

    public function addAction()
    {
        $form = new CallTypeForm();
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
                    $calltype = new CallType();
                    $calltype->setName($data['name']);
                    $calltype->setStatus($data['status']);
                    $calltype->setCreatedBy($user->getId());
                    $this->entityManager->persist($calltype);
                    $this->entityManager->flush();
                } catch (Exception $e) {
                    $this->logger->info('Caught exception: ', $e->getMessage(), "\n");
                }

                $log = $this->logManager;
                $log->setlog('CallType Added', $data['name'], $this->authService->getIdentity());
            } else {
                $this->logger->info('form validator: ', $form->getMessages(), "\n");
            }
            $this->flashMessenger()->addSuccessMessage('CallType Added '.$data['name']);

            return $this->redirect()->toRoute('call-type', ['action' => 'index']);
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

        $calltype = $this->entityManager->getRepository(CallType::class)
            ->find($id)
        ;

        if (null == $calltype) {
            $this->getResponse()->setStatusCode(404);

            return;
        }

        $form = new CallTypeForm();

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();

                try {
                    $calltype->setName($data['name']);
                    $calltype->setStatus($data['status']);
                    $calltype->setCreatedBy($user->getId());
                    $this->entityManager->persist($calltype);
                    $this->entityManager->flush();
                } catch (Exception $e) {
                    $this->logger->info('Caught exception: ', $e->getMessage(), "\n");
                }

                $log = $this->logManager;
                $log->setlog('CallType Edited', $data['name'], $this->authService->getIdentity());

                $this->flashMessenger()->addSuccessMessage('CallType Edited '.$data['name']);

                return $this->redirect()->toRoute('call-type', ['action' => 'index']);
            }
            $this->logger->info('form validator: ', $form->getMessages(), "\n");
        } else {
            $form->setData(
                [
                    'name' => $calltype->getName(),
                    'status' => $calltype->getStatus(),
                ]
            );
        }

        return new ViewModel(['form' => $form]);
    }

    public function setstatusAction()
    {
        $id = (int) $this->params()->fromRoute('id', -1);
        $calltype = $this->entityManager->getRepository(CallType::class)
            ->findOneBy(['id' => $id]);
			
        $name = $calltype->getName();
        $status = $calltype->getStatus();
        if (1 == $status) {
            $calltype->setStatus('0');
        } else {
            $calltype->setStatus('1');
        }
        $this->entityManager->persist($calltype);
        $this->entityManager->flush();

        $this->flashMessenger()->addSuccessMessage('CallType Status of '.$name.'  Changed');

        return $this->redirect()->toRoute('call-type');
    }
	
	public function deleteAction()
    {
		$id = (int) $this->params()->fromRoute('id', -1);
        $calltype = $this->entityManager->getRepository(CallType::class)
            ->find($id);
        $name = $calltype->getName();
        $this->entityManager->remove($calltype);
        $this->entityManager->flush();

        $log = $this->logManager;
        $log->setlog('Call Type Deleted', $name, $this->authService->getIdentity());

        $this->flashMessenger()->addSuccessMessage('Call Type deleted '.$name);

        return $this->redirect()->toRoute('call-type');
       
    }
}
