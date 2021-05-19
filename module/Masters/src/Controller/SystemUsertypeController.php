<?php

namespace Masters\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Masters\Entity\SystemUserType;
use Masters\Form\SystemUserTypeForm;
use User\Entity\User;

class SystemUsertypeController extends AbstractActionController
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
        $paginator['count'] = $this->entityManager->getUnitOfWork()->getEntityPersister(SystemUserType::class)->count();
        $paginator['per_page'] = 10;
        $offset = $paginator['page'] * $paginator['per_page'] - $paginator['per_page'];

        $form = new SystemUserTypeForm();
        $system_usertype = $this->entityManager->getRepository(SystemUserType::class)
            ->findBy([], ['id' => 'ASC'], $paginator['per_page'], $offset)
        ;

        return new ViewModel(['system_usertype' => $system_usertype, 'form' => $form, 'paginator' => $paginator]);
    }

    public function addAction()
    {
        $form = new SystemUserTypeForm();
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
                    $usertype = new SystemUserType();
                    $usertype->setName($data['name']);
                    $usertype->setStatus($data['status']);
                    $usertype->setConfidential($data['confidential']);
                    $usertype->setCreatedBy($user->getId());
                    $this->entityManager->persist($usertype);
                    $this->entityManager->flush();
                } catch (Exception $e) {
                    $this->logger->info('Caught exception: ', $e->getMessage(), "\n");
                }

                $log = $this->logManager;
                $log->setlog('SystemUserType Added', $data['name'], $this->authService->getIdentity());
            } else {
                $this->logger->info('form validator: ', $form->getMessages(), "\n");
            }
            $this->flashMessenger()->addSuccessMessage('SystemUserType Added '.$data['name']);

            return $this->redirect()->toRoute('system-usertype', ['action' => 'index']);
        }

        return new ViewModel(['form' => $form]);
    }

    public function editAction()
    {
        $user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['email' => $this->authService->getIdentity()], ['id' => 'ASC'])
        ;

        $id = (int) $this->params()->fromRoute('id', -1);
        if ($id < 1) {
            $this->getResponse()->setStatusCode(404);

            return;
        }

        $usertype = $this->entityManager->getRepository(SystemUserType::class)
            ->find($id)
        ;

        if (null == $usertype) {
            $this->getResponse()->setStatusCode(404);

            return;
        }

        // Create user form
        $form = new SystemUserTypeForm();

        // Check if user has submitted the form
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();

                try {
                    $usertype->setName($data['name']);
                    $usertype->setStatus($data['status']);
                    $usertype->setConfidential($data['confidential']);
                    $usertype->setCreatedBy($user->getId());
                    $this->entityManager->persist($usertype);
                    $this->entityManager->flush();
                } catch (Exception $e) {
                    $this->logger->info('Caught exception: ', $e->getMessage(), "\n");
                }

                $log = $this->logManager;
                $log->setlog('SystemUserType Edited', $data['name'], $this->authService->getIdentity());

                $this->flashMessenger()->addSuccessMessage('SystemUserType Edited '.$data['name']);

                return $this->redirect()->toRoute('system-usertype', ['action' => 'index']);
            }
            $this->logger->info('form validator: ', $form->getMessages(), "\n");
        } else {
            $form->setData(
                [
                    'name' => $usertype->getName(),
                    'confidential' => $usertype->getConfidential(),
                    'status' => $usertype->getStatus(),
                ]
            );
        }

        return new ViewModel(['form' => $form]);
    }

    public function setstatusAction()
    {
        $id = (int) $this->params()->fromRoute('id', -1);
        $usertype = $this->entityManager->getRepository(SystemUserType::class)
            ->findOneBy(['id' => $id])
        ;
        $name = $usertype->getName();
        $status = $usertype->getStatus();
        if (1 == $status) {
            $usertype->setStatus('0');
        } else {
            $usertype->setStatus('1');
        }
        $this->entityManager->persist($usertype);
        $this->entityManager->flush();

        $this->flashMessenger()->addSuccessMessage('SystemUserType Status of '.$name.'  Changed');

        return $this->redirect()->toRoute('system-usertype');
    }
	
		public function deleteAction()
    {
		$id = (int) $this->params()->fromRoute('id', -1);
        $usertype = $this->entityManager->getRepository(SystemUserType::class)
            ->find($id);
        $name = $usertype->getName();
        $this->entityManager->remove($usertype);
        $this->entityManager->flush();

        $log = $this->logManager;
        $log->setlog('SystemUserType Deleted', $name, $this->authService->getIdentity());

        $this->flashMessenger()->addSuccessMessage('SystemUserType deleted '.$name);

        return $this->redirect()->toRoute('system-usertype');
       
    }
}
