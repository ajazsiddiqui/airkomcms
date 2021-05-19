<?php

namespace Masters\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Masters\Entity\ProductModels;
use Masters\Form\ProductModelsForm;
use User\Entity\User;

class ProductModelsController extends AbstractActionController
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
        $paginator['count'] = $this->entityManager->getUnitOfWork()->getEntityPersister(ProductModels::class)->count();
        $paginator['per_page'] = 10;
        $offset = $paginator['page'] * $paginator['per_page'] - $paginator['per_page'];

        $form = new ProductModelsForm();
        $product_models = $this->entityManager->getRepository(ProductModels::class)
            ->findBy([], ['id' => 'ASC'], $paginator['per_page'], $offset);

        return new ViewModel(['product_models' => $product_models, 'form' => $form, 'paginator' => $paginator]);
    }

    public function addAction()
    {
        $form = new ProductModelsForm();
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
                    $ProductModels = new ProductModels();
                    $ProductModels->setName($data['name']);
                    $ProductModels->setStatus($data['status']);
                    $ProductModels->setCreatedBy($user->getId());
                    $this->entityManager->persist($ProductModels);
                    $this->entityManager->flush();
                } catch (Exception $e) {
                    $this->logger->info('Caught exception: ', $e->getMessage(), "\n");
                }

                $log = $this->logManager;
                $log->setlog('ProductModels Added', $data['name'], $this->authService->getIdentity());
            } else {
                $this->logger->info('form validator: ', $form->getMessages(), "\n");
            }
            $this->flashMessenger()->addSuccessMessage('ProductModels Added '.$data['name']);

            return $this->redirect()->toRoute('product-models', ['action' => 'index']);
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

        $ProductModels = $this->entityManager->getRepository(ProductModels::class)
            ->find($id)
        ;

        if (null == $ProductModels) {
            $this->getResponse()->setStatusCode(404);

            return;
        }

        $form = new ProductModelsForm();

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();

                try {
                    $ProductModels->setName($data['name']);
                    $ProductModels->setStatus($data['status']);
                    $ProductModels->setCreatedBy($user->getId());
                    $this->entityManager->persist($ProductModels);
                    $this->entityManager->flush();
                } catch (Exception $e) {
                    $this->logger->info('Caught exception: ', $e->getMessage(), "\n");
                }

                $log = $this->logManager;
                $log->setlog('ProductModels Edited', $data['name'], $this->authService->getIdentity());

                $this->flashMessenger()->addSuccessMessage('ProductModels Edited '.$data['name']);

                return $this->redirect()->toRoute('product-models', ['action' => 'index']);
            }
            $this->logger->info('form validator: ', $form->getMessages(), "\n");
        } else {
            $form->setData(
                [
                    'name' => $ProductModels->getName(),
                    'status' => $ProductModels->getStatus(),
                ]
            );
        }

        return new ViewModel(['form' => $form]);
    }

    public function setstatusAction()
    {
        $id = (int) $this->params()->fromRoute('id', -1);
        $ProductModels = $this->entityManager->getRepository(ProductModels::class)
            ->findOneBy(['id' => $id]);
			
        $name = $ProductModels->getName();
        $status = $ProductModels->getStatus();
        if (1 == $status) {
            $ProductModels->setStatus('0');
        } else {
            $ProductModels->setStatus('1');
        }
        $this->entityManager->persist($ProductModels);
        $this->entityManager->flush();

        $this->flashMessenger()->addSuccessMessage('Product Models Status of '.$name.'  Changed');

        return $this->redirect()->toRoute('product-models');
    }
	
		public function deleteAction()
    {
		$id = (int) $this->params()->fromRoute('id', -1);
        $ProductModels = $this->entityManager->getRepository(ProductModels::class)
            ->find($id);
        $name = $ProductModels->getName();
        $this->entityManager->remove($ProductModels);
        $this->entityManager->flush();

        $log = $this->logManager;
        $log->setlog('Product Models Deleted', $name, $this->authService->getIdentity());

        $this->flashMessenger()->addSuccessMessage('Product Models deleted '.$name);

        return $this->redirect()->toRoute('product-models');
       
    }
}
