<?php

namespace Application\Controller\Factory;

use Application\Controller\ContactsController;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Logs\Service\LogManager;

/**
 * This is the factory for ContactsController. Its purpose is to instantiate the
 * controller and inject dependencies into it.
 */
class ContactsControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('file_manager');
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $ExtranetUtilities = $container->get(\Application\Service\ExtranetUtilities::class);
        $authService = $container->get(\Laminas\Authentication\AuthenticationService::class);
        $logManager = $container->get(LogManager::class);
        $airkom = $container->get('airkom');

        return new ContactsController($authService, $entityManager, $logManager, $ExtranetUtilities, $airkom);
    }
}
