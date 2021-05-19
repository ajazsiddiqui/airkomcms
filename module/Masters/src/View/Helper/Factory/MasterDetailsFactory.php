<?php

namespace Masters\View\Helper\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Masters\View\Helper\MasterDetails;

/**
 * This is the factory for Access view helper. Its purpose is to instantiate the helper
 * and inject dependencies into its constructor.
 */
class MasterDetailsFactory implements FactoryInterface
{
    /**
     * @param string $requestedName
     *
     * @return AuthAdapter
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        $authenticationService = $container->get(\Laminas\Authentication\AuthenticationService::class);

        return new MasterDetails($authenticationService, $entityManager);
    }
}
