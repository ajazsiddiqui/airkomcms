<?php

namespace User\View\Helper\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use User\View\Helper\UserDetail;

/**
 * This is the factory for Access view helper. Its purpose is to instantiate the helper
 * and inject dependencies into its constructor.
 */
class UserDetailFactory implements FactoryInterface
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

        return new UserDetail($authenticationService, $entityManager);
    }
}
