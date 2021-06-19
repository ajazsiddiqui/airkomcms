<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pipeline
 *
 * @ORM\Table(name="pipeline")
 * @ORM\Entity
 */
class Pipeline
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
     * @ORM\Column(name="contact", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $contact;

    /**
     * @var int
     *
     * @ORM\Column(name="spt_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $sptId;

    /**
     * @var int
     *
     * @ORM\Column(name="stage", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $stage;

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
     * Set contact.
     *
     * @param int $contact
     *
     * @return Pipeline
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
     * Set sptId.
     *
     * @param string $sptId
     *
     * @return Pipeline
     */
    public function setSptId($sptId)
    {
        $this->sptId = $sptId;

        return $this;
    }

    /**
     * Get sptId.
     *
     * @return int
     */
    public function getSptId()
    {
        return $this->sptId;
    }

    /**
     * Set stage.
     *
     * @param int $stage
     *
     * @return Pipeline
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
     * @return Pipeline
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
