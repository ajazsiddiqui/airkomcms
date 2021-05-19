<?php

namespace Masters\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Masters\Entity\ContactedType;
use Masters\Form\ContactedTypeForm;
use User\Entity\User;

class ContactedTypeController extends AbstractActionController
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
        $paginator['count'] = $this->entityManager->getUnitOfWork()->getEntityPersister(ContactedType::class)->count();
        $paginator['per_page'] = 10;
        $offset = $paginator['page'] * $paginator['per_page'] - $paginator['per_page'];

        $form = new ContactedTypeForm();
        $contacted_type = $this->entityManager->getRepository(ContactedType::class)
            ->findBy([], ['id' => 'ASC'], $paginator['per_page'], $offset);

        return new ViewModel(['contacted_type' => $contacted_type, 'form' => $form, 'paginator' => $paginator]);
    }

    public function addAction()
    {
        $form = new ContactedTypeForm();
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
                    $contactedtype = new ContactedType();
                    $contactedtype->setName($data['name']);
                    $contactedtype->setStatus($data['status']);
                    $contactedtype->setCreatedBy($user->getId());
                    $this->entityManager->persist($contactedtype);
                    $this->entityManager->flush();
                } catch (Exception $e) {
                    $this->logger->info('Caught exception: ', $e->getMessage(), "\n");
                }

                $log = $this->logManager;
                $log->setlog('ContactedType Added', $data['name'], $this->authService->getIdentity());
            } else {
                $this->logger->info('form validator: ', $form->getMessages(), "\n");
            }
            $this->flashMessenger()->addSuccessMessage('ContactedType Added '.$data['name']);

            return $this->redirect()->toRoute('contacted-type', ['action' => 'index']);
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

        $contactedtype = $this->entityManager->getRepository(ContactedType::class)
            ->find($id)
        ;

        if (null == $contactedtype) {
            $this->getResponse()->setStatusCode(404);

            return;
        }

        $form = new ContactedTypeForm();

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();

                try {
                    $contactedtype->setName($data['name']);
                    $contactedtype->setStatus($data['status']);
                    $contactedtype->setCreatedBy($user->getId());
                    $this->entityManager->persist($contactedtype);
                    $this->entityManager->flush();
                } catch (Exception $e) {
                    $this->logger->info('Caught exception: ', $e->getMessage(), "\n");
                }

                $log = $this->logManager;
                $log->setlog('ContactedType Edited', $data['name'], $this->authService->getIdentity());

                $this->flashMessenger()->addSuccessMessage('ContactedType Edited '.$data['name']);

                return $this->redirect()->toRoute('contacted-type', ['action' => 'index']);
            }
            $this->logger->info('form validator: ', $form->getMessages(), "\n");
        } else {
            $form->setData(
                [
                    'name' => $contactedtype->getName(),
                    'status' => $contactedtype->getStatus(),
                ]
            );
        }

        return new ViewModel(['form' => $form]);
    }

    public function setstatusAction()
    {
        $id = (int) $this->params()->fromRoute('id', -1);
        $contactedtype = $this->entityManager->getRepository(ContactedType::class)
            ->findOneBy(['id' => $id]);
			
        $name = $contactedtype->getName();
        $status = $contactedtype->getStatus();
        if (1 == $status) {
            $contactedtype->setStatus('0');
        } else {
            $contactedtype->setStatus('1');
        }
        $this->entityManager->persist($contactedtype);
        $this->entityManager->flush();

        $this->flashMessenger()->addSuccessMessage('ContactedType Status of '.$name.'  Changed');

        return $this->redirect()->toRoute('contacted-type');
    }
	
	public function deleteAction()
    {
		$id = (int) $this->params()->fromRoute('id', -1);
        $contactedtype = $this->entityManager->getRepository(ContactedType::class)
            ->find($id);
        $name = $contactedtype->getName();
        $this->entityManager->remove($contactedtype);
        $this->entityManager->flush();

        $log = $this->logManager;
        $log->setlog('Contacted Type Deleted', $name, $this->authService->getIdentity());

        $this->flashMessenger()->addSuccessMessage('Contacted Type deleted '.$name);

        return $this->redirect()->toRoute('contacted-type');
       
    }
}
