<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Roadmap
 *
 * @ORM\Table(name="roadmap")
 * @ORM\Entity
 */
class Roadmap
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
     * @ORM\Column(name="week", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $week;

    /**
     * @var int
     *
     * @ORM\Column(name="market_segment", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $marketSegment;

    /**
     * @var string
     *
     * @ORM\Column(name="prospect_name", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $prospectName;

    /**
     * @var string
     *
     * @ORM\Column(name="prospect_city", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $prospectCity;

    /**
     * @var string
     *
     * @ORM\Column(name="propspect_machine", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $propspectMachine;

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
     * @ORM\Column(name="product", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $product;

    /**
     * @var int
     *
     * @ORM\Column(name="next_action", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $nextAction;

    /**
     * @var int
     *
     * @ORM\Column(name="expected_quanitity", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $expectedQuanitity;

    /**
     * @var int
     *
     * @ORM\Column(name="expected_potential_order_value", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $expectedPotentialOrderValue;

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
     * Set week.
     *
     * @param string $week
     *
     * @return Roadmap
     */
    public function setWeek($week)
    {
        $this->week = $week;

        return $this;
    }

    /**
     * Get week.
     *
     * @return string
     */
    public function getWeek()
    {
        return $this->week;
    }

    /**
     * Set marketSegment.
     *
     * @param int $marketSegment
     *
     * @return Roadmap
     */
    public function setMarketSegment($marketSegment)
    {
        $this->marketSegment = $marketSegment;

        return $this;
    }

    /**
     * Get marketSegment.
     *
     * @return int
     */
    public function getMarketSegment()
    {
        return $this->marketSegment;
    }

    /**
     * Set prospectName.
     *
     * @param string $prospectName
     *
     * @return Roadmap
     */
    public function setProspectName($prospectName)
    {
        $this->prospectName = $prospectName;

        return $this;
    }

    /**
     * Get prospectName.
     *
     * @return string
     */
    public function getProspectName()
    {
        return $this->prospectName;
    }

    /**
     * Set prospectCity.
     *
     * @param string $prospectCity
     *
     * @return Roadmap
     */
    public function setProspectCity($prospectCity)
    {
        $this->prospectCity = $prospectCity;

        return $this;
    }

    /**
     * Get prospectCity.
     *
     * @return string
     */
    public function getProspectCity()
    {
        return $this->prospectCity;
    }

    /**
     * Set propspectMachine.
     *
     * @param string $propspectMachine
     *
     * @return Roadmap
     */
    public function setPropspectMachine($propspectMachine)
    {
        $this->propspectMachine = $propspectMachine;

        return $this;
    }

    /**
     * Get propspectMachine.
     *
     * @return string
     */
    public function getPropspectMachine()
    {
        return $this->propspectMachine;
    }

    /**
     * Set productSeries.
     *
     * @param int $productSeries
     *
     * @return Roadmap
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
     * @return Roadmap
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
     * Set product.
     *
     * @param int $product
     *
     * @return Roadmap
     */
    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product.
     *
     * @return int
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set nextAction.
     *
     * @param int $nextAction
     *
     * @return Roadmap
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
     * Set expectedQuanitity.
     *
     * @param int $expectedQuanitity
     *
     * @return Roadmap
     */
    public function setExpectedQuanitity($expectedQuanitity)
    {
        $this->expectedQuanitity = $expectedQuanitity;

        return $this;
    }

    /**
     * Get expectedQuanitity.
     *
     * @return int
     */
    public function getExpectedQuanitity()
    {
        return $this->expectedQuanitity;
    }

    /**
     * Set expectedPotentialOrderValue.
     *
     * @param int $expectedPotentialOrderValue
     *
     * @return Roadmap
     */
    public function setExpectedPotentialOrderValue($expectedPotentialOrderValue)
    {
        $this->expectedPotentialOrderValue = $expectedPotentialOrderValue;

        return $this;
    }

    /**
     * Get expectedPotentialOrderValue.
     *
     * @return int
     */
    public function getExpectedPotentialOrderValue()
    {
        return $this->expectedPotentialOrderValue;
    }

    /**
     * Set createdBy.
     *
     * @param int $createdBy
     *
     * @return Roadmap
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
     * @return Roadmap
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
