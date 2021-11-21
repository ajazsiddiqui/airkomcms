<?php

namespace Cards\Controller\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Cards\Controller\CardsController;
use Cards\Service\GalleryManager;
/**
 * This is the factory for IndexController. Its purpose is to instantiate the
 * controller and inject dependencies into it.
 */
class CardsControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
		$ExtranetUtilities = $container->get(\Application\Service\ExtranetUtilities::class);
		$GalleryManager = $container->get(GalleryManager::class);
        // Instantiate the controller and inject dependencies
        return new CardsController($entityManager, $ExtranetUtilities, $GalleryManager);
    }
}
