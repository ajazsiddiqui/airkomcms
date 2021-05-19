<?php

namespace Masters\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Masters\Entity\Probability;
use Masters\Form\ProbabilityForm;
use User\Entity\User;

class ProbabilityController extends AbstractActionController
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
        $paginator['count'] = $this->entityManager->getUnitOfWork()->getEntityPersister(Probability::class)->count();
        $paginator['per_page'] = 10;
        $offset = $paginator['page'] * $paginator['per_page'] - $paginator['per_page'];

        $form = new ProbabilityForm();
        $probability = $this->entityManager->getRepository(Probability::class)
            ->findBy([], ['id' => 'ASC'], $paginator['per_page'], $offset);

        return new ViewModel(['probability' => $probability, 'form' => $form, 'paginator' => $paginator]);
    }

    public function addAction()
    {
        $form = new ProbabilityForm();
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
                    $Probability = new Probability();
                    $Probability->setName($data['name']);
                    $Probability->setStatus($data['status']);
                    $Probability->setCreatedBy($user->getId());
                    $this->entityManager->persist($Probability);
                    $this->entityManager->flush();
                } catch (Exception $e) {
                    $this->logger->info('Caught exception: ', $e->getMessage(), "\n");
                }

                $log = $this->logManager;
                $log->setlog('Probability Added', $data['name'], $this->authService->getIdentity());
            } else {
                $this->logger->info('form validator: ', $form->getMessages(), "\n");
            }
            $this->flashMessenger()->addSuccessMessage('Probability Added '.$data['name']);

            return $this->redirect()->toRoute('probability', ['action' => 'index']);
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

        $Probability = $this->entityManager->getRepository(Probability::class)
            ->find($id)
        ;

        if (null == $Probability) {
            $this->getResponse()->setStatusCode(404);

            return;
        }

        $form = new ProbabilityForm();

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();

                try {
                    $Probability->setName($data['name']);
                    $Probability->setStatus($data['status']);
                    $Probability->setCreatedBy($user->getId());
                    $this->entityManager->persist($Probability);
                    $this->entityManager->flush();
                } catch (Exception $e) {
                    $this->logger->info('Caught exception: ', $e->getMessage(), "\n");
                }

                $log = $this->logManager;
                $log->setlog('Probability Edited', $data['name'], $this->authService->getIdentity());

                $this->flashMessenger()->addSuccessMessage('Probability Edited '.$data['name']);

                return $this->redirect()->toRoute('probability', ['action' => 'index']);
            }
            $this->logger->info('form validator: ', $form->getMessages(), "\n");
        } else {
            $form->setData(
                [
                    'name' => $Probability->getName(),
                    'status' => $Probability->getStatus(),
                ]
            );
        }

        return new ViewModel(['form' => $form]);
    }

    public function setstatusAction()
    {
        $id = (int) $this->params()->fromRoute('id', -1);
        $Probability = $this->entityManager->getRepository(Probability::class)
            ->findOneBy(['id' => $id]);
			
        $name = $Probability->getName();
        $status = $Probability->getStatus();
        if (1 == $status) {
            $Probability->setStatus('0');
        } else {
            $Probability->setStatus('1');
        }
        $this->entityManager->persist($Probability);
        $this->entityManager->flush();

        $this->flashMessenger()->addSuccessMessage('Probability Status of '.$name.'  Changed');

        return $this->redirect()->toRoute('probability');
    }
	
		public function deleteAction()
    {
		$id = (int) $this->params()->fromRoute('id', -1);
        $Probability = $this->entityManager->getRepository(Probability::class)
            ->find($id);
        $name = $Probability->getName();
        $this->entityManager->remove($Probability);
        $this->entityManager->flush();

        $log = $this->logManager;
        $log->setlog('Probability Deleted', $name, $this->authService->getIdentity());

        $this->flashMessenger()->addSuccessMessage('Probability deleted '.$name);

        return $this->redirect()->toRoute('probability');
       
    }
}
