<?php

namespace Settings\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Settings.
 *
 * @ORM\Table(name="settings")
 * @ORM\Entity
 */
class Settings
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="company_name", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $companyName;

    /**
     * @var string
     *
     * @ORM\Column(name="company_brief", type="text", length=65535, precision=0, scale=0, nullable=false, unique=false)
     */
    private $companyBrief;

    /**
     * @var string
     *
     * @ORM\Column(name="contact", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $contact;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="page_title", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $pageTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="page_keywords", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    private $pageKeywords;

    /**
     * @var string
     *
     * @ORM\Column(name="page_description", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    private $pageDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="distance_travel_percentage", type="decimal", precision=10, scale=2, nullable=false, unique=false)
     */
    private $distanceTravelPercentage;

    /**
     * @var string
     *
     * @ORM\Column(name="name_emailer", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $nameEmailer;

    /**
     * @var string
     *
     * @ORM\Column(name="email_emailer", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $emailEmailer;


    /**
     * @var int
     *
     * @ORM\Column(name="sms_enabled", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $smsEnabled;

    /**
     * @var string
     *
     * @ORM\Column(name="sms_api", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $smsApi;

    /**
     * @var string
     *
     * @ORM\Column(name="sendgrid_api", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $sendgridApi;

    /**
     * @var string
     *
     * @ORM\Column(name="created_by", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $createdBy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", precision=0, scale=0, nullable=false, unique=false)
     */
    private $dateCreated;

    public function __construct()
    {
        $this->dateCreated = new \DateTime();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set companyName.
     *
     * @param string $companyName
     *
     * @return Settings
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * Get companyName.
     *
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * Set companyBrief.
     *
     * @param string $companyBrief
     *
     * @return Settings
     */
    public function setCompanyBrief($companyBrief)
    {
        $this->companyBrief = $companyBrief;

        return $this;
    }

    /**
     * Get companyBrief.
     *
     * @return string
     */
    public function getCompanyBrief()
    {
        return $this->companyBrief;
    }

    /**
     * Set contact.
     *
     * @param string $contact
     *
     * @return Settings
     */
    public function setContact($contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact.
     *
     * @return string
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return Settings
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }


    /**
     * Set pageTitle.
     *
     * @param string $pageTitle
     *
     * @return Settings
     */
    public function setPageTitle($pageTitle)
    {
        $this->pageTitle = $pageTitle;

        return $this;
    }

    /**
     * Get pageTitle.
     *
     * @return string
     */
    public function getPageTitle()
    {
        return $this->pageTitle;
    }

    /**
     * Set pageKeywords.
     *
     * @param string $pageKeywords
     *
     * @return Settings
     */
    public function setPageKeywords($pageKeywords)
    {
        $this->pageKeywords = $pageKeywords;

        return $this;
    }

    /**
     * Get pageKeywords.
     *
     * @return string
     */
    public function getPageKeywords()
    {
        return $this->pageKeywords;
    }

    /**
     * Set pageDescription.
     *
     * @param string $pageDescription
     *
     * @return Settings
     */
    public function setPageDescription($pageDescription)
    {
        $this->pageDescription = $pageDescription;

        return $this;
    }

    /**
     * Get pageDescription.
     *
     * @return string
     */
    public function getPageDescription()
    {
        return $this->pageDescription;
    }


    /**
     * Set distanceTravelPercentage.
     *
     * @param string $distanceTravelPercentage
     *
     * @return Settings
     */
    public function setDistanceTravelPercentage($distanceTravelPercentage)
    {
        $this->distanceTravelPercentage = $distanceTravelPercentage;

        return $this;
    }

    /**
     * Get distanceTravelPercentage.
     *
     * @return string
     */
    public function getDistanceTravelPercentage()
    {
        return $this->distanceTravelPercentage;
    }

    /**
     * Set nameEmailer.
     *
     * @param string $nameEmailer
     *
     * @return Settings
     */
    public function setNameEmailer($nameEmailer)
    {
        $this->nameEmailer = $nameEmailer;

        return $this;
    }

    /**
     * Get nameEmailer.
     *
     * @return string
     */
    public function getNameEmailer()
    {
        return $this->nameEmailer;
    }

    /**
     * Set emailEmailer.
     *
     * @param string $emailEmailer
     *
     * @return Settings
     */
    public function setEmailEmailer($emailEmailer)
    {
        $this->emailEmailer = $emailEmailer;

        return $this;
    }

    /**
     * Get emailEmailer.
     *
     * @return string
     */
    public function getEmailEmailer()
    {
        return $this->emailEmailer;
    }


    /**
     * Set smsEnabled.
     *
     * @param int $smsEnabled
     *
     * @return Settings
     */
    public function setSmsEnabled($smsEnabled)
    {
        $this->smsEnabled = $smsEnabled;

        return $this;
    }

    /**
     * Get smsEnabled.
     *
     * @return int
     */
    public function getSmsEnabled()
    {
        return $this->smsEnabled;
    }

    /**
     * Set smsApi.
     *
     * @param string $smsApi
     *
     * @return Settings
     */
    public function setSmsApi($smsApi)
    {
        $this->smsApi = $smsApi;

        return $this;
    }

    /**
     * Get smsApi.
     *
     * @return string
     */
    public function getSmsApi()
    {
        return $this->smsApi;
    }

    /**
     * Set sendgridApi.
     *
     * @param string $sendgridApi
     *
     * @return Settings
     */
    public function setSendgridApi($sendgridApi)
    {
        $this->sendgridApi = $sendgridApi;

        return $this;
    }

    /**
     * Get sendgridApi.
     *
     * @return string
     */
    public function getSendgridApi()
    {
        return $this->sendgridApi;
    }


    /**
     * Set createdBy.
     *
     * @param string $createdBy
     *
     * @return Settings
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy.
     *
     * @return string
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set dateCreated.
     *
     * @param \DateTime $dateCreated
     *
     * @return Settings
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated.
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated->format('d-m-Y');
    }
}
