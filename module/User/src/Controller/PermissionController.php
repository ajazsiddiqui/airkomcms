<?php

namespace User\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use User\Entity\Permission;
use User\Form\PermissionForm;

class PermissionController extends AbstractActionController
{
    private $entityManager;
    private $permissionManager;

    public function __construct($entityManager, $permissionManager)
    {
        $this->entityManager = $entityManager;
        $this->permissionManager = $permissionManager;
    }

    public function indexAction()
    {
        $permissions = $this->entityManager->getRepository(Permission::class)
            ->findBy([], ['name' => 'DESC'])
        ;

        return new ViewModel(
            [
                'permissions' => $permissions,
            ]
        );
    }

    public function addAction()
    {
        $form = new PermissionForm('create', $this->entityManager);

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);
            if ($form->isValid()) {
                $data = $form->getData();
                $this->permissionManager->addPermission($data);
                $this->flashMessenger()->addSuccessMessage('Added new permission.');

                return $this->redirect()->toRoute('permissions', ['action' => 'index']);
            }
        }

        return new ViewModel(
            [
                'form' => $form,
            ]
        );
    }

    public function viewAction()
    {
        $id = (int) $this->params()->fromRoute('id', -1);
        if ($id < 1) {
            $this->getResponse()->setStatusCode(404);

            return;
        }

        $permission = $this->entityManager->getRepository(Permission::class)
            ->find($id)
        ;

        if (null == $permission) {
            $this->getResponse()->setStatusCode(404);

            return;
        }

        return new ViewModel(
            [
                'permission' => $permission,
            ]
        );
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', -1);
        if ($id < 1) {
            $this->getResponse()->setStatusCode(404);

            return;
        }

        $permission = $this->entityManager->getRepository(Permission::class)
            ->find($id)
        ;

        if (null == $permission) {
            $this->getResponse()->setStatusCode(404);

            return;
        }

        $form = new PermissionForm('update', $this->entityManager, $permission);

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();

            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();
                $this->permissionManager->updatePermission($permission, $data);
                $this->flashMessenger()->addSuccessMessage('Updated the permission.');

                return $this->redirect()->toRoute('permissions', ['action' => 'index']);
            }
        } else {
            $form->setData(
                [
                    'name' => $permission->getName(),
                    'description' => $permission->getDescription(),
                ]
            );
        }

        return new ViewModel(
            [
                'form' => $form,
                'permission' => $permission,
            ]
        );
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', -1);
        if ($id < 1) {
            $this->getResponse()->setStatusCode(404);

            return;
        }

        $permission = $this->entityManager->getRepository(Permission::class)
            ->find($id)
        ;

        if (null == $permission) {
            $this->getResponse()->setStatusCode(404);

            return;
        }

        $this->permissionManager->deletePermission($permission);
        $this->flashMessenger()->addSuccessMessage('Deleted the permission.');

        return $this->redirect()->toRoute('permissions', ['action' => 'index']);
    }
}
