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
use Application\Form\ContactForm;
use Application\Entity\Contacts;
use User\Entity\User;

class ContactsController extends AbstractActionController
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
		

        $form = new ContactForm();
        
			
		$user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['email' => $this->authService->getIdentity()]);
		
		$paginator['page'] = $this->params()->fromQuery('page', 1);
		$paginator['per_page'] = 10;
		
		if($user->getUserType() == 1){
				
			$paginator['count'] = $this->entityManager->getUnitOfWork()->getEntityPersister(Contacts::class)->count();
			$offset = $paginator['page'] * $paginator['per_page'] - $paginator['per_page'];
			$contacts = $this->entityManager->getRepository(Contacts::class)
            ->findBy([], ['id' => 'ASC'], $paginator['per_page'], $offset);
		}else{		
			
			$contacts = $this->entityManager->getRepository(Contacts::class)
            ->findBy(['createdBy'=>$user->getId()]);
			
			$paginator['count'] = count($contacts);
			$offset = $paginator['page'] * $paginator['per_page'] - $paginator['per_page'];
		}
		
        return new ViewModel(['contacts' => $contacts, 'form' => $form, 'paginator' => $paginator]);
       
    }

	
	public function addAction()
    {
	   $form = new ContactForm();
        $request = $this->getRequest();
        $user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['email' => $this->authService->getIdentity()], ['id' => 'ASC']);

        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            $form->setData($post);
            if ($form->isValid()) {
                $data = $form->getData();

                try {
                    $contact = new Contacts();
					$contact->setName($data['name']);
					$contact->setDesignation($data['designation']);
					$contact->setCompany($data['company']);
					$contact->setCity($data['city']);
					$contact->setAddress($data['address']);
					$contact->setTelephone($data['telephone']);
					$contact->setEmail($data['email']);
					$contact->setWebsite($data['website']);
					$contact->setCreatedBy($user->getId());
                    $this->entityManager->persist($contact);
                    $this->entityManager->flush();
                } catch (Exception $e) {
                    $this->logger->info('Caught exception: ', $e->getMessage(), "\n");
                }

                $log = $this->logManager;
                $log->setlog('Contact Added', $data['name'], $this->authService->getIdentity());
            } else {
                $this->logger->info('form validator: ', $form->getMessages(), "\n");
            }
            $this->flashMessenger()->addSuccessMessage('Contact Added '.$data['name']);

            return $this->redirect()->toRoute('contacts', ['action' => 'index']);
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

        $contact = $this->entityManager->getRepository(Contacts::class)
            ->find($id);

        if (null == $contact) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $form = new ContactForm();

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();

                try {
					$contact->setName($data['name']);
					$contact->setDesignation($data['designation']);
					$contact->setCompany($data['company']);
					$contact->setCity($data['city']);
					$contact->setAddress($data['address']);
					$contact->setTelephone($data['telephone']);
					$contact->setEmail($data['email']);
					$contact->setWebsite($data['website']);
                    $contact->setCreatedBy($user->getId());
                    $this->entityManager->persist($contact);
                    $this->entityManager->flush();
                } catch (Exception $e) {
                    $this->logger->info('Caught exception: ', $e->getMessage(), "\n");
                }

                $log = $this->logManager;
                $log->setlog('Contact Edited', $data['name'], $this->authService->getIdentity());

                $this->flashMessenger()->addSuccessMessage('Contact Edited '.$data['name']);

                return $this->redirect()->toRoute('contacts', ['action' => 'index']);
            }
            $this->logger->info('form validator: ', $form->getMessages(), "\n");
        } else {
            $form->setData(
                [
				'name' => $contact->getName(),
				'designation' => $contact->getDesignation(),
				'company' => $contact->getCompany(),
				'city' => $contact->getCity(),
				'address' => $contact->getAddress(),
				'telephone' => $contact->getTelephone(),
				'email' => $contact->getEmail(),
				'website' => $contact->getWebsite(),
                ]
            );
        }

        return new ViewModel(['form' => $form]);
    }
	
	public function deleteAction()
    {
		$id = (int) $this->params()->fromRoute('id', -1);
        $contact = $this->entityManager->getRepository(Contacts::class)
            ->find($id);
        $contact_name = $contact->getName();
        $this->entityManager->remove($contact);
        $this->entityManager->flush();

        $log = $this->logManager;
        $log->setlog('Contact Deleted', $contact_name, $this->authService->getIdentity());

        $this->flashMessenger()->addSuccessMessage('Contact deleted '.$contact_name);

        return $this->redirect()->toRoute('contacts');
       
    }
}
