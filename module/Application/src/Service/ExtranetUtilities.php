<?php
namespace Application\Service;
use Laminas\Crypt\Password\Bcrypt;
use Masters\Entity\SystemUserType;
use Masters\Entity\TravelType;
use Masters\Entity\CallType;
use Masters\Entity\ProductModels;
use Masters\Entity\ProductSeries;
use Masters\Entity\Products;
use Masters\Entity\SalesStage;
use Masters\Entity\TravelMode;
use Masters\Entity\NextAction;
use Masters\Entity\Branch;
use Masters\Entity\LeadStage;
use Masters\Entity\LeadSource;
use Masters\Entity\MarketSegment;
use Masters\Entity\Probability;
use Masters\Entity\ContactedType;
use Application\Entity\Contacts;
use Settings\Entity\Targets;
use User\Entity\User;
class ExtranetUtilities
{
    private $entityManager;
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function userConfirm($email, $password)
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email, 'status' => 1]);
        if (empty($user)) {
            return false;
        }
        $passwordHash = $user->getPassword();
        $bcrypt = new Bcrypt();
        if ($bcrypt->verify($password, $passwordHash)) {
            return true;
        }
        return false;
    }
	
	public function getSPTs($current_user, $user = 0,$dates = 0, $daterange = false){

		$month = 0;
		
		if($daterange){
			$date = explode(" - ", $dates);
			

			$startdate = $this->makeDBDate($date[0]);
			$enddate = $this->makeDBDate($date[1]);
			
			$dateprefix = 'AND date_created <= "'.$enddate.'"';
			$dateprefix2 = 'WHERE date_created <= "'.$enddate.'"';
			$dateprefix3 = 'AND date_modified >= "'.$startdate.'" AND date_modified <=  "'.$enddate.'  23:59:00"';
		}else{
			if(isset($dates) && $dates != 0){
				$dates = explode("-",$dates);
				$month = $dates[1];
				$year = $dates[0];
			}
			
			$dateprefix = ($month != 0)?'AND MONTH(`date_created`) <= '.$month.' AND YEAR(`date_created`) <= '.$year:'';
			$dateprefix2 = ($month != 0)?'WHERE MONTH(`date_created`) <= '.$month.' AND YEAR(`date_created`) <= '.$year:'';
			$dateprefix3 = ($month != 0)?'AND MONTH(`date_modified`) = '.$month.' AND YEAR(`date_modified`) = '.$year:'';
		}
		
		
		$userprefix = $user !=0 ? "AND created_by = ".$user :($current_user->getUserType() == 1 ? '' : "AND created_by = ".$current_user->getId());
		$userprefix2 = $user !=0 ? "AND created_by = ".$user :($current_user->getUserType() == 1 ? '' : "AND created_by = ".$current_user->getId());
		
		//Early
		$early = "SELECT * from spt WHERE stage = 1 ".$dateprefix." ".$userprefix;
		$e = $this->entityManager->getConnection()->prepare($early);
		$e->execute();
		$earlyLeads =  $e->fetchAll();
		$array['Early'] = $earlyLeads;
		
		//Active
		$active = "select * from spt where id in (select spt_id from pipeline ".$dateprefix2." group by spt_id having max(stage) = 2) ".$userprefix2;
		$a = $this->entityManager->getConnection()->prepare($active);
		$a->execute();
		$activeLeads =  $a->fetchAll();
		$array['Active'] = $activeLeads;
		
		//close
		$close = "select * from spt where stage = 3 ".$dateprefix3." ".$userprefix;
		$c = $this->entityManager->getConnection()->prepare($close);
		$c->execute();
		$closeLeads =  $c->fetchAll();
		$array['Close'] = $closeLeads;
		

		
		//offline
		$offline = "select * from spt where stage = 4 ".$dateprefix3." ".$userprefix;		
		$o = $this->entityManager->getConnection()->prepare($offline);
		$o->execute();
		$offlineLeads =  $o->fetchAll();
		$array['Offline'] = $offlineLeads;
		
		//lead
		$lead = "select * from spt where stage = 5 ".$dateprefix3." ".$userprefix;
		$l = $this->entityManager->getConnection()->prepare($lead);
		$l->execute();
		$lead =  $l->fetchAll();
		$array['Lead'] = $lead;
		
		return $array;
		
	}
	
	 public function getTargetByUser($userid, $callType)
    {
        $target = $this->entityManager->getRepository(Targets::class)->findOneBy(['userId' => $userid,'callType' => $callType]);

        return empty($target) ? 1 : $target->getTarget();
    }
	
    public function changePassword($user, $password)
    {
        // Set new password for user
        $bcrypt = new Bcrypt();
        $passwordHash = $bcrypt->create($password);
        $user->setPassword($passwordHash);
        $this->entityManager->flush();
        return true;
    }
    public function getUserProfilePic($id)
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['id' => $id]);
        return !empty($user) ? $user->getProfilePic() : 'user.png';
    }
    public function get_client_ip()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP')) {
            $ipaddress = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_X_FORWARDED')) {
            $ipaddress = getenv('HTTP_X_FORWARDED');
        } elseif (getenv('HTTP_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        } elseif (getenv('HTTP_FORWARDED')) {
            $ipaddress = getenv('HTTP_FORWARDED');
        } elseif (getenv('REMOTE_ADDR')) {
            $ipaddress = getenv('REMOTE_ADDR');
        } else {
            $ipaddress = 'UNKNOWN';
        }
        return $ipaddress;
    }
    public function getUserType($id)
    {
        $user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['id' => $id]);
        $usertype = $this->entityManager->getRepository(SystemUserType::class)
            ->findOneBy(['id' => $user->getUserType()]);
        return empty($usertype)?'':$usertype->getName();
    }

    public function makeDate($string)
    {
        if (0 == $string || empty($string)) {
            return null;
        }
        $string = str_replace('/', '-', $string);
        return \Datetime::createFromFormat('d-m-Y', $string);
    }
    public function makeDBDate($string)
    {
        $string = str_replace(' ', '', $string);
        $dateObj = \DateTime::createFromFormat('d/m/Y', $string);
        return $dateObj->format('Y/m/d');
    }
    public function getArray($string)
    {
        $values = explode(',', $string);
        $array = [];
        foreach ($values as $value) {
            $array[] = $value;
        }
        return $array;
    }
    public function makeString($array)
    {
        if (is_string($array) || empty($array)) {
            return $array;
        }
        $string = '';
        foreach ($array as $key => $value) {
            $string .= $value.',';
        }
        return $string;
    }
    public function getContact($id)
    {
        $contact = $this->entityManager->getRepository(Contacts::class)->findOneBy(['id' => $id]);
        return empty($contact) ? null : $customer->getName();
    }
    public function valid_email($str)
    {
        return (!preg_match('/^([a-z0-9\\+_\\-]+)(\\.[a-z0-9\\+_\\-]+)*@([a-z0-9\\-]+\\.)+[a-z]{2,6}$/ix', $str)) ? false : true;
    }
	public function getTravelTypeList()
	{
		$types = $this->entityManager->getRepository(TravelType::class)->findAll();
        $list = [];
        foreach ($types as $type) {
            $list[$type->getID()] = $type->getName();
        }
        return $list;
	}
	public function getCallTypeList()
	{
		$types = $this->entityManager->getRepository(CallType::class)->findAll();
        $list = [];
        foreach ($types as $type) {
            $list[$type->getID()] = $type->getName();
        }
        return $list;
	}
	public function getContactsList()
	{
		$contacts = $this->entityManager->getRepository(Contacts::class)->findAll();
        $list = [];
        foreach ($contacts as $contact) {
            $list[$contact->getID()] = $contact->getCompany();
        }
        return $list;
	}
	public function getProductSeriesList()
	{
		$series = $this->entityManager->getRepository(ProductSeries::class)->findAll();
        $list = [];
        foreach ($series as $s) {
            $list[$s->getID()] = $s->getName();
        }
        return $list;
	}
	public function getProductModelsList()
	{
		$models = $this->entityManager->getRepository(ProductModels::class)->findAll();
        $list = [];
        foreach ($models as $m) {
            $list[$m->getID()] = $m->getName();
        }
        return $list;
	}
	public function getProductsList()
	{
		$products = $this->entityManager->getRepository(Products::class)->findAll();
        $list = [];
        foreach ($products as $p) {
            $list[$p->getID()] = $p->getName();
        }
        return $list;
	}
	public function getSalesStageList()
	{
		$stages = $this->entityManager->getRepository(SalesStage::class)->findAll();
        $list = [];
        foreach ($stages as $s) {
            $list[$s->getID()] = $s->getName();
        }
        return $list;
	}
	public function getNextActionList()
	{
		$actions = $this->entityManager->getRepository(NextAction::class)->findAll();
        $list = [];
        foreach ($actions as $a) {
            $list[$a->getID()] = $a->getName();
        }
        return $list;
	}
	public function getTravelModeList()
	{
		$modes = $this->entityManager->getRepository(TravelMode::class)->findAll();
        $list = [];
        foreach ($modes as $m) {
            $list[$m->getID()] = $m->getName();
        }
        return $list;
	}
	public function getLeadStageList()
	{
		$stage = $this->entityManager->getRepository(LeadStage::class)->findAll();
        $list = [];
        foreach ($stage as $s) {
            $list[$s->getID()] = $s->getName();
        }
        return $list;
	}
	public function getExecutiveList()
	{
		$executives = $this->entityManager->getRepository(User::class)->findBy(['userType'=>3]);
        $list = [];
        foreach ($executives as $e) {
            $list[$e->getID()] = $e->getFullName();
        }
        return $list;
	}
	public function getLeadSourceList()
	{
		$source = $this->entityManager->getRepository(LeadSource::class)->findAll();
        $list = [];
        foreach ($source as $s) {
            $list[$s->getID()] = $s->getName();
        }
        return $list;
	}
	public function getProbabilityList()
	{
		$probability = $this->entityManager->getRepository(Probability::class)->findAll();
        $list = [];
        foreach ($probability as $p) {
            $list[$p->getID()] = $p->getName();
        }
        return $list;
	}
	public function getContactedTypeList()
	{
		$types = $this->entityManager->getRepository(ContactedType::class)->findAll();
        $list = [];
        foreach ($types as $t) {
            $list[$t->getID()] = $t->getName();
        }
        return $list;
	}
	public function getMarketSegmentList()
	{
		$segment = $this->entityManager->getRepository(MarketSegment::class)->findAll();
        $list = [];
        foreach ($segment as $s) {
            $list[$s->getID()] = $s->getName();
        }
        return $list;
	}
	
	public function getStageName($id)
	{
		$stage = $this->entityManager->getRepository(LeadStage::class)->findOneBy(['id' => $id]);
        return empty($stage) ? '' : $stage->getName();
	}
	
	public function getProspectName($id)
	{
		$prospect = $this->entityManager->getRepository(Contacts::class)->findOneBy(['id' => $id]);
        return empty($prospect) ? '' : $prospect->getCompany();
	}
	public function getBranchName($id)
	{
		$branch = $this->entityManager->getRepository(Branch::class)->findOneBy(['id' => $id]);
        return empty($branch) ? '' : $branch->getName();
	}
	public function getLeadSourceName($id)
	{
		$source = $this->entityManager->getRepository(LeadSource::class)->findOneBy(['id' => $id]);
        return empty($source) ? '' : $source->getName();
	}
	public function getExecutiveName($id)
	{
		$user = $this->entityManager->getRepository(User::class)->findOneBy(['id' => $id]);
        return empty($user) ? '' : $user->getFullName();
	}
	public function getSalesStageName($id)
	{
		$stage = $this->entityManager->getRepository(SalesStage::class)->findOneBy(['id' => $id]);
        return empty($stage) ? '' : $stage->getName();
	}
	public function getProductSeriesName($id)
	{
		$series = $this->entityManager->getRepository(ProductSeries::class)->findOneBy(['id' => $id]);
        return empty($series) ? '' : $series->getName();
	}
	public function getActualProductName($id)
	{
		$product = $this->entityManager->getRepository(Products::class)->findOneBy(['id' => $id]);
        return empty($product) ? '' : $product->getName();
	}
	public function getProductModelName($id)
	{
		$product = $this->entityManager->getRepository(ProductModels::class)->findOneBy(['id' => $id]);
        return empty($product) ? '' : $product->getName();
	}
	public function getExpectedMonthName($id)
	{
		$months = [1 => 'Jan.', 2 => 'Feb.', 3 => 'Mar.', 4 => 'Apr.', 5 => 'May', 6 => 'Jun.', 7 => 'Jul.', 8 => 'Aug.', 9 => 'Sep.', 10 => 'Oct.', 11 => 'Nov.', 12 => 'Dec.'];
        return empty($id) ? '' : $months[$id];
	}
	public function getClosePropabilityName($id)
	{
		$probability = $this->entityManager->getRepository(Probability::class)->findOneBy(['id' => $id]);
        return empty($probability) ? '' : $probability->getName();
	}
	public function getNextActionName($id)
	{
		$action = $this->entityManager->getRepository(NextAction::class)->findOneBy(['id' => $id]);
        return empty($action) ? '' : $action->getName();
	}
	
	public function getContactedTypeName($id)
	{
		$type = $this->entityManager->getRepository(ContactedType::class)->findOneBy(['id' => $id]);
        return empty($type) ? '' : $type->getName();
	}
	
	public function getCityName($id)
    {
        $city = $this->entityManager->getRepository(Locations::class)->findOneBy(['id' => $id]);
        return empty($city) ? '' : $city->getName();
    }
	
	public function getCallTypeName($id)
    {
        $calltype = $this->entityManager->getRepository(CallType::class)->findOneBy(['id' => $id]);
        return empty($calltype) ? '' : $calltype->getName();
    }
	public function getContactName($id)
    {
        $contact = $this->entityManager->getRepository(Contacts::class)->findOneBy(['id' => $id]);
        return empty($contact) ? '' : $contact->getName();
    }
	public function getContactCity($id)
    {
        $contact = $this->entityManager->getRepository(Contacts::class)->findOneBy(['id' => $id]);
        return empty($contact) ? '' : $contact->getCity();
    }
	public function getContactCompany($id)
    {
        $contact = $this->entityManager->getRepository(Contacts::class)->findOneBy(['id' => $id]);
        return empty($contact) ? '' : $contact->getCompany();
    }
	public function getContactContact($id)
    {
        $contact = $this->entityManager->getRepository(Contacts::class)->findOneBy(['id' => $id]);
        return empty($contact) ? '' : $contact->getContact();
    }
	public function getMarketSegmentName($id)
    {
        $segment = $this->entityManager->getRepository(MarketSegment::class)->findOneBy(['id' => $id]);
        return empty($segment) ? '' : $segment->getName();
    }
	public function getTravelModeName($id)
    {
        $mode = $this->entityManager->getRepository(TravelMode::class)->findOneBy(['id' => $id]);
        return empty($mode) ? '' : $mode->getName();
    }
}