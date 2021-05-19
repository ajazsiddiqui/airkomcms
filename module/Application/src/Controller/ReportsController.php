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
        $search_array = $this->params()->fromQuery('search', []);
        $search_array = empty($search_array) ? [] : unserialize(base64_decode($search_array));

        $post = $request->getPost()->toArray();
        empty($post) ? $post = $search_array : '';

        if (!empty($post)) {
            $search_array['s_user'] = $post['s_user'];
            $search_array['s_daterange'] = $post['s_daterange'];
        }

        $query = $this->entityManager->createQueryBuilder()->select('U')
            ->from('User\Entity\User', 'U');
			
        if (!empty($search_array['s_user'])) {
            $query->Where('U.id = :s_user')->setParameter('s_user',$post['s_user']);
        }
        if (!empty($search_array['s_role'])) {
            $query->andWhere('U.userType = :s_role')->setParameter('s_role', $post['s_role']);
        }
        $paginator['page'] = $this->params()->fromQuery('page', 1);
        $paginator['count'] = count($query->getQuery()->getScalarResult());
        $paginator['per_page'] = 12;
        $offset = $paginator['page'] * $paginator['per_page'] - $paginator['per_page'];

        $query->setFirstResult($offset)->setMaxResults($paginator['per_page'])->add('orderBy', 'U.id DESC');

        $users = $query->getQuery()->getResult();

        $systemUserTypes = $this->entityManager->getRepository(SystemUserType::class)
            ->findAll();

        return new ViewModel(['users' => $users, 'form' => $form, 'systemUserTypes' => $systemUserTypes, 'paginator' => $paginator, 'search_array' => $search_array]);
    }
}
