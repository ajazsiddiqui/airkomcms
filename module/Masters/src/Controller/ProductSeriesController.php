<?php

namespace Masters\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Masters\Entity\ProductSeries;
use Masters\Form\ProductSeriesForm;
use User\Entity\User;

class ProductSeriesController extends AbstractActionController
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
        $paginator['count'] = $this->entityManager->getUnitOfWork()->getEntityPersister(ProductSeries::class)->count();
        $paginator['per_page'] = 10;
        $offset = $paginator['page'] * $paginator['per_page'] - $paginator['per_page'];

        $form = new ProductSeriesForm();
        $product_series = $this->entityManager->getRepository(ProductSeries::class)
            ->findBy([], ['id' => 'ASC'], $paginator['per_page'], $offset);

        return new ViewModel(['product_series' => $product_series, 'form' => $form, 'paginator' => $paginator]);
    }

    public function addAction()
    {
        $form = new ProductSeriesForm();
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
                    $ProductSeries = new ProductSeries();
                    $ProductSeries->setName($data['name']);
                    $ProductSeries->setStatus($data['status']);
                    $ProductSeries->setCreatedBy($user->getId());
                    $this->entityManager->persist($ProductSeries);
                    $this->entityManager->flush();
                } catch (Exception $e) {
                    $this->logger->info('Caught exception: ', $e->getMessage(), "\n");
                }

                $log = $this->logManager;
                $log->setlog('ProductSeries Added', $data['name'], $this->authService->getIdentity());
            } else {
                $this->logger->info('form validator: ', $form->getMessages(), "\n");
            }
            $this->flashMessenger()->addSuccessMessage('ProductSeries Added '.$data['name']);

            return $this->redirect()->toRoute('product-series', ['action' => 'index']);
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

        $ProductSeries = $this->entityManager->getRepository(ProductSeries::class)
            ->find($id)
        ;

        if (null == $ProductSeries) {
            $this->getResponse()->setStatusCode(404);

            return;
        }

        $form = new ProductSeriesForm();

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();

                try {
                    $ProductSeries->setName($data['name']);
                    $ProductSeries->setStatus($data['status']);
                    $ProductSeries->setCreatedBy($user->getId());
                    $this->entityManager->persist($ProductSeries);
                    $this->entityManager->flush();
                } catch (Exception $e) {
                    $this->logger->info('Caught exception: ', $e->getMessage(), "\n");
                }

                $log = $this->logManager;
                $log->setlog('ProductSeries Edited', $data['name'], $this->authService->getIdentity());

                $this->flashMessenger()->addSuccessMessage('ProductSeries Edited '.$data['name']);

                return $this->redirect()->toRoute('product-series', ['action' => 'index']);
            }
            $this->logger->info('form validator: ', $form->getMessages(), "\n");
        } else {
            $form->setData(
                [
                    'name' => $ProductSeries->getName(),
                    'status' => $ProductSeries->getStatus(),
                ]
            );
        }

        return new ViewModel(['form' => $form]);
    }

    public function setstatusAction()
    {
        $id = (int) $this->params()->fromRoute('id', -1);
        $ProductSeries = $this->entityManager->getRepository(ProductSeries::class)
            ->findOneBy(['id' => $id]);
			
        $name = $ProductSeries->getName();
        $status = $ProductSeries->getStatus();
        if (1 == $status) {
            $ProductSeries->setStatus('0');
        } else {
            $ProductSeries->setStatus('1');
        }
        $this->entityManager->persist($ProductSeries);
        $this->entityManager->flush();

        $this->flashMessenger()->addSuccessMessage('Product Series Status of '.$name.'  Changed');

        return $this->redirect()->toRoute('product-series');
    }
	
		public function deleteAction()
    {
		$id = (int) $this->params()->fromRoute('id', -1);
        $ProductSeries = $this->entityManager->getRepository(ProductSeries::class)
            ->find($id);
        $name = $ProductSeries->getName();
        $this->entityManager->remove($ProductSeries);
        $this->entityManager->flush();

        $log = $this->logManager;
        $log->setlog('Product Series Deleted', $name, $this->authService->getIdentity());

        $this->flashMessenger()->addSuccessMessage('Product Series deleted '.$name);

        return $this->redirect()->toRoute('product-series');
       
    }
}
