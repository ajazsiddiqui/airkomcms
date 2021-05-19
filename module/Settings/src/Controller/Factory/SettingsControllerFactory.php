<?php

namespace Settings\Controller\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Logs\Service\LogManager;
use Settings\Controller\SettingsController;

class SettingsControllerFactory implements FactoryInterface
{
    /**
     * @param string $requestedName
     *
     * @return AuthAdapter
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('file_manager');
        $dir = $config['upload_dir'];
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        $logManager = $container->get(LogManager::class);

        $authenticationService = $container->get(\Laminas\Authentication\AuthenticationService::class);

        return new SettingsController($dir, $authenticationService, $entityManager, $logManager);
    }
}
