<?php

namespace Logs\Controller\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Logs\Controller\LogsController;

/**
 * This is the factory for IndexController. Its purpose is to instantiate the
 * controller and inject dependencies into it.
 */
class LogsControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
		$ExtranetUtilities = $container->get(\Application\Service\ExtranetUtilities::class);
        // Instantiate the controller and inject dependencies
        return new LogsController($entityManager, $ExtranetUtilities);
    }
}
