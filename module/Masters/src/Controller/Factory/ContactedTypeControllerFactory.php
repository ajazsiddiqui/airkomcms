<?php

namespace Masters\Controller\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Logs\Service\LogManager;
use Masters\Controller\ContactedTypeController;

class ContactedTypeControllerFactory implements FactoryInterface
{
    /**
     * @param string $requestedName
     *
     * @return AuthAdapter
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('file_manager');
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        $logManager = $container->get(LogManager::class);

        $authenticationService = $container->get(\Laminas\Authentication\AuthenticationService::class);

        return new ContactedTypeController($authenticationService, $entityManager, $logManager);
    }
}
