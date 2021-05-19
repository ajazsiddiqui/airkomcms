<?php

namespace Application\Service\Factory;

use Application\Service\RbacAssertionManager;
use Interop\Container\ContainerInterface;

/**
 * This is the factory class for RbacAssertionManager service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class RbacAssertionManagerFactory
{
    /**
     * This method creates the NavManager service and returns its instance.
     *
     * @param mixed $requestedName
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $authService = $container->get(\Laminas\Authentication\AuthenticationService::class);

        return new RbacAssertionManager($entityManager, $authService);
    }
}
