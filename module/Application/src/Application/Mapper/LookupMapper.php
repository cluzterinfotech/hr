<?php

namespace Application\Mapper;

use Application\Abstraction\AbstractDataMapper;
use Application\Entity\CompanyEntity;
use Zend\Db\Sql\Predicate\Predicate;
use Zend\Db\Sql\Expression;

class LookupMapper extends AbstractDataMapper {

	protected $entityTable = "Company";

	protected function loadEntity(array $row) {
		$entity = new  CompanyEntity();
		return $this->arrayToEntity($row,$entity);
	}

	public function getNationalityList() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'lkpNationality'))
		       ->columns(array('id','nationalityName'))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute();
		return $this->toArrayList($results,'id','nationalityName');
	}
    
	public function getStateList() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'lkpStates'))
		->columns(array('id','stateName'))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute();
		return $this->toArrayList($results,'id','stateName');
	}
	
	public function getEventList() {
	    $sql = $this->getSql();
	    $select = $sql->select();
	    $select->from(array('e' => 'AttendanceEvent'))
	    ->columns(array('id','eventName'))
	    ;
	    $sqlString = $sql->getSqlStringForSqlObject($select);
	    $results = $this->adapter->query($sqlString)->execute();
	    return $this->toArrayList($results,'id','eventName');
	}
    
	public function getEmpTypeList() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'lkpEmployeeType'))
		->columns(array('id','employeeTypeName'))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute();
		return $this->toArrayList($results,'employeeTypeName','employeeTypeName');
	}
	
	public function getNoAttendanceReason() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'NoAttendanceReason'))
		       ->columns(array('id','reason'))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute();
		return $this->toArrayList($results,'id','reason');
	} 
    
	public function getSalaryGradeList() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'lkpSalaryGrade'))
		->columns(array('id','salaryGrade'))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute();
		return $this->toArrayList($results,'id','salaryGrade');
	}
	
	public function dayList() {
	    $sql = $this->getSql();
	    $select = $sql->select();
	    $select->from(array('e' => 'AttendanceDay'))
	           ->columns(array('id','dayNameFull'))
	    ;
	    $sqlString = $sql->getSqlStringForSqlObject($select);
	    $results = $this->adapter->query($sqlString)->execute();
	    return $this->toArrayList($results,'id','dayNameFull');
	}

	public function getJobGradeList() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'lkpJobGrade')) 
		       ->columns(array('id','jobGrade')) 
		;
		$sqlString = $sql->getSqlStringForSqlObject($select); 
		$results = $this->adapter->query($sqlString)->execute(); 
		return $this->toArrayList($results,'id','jobGrade'); 
	}   
	
	public function getMeansOfTransport() { 
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'MeansOfTransport'))
		       ->columns(array('id','meansOfTransport'))
		; 
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute();
		//\Zend\Debug\Debug::dump($results);
		//exit; 
		return $this->toArrayList($results,'id','meansOfTransport');
	}   
    
	public function getLeaveType() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'LkpLeaveType'))
		       ->columns(array('id','leaveName'))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute();
		return $this->toArrayList($results,'id','leaveName');
	}
	
	public function getAttenGroupList() {
	    $sql = $this->getSql();
	    $select = $sql->select();
	    $select->from(array('e' => 'AttendanceGroup'))
	           ->columns(array('id','groupName'))
	    ;
	    $sqlString = $sql->getSqlStringForSqlObject($select);
	    $results = $this->adapter->query($sqlString)->execute();
	    return $this->toArrayList($results,'id','groupName');
	}

	public function getBankList() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'lkpBank'))
		       ->columns(array('id','bankName'))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute();
		return $this->toArrayList($results,'id','bankName');
	}

	/*public function getPositionList() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'Position'))
		->columns(array('id','positionName'))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute();
		return $this->toArrayList($results,'id','positionName');
	}*/

	public function getLocationList() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'Location'))
		       ->columns(array('id','locationName'))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute();
		return $this->toArrayList($results,'id','locationName');
	}
	
	public function getDepartmentList() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'Department'))
		       ->columns(array('id','departmentName'))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute();
		return $this->toArrayList($results,'id','departmentName');
	}
	
	public function getCompanyList() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('c' => 'Company'))
		       ->columns(array('id','companyName'))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute();
		return $this->toArrayList($results,'id','companyName');
	}
	
	public function getReligionList() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('r' => 'lkpReligions'))
		       ->columns(array('id','religionName'))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute();
		return $this->toArrayList($results,'id','religionName');
	}
	
	public function getCurrencyList() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('r' => 'lkpCurrencies'))
		->columns(array('id','currencyName'))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute();
		return $this->toArrayList($results,'id','currencyName');
	}
	 
	public function getSkillGroupList() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'lkpSkillGroups'))
		       ->columns(array('id','skillGroup'))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute();
		return $this->toArrayList($results,'id','skillGroup');
	}
	
	public function getSectionList() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('s' => 'Section'))
		       ->columns(array('id','sectionName'  
		       		=> new Expression("sectionName + ' ' + CAST(sectionCode AS varchar(15))")))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute();
		return $this->toArrayList($results,'id','sectionName'); 
	}
	
	public function getRatingList() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'lkpRating'))
		       ->columns(array('id','Rating'))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute();
		return $this->toArrayList($results,'Rating','Rating');
	}
	
	public function memberTypeList() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'FamilyMemberType'))
		       ->columns(array('id','memberTypeName'))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute();
		return $this->toArrayList($results,'id','memberTypeName');
	}
	
	public function lbvfRoleList() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'LbvfLkpRole'))
		->columns(array('id','roleName'))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute();
		return $this->toArrayList($results,'id','roleName');
	}
	
	public function lbvfLoiList() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'LbvfLkpLOI'))
		       ->columns(array('id','levelOfInvolvement'))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute();
		return $this->toArrayList($results,'id','levelOfInvolvement'); 
	}
	
	//PositionLevel
	public function getOrganisationLevelList() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'PositionLevel'))
		       ->columns(array('id','levelName'))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute();
		return $this->toArrayList($results,'id','levelName');
	}
    
	public function getTerminationTypeList() {
		$sql = $this->getSql(); 
		$select = $sql->select(); 
		$select->from(array('e' => 'lkpTerminationType'))
		       ->columns(array('id','terminationType'))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute();
		return $this->toArrayList($results,'id','terminationType');
	}
    
	/*$predicate = new Predicate();
	 $sql = $this->getSql();
	 $select = $sql->select();
	 $select->from(array('e' => $this->entityTable))
	 ->columns(array('id','employeeId','leaveFrom','leaveTo'))
	 ;
	 $select->where($predicate->In('id',$ids));
	 //echo $select->getSqlString();
	 //exit;
	 return $select;*/

	//@todo rewrite logic 
	public function isOverlap($table,$from,$to,$employeeId) {
		$predicate = new Predicate();
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $table))
			   ->columns(array('id'))
			   ->where($predicate->greaterThanOrEqualTo('leaveFrom',$from))
			   ->where($predicate->lessThanOrEqualTo('leaveFrom',$to))
			   ->where(array('isCanceled' => 0))
			   ->where(array('employeeId' => $employeeId));
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString;
		//exit;
		$results = $this->adapter->query($sqlString)->execute()->current();
		//var_dump($results);
		//exit;
		if($results) {
			return 1;
		}
		return 0; 
	}

	// get number of days
	public function getLeaveRange($table,$from,$to,$employeeId,$leaveType) {
		$predicate = new Predicate();
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $table))
			   ->columns(array('leaveFromDate','leaveToDate'))
			   ->where($predicate->greaterThanOrEqualTo('leaveToDate',$from))
			   ->where($predicate->lessThanOrEqualTo('leaveFromDate',$to))
			   // ->where(array('isCanceled' => 0))
			   ->where(array('LkpLeaveTypeId' => $leaveType))
			   ->where(array('employeeId' => $employeeId));
		$sqlString = $sql->getSqlStringForSqlObject($select);
		/*if($employeeId == '1291') {
		 echo $sqlString;
		 exit;
		}*/
		$results = $this->adapter->query($sqlString)->execute();  
		//var_dump($results);
		//exit;
		if($results) {
		    return $results;
		}
		return 0;
	}

	public function getPaysuspendRange($table,$from,$to,$employeeId) {
		$predicate = new Predicate();
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $table))
		       ->columns(array('suspendFrom','suspendTo'))
		       ->where($predicate->greaterThanOrEqualTo('suspendTo',$from))
		       ->where($predicate->lessThanOrEqualTo('suspendFrom',$to))
		       ->where(array('employeeId' => $employeeId));
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString;
		//exit;
		$results = $this->adapter->query($sqlString)->execute();
		//var_dump($results); 
		//exit; 
		if($results) { 
		    return $results; 
		} 
		return 0; 
	}
	
	public function getPaysuspendRangeOverlap($table,$from,$to,$employeeId) {
	    $predicate = new Predicate();
	    $sql = $this->getSql();
	    $select = $sql->select();
	    $select->from(array('e' => $table))
	    ->columns(array('suspendFrom','suspendTo'))
	    ->where($predicate->greaterThanOrEqualTo('suspendTo',$from))
	    ->where($predicate->lessThanOrEqualTo('suspendFrom',$to))
	    ->where(array('employeeId' => $employeeId));
	    $sqlString = $sql->getSqlStringForSqlObject($select);
	    //echo $sqlString;
	    //exit;
	    $results = $this->adapter->query($sqlString)->execute()->current();
	    //var_dump($results);
	    //exit;
	    if($results) {
	        return 1;
	    }
	    return 0;
	}
    
	public function getEmpJoinDate($table,$employeeId) {
		$predicate = new Predicate();
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $table))
		       ->columns(array('empJoinDate'))
		     //->where($predicate->greaterThanOrEqualTo('empJoinDate',$from))
		     //->where($predicate->lessThanOrEqualTo('empJoinDate',$to))
		       ->where(array('employeeNumber' => $employeeId));
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString;
		//exit;
		$results = $this->adapter->query($sqlString)->execute()->current();
		//var_dump($results);
		//exit;
		if($results) {
			return $results['empJoinDate'];
		}
		return 0;
	}
	 
}
   