<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserDetails.
 *
 * @ORM\Table(name="user_details")
 * @ORM\Entity
 */
class UserDetails
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
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $userId;

    /**
     * @var int
     *
     * @ORM\Column(name="user_type", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $userType;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="contact", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $contact;

    /**
     * @var string
     *
     * @ORM\Column(name="alternate_number", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $alternateNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="text", length=65535, precision=0, scale=0, nullable=true, unique=false)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="pincode", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $pincode;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birth_date", type="datetime", precision=0, scale=0, nullable=true, unique=false)
     */
    private $birthDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="anniversary_date", type="datetime", precision=0, scale=0, nullable=true, unique=false)
     */
    private $anniversaryDate;

    /**
     * @var string
     *
     * @ORM\Column(name="remark", type="text", length=65535, precision=0, scale=0, nullable=true, unique=false)
     */
    private $remark;

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
     * Set userId.
     *
     * @param int $userId
     *
     * @return UserDetails
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId.
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set userType.
     *
     * @param int $userType
     *
     * @return UserDetails
     */
    public function setUserType($userType)
    {
        $this->userType = $userType;

        return $this;
    }

    /**
     * Get userType.
     *
     * @return int
     */
    public function getUserType()
    {
        return $this->userType;
    }

    /**
     * Set firstName.
     *
     * @param string $firstName
     *
     * @return Customers
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName.
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName.
     *
     * @param string $lastName
     *
     * @return Customers
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName.
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return Customers
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
     * Set contact.
     *
     * @param string $contact
     *
     * @return Customers
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
     * Set alternateNumber.
     *
     * @param string $alternateNumber
     *
     * @return Customers
     */
    public function setAlternateNumber($alternateNumber)
    {
        $this->alternateNumber = $alternateNumber;

        return $this;
    }

    /**
     * Get alternateNumber.
     *
     * @return string
     */
    public function getAlternateNumber()
    {
        return $this->alternateNumber;
    }

    /**
     * Set state.
     *
     * @param string $state
     *
     * @return Customers
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state.
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set city.
     *
     * @param string $city
     *
     * @return Customers
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city.
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set address.
     *
     * @param string $address
     *
     * @return Customers
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address.
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set pincode.
     *
     * @param string $pincode
     *
     * @return Customers
     */
    public function setPincode($pincode)
    {
        $this->pincode = $pincode;

        return $this;
    }

    /**
     * Get pincode.
     *
     * @return string
     */
    public function getPincode()
    {
        return $this->pincode;
    }

    /**
     * Set birthDate.
     *
     * @param \DateTime $birthDate
     *
     * @return Customers
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate.
     *
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return (!empty($this->birthDate)) ?
        $this->birthDate->format('d-m-Y') : '';
    }

    /**
     * Set anniversaryDate.
     *
     * @param \DateTime $anniversaryDate
     *
     * @return Customers
     */
    public function setAnniversaryDate($anniversaryDate)
    {
        $this->anniversaryDate = $anniversaryDate;

        return $this;
    }

    /**
     * Get anniversaryDate.
     *
     * @return \DateTime
     */
    public function getAnniversaryDate()
    {
        return (!empty($this->anniversaryDate)) ?
        $this->anniversaryDate->format('d-m-Y') : '';
    }

    /**
     * Set remark.
     *
     * @param string $remark
     *
     * @return Customers
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;

        return $this;
    }

    /**
     * Get remark.
     *
     * @return string
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     * Set dateCreated.
     *
     * @param \DateTime $dateCreated
     *
     * @return Customers
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
