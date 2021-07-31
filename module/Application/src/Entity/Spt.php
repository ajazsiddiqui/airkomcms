<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Spt
 *
 * @ORM\Table(name="spt")
 * @ORM\Entity
 */
class Spt
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
     * @ORM\Column(name="stage", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $stage;

    /**
     * @var int
     *
     * @ORM\Column(name="propect_name", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $propectName;

    /**
     * @var int
     *
     * @ORM\Column(name="lead_source", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $leadSource;

    /**
     * @var int
     *
     * @ORM\Column(name="executive", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $executive;

    /**
     * @var string
     *
     * @ORM\Column(name="offer_no", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $offerNo;

    /**
     * @var int
     *
     * @ORM\Column(name="sales_stage", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $salesStage;

    /**
     * @var int
     *
     * @ORM\Column(name="product_series", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $productSeries;

    /**
     * @var int
     *
     * @ORM\Column(name="product_model", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $productModel;

    /**
     * @var int
     *
     * @ORM\Column(name="actual_product", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $actualProduct;

    /**
     * @var string
     *
     * @ORM\Column(name="forecasted_booking_value", type="decimal", precision=10, scale=2, nullable=false, unique=false)
     */
    private $forecastedBookingValue;
	
	/**
     * @var string
     *
     * @ORM\Column(name="discount_offered", type="decimal", precision=10, scale=2, nullable=false, unique=false)
     */
    private $discountOffered;

    /**
     * @var int
     *
     * @ORM\Column(name="quanitity", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $quanitity;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expected_close_date", type="date", precision=0, scale=0, nullable=false, unique=false)
     */
    private $expectedCloseDate;

    /**
     * @var int
     *
     * @ORM\Column(name="expected_month", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $expectedMonth;

    /**
     * @var int
     *
     * @ORM\Column(name="close_probability", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $closeProbability;

    /**
     * @var int
     *
     * @ORM\Column(name="next_action", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $nextAction;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_contacted_date", type="date", precision=0, scale=0, nullable=false, unique=false)
     */
    private $lastContactedDate;

    /**
     * @var string
     *
     * @ORM\Column(name="remarks", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $remarks;

    /**
     * @var int
     *
     * @ORM\Column(name="contacted_type", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $contactedType;


    /**
     * @var int
     *
     * @ORM\Column(name="contact", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $contact;

    /**
     * @var int
     *
     * @ORM\Column(name="created_by", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $createdBy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", precision=0, scale=0, nullable=false, options={"default"="CURRENT_TIMESTAMP"}, unique=false)
     */
    private $dateCreated = 'CURRENT_TIMESTAMP';

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
     * Set stage.
     *
     * @param int $stage
     *
     * @return Spt
     */
    public function setStage($stage)
    {
        $this->stage = $stage;

        return $this;
    }

    /**
     * Get stage.
     *
     * @return int
     */
    public function getStage()
    {
        return $this->stage;
    }

    /**
     * Set propectName.
     *
     * @param int $propectName
     *
     * @return Spt
     */
    public function setPropectName($propectName)
    {
        $this->propectName = $propectName;

        return $this;
    }

    /**
     * Get propectName.
     *
     * @return int
     */
    public function getPropectName()
    {
        return $this->propectName;
    }

    /**
     * Set leadSource.
     *
     * @param int $leadSource
     *
     * @return Spt
     */
    public function setLeadSource($leadSource)
    {
        $this->leadSource = $leadSource;

        return $this;
    }

    /**
     * Get leadSource.
     *
     * @return int
     */
    public function getLeadSource()
    {
        return $this->leadSource;
    }

    /**
     * Set executive.
     *
     * @param int $executive
     *
     * @return Spt
     */
    public function setExecutive($executive)
    {
        $this->executive = $executive;

        return $this;
    }

    /**
     * Get executive.
     *
     * @return int
     */
    public function getExecutive()
    {
        return $this->executive;
    }

    /**
     * Set offerNo.
     *
     * @param string $offerNo
     *
     * @return Spt
     */
    public function setOfferNo($offerNo)
    {
        $this->offerNo = $offerNo;

        return $this;
    }

    /**
     * Get offerNo.
     *
     * @return string
     */
    public function getOfferNo()
    {
        return $this->offerNo;
    }

    /**
     * Set salesStage.
     *
     * @param int $salesStage
     *
     * @return Spt
     */
    public function setSalesStage($salesStage)
    {
        $this->salesStage = $salesStage;

        return $this;
    }

    /**
     * Get salesStage.
     *
     * @return int
     */
    public function getSalesStage()
    {
        return $this->salesStage;
    }

    /**
     * Set productSeries.
     *
     * @param int $productSeries
     *
     * @return Spt
     */
    public function setProductSeries($productSeries)
    {
        $this->productSeries = $productSeries;

        return $this;
    }

    /**
     * Get productSeries.
     *
     * @return int
     */
    public function getProductSeries()
    {
        return $this->productSeries;
    }

    /**
     * Set productModel.
     *
     * @param int $productModel
     *
     * @return Spt
     */
    public function setProductModel($productModel)
    {
        $this->productModel = $productModel;

        return $this;
    }

    /**
     * Get productModel.
     *
     * @return int
     */
    public function getProductModel()
    {
        return $this->productModel;
    }

    /**
     * Set actualProduct.
     *
     * @param int $actualProduct
     *
     * @return Spt
     */
    public function setActualProduct($actualProduct)
    {
        $this->actualProduct = $actualProduct;

        return $this;
    }

    /**
     * Get actualProduct.
     *
     * @return int
     */
    public function getActualProduct()
    {
        return $this->actualProduct;
    }

    /**
     * Set forecastedBookingValue.
     *
     * @param string $forecastedBookingValue
     *
     * @return Spt
     */
    public function setForecastedBookingValue($forecastedBookingValue)
    {
        $this->forecastedBookingValue = $forecastedBookingValue;

        return $this;
    }

    /**
     * Get forecastedBookingValue.
     *
     * @return string
     */
    public function getForecastedBookingValue()
    {
        return $this->forecastedBookingValue;
    }


    /**
     * Set discountOffered.
     *
     * @param string $discountOffered
     *
     * @return Spt
     */
    public function setDiscountOffered($discountOffered)
    {
        $this->discountOffered = $discountOffered;

        return $this;
    }

    /**
     * Get discountOffered.
     *
     * @return string
     */
    public function getDiscountOffered()
    {
        return $this->discountOffered;
    }

    /**
     * Set quanitity.
     *
     * @param int $quanitity
     *
     * @return Spt
     */
    public function setQuanitity($quanitity)
    {
        $this->quanitity = $quanitity;

        return $this;
    }

    /**
     * Get quanitity.
     *
     * @return int
     */
    public function getQuanitity()
    {
        return $this->quanitity;
    }

    /**
     * Set expectedCloseDate.
     *
     * @param \DateTime $expectedCloseDate
     *
     * @return Spt
     */
    public function setExpectedCloseDate($expectedCloseDate)
    {
        $this->expectedCloseDate = $expectedCloseDate;

        return $this;
    }

    /**
     * Get expectedCloseDate.
     *
     * @return \DateTime
     */
    public function getExpectedCloseDate()
    {
        return $this->expectedCloseDate;
    }

    /**
     * Set expectedMonth.
     *
     * @param int $expectedMonth
     *
     * @return Spt
     */
    public function setExpectedMonth($expectedMonth)
    {
        $this->expectedMonth = $expectedMonth;

        return $this;
    }

    /**
     * Get expectedMonth.
     *
     * @return int
     */
    public function getExpectedMonth()
    {
        return $this->expectedMonth;
    }

    /**
     * Set closeProbability.
     *
     * @param int $closeProbability
     *
     * @return Spt
     */
    public function setCloseProbability($closeProbability)
    {
        $this->closeProbability = $closeProbability;

        return $this;
    }

    /**
     * Get closeProbability.
     *
     * @return int
     */
    public function getCloseProbability()
    {
        return $this->closeProbability;
    }

    /**
     * Set nextAction.
     *
     * @param int $nextAction
     *
     * @return Spt
     */
    public function setNextAction($nextAction)
    {
        $this->nextAction = $nextAction;

        return $this;
    }

    /**
     * Get nextAction.
     *
     * @return int
     */
    public function getNextAction()
    {
        return $this->nextAction;
    }

    /**
     * Set lastContactedDate.
     *
     * @param \DateTime $lastContactedDate
     *
     * @return Spt
     */
    public function setLastContactedDate($lastContactedDate)
    {
        $this->lastContactedDate = $lastContactedDate;

        return $this;
    }

    /**
     * Get lastContactedDate.
     *
     * @return \DateTime
     */
    public function getLastContactedDate()
    {
        return $this->lastContactedDate;
    }

    /**
     * Set remarks.
     *
     * @param string $remarks
     *
     * @return Spt
     */
    public function setRemarks($remarks)
    {
        $this->remarks = $remarks;

        return $this;
    }

    /**
     * Get remarks.
     *
     * @return string
     */
    public function getRemarks()
    {
        return $this->remarks;
    }

    /**
     * Set contactedType.
     *
     * @param int $contactedType
     *
     * @return Spt
     */
    public function setContactedType($contactedType)
    {
        $this->contactedType = $contactedType;

        return $this;
    }

    /**
     * Get contactedType.
     *
     * @return int
     */
    public function getContactedType()
    {
        return $this->contactedType;
    }

    /**
     * Set contact.
     *
     * @param int $contact
     *
     * @return Spt
     */
    public function setContact($contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact.
     *
     * @return int
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set createdBy.
     *
     * @param int $createdBy
     *
     * @return Spt
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy.
     *
     * @return int
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
     * @return Spt
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
        return $this->dateCreated->format('Y-m-d');
    }
}
