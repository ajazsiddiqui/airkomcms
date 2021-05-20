<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use User\Entity\User;

class ReportsController extends AbstractActionController
{
    private $authService;
    private $entityManager;
    private $logManager;
    private $ExtranetUtilities;
    private $airkom;
    private $BookingUtilities;

    public function __construct($authService, $entityManager, $logManager, $ExtranetUtilities, $airkom)
    {
        $this->authService = $authService;
        $this->entityManager = $entityManager;
        $this->logManager = $logManager;
        $this->ExtranetUtilities = $ExtranetUtilities;
        $this->airkom = $airkom;
    }
	
    public function indexAction()
    {
		$request = $this->getRequest();

        $post = $request->getPost()->toArray();

		$selectedUser = !empty($post['s_user'])?$post['s_user']:'';
		$selectedDate = !empty($post['s_daterange'])?$post['s_daterange']:'';

        $users = $this->entityManager->getRepository(User::class)
            ->findBy([], ['fullName' => 'ASC']);

        return new ViewModel(['selectedUser'=>$selectedUser,'selectedDate' =>$selectedDate, 'users' => $users]);
    }
}
