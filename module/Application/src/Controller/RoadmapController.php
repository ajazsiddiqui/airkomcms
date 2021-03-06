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
use Application\Form\RoadmapForm;
use Application\Entity\Roadmap;
use Application\Entity\Contacts;
use User\Entity\User;
use Settings\Entity\Settings;
use Laminas\View\Model\JsonModel;

class RoadmapController extends AbstractActionController
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
	
   public function cors()
    {
        // Allow from any origin
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
            header('Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept');
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');    // cache for 1 day
        }
        // Access-Control headers are received during OPTIONS requests
        if ('OPTIONS' == $_SERVER['REQUEST_METHOD']) {
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
                // may also be using PUT, PATCH, HEAD etc
                header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
            }
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
                header('Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept');
            }

            exit(0);
        }
    }
	
	public function getCityAction()
    {
		$id = $this->params()->fromQuery('contactid', 0);
        $this->cors();
		$contact = $this->entityManager->getRepository(Contacts::class)
            ->findOneBY(['id'=>$id]);
			
		if(empty($contact)){
			return new JsonModel([]);
		}
        $array = ['name'=>$contact->getCity()];

        return new JsonModel($array);
    }

	public function indexAction()
    {
        $post = $this->getRequest()->getPost()->toArray();
		$form = new RoadmapForm();
        
		$user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['email' => $this->authService->getIdentity()]);
			
		$query = $this->entityManager->createQueryBuilder()->select('R')
				->from('Application\Entity\Roadmap', 'R')
				->join('Application\Entity\Contacts', 'C', 'WITH', 'C.id = R.prospectName');
		
		if($user->getUserType() != 1){
			$query->AndWhere('R.createdBy = :createdBy')
				->setParameter('createdBy', $user->getId());
		}
		
		if (!empty($post['s_prospect'])) {
			
			$query->AndWhere('C.company like :prospect')
				->setParameter('prospect',  '%'.$post['s_prospect'].'%');
		}
		
		$paginator['page'] = $this->params()->fromQuery('page', 1);
        $paginator['count'] = count($query->getQuery()->getScalarResult());
        $paginator['per_page'] = 10;
        $offset = $paginator['page'] * $paginator['per_page'] - $paginator['per_page'];

        $query->setFirstResult($offset)->setMaxResults($paginator['per_page'])->add('orderBy', 'R.id DESC');

        $roadmap = $query->getQuery()->getResult();	

        return new ViewModel(['roadmap' => $roadmap, 'form' => $form, 'paginator' => $paginator]);
    }
	
	public function addAction()
    {
		$form = new RoadmapForm();
		$form->get('prospect_name')->setValueOptions($this->ExtranetUtilities->getContactsList());
		$form->get('market_segment')->setValueOptions($this->ExtranetUtilities->getMarketSegmentList());
		$form->get('product_series')->setValueOptions($this->ExtranetUtilities->getProductSeriesList());
		$form->get('product_model')->setValueOptions($this->ExtranetUtilities->getProductModelsList());
		$form->get('product')->setValueOptions($this->ExtranetUtilities->getProductsList());
		$form->get('next_action')->setValueOptions($this->ExtranetUtilities->getNextActionList());
		
		
		
        $request = $this->getRequest();
        $user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['email' => $this->authService->getIdentity()], ['id' => 'ASC']);

        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            $form->setData($post);
            if ($form->isValid()) {
                $data = $form->getData();

                try {
                    $roadmap = new Roadmap();
					$roadmap->setWeek($data['week']);
					$roadmap->setMarketSegment($data['market_segment']);
					$roadmap->setProspectName($data['prospect_name']);
					$roadmap->setProspectCity($data['prospect_city']);
					$roadmap->setPropspectMachine($data['propspect_machine']);
					$roadmap->setProductSeries($data['product_series']);
					$roadmap->setProductModel($data['product_model']);
					$roadmap->setProduct($data['product']);
					$roadmap->setNextAction($data['next_action']);
					$roadmap->setExpectedQuanitity($data['expected_quanitity']);
					$roadmap->setExpectedPotentialOrderValue($data['expected_potential_order_value']);
					$roadmap->setCreatedBy($user->getId());
                    $this->entityManager->persist($roadmap);
                    $this->entityManager->flush();
                } catch (Exception $e) {
                    $this->logger->info('Caught exception: ', $e->getMessage(), "\n");
                }

                $log = $this->logManager;
                $log->setlog('Roadmap Added', $data['prospect_name'], $this->authService->getIdentity());
            } else {
                $this->logger->info('form validator: ', $form->getMessages(), "\n");
            }
            $this->flashMessenger()->addSuccessMessage('Roadmap Added '.$data['prospect_name']);

            return $this->redirect()->toRoute('roadmap');
        }

        return new ViewModel(['form' => $form]);
    }
	
	public function editAction()
    {
		$user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['email' => $this->authService->getIdentity()], ['id' => 'ASC']);

        $id = (int) $this->params()->fromRoute('id', -1);
        if ($id < 1) {
            $this->getResponse()->setStatusCode(404);

            return;
        }

        $roadmap = $this->entityManager->getRepository(Roadmap::class)
            ->find($id);

        if (null == $roadmap) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $form = new RoadmapForm();
		$form->get('prospect_name')->setValueOptions($this->ExtranetUtilities->getContactsList());
		$form->get('market_segment')->setValueOptions($this->ExtranetUtilities->getMarketSegmentList());
		$form->get('product_series')->setValueOptions($this->ExtranetUtilities->getProductSeriesList());
		$form->get('product_model')->setValueOptions($this->ExtranetUtilities->getProductModelsList());
		$form->get('product')->setValueOptions($this->ExtranetUtilities->getProductsList());
		$form->get('next_action')->setValueOptions($this->ExtranetUtilities->getNextActionList());
		
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();

                try {
					$roadmap->setWeek($data['week']);
					$roadmap->setMarketSegment($data['market_segment']);
					$roadmap->setProspectName($data['prospect_name']);
					$roadmap->setProspectCity($data['prospect_city']);
					$roadmap->setPropspectMachine($data['propspect_machine']);
					$roadmap->setProductSeries($data['product_series']);
					$roadmap->setProductModel($data['product_model']);
					$roadmap->setProduct($data['product']);
					$roadmap->setNextAction($data['next_action']);
					$roadmap->setExpectedQuanitity($data['expected_quanitity']);
					$roadmap->setExpectedPotentialOrderValue($data['expected_potential_order_value']);
					$roadmap->setCreatedBy($user->getId());
                    $this->entityManager->persist($roadmap);
                    $this->entityManager->flush();
                } catch (Exception $e) {
                    $this->logger->info('Caught exception: ', $e->getMessage(), "\n");
                }

                $log = $this->logManager;
                $log->setlog('Roadmap Edited', $data['prospect_name'], $this->authService->getIdentity());

                $this->flashMessenger()->addSuccessMessage('Roadmap Edited '.$data['prospect_name']);

                return $this->redirect()->toRoute('roadmap');
            }
            $this->logger->info('form validator: ', $form->getMessages(), "\n");
        } else {
            $form->setData(
                [
				'week' => $roadmap->getWeek(),
				'market_segment' => $roadmap->getMarketSegment(),
				'prospect_name' => $roadmap->getProspectName(),
				'prospect_city' => $roadmap->getProspectCity(),
				'propspect_machine' => $roadmap->getPropspectMachine(),
				'product_series' => $roadmap->getProductSeries(),
				'product_model' => $roadmap->getProductModel(),
				'product' => $roadmap->getProduct(),
				'next_action' => $roadmap->getNextAction(),
				'expected_quanitity' => $roadmap->getExpectedQuanitity(),
				'expected_potential_order_value' => $roadmap->getExpectedPotentialOrderValue(),

                ]
            );
        }
		
        return new ViewModel(['form' => $form]);

    }
	
	public function deleteAction()
    {
		$id = (int) $this->params()->fromRoute('id', -1);
        $roadmap = $this->entityManager->getRepository(Roadmap::class)
            ->find($id);
        $Roadmapid = $roadmap->getProspectName();
        $this->entityManager->remove($roadmap);
        $this->entityManager->flush();

        $log = $this->logManager;
        $log->setlog('Roadmap Deleted', $Roadmapid, $this->authService->getIdentity());

        $this->flashMessenger()->addSuccessMessage('Roadmap deleted '.$Roadmapid);

        return $this->redirect()->toRoute('roadmap');
       
    }
}
