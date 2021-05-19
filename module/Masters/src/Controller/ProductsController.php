<?php

namespace Masters\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Masters\Entity\Products;
use Masters\Form\ProductsForm;
use User\Entity\User;

class ProductsController extends AbstractActionController
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
        $paginator['count'] = $this->entityManager->getUnitOfWork()->getEntityPersister(Products::class)->count();
        $paginator['per_page'] = 10;
        $offset = $paginator['page'] * $paginator['per_page'] - $paginator['per_page'];

        $form = new ProductsForm();
        $products = $this->entityManager->getRepository(Products::class)
            ->findBy([], ['id' => 'ASC'], $paginator['per_page'], $offset);

        return new ViewModel(['products' => $products, 'form' => $form, 'paginator' => $paginator]);
    }

    public function addAction()
    {
        $form = new ProductsForm();
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
                    $Products = new Products();
                    $Products->setName($data['name']);
                    $Products->setStatus($data['status']);
                    $Products->setCreatedBy($user->getId());
                    $this->entityManager->persist($Products);
                    $this->entityManager->flush();
                } catch (Exception $e) {
                    $this->logger->info('Caught exception: ', $e->getMessage(), "\n");
                }

                $log = $this->logManager;
                $log->setlog('Products Added', $data['name'], $this->authService->getIdentity());
            } else {
                $this->logger->info('form validator: ', $form->getMessages(), "\n");
            }
            $this->flashMessenger()->addSuccessMessage('Products Added '.$data['name']);

            return $this->redirect()->toRoute('products', ['action' => 'index']);
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

        $Products = $this->entityManager->getRepository(Products::class)
            ->find($id)
        ;

        if (null == $Products) {
            $this->getResponse()->setStatusCode(404);

            return;
        }

        $form = new ProductsForm();

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();

                try {
                    $Products->setName($data['name']);
                    $Products->setStatus($data['status']);
                    $Products->setCreatedBy($user->getId());
                    $this->entityManager->persist($Products);
                    $this->entityManager->flush();
                } catch (Exception $e) {
                    $this->logger->info('Caught exception: ', $e->getMessage(), "\n");
                }

                $log = $this->logManager;
                $log->setlog('Products Edited', $data['name'], $this->authService->getIdentity());

                $this->flashMessenger()->addSuccessMessage('Products Edited '.$data['name']);

                return $this->redirect()->toRoute('products', ['action' => 'index']);
            }
            $this->logger->info('form validator: ', $form->getMessages(), "\n");
        } else {
            $form->setData(
                [
                    'name' => $Products->getName(),
                    'status' => $Products->getStatus(),
                ]
            );
        }

        return new ViewModel(['form' => $form]);
    }

    public function setstatusAction()
    {
        $id = (int) $this->params()->fromRoute('id', -1);
        $Products = $this->entityManager->getRepository(Products::class)
            ->findOneBy(['id' => $id]);
			
        $name = $Products->getName();
        $status = $Products->getStatus();
        if (1 == $status) {
            $Products->setStatus('0');
        } else {
            $Products->setStatus('1');
        }
        $this->entityManager->persist($Products);
        $this->entityManager->flush();

        $this->flashMessenger()->addSuccessMessage('Products Status of '.$name.'  Changed');

        return $this->redirect()->toRoute('products');
    }
	
		public function deleteAction()
    {
		$id = (int) $this->params()->fromRoute('id', -1);
        $Products = $this->entityManager->getRepository(Products::class)
            ->find($id);
        $name = $Products->getName();
        $this->entityManager->remove($Products);
        $this->entityManager->flush();

        $log = $this->logManager;
        $log->setlog('Products Deleted', $name, $this->authService->getIdentity());

        $this->flashMessenger()->addSuccessMessage('Products deleted '.$name);

        return $this->redirect()->toRoute('products');
       
    }
}
