<?php

namespace Logs\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Logs\Entity\Logs;
use User\Entity\User;

class LogsController extends AbstractActionController
{
    private $entityManager;
    private $ExtranetUtilities;

    public function __construct($entityManager, $ExtranetUtilities)
    {
        $this->entityManager = $entityManager;
        $this->ExtranetUtilities = $ExtranetUtilities;
    }

    public function indexAction()
    {
        $request = $this->getRequest();

        $search_array = $this->params()->fromQuery('search', []);
        $search_array = empty($search_array) ? [] : unserialize(base64_decode($search_array));

        $post = $request->getPost()->toArray();
        empty($post) ? $post = $search_array : '';

        if ($request->isPost()) {
            (empty($post['s_user']) ? '' : $search_array['user'] = $post['s_user']);
            (empty($post['s_action']) ? '' : $search_array['action'] = $post['s_action']);
            (empty($post['date_range']) ? '' : $search_array['date_range'] = $post['date_range']);
        }

        $query = $this->entityManager->createQueryBuilder()->select('L')
            ->from('Logs\Entity\Logs', 'L');

        if (!empty($search_array['user'])) {
            $query->where('L.user = :user')
                ->setParameter('user', $search_array['user']);
        }

        if (!empty($search_array['action'])) {
            $query->andWhere('L.action = :action')
                ->setParameter('action', $search_array['action']);
        }

        if (!empty($search_array['date_range'])) {
            $dates = explode(' - ', $search_array['date_range']);
			
            $startdate = $this->ExtranetUtilities->makeDBDate($dates[0]);
            $enddate = $this->ExtranetUtilities->makeDBDate($dates[1]);

            $query->AndWhere('L.dateCreated >= :startdate')
                ->setParameter('startdate', $startdate);
            $query->AndWhere('L.dateCreated <= :enddate')
                ->setParameter('enddate', $enddate);
        }

        $query->add('orderBy', 'L.id DESC');

        // $page = $this->params()->fromQuery('page', 1);
        // $adapter = new DoctrineAdapter(new ORMPaginator($query, false));
        // $paginator = new Paginator($adapter);
        // $paginator->setDefaultItemCountPerPage(10);
        // $paginator->setCurrentPageNumber($page);

        $paginator['page'] = $this->params()->fromQuery('page', 1);
        $paginator['count'] = count($query->getQuery()->getScalarResult());
        $paginator['per_page'] = 10;
        $offset = $paginator['page'] * $paginator['per_page'] - $paginator['per_page'];

        $query->setFirstResult($offset)->setMaxResults($paginator['per_page'])->add('orderBy', 'L.id DESC');

        $logs = $query->getQuery()->getResult();

        $users = $this->entityManager->getRepository(Logs::class)
            ->findAll()
        ;
        $userids = [];
        $actions = [];

        foreach ($users as $user) {
            $userids[] = $user->getUser();
            $actions[] = $user->getAction();
        }
        $userids = array_unique($userids);
        $actions = array_unique($actions);

        $users = $this->entityManager->getRepository(User::class)->findBy(['email' => $userids]);

        return new ViewModel(['logs' => $logs, 'paginator' => $paginator, 'users' => $users, 'actions' => $actions, 'search_array' => $search_array]);
    }
}
