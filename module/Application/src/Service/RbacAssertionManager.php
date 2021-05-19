<?php

namespace Application\Service;

use Laminas\Permissions\Rbac\Rbac;
use User\Entity\User;

/**
 * This service is used for invoking user-defined RBAC dynamic assertions.
 */
class RbacAssertionManager
{
    /**
     * Entity manager.
     *
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Auth service.
     *
     * @var Laminas\Authentication\AuthenticationService
     */
    private $authService;

    /**
     * Constructs the service.
     *
     * @param mixed $entityManager
     * @param mixed $authService
     */
    public function __construct($entityManager, $authService)
    {
        $this->entityManager = $entityManager;
        $this->authService = $authService;
    }

    /**
     * This method is used for dynamic assertions.
     *
     * @param mixed $permission
     * @param mixed $params
     */
    public function assert(Rbac $rbac, $permission, $params)
    {
        $currentUser = $this->entityManager->getRepository(User::class)
            ->findOneByEmail($this->authService->getIdentity())
        ;

        if ('profile.own.view' == $permission && $params['user']->getId() == $currentUser->getId()) {
            return true;
        }

        return false;
    }
}
