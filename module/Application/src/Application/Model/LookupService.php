<?php

namespace Application\Model;

use Application\Mapper\LookupMapper;

class LookupService {
	
	private $lookupMapper; 
	
	public function __construct(LookupMapper $lookupMapper) {
		$this->lookupMapper = $lookupMapper; 
	}
     	
	public function getNationalityList() {
		return $this->lookupMapper->getNationalityList(); 
	}
	
	public function getStateList() {
		return $this->lookupMapper->getStateList();
	}
	
	public function getEventList() {
	    return $this->lookupMapper->getEventList();
	}
	
	public function getReligionList() {
		return $this->lookupMapper->getReligionList();
	}
	
	public function getCurrencyList() {
		return $this->lookupMapper->getCurrencyList();
	}
	
	public function getEmpTypeList() { 
		return $this->lookupMapper->getEmpTypeList();
	}
	
	public function getNoAttendanceReason() {
		return $this->lookupMapper->getNoAttendanceReason();
	}
	
	public function getSalaryGradeList() { 
		return $this->lookupMapper->getSalaryGradeList();
	} 
	
	public function getJobGradeList() { 
		return $this->lookupMapper->getJobGradeList();
	}
	
	public function dayList() {
	    return $this->lookupMapper->dayList();
	}
	
	public function getBankList() {
		return $this->lookupMapper->getBankList();
	}
	
	public function getAttenGroupList() {
	    return $this->lookupMapper->getAttenGroupList();
	}
	
	/*public function getPositionList() {
		return $this->lookupMapper->getPositionList();
	}*/ 
	
	public function getLocationList() {
		return $this->lookupMapper->getLocationList();
	}
	
	public function getDepartmentList() {
		return $this->lookupMapper->getDepartmentList();
	}
	
	public function getCompanyList() {
		return $this->lookupMapper->getCompanyList();
	} 
	
	public function getLeaveType() {
		return $this->lookupMapper->getLeaveType();
	}
	
	public function getSkillGroupList() {
		return $this->lookupMapper->getSkillGroupList(); 
	}
	
	public function getSectionList() {
		return $this->lookupMapper->getSectionList();
	}
	
	public function getRatingList() {
		return $this->lookupMapper->getRatingList();
	}
	
	public function memberTypeList() {
		return $this->lookupMapper->memberTypeList();
	}
	
	public function lbvfRoleList() {
		return $this->lookupMapper->lbvfRoleList();
	}
	
	public function lbvfLoiList() {
		return $this->lookupMapper->lbvfLoiList();
	}
	
	public function getOrganisationLevelList() {
		return $this->lookupMapper->getOrganisationLevelList();
	}
	
	public function getTerminationTypeList() {
		return $this->lookupMapper->getTerminationTypeList();
	}
	
	public function getMeansOfTransport() {
		return $this->lookupMapper->getMeansOfTransport();
	} 
	
	public function getYesNoList() {
		return array(
			''  => '',
			'1' => 'Yes',
			'0' => 'No' 	
		);  
	}  
	
	public function isOverlap($table,$from,$to,$employeeId) { 
		return $this->lookupMapper->isOverlap($table,$from,$to,$employeeId);
	} 
	
	public function getLeaveRange($table,$from,$to,$employeeId,$leaveType) {
		//return 0;
		return $this->lookupMapper->getLeaveRange($table,$from,$to,$employeeId,$leaveType); 
	}
	
	public function getPaysuspendRangeOverlap($table,$from,$to,$employeeId) {
	    //return 0;
	    return $this->lookupMapper->getPaysuspendRangeOverlap($table,$from,$to,$employeeId);
	}
	
	public function getPaysuspendRange($table,$from,$to,$employeeId) {
		//return 0;
		return $this->lookupMapper->getPaysuspendRange($table,$from,$to,$employeeId); 
	}
	
	public function getEmpJoinDate($table,$employeeId) {
		//return 0;
		return $this->lookupMapper->getEmpJoinDate($table,$employeeId);
	}
    
	
}