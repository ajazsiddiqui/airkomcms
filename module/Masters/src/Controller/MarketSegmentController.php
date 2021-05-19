<?php

namespace Masters\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Masters\Entity\MarketSegment;
use Masters\Form\MarketSegmentForm;
use User\Entity\User;

class MarketSegmentController extends AbstractActionController
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
        $paginator['count'] = $this->entityManager->getUnitOfWork()->getEntityPersister(MarketSegment::class)->count();
        $paginator['per_page'] = 10;
        $offset = $paginator['page'] * $paginator['per_page'] - $paginator['per_page'];

        $form = new MarketSegmentForm();
        $market_segment = $this->entityManager->getRepository(MarketSegment::class)
            ->findBy([], ['id' => 'ASC'], $paginator['per_page'], $offset);

        return new ViewModel(['market_segment' => $market_segment, 'form' => $form, 'paginator' => $paginator]);
    }

    public function addAction()
    {
        $form = new MarketSegmentForm();
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
                    $MarketSegment = new MarketSegment();
                    $MarketSegment->setName($data['name']);
                    $MarketSegment->setStatus($data['status']);
                    $MarketSegment->setCreatedBy($user->getId());
                    $this->entityManager->persist($MarketSegment);
                    $this->entityManager->flush();
                } catch (Exception $e) {
                    $this->logger->info('Caught exception: ', $e->getMessage(), "\n");
                }

                $log = $this->logManager;
                $log->setlog('MarketSegment Added', $data['name'], $this->authService->getIdentity());
            } else {
                $this->logger->info('form validator: ', $form->getMessages(), "\n");
            }
            $this->flashMessenger()->addSuccessMessage('MarketSegment Added '.$data['name']);

            return $this->redirect()->toRoute('market-segment', ['action' => 'index']);
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

        $MarketSegment = $this->entityManager->getRepository(MarketSegment::class)
            ->find($id)
        ;

        if (null == $MarketSegment) {
            $this->getResponse()->setStatusCode(404);

            return;
        }

        $form = new MarketSegmentForm();

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();

                try {
                    $MarketSegment->setName($data['name']);
                    $MarketSegment->setStatus($data['status']);
                    $MarketSegment->setCreatedBy($user->getId());
                    $this->entityManager->persist($MarketSegment);
                    $this->entityManager->flush();
                } catch (Exception $e) {
                    $this->logger->info('Caught exception: ', $e->getMessage(), "\n");
                }

                $log = $this->logManager;
                $log->setlog('MarketSegment Edited', $data['name'], $this->authService->getIdentity());

                $this->flashMessenger()->addSuccessMessage('MarketSegment Edited '.$data['name']);

                return $this->redirect()->toRoute('market-segment', ['action' => 'index']);
            }
            $this->logger->info('form validator: ', $form->getMessages(), "\n");
        } else {
            $form->setData(
                [
                    'name' => $MarketSegment->getName(),
                    'status' => $MarketSegment->getStatus(),
                ]
            );
        }

        return new ViewModel(['form' => $form]);
    }

    public function setstatusAction()
    {
        $id = (int) $this->params()->fromRoute('id', -1);
        $MarketSegment = $this->entityManager->getRepository(MarketSegment::class)
            ->findOneBy(['id' => $id]);
			
        $name = $MarketSegment->getName();
        $status = $MarketSegment->getStatus();
        if (1 == $status) {
            $MarketSegment->setStatus('0');
        } else {
            $MarketSegment->setStatus('1');
        }
        $this->entityManager->persist($MarketSegment);
        $this->entityManager->flush();

        $this->flashMessenger()->addSuccessMessage('Market Segment Status of '.$name.'  Changed');

        return $this->redirect()->toRoute('market-segment');
    }
	
		public function deleteAction()
    {
		$id = (int) $this->params()->fromRoute('id', -1);
        $MarketSegment = $this->entityManager->getRepository(MarketSegment::class)
            ->find($id);
        $name = $MarketSegment->getName();
        $this->entityManager->remove($MarketSegment);
        $this->entityManager->flush();

        $log = $this->logManager;
        $log->setlog('Market Segment Deleted', $name, $this->authService->getIdentity());

        $this->flashMessenger()->addSuccessMessage('Market Segment deleted '.$name);

        return $this->redirect()->toRoute('market-segment');
       
    }
}
