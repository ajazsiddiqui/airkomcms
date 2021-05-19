<?php

namespace Masters\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Masters\Entity\TravelMode;
use Masters\Form\TravelModeForm;
use User\Entity\User;

class TravelModeController extends AbstractActionController
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
        $paginator['count'] = $this->entityManager->getUnitOfWork()->getEntityPersister(TravelMode::class)->count();
        $paginator['per_page'] = 10;
        $offset = $paginator['page'] * $paginator['per_page'] - $paginator['per_page'];

        $form = new TravelModeForm();
        $travel_mode = $this->entityManager->getRepository(TravelMode::class)
            ->findBy([], ['id' => 'ASC'], $paginator['per_page'], $offset);

        return new ViewModel(['travel_mode' => $travel_mode, 'form' => $form, 'paginator' => $paginator]);
    }

    public function addAction()
    {
        $form = new TravelModeForm();
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
                    $TravelMode = new TravelMode();
                    $TravelMode->setName($data['name']);
                    $TravelMode->setStatus($data['status']);
                    $TravelMode->setCreatedBy($user->getId());
                    $this->entityManager->persist($TravelMode);
                    $this->entityManager->flush();
                } catch (Exception $e) {
                    $this->logger->info('Caught exception: ', $e->getMessage(), "\n");
                }

                $log = $this->logManager;
                $log->setlog('TravelMode Added', $data['name'], $this->authService->getIdentity());
            } else {
                $this->logger->info('form validator: ', $form->getMessages(), "\n");
            }
            $this->flashMessenger()->addSuccessMessage('TravelMode Added '.$data['name']);

            return $this->redirect()->toRoute('travel-mode', ['action' => 'index']);
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

        $TravelMode = $this->entityManager->getRepository(TravelMode::class)
            ->find($id)
        ;

        if (null == $TravelMode) {
            $this->getResponse()->setStatusCode(404);

            return;
        }

        $form = new TravelModeForm();

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();

                try {
                    $TravelMode->setName($data['name']);
                    $TravelMode->setStatus($data['status']);
                    $TravelMode->setCreatedBy($user->getId());
                    $this->entityManager->persist($TravelMode);
                    $this->entityManager->flush();
                } catch (Exception $e) {
                    $this->logger->info('Caught exception: ', $e->getMessage(), "\n");
                }

                $log = $this->logManager;
                $log->setlog('TravelMode Edited', $data['name'], $this->authService->getIdentity());

                $this->flashMessenger()->addSuccessMessage('TravelMode Edited '.$data['name']);

                return $this->redirect()->toRoute('travel-mode', ['action' => 'index']);
            }
            $this->logger->info('form validator: ', $form->getMessages(), "\n");
        } else {
            $form->setData(
                [
                    'name' => $TravelMode->getName(),
                    'status' => $TravelMode->getStatus(),
                ]
            );
        }

        return new ViewModel(['form' => $form]);
    }

    public function setstatusAction()
    {
        $id = (int) $this->params()->fromRoute('id', -1);
        $TravelMode = $this->entityManager->getRepository(TravelMode::class)
            ->findOneBy(['id' => $id]);
			
        $name = $TravelMode->getName();
        $status = $TravelMode->getStatus();
        if (1 == $status) {
            $TravelMode->setStatus('0');
        } else {
            $TravelMode->setStatus('1');
        }
        $this->entityManager->persist($TravelMode);
        $this->entityManager->flush();

        $this->flashMessenger()->addSuccessMessage('Travel Mode Status of '.$name.'  Changed');

        return $this->redirect()->toRoute('travel-mode');
    }
	
		public function deleteAction()
    {
		$id = (int) $this->params()->fromRoute('id', -1);
        $TravelMode = $this->entityManager->getRepository(TravelMode::class)
            ->find($id);
        $name = $TravelMode->getName();
        $this->entityManager->remove($TravelMode);
        $this->entityManager->flush();

        $log = $this->logManager;
        $log->setlog('Travel Mode Deleted', $name, $this->authService->getIdentity());

        $this->flashMessenger()->addSuccessMessage('Travel Mode deleted '.$name);

        return $this->redirect()->toRoute('travel-mode');
       
    }
}
