<?php

namespace User\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Masters\Entity\SystemUserType;
use User\Entity\Role;
use Masters\Entity\Branch;
use User\Entity\User;
use User\Form\PasswordChangeForm;
use User\Form\PasswordResetForm;
use User\Form\UserForm;

class UserController extends AbstractActionController
{
    private $entityManager;
    private $userManager;
    private $authService;
    private $ExtranetUtilities;

    public function __construct($dir, $entityManager, $userManager, $authService, $ExtranetUtilities)
    {
        $this->dir = $dir;
        $this->entityManager = $entityManager;
        $this->userManager = $userManager;
        $this->authService = $authService;
        $this->ExtranetUtilities = $ExtranetUtilities;
    }

    public function indexAction()
    {
        if (!$this->access('user.manage')) {
            $this->getResponse()->setStatusCode(401);

            return;
        }
        $form = new PasswordChangeForm('change');
        $request = $this->getRequest();
        $search_array = $this->params()->fromQuery('search', []);
        $search_array = empty($search_array) ? [] : unserialize(base64_decode($search_array));

        $post = $request->getPost()->toArray();
        empty($post) ? $post = $search_array : '';

        if (!empty($post)) {
            $search_array['s_user'] = $post['s_user'];
            $search_array['s_role'] = $post['s_role'];
        }

        $query = $this->entityManager->createQueryBuilder()->select('U')
            ->from('User\Entity\User', 'U');
			
        if (!empty($search_array['s_user'])) {
            $query->Where('U.fullName like :s_user')->setParameter('s_user', '%'.$post['s_user'].'%');
        }
        if (!empty($search_array['s_role'])) {
            $query->andWhere('U.userType = :s_role')->setParameter('s_role', $post['s_role']);
        }
        $paginator['page'] = $this->params()->fromQuery('page', 1);
        $paginator['count'] = count($query->getQuery()->getScalarResult());
        $paginator['per_page'] = 12;
        $offset = $paginator['page'] * $paginator['per_page'] - $paginator['per_page'];

        $query->setFirstResult($offset)->setMaxResults($paginator['per_page'])->add('orderBy', 'U.id DESC');

        $users = $query->getQuery()->getResult();

        $systemUserTypes = $this->entityManager->getRepository(SystemUserType::class)
            ->findAll();

        return new ViewModel(['users' => $users, 'form' => $form, 'systemUserTypes' => $systemUserTypes, 'paginator' => $paginator, 'search_array' => $search_array]);
    }

