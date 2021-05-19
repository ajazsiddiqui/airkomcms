<?php

namespace Masters\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Masters\Entity\NextAction;
use Masters\Form\NextActionForm;
use User\Entity\User;

class NextActionController extends AbstractActionController
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
        $paginator['count'] = $this->entityManager->getUnitOfWork()->getEntityPersister(NextAction::class)->count();
        $paginator['per_page'] = 10;
        $offset = $paginator['page'] * $paginator['per_page'] - $paginator['per_page'];

        $form = new NextActionForm();
        $next_action = $this->entityManager->getRepository(NextAction::class)
            ->findBy([], ['id' => 'ASC'], $paginator['per_page'], $offset);

        return new ViewModel(['next_action' => $next_action, 'form' => $form, 'paginator' => $paginator]);
    }

    public function addAction()
    {
        $form = new NextActionForm();
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
                    $NextAction = new NextAction();
                    $NextAction->setName($data['name']);
                    $NextAction->setStatus($data['status']);
                    $NextAction->setCreatedBy($user->getId());
                    $this->entityManager->persist($NextAction);
                    $this->entityManager->flush();
                } catch (Exception $e) {
                    $this->logger->info('Caught exception: ', $e->getMessage(), "\n");
                }

                $log = $this->logManager;
                $log->setlog('NextAction Added', $data['name'], $this->authService->getIdentity());
            } else {
                $this->logger->info('form validator: ', $form->getMessages(), "\n");
            }
            $this->flashMessenger()->addSuccessMessage('NextAction Added '.$data['name']);

            return $this->redirect()->toRoute('next-action', ['action' => 'index']);
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

        $NextAction = $this->entityManager->getRepository(NextAction::class)
            ->find($id)
        ;

        if (null == $NextAction) {
            $this->getResponse()->setStatusCode(404);

            return;
        }

        $form = new NextActionForm();

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();

                try {
                    $NextAction->setName($data['name']);
                    $NextAction->setStatus($data['status']);
                    $NextAction->setCreatedBy($user->getId());
                    $this->entityManager->persist($NextAction);
                    $this->entityManager->flush();
                } catch (Exception $e) {
                    $this->logger->info('Caught exception: ', $e->getMessage(), "\n");
                }

                $log = $this->logManager;
                $log->setlog('NextAction Edited', $data['name'], $this->authService->getIdentity());

                $this->flashMessenger()->addSuccessMessage('NextAction Edited '.$data['name']);

                return $this->redirect()->toRoute('next-action', ['action' => 'index']);
            }
            $this->logger->info('form validator: ', $form->getMessages(), "\n");
        } else {
            $form->setData(
                [
                    'name' => $NextAction->getName(),
                    'status' => $NextAction->getStatus(),
                ]
            );
        }

        return new ViewModel(['form' => $form]);
    }

    public function setstatusAction()
    {
        $id = (int) $this->params()->fromRoute('id', -1);
        $NextAction = $this->entityManager->getRepository(NextAction::class)
            ->findOneBy(['id' => $id]);
			
        $name = $NextAction->getName();
        $status = $NextAction->getStatus();
        if (1 == $status) {
            $NextAction->setStatus('0');
        } else {
            $NextAction->setStatus('1');
        }
        $this->entityManager->persist($NextAction);
        $this->entityManager->flush();

        $this->flashMessenger()->addSuccessMessage('Next Action Status of '.$name.'  Changed');

        return $this->redirect()->toRoute('next-action');
    }
	
		public function deleteAction()
    {
		$id = (int) $this->params()->fromRoute('id', -1);
        $NextAction = $this->entityManager->getRepository(NextAction::class)
            ->find($id);
        $name = $NextAction->getName();
        $this->entityManager->remove($NextAction);
        $this->entityManager->flush();

        $log = $this->logManager;
        $log->setlog('Next Action Deleted', $name, $this->authService->getIdentity());

        $this->flashMessenger()->addSuccessMessage('Next Action deleted '.$name);

        return $this->redirect()->toRoute('next-action');
       
    }
}
