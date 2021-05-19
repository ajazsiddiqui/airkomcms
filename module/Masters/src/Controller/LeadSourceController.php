<?php

namespace Masters\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Masters\Entity\LeadSource;
use Masters\Form\LeadSourceForm;
use User\Entity\User;

class LeadSourceController extends AbstractActionController
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
        $paginator['count'] = $this->entityManager->getUnitOfWork()->getEntityPersister(LeadSource::class)->count();
        $paginator['per_page'] = 10;
        $offset = $paginator['page'] * $paginator['per_page'] - $paginator['per_page'];

        $form = new LeadSourceForm();
        $lead_source = $this->entityManager->getRepository(LeadSource::class)
            ->findBy([], ['id' => 'ASC'], $paginator['per_page'], $offset);

        return new ViewModel(['lead_source' => $lead_source, 'form' => $form, 'paginator' => $paginator]);
    }

    public function addAction()
    {
        $form = new LeadSourceForm();
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
                    $LeadSource = new LeadSource();
                    $LeadSource->setName($data['name']);
                    $LeadSource->setStatus($data['status']);
                    $LeadSource->setCreatedBy($user->getId());
                    $this->entityManager->persist($LeadSource);
                    $this->entityManager->flush();
                } catch (Exception $e) {
                    $this->logger->info('Caught exception: ', $e->getMessage(), "\n");
                }

                $log = $this->logManager;
                $log->setlog('LeadSource Added', $data['name'], $this->authService->getIdentity());
            } else {
                $this->logger->info('form validator: ', $form->getMessages(), "\n");
            }
            $this->flashMessenger()->addSuccessMessage('LeadSource Added '.$data['name']);

            return $this->redirect()->toRoute('lead-source', ['action' => 'index']);
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

        $LeadSource = $this->entityManager->getRepository(LeadSource::class)
            ->find($id)
        ;

        if (null == $LeadSource) {
            $this->getResponse()->setStatusCode(404);

            return;
        }

        $form = new LeadSourceForm();

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();

                try {
                    $LeadSource->setName($data['name']);
                    $LeadSource->setStatus($data['status']);
                    $LeadSource->setCreatedBy($user->getId());
                    $this->entityManager->persist($LeadSource);
                    $this->entityManager->flush();
                } catch (Exception $e) {
                    $this->logger->info('Caught exception: ', $e->getMessage(), "\n");
                }

                $log = $this->logManager;
                $log->setlog('LeadSource Edited', $data['name'], $this->authService->getIdentity());

                $this->flashMessenger()->addSuccessMessage('LeadSource Edited '.$data['name']);

                return $this->redirect()->toRoute('lead-source', ['action' => 'index']);
            }
            $this->logger->info('form validator: ', $form->getMessages(), "\n");
        } else {
            $form->setData(
                [
                    'name' => $LeadSource->getName(),
                    'status' => $LeadSource->getStatus(),
                ]
            );
        }

        return new ViewModel(['form' => $form]);
    }

    public function setstatusAction()
    {
        $id = (int) $this->params()->fromRoute('id', -1);
        $LeadSource = $this->entityManager->getRepository(LeadSource::class)
            ->findOneBy(['id' => $id]);
			
        $name = $LeadSource->getName();
        $status = $LeadSource->getStatus();
        if (1 == $status) {
            $LeadSource->setStatus('0');
        } else {
            $LeadSource->setStatus('1');
        }
        $this->entityManager->persist($LeadSource);
        $this->entityManager->flush();

        $this->flashMessenger()->addSuccessMessage('LeadSource Status of '.$name.'  Changed');

        return $this->redirect()->toRoute('lead-source');
    }
	
	public function deleteAction()
    {
		$id = (int) $this->params()->fromRoute('id', -1);
        $LeadSource = $this->entityManager->getRepository(LeadSource::class)
            ->find($id);
        $name = $LeadSource->getName();
        $this->entityManager->remove($LeadSource);
        $this->entityManager->flush();

        $log = $this->logManager;
        $log->setlog('LeadSource Deleted', $name, $this->authService->getIdentity());

        $this->flashMessenger()->addSuccessMessage('LeadSource deleted '.$name);

        return $this->redirect()->toRoute('lead-source');
       
    }
}
