<?php

namespace Masters\View\Helper;

use Laminas\View\Helper\AbstractHelper;
use Application\Entity\Contacts;
use Masters\Entity\LeadSource;
use Masters\Entity\LeadStage;
use Masters\Entity\MarketSegment;
use Masters\Entity\NextAction;
use User\Entity\User;

class MasterDetails extends AbstractHelper
{
    private $entityManager;

    public function __construct($authService, $entityManager)
    {
        $this->authService = $authService;
        $this->entityManager = $entityManager;
    }

    public function getContactName($id)
    {
        $contact = $this->entityManager->getRepository(Contacts::class)->findOneBy(['id' => $id]);

        return empty($contact) ? null : $contact->getName();
    }
	


	public function getLeadSourceName($id)
    {
        $source = $this->entityManager->getRepository(LeadSource::class)->findOneBy(['id' => $id]);

        return empty($source) ? null : $source->getName();
    }

	public function getPropectName($id)
    {
        $contact = $this->entityManager->getRepository(Contacts::class)->findOneBy(['id' => $id]);

        return empty($contact) ? null : $contact->getCompany();
    }
	
	public function getLeadStageName($id)
    {
        $stage = $this->entityManager->getRepository(LeadStage::class)->findOneBy(['id' => $id]);

        return empty($stage) ? null : $stage->getName();
    }
	
	public function getExecutiveName($id)
    {
        $executive = $this->entityManager->getRepository(User::class)->findOneBy(['id' => $id]);

        return empty($executive) ? null : $executive->getFullName();
    }

	public function getMarketSegmentName($id)
    {
        $segment = $this->entityManager->getRepository(MarketSegment::class)->findOneBy(['id' => $id]);

        return empty($segment) ? null : $segment->getName();
    }
	public function getNextActionName($id)
    {
        $action = $this->entityManager->getRepository(NextAction::class)->findOneBy(['id' => $id]);

        return empty($action) ? null : $action->getName();
    }
   
}
