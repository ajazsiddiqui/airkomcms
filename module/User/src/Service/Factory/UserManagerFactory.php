<?php

namespace User\Service\Factory;

use Interop\Container\ContainerInterface;
use User\Service\PermissionManager;
use User\Service\RoleManager;
use User\Service\UserManager;

/**
 * This is the factory class for UserManager service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class UserManagerFactory
{
    /**
     * This method creates the UserManager service and returns its instance.
     *
     * @param mixed $requestedName
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $roleManager = $container->get(RoleManager::class);
        $permissionManager = $container->get(PermissionManager::class);

        return new UserManager($entityManager, $roleManager, $permissionManager);
    }
}
