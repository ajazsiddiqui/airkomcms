<?php

namespace User\Service\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use User\Service\AuthAdapter;

/**
 * This is the factory class for AuthAdapter service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class AuthAdapterFactory implements FactoryInterface
{
    /**
     * This method creates the AuthAdapter service and returns its instance.
     *
     * @param mixed $requestedName
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        // Get Doctrine entity manager from Service Manager.
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        // Create the AuthAdapter and inject dependency to its constructor.
        return new AuthAdapter($entityManager);
    }
}