    public function addAction()
    {
        $form = new UserForm($this->dir, 'create', $this->entityManager);

        $allRoles = $this->entityManager->getRepository(Role::class)
            ->findBy([], ['name' => 'ASC']);
        $roleList = [];
        foreach ($allRoles as $role) {
            $roleList[$role->getId()] = $role->getName();
        }
		
		$allBranches = $this->entityManager->getRepository(Branch::class)
            ->findBy([], ['name' => 'ASC']);
        $branchList = [];
        foreach ($allBranches as $branch) {
            $branchList[$branch->getId()] = $branch->getName();
        }

        $form->get('roles')->setValueOptions($roleList);
        $form->get('branch')->setValueOptions($branchList);

        $allUserTypes = $this->entityManager->getRepository(SystemUserType::class)
            ->findBy([], ['name' => 'ASC']);
        $UserTypesList = [];
        foreach ($allUserTypes as $userType) {
            $UserTypesList[$userType->getId()] = $userType->getName();
        }

        $form->get('user_type')->setValueOptions($UserTypesList);

        if ($this->getRequest()->isPost()) {
            $post = array_merge_recursive(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            );

            $form->setData($post);
            if ($form->isValid()) {
                $data = $form->getData();

                if (!empty($data['image'])) {
                    $path = $this->dir.DIRECTORY_SEPARATOR.'profile_pics';
                    $randString = md5(time());
                    $fileName = $data['image']['name'];
                    $splitName = explode('.', $fileName);
                    $fileExt = end($splitName);
                    $newFileName = strtolower($randString.'.'.$fileExt);
                    if (file_exists($path.DIRECTORY_SEPARATOR.$newFileName)) {
                        $this->flashMessenger()->addErrorMessage($data['profile_pic']['name'].' already exist', 'alert alert-danger');
                    } else {
                        rename($data['profile_pic']['tmp_name'], $path.DIRECTORY_SEPARATOR.$newFileName);
                        $this->flashMessenger()->addSuccessMessage($data['profile_pic']['name'].' Uploaded', 'alert alert-success');
                    }
                } else {
                    $newFileName = '';
                }

                $user = $this->userManager->addUser($data, $newFileName);

                return $this->redirect()->toRoute('users');
            }else{
				print_r($form->getMessages());
				
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
            $user = $this->entityManager->getRepository(User::class)
                ->findOneBy(['email' => $this->authService->getIdentity()]);
        } else {
            $user = $this->entityManager->getRepository(User::class)
                ->findOneBy(['email' => $this->authService->getIdentity()]);

            if (1 != $user->getUserType()) {

                if ($id != $user->getId()) {
                    $this->layout()->setTemplate('layout/blank');
                    $this->getResponse()->setStatusCode(404);

                    return;
                }
            } else {
                $user = $this->entityManager->getRepository(User::class)
                    ->find($id);
            }
        }

        if (null == $user) {
            $this->layout()->setTemplate('layout/blank');
            $this->getResponse()->setStatusCode(404);

            return;
        }

        $usertype = $this->ExtranetUtilities->getUserType($user->getId());

        $form = new PasswordChangeForm('change');

        return new ViewModel(
            [
                'user' => $user,
                'usertype' => $usertype,
                'form' => $form,
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

        $user = $this->entityManager->getRepository(User::class)
            ->find($id);

        if (null == $user) {
            $this->getResponse()->setStatusCode(404);

            return;
        }

        $form = new UserForm($this->dir, 'update', $this->entityManager, $user);
        $form->getInputFilter()->get('profile_pic')->setRequired(false);

        $allRoles = $this->entityManager->getRepository(Role::class)
            ->findBy([], ['name' => 'ASC']);
        $roleList = [];
        foreach ($allRoles as $role) {
            $roleList[$role->getId()] = $role->getName();
        }

		$allBranches = $this->entityManager->getRepository(Branch::class)
            ->findBy([], ['name' => 'ASC']);
        $branchList = [];
        foreach ($allBranches as $branch) {
            $branchList[$branch->getId()] = $branch->getName();
        }

        $form->get('roles')->setValueOptions($roleList);
        $form->get('branch')->setValueOptions($branchList);
		

        $allUserTypes = $this->entityManager->getRepository(SystemUserType::class)
            ->findBy([], ['name' => 'ASC']);
        $UserTypesList = [];
        foreach ($allUserTypes as $userType) {
            $UserTypesList[$userType->getId()] = $userType->getName();
        }

        $form->get('user_type')->setValueOptions($UserTypesList);

        if ($this->getRequest()->isPost()) {
            $post = array_merge_recursive(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            );
            $form->setData($post);

            $newFileName = '';
            if ($form->isValid()) {
                $data = $form->getData();

                if (empty($data['profile_pic']['name'])) {
                    $data['profile_pic']['name'] = $user->getProfilePic();
                } else {
                    $path = $this->dir.DIRECTORY_SEPARATOR.'profile_pics';

                    $randString = md5(time());
                    $fileName = $data['profile_pic']['name'];
                    $splitName = explode('.', $fileName);
                    $fileExt = end($splitName);
                    $newFileName = strtolower($randString.'.'.$fileExt);

                    if (file_exists($path.DIRECTORY_SEPARATOR.$newFileName)) {
                        $this->flashMessenger()->addErrorMessage($data['profile_pic']['name'].' already exist', 'alert alert-danger');
                    } else {
                        rename($data['profile_pic']['tmp_name'], $path.DIRECTORY_SEPARATOR.$newFileName);
                        $this->flashMessenger()->addSuccessMessage($data['profile_pic']['name'].' Uploaded', 'alert alert-success');
                    }
                }

                $this->userManager->updateUser($user, $data, $newFileName);

                return $this->redirect()->toRoute(
                    'users',
                    ['action' => 'view', 'id' => $user->getId()]
                );
            }
        } else {
            $userRoleIds = [];
            foreach ($user->getRoles() as $role) {
                $userRoleIds[] = $role->getId();
            }

            $form->setData(
                [
                    'full_name' => $user->getFullName(),
                    'contact_no' => $user->getContactNo(),
                    'user_type' => $user->getUserType(),
                    'designation' => $user->getDesignation(),
                    'email' => $user->getEmail(),
                    'alternate_email' => $user->getAlternateEmail(),
                    'branch' => $user->getBranch(),
                    'status' => $user->getStatus(),
                    'roles' => $userRoleIds,
                ]
            );
        }

        return new ViewModel(
            [
                'user' => $user,
                'form' => $form,
            ]
        );
    }

    public function editUserAction()
    {
        $id = (int) $this->params()->fromRoute('id', -1);
        if ($id < 1) {
            $this->layout()->setTemplate('layout/blank');
            $this->getResponse()->setStatusCode(404);

            return;
        }

        $user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['email' => $this->authService->getIdentity()]);

        if ($user->getId() != $id) {
            $this->layout()->setTemplate('layout/blank');
            $this->getResponse()->setStatusCode(404);

            return;
        }

        $form = new UserForm($this->dir, 'update', $this->entityManager, $user);
        $form->getInputFilter()->get('profile_pic')->setRequired(false);

        $allRoles = $this->entityManager->getRepository(Role::class)
            ->findBy([], ['name' => 'ASC']);
			
        $roleList = [];
        foreach ($allRoles as $role) {
            $roleList[$role->getId()] = $role->getName();
        }

		$allBranches = $this->entityManager->getRepository(Branch::class)
            ->findBy([], ['name' => 'ASC']);
        $branchList = [];
        foreach ($allBranches as $branch) {
            $branchList[$branch->getId()] = $branch->getName();
        }

        $form->get('roles')->setValueOptions($roleList);
        $form->get('branch')->setValueOptions($branchList);

        if ($this->getRequest()->isPost()) {
            $post = array_merge_recursive(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            );
            $form->setData($post);

            $newFileName = '';
            if ($form->isValid()) {
                $data = $form->getData();

                if (empty($data['profile_pic']['name'])) {
                    $data['profile_pic']['name'] = $user->getProfilePic();
                } else {
                    $path = $this->dir.DIRECTORY_SEPARATOR.'profile_pics';

                    $randString = md5(time());
                    $fileName = $data['profile_pic']['name'];
                    $splitName = explode('.', $fileName);
                    $fileExt = end($splitName);
                    $newFileName = strtolower($randString.'.'.$fileExt);

                    if (file_exists($path.DIRECTORY_SEPARATOR.$newFileName)) {
                        $this->flashMessenger()->addErrorMessage($data['profile_pic']['name'].' already exist', 'alert alert-danger');
                    } else {
                        rename($data['profile_pic']['tmp_name'], $path.DIRECTORY_SEPARATOR.$newFileName);
                        $this->flashMessenger()->addSuccessMessage($data['profile_pic']['name'].' Uploaded', 'alert alert-success');
                    }
                }

                $this->userManager->updateUser($user, $data, $newFileName);

                return $this->redirect()->toRoute(
                    'users',
                    ['action' => 'view', 'id' => $user->getId()]
                );
            }
        } else {
            $form->setData(
                [
                    'full_name' => $user->getFullName(),
                    'contact_no' => $user->getContactNo(),
                    'email' => $user->getEmail(),
                    'branch' => $user->getBranch(),
                    'status' => $user->getStatus(),
                ]
            );
        }

        return new ViewModel(
            [
                'user' => $user,
                'form' => $form,
            ]
        );
    }

    public function changePasswordAction()
    {
        $id = (int) $this->params()->fromRoute('id', -1);
        if ($id < 1) {
            $this->layout()->setTemplate('layout/blank');
            $this->getResponse()->setStatusCode(404);

            return;
        }

        $user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['email' => $this->authService->getIdentity()]);

        if (1 != $user->getUserType()) {
            if ($user->getId() != $id) {
                $this->layout()->setTemplate('layout/blank');
                $this->getResponse()->setStatusCode(404);
            }
        }

        $user = $this->entityManager->getRepository(User::class)
            ->find($id);

        if (null == $user) {
            $this->getResponse()->setStatusCode(404);

            return;
        }

        $form = new PasswordChangeForm('change');

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();

            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();
                if (!$this->userManager->changePassword($user, $data)) {
                    $this->flashMessenger()->addErrorMessage(
                        'Sorry, the old password is incorrect. Could not set the new password.'
                    );
                } else {
                    $this->flashMessenger()->addSuccessMessage(
                        'Changed the password successfully.'
                    );
                }

                return $this->redirect()->toRoute(
                    'users',
                    ['action' => 'view', 'id' => $user->getId()]
                );
            }
        }

