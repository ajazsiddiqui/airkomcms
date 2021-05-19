<?php

namespace Application\View\Helper;

use Laminas\View\Helper\AbstractHelper;
use Properties\Entity\Properties;
use Settings\Entity\Settings;

class SystemSettings extends AbstractHelper
{
    private $settings;

    public function __construct($authService, $entityManager)
    {
        $this->authService = $authService;
        $this->settings = $entityManager->getRepository(Settings::class)->findOneBy(['id' => 1]);
        $this->entityManager = $entityManager;
    }

    public function getCompanyName()
    {
        return $this->settings->getCompanyName();
    }

    public function getCompanyBrief()
    {
        return $this->settings->getCompanyBrief();
    }

    public function getCompanyLogo()
    {
        return $this->settings->getCompanyLogo();
    }

    public function getFavicon()
    {
        return $this->settings->getFavicon();
    }

    public function getBrandColor()
    {
        return $this->settings->getBrandColor();
    }

    public function getContact()
    {
        return $this->settings->getContact();
    }

    public function getEmail()
    {
        return $this->settings->getEmail();
    }

    public function getCpApproval()
    {
        return $this->settings->getCpApproval();
    }

    public function getPageTitle()
    {
        return $this->settings->getPageTitle();
    }

    public function getPageKeywords()
    {
        return $this->settings->getPageKeywords();
    }

    public function getPageDescription()
    {
        return $this->settings->getPageDescription();
    }

    public function getNameEmailer()
    {
        return $this->settings->getNameEmailer();
    }

    public function getEmailEmailer()
    {
        return $this->settings->getEmailEmailer();
    }

    public function getBirthdayReminder()
    {
        return $this->settings->getBirthdayReminder();
    }

    public function getSmsEnabled()
    {
        return $this->settings->getSmsEnabled();
    }

    public function getSmsApi()
    {
        return $this->settings->getSmsApi();
    }

    public function getKookooApi()
    {
        return $this->settings->getKookooApi();
    }

    public function getCallApi()
    {
        return $this->settings->getCallApi();
    }

    public function getFacebook()
    {
        return $this->settings->getFacebook();
    }

    public function getTwitter()
    {
        return $this->settings->getTwitter();
    }

    public function getLinkedin()
    {
        return $this->settings->getLinkedin();
    }

    public function getPinterest()
    {
        return $this->settings->getPinterest();
    }

    public function getProperty($id)
    {
        $property = $this->entityManager->getRepository(Properties::class)->findOneBy(['id' => $id]);

        return $property->getName();
    }
}
