<?php

namespace Settings\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Settings\Entity\Settings;
use Settings\Form\SettingsForm;
use User\Entity\User;

class SettingsController extends AbstractActionController
{
    private $_dir;
    private $authService;
    private $entityManager;
    private $logManager;

    public function __construct($dir, $authService, $entityManager, $logManager)
    {
        $this->_dir = $dir;
        $this->authService = $authService;
        $this->entityManager = $entityManager;
        $this->logManager = $logManager;
    }

    public function init()
    {
        if ($user = $this->identity()) {
        } else {
            return $this->redirect()->toRoute('login');
        }
    }

    public function indexAction()
    {
        $user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['email' => $this->authService->getIdentity()], ['id' => 'ASC']);

        $form = new SettingsForm();
        $settings = $this->entityManager->getRepository(Settings::class)->findOneBy(['id' => 1]);

        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost()->toArray();

            $form->setData($post);

            if ($form->isValid()) {
                $data = $form->getData();

                try {
                    $settings->setCompanyName($data['company_name']);
                    $settings->setCompanyBrief($data['company_brief']);
                    $settings->setContact($data['contact']);
                    $settings->setEmail($data['email']);
                    $settings->setPageTitle($data['page_title']);
                    $settings->setPageKeywords($data['page_keywords']);
                    $settings->setPageDescription($data['page_description']);
                    $settings->setDistanceTravelPercentage($data['distance_travel_percentage']);
                    $settings->setNameEmailer($data['name_emailer']);
                    $settings->setEmailEmailer($data['email_emailer']);
                    $settings->setSmsEnabled($data['sms_enabled']);
                    $settings->setSmsApi($data['sms_api']);
                    $settings->setSendgridApi($data['sendgrid_api']);
                    $settings->setCreatedBy($user->getId());
                    $this->entityManager->persist($settings);
                    $this->entityManager->flush();
                } catch (Exception $e) {
                    
                }

                $log = $this->logManager;
                $log->setlog('Settings Edited', '', $this->authService->getIdentity());

                $this->flashMessenger()->addSuccessMessage('Settings Updated Successfully');

                return $this->redirect()->toRoute('settings', ['action' => 'index']);
            }
            //$form->getMessages();
        } else {
            $form->setData(
                [
                    'company_name' => $settings->getCompanyName(),
                    'company_brief' => $settings->getCompanyBrief(),
                    'contact' => $settings->getContact(),
                    'email' => $settings->getEmail(),
                    'page_title' => $settings->getPageTitle(),
                    'page_keywords' => $settings->getPageKeywords(),
                    'page_description' => $settings->getPageDescription(),
                    'distance_travel_percentage' => $settings->getDistanceTravelPercentage(),
                    'name_emailer' => $settings->getNameEmailer(),
                    'email_emailer' => $settings->getEmailEmailer(),
                    'sms_enabled' => $settings->getSmsEnabled(),
                    'sms_api' => $settings->getSmsApi(),
                    'sendgrid_api' => $settings->getSendgridApi(),
                ]
            );
        }

        return new ViewModel(['settings' => $settings, 'form' => $form]);
    }
}
