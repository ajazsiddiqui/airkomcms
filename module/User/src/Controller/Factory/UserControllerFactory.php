<?php

namespace User\Controller\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use User\Controller\UserController;
use User\Service\UserManager;

/**
 * This is the factory for UserController. Its purpose is to instantiate the
 * controller and inject dependencies into it.
 */
class UserControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $userManager = $container->get(UserManager::class);

        $config = $container->get('file_manager');
        $dir = $config['upload_dir'];
        $authService = $container->get(\Laminas\Authentication\AuthenticationService::class);
        $ExtranetUtilities = $container->get(\Application\Service\ExtranetUtilities::class);

        // Instantiate the controller and inject dependencies
        return new UserController($dir, $entityManager, $userManager, $authService, $ExtranetUtilities);
    }
}
