<?php

namespace Settings\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Targets
 *
 * @ORM\Table(name="targets")
 * @ORM\Entity
 */
class Targets
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
     * @ORM\Column(name="call_type", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $callType;

    /**
     * @var decimal
     *
     * @ORM\Column(name="target", type="decimal", precision=10, scale=0, nullable=false, unique=false)
     */
    private $target;

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
     * Set userId.
     *
     * @param int $userId
     *
     * @return Targets
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
     * Set callType.
     *
     * @param int $callType
     *
     * @return Targets
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
     * Set target.
     *
     * @param string $target
     *
     * @return Targets
     */
    public function setTarget($target)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * Get target.
     *
     * @return string
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Set createdBy.
     *
     * @param int $createdBy
     *
     * @return Targets
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
     * @return Targets
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
