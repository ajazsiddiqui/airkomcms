<?php

namespace Application\Service\Factory;

use Application\Service\ExtranetUtilities;
use Interop\Container\ContainerInterface;

class ExtranetUtilitiesFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        return new ExtranetUtilities($entityManager);
    }
}
