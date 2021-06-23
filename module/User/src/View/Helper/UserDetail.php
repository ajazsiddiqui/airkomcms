<?php

namespace User\View\Helper;

use Laminas\View\Helper\AbstractHelper;
use Masters\Entity\SystemUserType;
use Masters\Entity\Branch;
use Properties\Entity\Properties;
use User\Entity\User;

class UserDetail extends AbstractHelper
{
    private $entityManager;

    public function __construct($authService, $entityManager)
    {
        $this->authService = $authService;
        $this->entityManager = $entityManager;
    }

    public function getUserProfilePic()
    {
		
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $this->authService->getIdentity()]);
        return !empty($user) ? $user->getProfilePic() : '';
    }

    public function getIdByEmail($email)
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

        return !empty($user) ? $user->getId() : '';
    }

    public function getFullName()
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $this->authService->getIdentity()]);

        return empty($user) ? '' : $user->getFullName();
    }

    public function getName($id)
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['id' => $id]);

        return $user->getFullName();
    }
	
    public function getBranch($id)
    {
        $branch = $this->entityManager->getRepository(Branch::class)->findOneBy(['id' => $id]);

        return $branch->getName();
    }

    public function getUserPic($id)
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['id' => $id]);

        return !empty($user->getProfilePic()) ? $user->getProfilePic() : 'user.jpg';
    }

    public function getUserType()
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $this->authService->getIdentity()]);

        if (!empty($user)) {
            $usertype = $this->entityManager->getRepository(SystemUserType::class)->findOneBy(['id' => $user->getUserType()]);
        }

        return !empty($usertype) ? $usertype->getName() : 'General';
    }

    public function getUsertypeCount($roleid)
    {
        $user = $this->entityManager->getRepository(User::class)->findBy(['userType' => $roleid]);

        return empty($user) ? 0 : count($user);
    }

    public function getAssignedProperties()
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $this->authService->getIdentity()]);
        $properties = $this->entityManager->getRepository(Properties::class)->findBy(['assignedTo' => $user->getId()]);

        return empty($properties) ? 0 : $properties;
    }
}
