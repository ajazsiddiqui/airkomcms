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
	
    public function indexAction()
    {
		$paginator['page'] = $this->params()->fromQuery('page', 1);
        $paginator['count'] = $this->entityManager->getUnitOfWork()->getEntityPersister(Roadmap::class)->count();
        $paginator['per_page'] = 10;
        $offset = $paginator['page'] * $paginator['per_page'] - $paginator['per_page'];

        $form = new RoadmapForm();
        $roadmap = $this->entityManager->getRepository(Roadmap::class)
            ->findBy([], ['id' => 'ASC'], $paginator['per_page'], $offset);

        return new ViewModel(['roadmap' => $roadmap, 'form' => $form, 'paginator' => $paginator]);
    }
	
	public function addAction()
    {
		$form = new RoadmapForm();
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
