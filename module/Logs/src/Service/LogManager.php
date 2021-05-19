<?php

namespace Logs\Service;

use Logs\Entity\Logs;

class LogManager
{
    private $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function setlog($action, $action_name, $user, $property = 0)
    {
        $log = new Logs();
        $log->setAction($action);
        $log->setActionName($action_name);
        $log->setUser($user);
        $log->setPropertyId($property);
        $this->entityManager->persist($log);
        $this->entityManager->flush();
    }
}
