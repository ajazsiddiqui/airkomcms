<?php

namespace Application\View\Helper;

use Laminas\View\Helper\AbstractHelper;
use Application\Entity\Contacts;
use User\Entity\User;

class ContactDetail extends AbstractHelper
{
    private $entityManager;

    public function __construct($authService, $entityManager)
    {
        $this->authService = $authService;
        $this->entityManager = $entityManager;
    }

    public function getName($id)
    {
        $user = $this->entityManager->getRepository(Contacts::class)->findOneBy(['id' => $id]);

        return $user->getName();
    }

    public function getCompanyName($id)
    {
        $user = $this->entityManager->getRepository(Contacts::class)->findOneBy(['id' => $id]);

        return $user->getCompany();
    }
    
}
