<?php

namespace Cards\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Cards\Entity\Cards;
use User\Entity\User;
use Settings\Entity\Settings;
use JeroenDesloovere\VCard\VCard;
use Application\Entity\Contacts;

class CardsController extends AbstractActionController
{
    private $entityManager;
    private $ExtranetUtilities;
    private $GalleryManager;

    public function __construct($entityManager, $ExtranetUtilities, $GalleryManager)
    {
        $this->entityManager = $entityManager;
        $this->ExtranetUtilities = $ExtranetUtilities;
		$this->GalleryManager = $GalleryManager;
    }

    public function indexAction()
    {
        $request = $this->getRequest();

        $post = $request->getPost()->toArray();
		
		$query = $this->entityManager->createQueryBuilder()->select('U')
            ->from('User\Entity\User', 'U');
			
        if (!empty($post['s_user'])) {
            $query->Where('U.fullName like :s_user')->setParameter('s_user', '%'.$post['s_user'].'%');
        }

        $paginator['page'] = $this->params()->fromQuery('page', 1);
        $paginator['count'] = count($query->getQuery()->getScalarResult());
        $paginator['per_page'] = 12;
        $offset = $paginator['page'] * $paginator['per_page'] - $paginator['per_page'];

        $query->setFirstResult($offset)->setMaxResults($paginator['per_page'])->add('orderBy', 'U.id DESC');

        $users = $query->getQuery()->getResult();

        return new ViewModel(['users'=>$users, 'paginator' => $paginator, 'search_array' => $post]);
    }
	
	
	public function viewAction(){
		$this->layout()->setTemplate('layout/blank');
		$id = (int) $this->params()->fromRoute('id', -1);
		if ($id<0) {
            $this->getResponse()->setStatusCode(404);            
            return;
        }
		
        $user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['id' => $id]);
		$settings = $this->entityManager->getRepository(Settings::class)
            ->findOneBy(['id' => 1]);
		$files = $this->GalleryManager->getSavedFiles();

		return new ViewModel(['user'=>$user,'settings'=>$settings,'gallery'=>$files]);
	}
	
	public function vcardAction(){
		
		$this->layout()->setTemplate('layout/blank');
		$id = (int) $this->params()->fromRoute('id', -1);
		
		if ($id<0) {
            $this->getResponse()->setStatusCode(404);            
            return;
        }
		
		$user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['id' => $id]);
		$settings = $this->entityManager->getRepository(Settings::class)
            ->findOneBy(['id' => 1]);	
			
			// define vcard
		$vcard = new VCard();

		// define variables
		$lastname = '';
		$firstname = $user->getFullName();
		$additional = '';
		$prefix = '';
		$suffix = '';

		// add personal data
		$vcard->addName($lastname, $firstname, $additional, $prefix, $suffix);

		$email = !empty($user->getAlternateEmail()) ? $user->getAlternateEmail() : $user->getEmail();
		// add work data
		$vcard->addCompany($settings->getCompanyName());
		$vcard->addJobtitle($user->getDesignation());
		$vcard->addRole('');
		$vcard->addEmail($email);
		$vcard->addPhoneNumber($user->getContactNo(), 'PREF;WORK');
		$vcard->addAddress(null, $settings->getAddress(), 'street', 'worktown', null, 'workpostcode', 'India');
		$vcard->addLabel('street, worktown, workpostcode India');
		$vcard->addURL($settings->getWebsite());

		$vcard->addPhoto('https://airkomgroup.com/logo.png');

		// return vcard as a string
		//return $vcard->getOutput();

		// return vcard as a download
		return $vcard->download();

		// save vcard on disk
		//$vcard->setSavePath('/path/to/directory');
		//$vcard->save();

	}
	
	public function addContactAction(){
		
		$this->layout()->setTemplate('layout/blank');
		
		$id = (int) $this->params()->fromRoute('id', -1);
		
		if ($id<0) {
            $this->getResponse()->setStatusCode(404);            
            return;
        }
		$request = $this->getRequest();
		if ($request->isPost()) {
            $post = $request->getPost()->toArray();
             try {
                    $contact = new Contacts();
					$contact->setName($post['name']);
					$contact->setDesignation($post['designation']);
					$contact->setCompany($post['company']);
					$contact->setTelephone($post['telephone']);
					$contact->setEmail($post['email']);
					$contact->setCreatedBy($id);
                    $this->entityManager->persist($contact);
                    $this->entityManager->flush();
                } catch (Exception $e) {
                    $this->logger->info('Caught exception: ', $e->getMessage(), "\n");
                }

            return $this->redirect()->toRoute('cards', ['action' => 'view','id'=>$id]);
        }else{
			return;
		}

	}
}
