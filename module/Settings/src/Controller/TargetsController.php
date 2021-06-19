<?php

namespace Settings\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Settings\Entity\Targets;
use User\Entity\User;
use Masters\Entity\CallType;

class TargetsController extends AbstractActionController
{
    private $_dir;
    private $authService;
    private $entityManager;
    private $logManager;

    public function __construct($dir, $authService, $entityManager, $logManager)
    {
        $this->_dir = $dir;
        $this->authService = $authService;
        $this->entityManager = $entityManager;
        $this->logManager = $logManager;
    }

    public function init()
    {
        if ($user = $this->identity()) {
        } else {
            return $this->redirect()->toRoute('login');
        }
    }

    public function indexAction()
    {
        $users = $this->entityManager->getRepository(User::class)
            ->findBy([], ['fullName' => 'ASC']);

		$user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['email' => $this->authService->getIdentity()]);
			
		$calltypes = $this->entityManager->getRepository(CallType::class)
            ->findAll();
			
        $post = $this->getRequest()->getPost()->toArray();
		
		$currentuser = [];
		$targets = [];
		
		$id = (int) $this->params()->fromRoute('id', -1);
		
        if ($id > 0) {
            $currentuser = $this->entityManager->getRepository(User::class)
					->findOneBy(['id'=>$id]);
        }
		
		if($post){
			if (!empty($post['s_user'])) {
				$currentuser = $this->entityManager->getRepository(User::class)
					->findOneBy(['id'=>$post['s_user']]);
			}
			
			if(!empty($post['target_user'])){
				$oldtarget = $this->entityManager->getRepository(Targets::class)
					 ->findBy(['userId'=>$post['target_user']]);
				
				if(!empty($oldtarget)){
					foreach ($oldtarget as $ot){
						$this->entityManager->remove($ot);
						$this->entityManager->flush();
					}
				}
				

				foreach ($post as $k => $v){
					$target = new Targets();
					$target->setUserId($post['target_user']);
					$target->setCallType($k);
					$target->setTarget($v);
					$target->setCreatedBy($user->getId());
                    $this->entityManager->persist($target);
                    $this->entityManager->flush();
				}
				
				$this->flashMessenger()->addSuccessMessage('Targets Updated');
				return $this->redirect()->toRoute('targets', ['id' =>$post['target_user']]);
			}
		}
		
		if(!empty($currentuser)){
			$query = $this->entityManager->createQueryBuilder()->select('T')
					->from('Settings\Entity\Targets', 'T');
			$query->Where('T.userId = :s_user')
					->setParameter('s_user',$currentuser->getId());
			$targets = $query->getQuery()->getArrayResult();
		}

         return new ViewModel(['users' => $users, 'currentuser' => $currentuser, 'calltypes' => $calltypes, 'targets' => $targets]);
    }
}


function insertdata(){
	$users = $this->entityManager->getRepository(User::class)
            ->findBy([], ['fullName' => 'ASC']);
			
		$array = [
		1=>10,
		2=>2,
		3=>1,
		4=>1,
		5=>1,
		6=>1,
		97=>100,
		98=>100,
		99=>6000000,
		100=>2000000
		];
		
		foreach ($users as $u){
			foreach ($array as $k => $v){
				$target = new Targets();
				$target->setUserId($u->getId());
				$target->setCallType($k);
				$target->setTarget($v);
				$target->setCreatedBy(1);
				$this->entityManager->persist($target);
				$this->entityManager->flush();
			}
		}
}