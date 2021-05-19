<?php

namespace User\Controller;

use Laminas\Authentication\Result;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\MvcEvent;
use Laminas\Uri\Uri;
use Laminas\View\Model\ViewModel;
use User\Form\LoginForm;

class AuthController extends AbstractActionController
{
    private $entityManager;
    private $authManager;
    private $authService;
    private $userManager;

    public function __construct($entityManager, $authManager, $authService, $userManager)
    {
        $this->entityManager = $entityManager;
        $this->authManager = $authManager;
        $this->authService = $authService;
        $this->userManager = $userManager;
    }

    public function onDispatch(MvcEvent $e)
    {
        return parent::onDispatch($e);
    }

    public function loginAction()
    {
        if (null != $this->authService->getIdentity()) {
            return $this->redirect()->toRoute('application');
        }

        $this->layout()->setTemplate('layout/login-layout');
        $redirectUrl = (string) $this->params()->fromQuery('redirectUrl', '');
        if (strlen($redirectUrl) > 2048) {
            throw new \Exception('Too long redirectUrl argument passed');
        }

        $this->userManager->createAdminUserIfNotExists();

        $form = new LoginForm();
        $form->get('redirect_url')->setValue($redirectUrl);

        $isLoginError = false;

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();

            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();

                $result = $this->authManager->login(
                    $data['email'],
                    $data['password'],
                    $data['remember_me']
                );

                if (Result::SUCCESS == $result->getCode()) {
                    $redirectUrl = $this->params()->fromPost('redirect_url', '');

                    if (!empty($redirectUrl)) {
                        $uri = new Uri($redirectUrl);
                        if (!$uri->isValid() || null != $uri->getHost()) {
                            throw new \Exception('Incorrect redirect URL: '.$redirectUrl);
                        }
                    }

                    if (empty($redirectUrl)) {
                        return $this->redirect()->toRoute('application');
                    }
                    $this->redirect()->toUrl($redirectUrl);
                } else {
                    $isLoginError = true;
                }
            } else {
                $isLoginError = true;
            }
        }

        return new ViewModel(
            [
                'form' => $form,
                'isLoginError' => $isLoginError,
                'redirectUrl' => $redirectUrl,
            ]
        );
    }

    public function logoutAction()
    {
        if (null == $this->authService->getIdentity()) {
            return $this->redirect()->toRoute('login');
        }
        $this->layout()->setTemplate('layout/login-layout');
        $this->authManager->logout();

        return $this->redirect()->toRoute('login');
    }

    public function notAuthorizedAction()
    {
        $this->layout()->setTemplate('layout/auth-layout');
        $this->getResponse()->setStatusCode(403);

        return new ViewModel();
    }
}
