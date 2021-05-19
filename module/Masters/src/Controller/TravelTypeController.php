<?php

namespace Masters\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Masters\Entity\TravelType;
use Masters\Form\TravelTypeForm;
use User\Entity\User;

class TravelTypeController extends AbstractActionController
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
        $paginator['count'] = $this->entityManager->getUnitOfWork()->getEntityPersister(TravelType::class)->count();
        $paginator['per_page'] = 10;
        $offset = $paginator['page'] * $paginator['per_page'] - $paginator['per_page'];

        $form = new TravelTypeForm();
        $travel_type = $this->entityManager->getRepository(TravelType::class)
            ->findBy([], ['id' => 'ASC'], $paginator['per_page'], $offset);

        return new ViewModel(['travel_type' => $travel_type, 'form' => $form, 'paginator' => $paginator]);
    }

    public function addAction()
    {
        $form = new TravelTypeForm();
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
                    $TravelType = new TravelType();
                    $TravelType->setName($data['name']);
                    $TravelType->setStatus($data['status']);
                    $TravelType->setCreatedBy($user->getId());
                    $this->entityManager->persist($TravelType);
                    $this->entityManager->flush();
                } catch (Exception $e) {
                    $this->logger->info('Caught exception: ', $e->getMessage(), "\n");
                }

                $log = $this->logManager;
                $log->setlog('TravelType Added', $data['name'], $this->authService->getIdentity());
            } else {
                $this->logger->info('form validator: ', $form->getMessages(), "\n");
            }
            $this->flashMessenger()->addSuccessMessage('TravelType Added '.$data['name']);

            return $this->redirect()->toRoute('travel-type', ['action' => 'index']);
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

        $TravelType = $this->entityManager->getRepository(TravelType::class)
            ->find($id)
        ;

        if (null == $TravelType) {
            $this->getResponse()->setStatusCode(404);

            return;
        }

        $form = new TravelTypeForm();

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();

                try {
                    $TravelType->setName($data['name']);
                    $TravelType->setStatus($data['status']);
                    $TravelType->setCreatedBy($user->getId());
                    $this->entityManager->persist($TravelType);
                    $this->entityManager->flush();
                } catch (Exception $e) {
                    $this->logger->info('Caught exception: ', $e->getMessage(), "\n");
                }

                $log = $this->logManager;
                $log->setlog('TravelType Edited', $data['name'], $this->authService->getIdentity());

                $this->flashMessenger()->addSuccessMessage('TravelType Edited '.$data['name']);

                return $this->redirect()->toRoute('travel-type', ['action' => 'index']);
            }
            $this->logger->info('form validator: ', $form->getMessages(), "\n");
        } else {
            $form->setData(
                [
                    'name' => $TravelType->getName(),
                    'status' => $TravelType->getStatus(),
                ]
            );
        }

        return new ViewModel(['form' => $form]);
    }

    public function setstatusAction()
    {
        $id = (int) $this->params()->fromRoute('id', -1);
        $TravelType = $this->entityManager->getRepository(TravelType::class)
            ->findOneBy(['id' => $id]);
			
        $name = $TravelType->getName();
        $status = $TravelType->getStatus();
        if (1 == $status) {
            $TravelType->setStatus('0');
        } else {
            $TravelType->setStatus('1');
        }
        $this->entityManager->persist($TravelType);
        $this->entityManager->flush();

        $this->flashMessenger()->addSuccessMessage('TravelType Status of '.$name.'  Changed');

        return $this->redirect()->toRoute('travel-type');
    }
	
	public function deleteAction()
    {
		$id = (int) $this->params()->fromRoute('id', -1);
        $TravelType = $this->entityManager->getRepository(TravelType::class)
            ->find($id);
        $name = $TravelType->getName();
        $this->entityManager->remove($TravelType);
        $this->entityManager->flush();

        $log = $this->logManager;
        $log->setlog('Travel Type Deleted', $name, $this->authService->getIdentity());

        $this->flashMessenger()->addSuccessMessage('Travel Type deleted '.$name);

        return $this->redirect()->toRoute('travel-type');
       
    }
}
