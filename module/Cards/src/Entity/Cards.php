<?php

namespace Cards\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cards.
 *
 * @ORM\Table(name="cards")
 * @ORM\Entity
 */
class Cards
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
     * @ORM\Column(name="action", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $action;

    /**
     * @var string
     *
     * @ORM\Column(name="action_name", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $actionName;

    /**
     * @var string
     *
     * @ORM\Column(name="user", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $user;

    /**
     * @var int
     *
     * @ORM\Column(name="property_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $propertyId;

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
     * Set action.
     *
     * @param string $action
     *
     * @return Cards
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action.
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set actionName.
     *
     * @param string $actionName
     *
     * @return Cards
     */
    public function setActionName($actionName)
    {
        $this->actionName = $actionName;

        return $this;
    }

    /**
     * Get actionName.
     *
     * @return string
     */
    public function getActionName()
    {
        return $this->actionName;
    }

    /**
     * Set user.
     *
     * @param string $user
     *
     * @return Cards
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set propertyId.
     *
     * @param string $propertyId
     *
     * @return Cards
     */
    public function setPropertyId($propertyId)
    {
        $this->propertyId = $propertyId;

        return $this;
    }

    /**
     * Get propertyId.
     *
     * @return string
     */
    public function getPropertyId()
    {
        return $this->propertyId;
    }

    /**
     * Set dateCreated.
     *
     * @param \DateTime $dateCreated
     *
     * @return Cards
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
        return $this->dateCreated->format('d-m-Y H:i');
    }
}
