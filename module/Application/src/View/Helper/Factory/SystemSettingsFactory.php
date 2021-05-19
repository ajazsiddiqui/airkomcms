<?php

namespace Application\View\Helper\Factory;

use Application\View\Helper\SystemSettings;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * This is the factory for Menu view helper. Its purpose is to instantiate the
 * helper and init menu items.
 */
class SystemSettingsFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $authenticationService = $container->get(\Laminas\Authentication\AuthenticationService::class);

        return new SystemSettings($authenticationService, $entityManager);
    }
}
