<?php

namespace Application\Service\Factory;

use Application\Service\NavManager;
use Interop\Container\ContainerInterface;
use User\Service\RbacManager;

/**
 * This is the factory class for NavManager service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class NavManagerFactory
{
    /**
     * This method creates the NavManager service and returns its instance.
     *
     * @param mixed $requestedName
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $authService = $container->get(\Laminas\Authentication\AuthenticationService::class);

        $viewHelperManager = $container->get('ViewHelperManager');
        $urlHelper = $viewHelperManager->get('url');
        $rbacManager = $container->get(RbacManager::class);
        $translator = $container->get('MvcTranslator');

        return new NavManager($authService, $urlHelper, $rbacManager, $translator);
    }
}
