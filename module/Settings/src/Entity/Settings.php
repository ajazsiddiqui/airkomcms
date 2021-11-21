<?php

namespace Settings\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Settings
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
     * @var string|null
     *
     * @ORM\Column(name="services", type="text", length=65535, precision=0, scale=0, nullable=true, unique=false)
     */
    private $services;

    /**
     * @var string|null
     *
     * @ORM\Column(name="payment", type="text", length=65535, precision=0, scale=0, nullable=true, unique=false)
     */
    private $payment;

    /**
     * @var string|null
     *
     * @ORM\Column(name="address", type="text", length=65535, precision=0, scale=0, nullable=true, unique=false)
     */
    private $address;

    /**
     * @var string|null
     *
     * @ORM\Column(name="website", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $website;

    /**
     * @var string|null
     *
     * @ORM\Column(name="facebook", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $facebook;

    /**
     * @var string|null
     *
     * @ORM\Column(name="linkedin", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $linkedin;

    /**
     * @var string|null
     *
     * @ORM\Column(name="instagram", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $instagram;

    /**
     * @var string|null
     *
     * @ORM\Column(name="youtube", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $youtube;

    /**
     * @var string|null
     *
     * @ORM\Column(name="catalog", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $catalog;

    /**
     * @var string|null
     *
     * @ORM\Column(name="contact", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $contact;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="page_title", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $pageTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="page_keywords", type="text", length=65535, precision=0, scale=0, nullable=false, unique=false)
     */
    private $pageKeywords;

    /**
     * @var string
     *
     * @ORM\Column(name="page_description", type="text", length=65535, precision=0, scale=0, nullable=false, unique=false)
     */
    private $pageDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="distance_travel_percentage", type="decimal", precision=10, scale=2, nullable=false, unique=false)
     */
    private $distanceTravelPercentage;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name_emailer", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $nameEmailer;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email_emailer", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $emailEmailer;

    /**
     * @var int|null
     *
     * @ORM\Column(name="sms_enabled", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $smsEnabled;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sms_api", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $smsApi;

    /**
     * @var string|null
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
     * @ORM\Column(name="date_created", type="datetime", precision=0, scale=0, nullable=false, options={"default"="CURRENT_TIMESTAMP"}, unique=false)
     */
    private $dateCreated = 'CURRENT_TIMESTAMP';


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
     * Set services.
     *
     * @param string|null $services
     *
     * @return Settings
     */
    public function setServices($services = null)
    {
        $this->services = $services;

        return $this;
    }

    /**
     * Get services.
     *
     * @return string|null
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * Set payment.
     *
     * @param string|null $payment
     *
     * @return Settings
     */
    public function setPayment($payment = null)
    {
        $this->payment = $payment;

        return $this;
    }

    /**
     * Get payment.
     *
     * @return string|null
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * Set address.
     *
     * @param string|null $address
     *
     * @return Settings
     */
    public function setAddress($address = null)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address.
     *
     * @return string|null
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set website.
     *
     * @param string|null $website
     *
     * @return Settings
     */
    public function setWebsite($website = null)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website.
     *
     * @return string|null
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set facebook.
     *
     * @param string|null $facebook
     *
     * @return Settings
     */
    public function setFacebook($facebook = null)
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get facebook.
     *
     * @return string|null
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Set linkedin.
     *
     * @param string|null $linkedin
     *
     * @return Settings
     */
    public function setLinkedin($linkedin = null)
    {
        $this->linkedin = $linkedin;

        return $this;
    }

    /**
     * Get linkedin.
     *
     * @return string|null
     */
    public function getLinkedin()
    {
        return $this->linkedin;
    }

    /**
     * Set instagram.
     *
     * @param string|null $instagram
     *
     * @return Settings
     */
    public function setInstagram($instagram = null)
    {
        $this->instagram = $instagram;

        return $this;
    }

    /**
     * Get instagram.
     *
     * @return string|null
     */
    public function getInstagram()
    {
        return $this->instagram;
    }

    /**
     * Set youtube.
     *
     * @param string|null $youtube
     *
     * @return Settings
     */
    public function setYoutube($youtube = null)
    {
        $this->youtube = $youtube;

        return $this;
    }

    /**
     * Get youtube.
     *
     * @return string|null
     */
    public function getYoutube()
    {
        return $this->youtube;
    }

    /**
     * Set catalog.
     *
     * @param string|null $catalog
     *
     * @return Settings
     */
    public function setCatalog($catalog = null)
    {
        $this->catalog = $catalog;

        return $this;
    }

    /**
     * Get catalog.
     *
     * @return string|null
     */
    public function getCatalog()
    {
        return $this->catalog;
    }

    /**
     * Set contact.
     *
     * @param string|null $contact
     *
     * @return Settings
     */
    public function setContact($contact = null)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact.
     *
     * @return string|null
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set email.
     *
     * @param string|null $email
     *
     * @return Settings
     */
    public function setEmail($email = null)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set pageTitle.
     *
     * @param string|null $pageTitle
     *
     * @return Settings
     */
    public function setPageTitle($pageTitle = null)
    {
        $this->pageTitle = $pageTitle;

        return $this;
    }

    /**
     * Get pageTitle.
     *
     * @return string|null
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
     * @param string|null $nameEmailer
     *
     * @return Settings
     */
    public function setNameEmailer($nameEmailer = null)
    {
        $this->nameEmailer = $nameEmailer;

        return $this;
    }

    /**
     * Get nameEmailer.
     *
     * @return string|null
     */
    public function getNameEmailer()
    {
        return $this->nameEmailer;
    }

    /**
     * Set emailEmailer.
     *
     * @param string|null $emailEmailer
     *
     * @return Settings
     */
    public function setEmailEmailer($emailEmailer = null)
    {
        $this->emailEmailer = $emailEmailer;

        return $this;
    }

    /**
     * Get emailEmailer.
     *
     * @return string|null
     */
    public function getEmailEmailer()
    {
        return $this->emailEmailer;
    }

    /**
     * Set smsEnabled.
     *
     * @param int|null $smsEnabled
     *
     * @return Settings
     */
    public function setSmsEnabled($smsEnabled = null)
    {
        $this->smsEnabled = $smsEnabled;

        return $this;
    }

    /**
     * Get smsEnabled.
     *
     * @return int|null
     */
    public function getSmsEnabled()
    {
        return $this->smsEnabled;
    }

    /**
     * Set smsApi.
     *
     * @param string|null $smsApi
     *
     * @return Settings
     */
    public function setSmsApi($smsApi = null)
    {
        $this->smsApi = $smsApi;

        return $this;
    }

    /**
     * Get smsApi.
     *
     * @return string|null
     */
    public function getSmsApi()
    {
        return $this->smsApi;
    }

    /**
     * Set sendgridApi.
     *
     * @param string|null $sendgridApi
     *
     * @return Settings
     */
    public function setSendgridApi($sendgridApi = null)
    {
        $this->sendgridApi = $sendgridApi;

        return $this;
    }

    /**
     * Get sendgridApi.
     *
     * @return string|null
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
        return $this->dateCreated;
    }
}
