<?php

namespace User\Service\Factory;

use Interop\Container\ContainerInterface;
use User\Service\RbacManager;
use User\Service\RoleManager;

/**
 * This is the factory class for RoleManager service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class RoleManagerFactory
{
    /**
     * This method creates the UserManager service and returns its instance.
     *
     * @param mixed $requestedName
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $rbacManager = $container->get(RbacManager::class);

        return new RoleManager($entityManager, $rbacManager);
    }
}