        return new ViewModel(
            [
                'user' => $user,
                'form' => $form,
            ]
        );
    }

    public function resetPasswordAction()
    {
        $this->layout()->setTemplate('layout/login-layout');
        $form = new PasswordResetForm();

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();

            $form->setData($data);
            if ($form->isValid()) {
                $user = $this->entityManager->getRepository(User::class)
                    ->findOneByEmail($data['email']);
					
                if (null != $user) {
                    $this->userManager->generatePasswordResetToken($user);

                    return $this->redirect()->toRoute(
                        'users',
                        ['action' => 'message', 'id' => 'sent']
                    );
                }

                return $this->redirect()->toRoute(
                    'users',
                    ['action' => 'message', 'id' => 'invalid-email']
                );
            }
        }

        return new ViewModel(
            [
                'form' => $form,
            ]
        );
    }

    public function messageAction()
    {
        $id = (string) $this->params()->fromRoute('id');

        if ('invalid-email' != $id && 'sent' != $id && 'set' != $id && 'failed' != $id) {
            throw new \Exception('Invalid message ID specified');
        }

        return new ViewModel(
            [
                'id' => $id,
            ]
        );
    }

    public function setPasswordAction()
    {
        $token = $this->params()->fromQuery('token', null);

        if (null != $token && (!is_string($token) || 32 != strlen($token))) {
            throw new \Exception('Invalid token type or length');
        }

        if (null === $token
            || !$this->userManager->validatePasswordResetToken($token)
        ) {
            return $this->redirect()->toRoute(
                'users',
                ['action' => 'message', 'id' => 'failed']
            );
        }

        $form = new PasswordChangeForm('reset');

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();

            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();

                if ($this->userManager->setNewPasswordByToken($token, $data['new_password'])) {
                    return $this->redirect()->toRoute(
                        'users',
                        ['action' => 'message', 'id' => 'set']
                    );
                }

                return $this->redirect()->toRoute(
                    'users',
                    ['action' => 'message', 'id' => 'failed']
                );
            }
        }

        return new ViewModel(
            [
                'form' => $form,
            ]
        );
    }

    public function setstatusAction()
    {
        $id = (int) $this->params()->fromRoute('id', -1);
        $user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['id' => $id]);
			
        $status = $user->getStatus();
        if (1 == $status) {
            $user->setStatus('0');
        } else {
            $user->setStatus('1');
        }
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->flashMessenger()->addSuccessMessage('User Status Changed '.$user->getId());

        return $this->redirect()->toRoute('users');
    }
}
