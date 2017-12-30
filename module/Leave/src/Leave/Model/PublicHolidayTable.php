<?php

namespace Leave\Model;

use Leave\Model\PublicHoliday;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;

class PublicHolidayTable {
	protected $leaveEntitlemen;
	protected $adapter;
	protected $sql;
	public function __construct($leaveEntitlemenTableGateway) {
		$this->leaveEntitlemen = $leaveEntitlemenTableGateway;
		$this->adapter = $this->leaveEntitlemen->getAdapter ();
		$this->sql = new Sql ( $this->adapter );
	}
	public function savePublicHoliday(PublicHoliday $leaveEntitlememnt) {
		$data = array (
				'yearsOfService' => $leaveEntitlememnt->getYearsOfService (),
				'numberOfDays' => $leaveEntitlememnt->getNumberOfDays (),
				'companyId' => $leaveEntitlememnt->getCompanyId () 
		);
		// \Zend\Debug\Debug::dump($data);
		
		$id = ( int ) $leaveEntitlememnt->getId ();
		if ($id == 0) {
			$this->leaveEntitlemen->insert ( $data );
		} else {
			$this->leaveEntitlemen->update ( $data );
		}
	}
	public function isPublicHoliday($id) {
		$resultSet = $this->publicHoliday->select ( array (
				'id' => $id 
		) );
		if ($resultSet->count () > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// public function fetchPublicHoliday($id)
	// {
	// $id = (int)$id;
	// if(!$this->isPublicHoliday($id)){
	// throw new \Exception(" $id does not exist");
	// } else {
	//
	//
	//
	// $publicHolidayData = $this->publicHoliday->select(array('id' => $id));
	//
	// }
	//
	// return $publicHolidayData;
}