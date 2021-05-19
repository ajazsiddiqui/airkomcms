<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dcr
 *
 * @ORM\Table(name="dcr")
 * @ORM\Entity
 */
class Dcr
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
     * @var \DateTime
     *
     * @ORM\Column(name="visit_date", type="date", precision=0, scale=0, nullable=false, unique=false)
     */
    private $visitDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_period", type="date", precision=0, scale=0, nullable=false, unique=false)
     */
    private $startPeriod;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_period", type="date", precision=0, scale=0, nullable=false, unique=false)
     */
    private $endPeriod;

    /**
     * @var int
     *
     * @ORM\Column(name="dcr_no", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $dcrNo;

    /**
     * @var int
     *
     * @ORM\Column(name="travel_type", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $travelType;

    /**
     * @var int
     *
     * @ORM\Column(name="call_type", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $callType;

    /**
     * @var int
     *
     * @ORM\Column(name="call_count", type="integer", precision=0, scale=0, nullable=false, options={"default"="1"}, unique=false)
     */
    private $callCount = 1;

    /**
     * @var int
     *
     * @ORM\Column(name="contact_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $contactId;

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
     * @ORM\Column(name="product_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $productId;

    /**
     * @var int
     *
     * @ORM\Column(name="quanitity", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $quanitity;

    /**
     * @var string
     *
     * @ORM\Column(name="order_value", type="decimal", precision=10, scale=2, nullable=false, unique=false)
     */
    private $orderValue;

    /**
     * @var int
     *
     * @ORM\Column(name="sales_stage", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $salesStage;

    /**
     * @var int
     *
     * @ORM\Column(name="next_action", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $nextAction;

    /**
     * @var string
     *
     * @ORM\Column(name="remarks", type="text", length=65535, precision=0, scale=0, nullable=false, unique=false)
     */
    private $remarks;

    /**
     * @var int
     *
     * @ORM\Column(name="Bike_km_reading_start", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $bikeKmReadingStart;

    /**
     * @var int
     *
     * @ORM\Column(name="bike_km_reading_end", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $bikeKmReadingEnd;

    /**
     * @var int
     *
     * @ORM\Column(name="distance_travelled", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $distanceTravelled;

    /**
     * @var string
     *
     * @ORM\Column(name="amount_one", type="decimal", precision=10, scale=2, nullable=false, unique=false)
     */
    private $amountOne;

    /**
     * @var int
     *
     * @ORM\Column(name="travel_mode", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $travelMode;

    /**
     * @var string
     *
     * @ORM\Column(name="amount_two", type="decimal", precision=10, scale=2, nullable=false, unique=false)
     */
    private $amountTwo;

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
     * Set visitDate.
     *
     * @param \DateTime $visitDate
     *
     * @return Dcr
     */
    public function setVisitDate($visitDate)
    {
        $this->visitDate = $visitDate;

        return $this;
    }

    /**
     * Get visitDate.
     *
     * @return \DateTime
     */
    public function getVisitDate()
    {
        return $this->visitDate;
    }

    /**
     * Set startPeriod.
     *
     * @param \DateTime $startPeriod
     *
     * @return Dcr
     */
    public function setStartPeriod($startPeriod)
    {
        $this->startPeriod = $startPeriod;

        return $this;
    }

    /**
     * Get startPeriod.
     *
     * @return \DateTime
     */
    public function getStartPeriod()
    {
        return $this->startPeriod;
    }

    /**
     * Set endPeriod.
     *
     * @param \DateTime $endPeriod
     *
     * @return Dcr
     */
    public function setEndPeriod($endPeriod)
    {
        $this->endPeriod = $endPeriod;

        return $this;
    }

    /**
     * Get endPeriod.
     *
     * @return \DateTime
     */
    public function getEndPeriod()
    {
        return $this->endPeriod;
    }

    /**
     * Set dcrNo.
     *
     * @param int $dcrNo
     *
     * @return Dcr
     */
    public function setDcrNo($dcrNo)
    {
        $this->dcrNo = $dcrNo;

        return $this;
    }

    /**
     * Get dcrNo.
     *
     * @return int
     */
    public function getDcrNo()
    {
        return $this->dcrNo;
    }

    /**
     * Set travelType.
     *
     * @param int $travelType
     *
     * @return Dcr
     */
    public function setTravelType($travelType)
    {
        $this->travelType = $travelType;

        return $this;
    }

    /**
     * Get travelType.
     *
     * @return int
     */
    public function getTravelType()
    {
        return $this->travelType;
    }

    /**
     * Set callType.
     *
     * @param int $callType
     *
     * @return Dcr
     */
    public function setCallType($callType)
    {
        $this->callType = $callType;

        return $this;
    }

    /**
     * Get callType.
     *
     * @return int
     */
    public function getCallType()
    {
        return $this->callType;
    }

    /**
     * Set callCount.
     *
     * @param int $callCount
     *
     * @return Dcr
     */
    public function setCallCount($callCount)
    {
        $this->callCount = $callCount;

        return $this;
    }

    /**
     * Get callCount.
     *
     * @return int
     */
    public function getCallCount()
    {
        return $this->callCount;
    }

    /**
     * Set contactId.
     *
     * @param int $contactId
     *
     * @return Dcr
     */
    public function setContactId($contactId)
    {
        $this->contactId = $contactId;

        return $this;
    }

    /**
     * Get contactId.
     *
     * @return int
     */
    public function getContactId()
    {
        return $this->contactId;
    }

    /**
     * Set productSeries.
     *
     * @param int $productSeries
     *
     * @return Dcr
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
     * @return Dcr
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
     * Set productId.
     *
     * @param int $productId
     *
     * @return Dcr
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;

        return $this;
    }

    /**
     * Get productId.
     *
     * @return int
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * Set quanitity.
     *
     * @param int $quanitity
     *
     * @return Dcr
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
     * Set orderValue.
     *
     * @param string $orderValue
     *
     * @return Dcr
     */
    public function setOrderValue($orderValue)
    {
        $this->orderValue = $orderValue;

        return $this;
    }

    /**
     * Get orderValue.
     *
     * @return string
     */
    public function getOrderValue()
    {
        return $this->orderValue;
    }

    /**
     * Set salesStage.
     *
     * @param int $salesStage
     *
     * @return Dcr
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
     * Set nextAction.
     *
     * @param int $nextAction
     *
     * @return Dcr
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
     * Set remarks.
     *
     * @param string $remarks
     *
     * @return Dcr
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
     * Set bikeKmReadingStart.
     *
     * @param int $bikeKmReadingStart
     *
     * @return Dcr
     */
    public function setBikeKmReadingStart($bikeKmReadingStart)
    {
        $this->bikeKmReadingStart = $bikeKmReadingStart;

        return $this;
    }

    /**
     * Get bikeKmReadingStart.
     *
     * @return int
     */
    public function getBikeKmReadingStart()
    {
        return $this->bikeKmReadingStart;
    }

    /**
     * Set bikeKmReadingEnd.
     *
     * @param int $bikeKmReadingEnd
     *
     * @return Dcr
     */
    public function setBikeKmReadingEnd($bikeKmReadingEnd)
    {
        $this->bikeKmReadingEnd = $bikeKmReadingEnd;

        return $this;
    }

    /**
     * Get bikeKmReadingEnd.
     *
     * @return int
     */
    public function getBikeKmReadingEnd()
    {
        return $this->bikeKmReadingEnd;
    }

    /**
     * Set distanceTravelled.
     *
     * @param int $distanceTravelled
     *
     * @return Dcr
     */
    public function setDistanceTravelled($distanceTravelled)
    {
        $this->distanceTravelled = $distanceTravelled;

        return $this;
    }

    /**
     * Get distanceTravelled.
     *
     * @return int
     */
    public function getDistanceTravelled()
    {
        return $this->distanceTravelled;
    }

    /**
     * Set amountOne.
     *
     * @param string $amountOne
     *
     * @return Dcr
     */
    public function setAmountOne($amountOne)
    {
        $this->amountOne = $amountOne;

        return $this;
    }

    /**
     * Get amountOne.
     *
     * @return string
     */
    public function getAmountOne()
    {
        return $this->amountOne;
    }

    /**
     * Set travelMode.
     *
     * @param int $travelMode
     *
     * @return Dcr
     */
    public function setTravelMode($travelMode)
    {
        $this->travelMode = $travelMode;

        return $this;
    }

    /**
     * Get travelMode.
     *
     * @return int
     */
    public function getTravelMode()
    {
        return $this->travelMode;
    }

    /**
     * Set amountTwo.
     *
     * @param string $amountTwo
     *
     * @return Dcr
     */
    public function setAmountTwo($amountTwo)
    {
        $this->amountTwo = $amountTwo;

        return $this;
    }

    /**
     * Get amountTwo.
     *
     * @return string
     */
    public function getAmountTwo()
    {
        return $this->amountTwo;
    }

    /**
     * Set createdBy.
     *
     * @param int $createdBy
     *
     * @return Dcr
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
     * @return Dcr
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
        return $this->dateCreated->format('Y-m-d H:i:s');
    }
}
