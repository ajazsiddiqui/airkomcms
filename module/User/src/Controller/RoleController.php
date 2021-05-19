<?php

namespace User\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use User\Entity\Permission;
use User\Entity\Role;
use User\Form\RoleForm;
use User\Form\RolePermissionsForm;

class RoleController extends AbstractActionController
{
    private $entityManager;
    private $roleManager;

    public function __construct($entityManager, $roleManager)
    {
        $this->entityManager = $entityManager;
        $this->roleManager = $roleManager;
    }

    public function indexAction()
    {
        $roles = $this->entityManager->getRepository(Role::class)
            ->findBy([], ['id' => 'DESC'])
        ;

        return new ViewModel(
            [
                'roles' => $roles,
            ]
        );
    }

    public function addAction()
    {
        $form = new RoleForm('create', $this->entityManager);

        $roleList = [];
        $roles = $this->entityManager->getRepository(Role::class)
            ->findBy([], ['name' => 'ASC'])
        ;
        foreach ($roles as $role) {
            $roleList[$role->getId()] = $role->getName();
        }
        $form->get('inherit_roles[]')->setValueOptions($roleList);

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();
                $this->roleManager->addRole($data);
                $this->flashMessenger()->addSuccessMessage('Added new role.');

                return $this->redirect()->toRoute('roles', ['action' => 'index']);
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

        $role = $this->entityManager->getRepository(Role::class)
            ->find($id)
        ;

        if (null == $role) {
            $this->getResponse()->setStatusCode(404);

            return;
        }

        $allPermissions = $this->entityManager->getRepository(Permission::class)
            ->findBy([], ['name' => 'ASC'])
        ;

        $effectivePermissions = $this->roleManager->getEffectivePermissions($role);

        return new ViewModel(
            [
                'role' => $role,
                'allPermissions' => $allPermissions,
                'effectivePermissions' => $effectivePermissions,
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

        $role = $this->entityManager->getRepository(Role::class)
            ->find($id)
        ;

        if (null == $role) {
            $this->getResponse()->setStatusCode(404);

            return;
        }
        $form = new RoleForm('update', $this->entityManager, $role);

        $roleList = [];
        $roles = $this->entityManager->getRepository(Role::class)
            ->findBy([], ['name' => 'ASC'])
        ;
        foreach ($roles as $role2) {
            $roleList[$role2->getId()] = $role2->getName();
        }
        $form->get('inherit_roles[]')->setValueOptions($roleList);

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();

            $form->setData($data);
            if ($form->isValid()) {
                $data = $form->getData();
                $this->roleManager->updateRole($role, $data);
                $this->flashMessenger()->addSuccessMessage('Updated the role.');

                return $this->redirect()->toRoute('roles', ['action' => 'index']);
            }
        } else {
            $form->setData(
                [
                    'name' => $role->getName(),
                    'description' => $role->getDescription(),
                ]
            );
        }

        return new ViewModel(
            [
                'form' => $form,
                'role' => $role,
            ]
        );
    }

    public function editPermissionsAction()
    {
        $id = (int) $this->params()->fromRoute('id', -1);
        if ($id < 1) {
            $this->getResponse()->setStatusCode(404);

            return;
        }

        $role = $this->entityManager->getRepository(Role::class)
            ->find($id)
        ;

        if (null == $role) {
            $this->getResponse()->setStatusCode(404);

            return;
        }

        $allPermissions = $this->entityManager->getRepository(Permission::class)
            ->findBy([], ['name' => 'ASC'])
        ;

        $effectivePermissions = $this->roleManager->getEffectivePermissions($role);

        $form = new RolePermissionsForm($this->entityManager);
        foreach ($allPermissions as $permission) {
            $label = $permission->getName();
            $isDisabled = false;
            if (isset($effectivePermissions[$permission->getName()]) && 'inherited' == $effectivePermissions[$permission->getName()]) {
                $label .= ' (inherited)';
                $isDisabled = true;
            }
            $form->addPermissionField($permission->getName(), $label, $isDisabled);
        }

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();

            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();
                $this->roleManager->updateRolePermissions($role, $data);
                $this->flashMessenger()->addSuccessMessage('Updated permissions for the role.');

                return $this->redirect()->toRoute('roles', ['action' => 'view', 'id' => $role->getId()]);
            }
        } else {
            $data = [];
            foreach ($effectivePermissions as $name => $inherited) {
                $data['permissions'][$name] = 1;
            }

            $form->setData($data);
        }

        $errors = $form->getMessages();

        return new ViewModel(
            [
                'form' => $form,
                'role' => $role,
                'allPermissions' => $allPermissions,
                'effectivePermissions' => $effectivePermissions,
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

        $role = $this->entityManager->getRepository(Role::class)
            ->find($id)
        ;

        if (null == $role) {
            $this->getResponse()->setStatusCode(404);

            return;
        }

        $this->roleManager->deleteRole($role);

        $this->flashMessenger()->addSuccessMessage('Deleted the role.');

        return $this->redirect()->toRoute('roles', ['action' => 'index']);
    }
}
