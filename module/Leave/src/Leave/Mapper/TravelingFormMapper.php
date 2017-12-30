<?php 

namespace Leave\Mapper; 

use Application\Abstraction\AbstractDataMapper;
use Leave\Model\LeaveFormEntity;
use Payment\Model\DateRange;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Predicate\Predicate;

class TravelingFormMapper extends AbstractDataMapper {
	
	protected $entityTable = "LeaveForm"; 
    
	protected function loadEntity(array $row) { 
	    $entity = new LeaveFormEntity(); 
		return $this->arrayToEntity($row,$entity); 
	} 
    
	// unapproved leave list, waiting for approval 
	public function getLeaveFormList() { 
	    $predicate = new Predicate(); 
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('id','employeeId','appliedDate','joinDate',
		             'positionId','departmentId','locationId','leaveFrom',
                     'leaveTo','leaveAllowanceRequest','advanceSalaryRequest',
		             'address','daysEntitled','outstandingBalance','daysTaken',
		             'thisLeaveDays','revisedDays','publicHoilday','remainingDays',
		             'delegatedPositionId','approvedLevel','approvalLevel'))  
			   ->where($predicate->greaterThanOrEqualTo('leaveFrom',date('Y-m-d')))
			   ->where(array('isCanceled' => 0))
			   ->where(array('isApproved' => 0))
		// ->where($predicate->lessThanOrEqualTo('approvedLevel','approvalLevel')) 
		;  
		$sqlString = $sql->getSqlStringForSqlObject($select); 
		//echo $sqlString; 
		//exit; 
		return $this->adapter->query($sqlString)->execute(); 
	} 
    
	// $ids List 
	public function getLeaveFormApprovalList($ids) { 
		$predicate = new Predicate();
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('id','employeeId','leaveFrom','leaveTo'))
		       ->join(array('ep' => 'EmpEmployeeInfoMain'),'ep.employeeNumber = e.employeeId',
		       		  array('employeeName'))
		;  
		$select->where($predicate->In('e.id',$ids)); 
		//echo $select->getSqlString(); 
		//exit; 
		return $select; 	
	}   
    
    public function fetchLeaveById($id) { 
    	if ($this->identityMap->hasId($id)) {
    		return $this->identityMap->getObject($id);
    	}
    	$sql = $this->getSql(); 
		$select = $sql->select(); 
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('id','employeeId','appliedDate',
		       		           'joinDate' => new Expression('convert(varchar(10),joinDate,120)'),
		       		           'leaveFrom' => new Expression('convert(varchar(10),leaveFrom,120)'),
		       		           'leaveTo' => new Expression('convert(varchar(10),leaveTo,120)'),
		       		           'positionId','departmentId','locationId','daysEntitled',
                               'leaveAllowanceRequest','advanceSalaryRequest','address',
                               'outstandingBalance','daysTaken','thisLeaveDays',
                               'revisedDays','publicHoilday','remainingDays',
                               'delegatedPositionId','approvedLevel','approvalLevel' 
		       )) 
		       ->where(array('id' => $id)) 
		;  
		$sqlString = $sql->getSqlStringForSqlObject($select); 
		//echo $sqlString; 
		//exit; 
		$results = $this->adapter->query($sqlString)->execute()->current(); 
    	$entity = $this->loadEntity($results); 
    	$this->identityMap->set($id,$entity); 
    	return $entity; 
	} 
	
	public function fetchEmployeeLeave($id) {
		if ($this->identityMap->hasId($id)) {
			return $this->identityMap->getObject($id);
		}
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
			   ->columns(array('id','employeeId','appliedDate',
						'joinDate' => new Expression('convert(varchar(12),joinDate,107)'),
						'leaveFrom' => new Expression('convert(varchar(12),leaveFrom,107)'),
						'leaveTo' => new Expression('convert(varchar(12),leaveTo,107)'),
						'positionId','departmentId','locationId','daysEntitled',
						'leaveAllowanceRequest','advanceSalaryRequest','address',
						'outstandingBalance','daysTaken','thisLeaveDays',
						'revisedDays','publicHoilday','remainingDays',
						'delegatedPositionId','approvedLevel','approvalLevel'
			   ))
			   ->join(array('ep' => 'EmpEmployeeInfoMain'),'ep.employeeNumber = e.employeeId',
		       		  array('employeeName'))
		       ->join(array('epp' => 'EmpEmployeeInfoMain'),'epp.employeeNumber = e.delegatedPositionId',
		       		  array('delegatedEmployee' => 'employeeName'))
		       ->join(array('p' => 'Position'),'p.id = e.positionId',
		         	  array('positionName' => new Expression("positionName + ' ' +shortDescription")))
		       ->join(array('d' => 'Department'),'d.id = e.departmentId',
		       		  array('departmentName'))
		       ->join(array('l' => 'Location'),'l.id = e.locationId', 
		       		  array('locationName'))
			   ->where(array('e.id' => $id))
		; 
		$sqlString = $sql->getSqlStringForSqlObject($select); 
		//echo $sqlString; 
		//exit; 
		$results = $this->adapter->query($sqlString)->execute()->current(); 
		
		return $results; 
	} 
	
	public function approverLeaveForm(array $cancelInfo) {
		$update = array(
				'isCanceled'   => 1,
				'canceledBy'   => $cancelInfo['employeeNumber'],
				'canceledDate' => date('Y-m-d'),
				'id'           => $cancelInfo['id'],
		);
		$this->update($update); 
	}
	
	public function addApproverInfo(array $approverInfo) { 
		$this->setEntityTable('LeaveApproverInfo'); 
		$this->insert($approverInfo);  
	} 
	
	public function addToLeave(array $leaveArray) { 
		$this->setEntityTable('Leave'); 
		$this->insert($leaveArray); 
	} 
	
	/*public function updateLeaveForm(array $update) {
		
		$this->update($update); 
	}*/
	
	public function getLeaveLevel() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'LeaveApprovalLevel'))
		       ->columns(array('id','ApprovalLevelName','ApprovalSequence')) 
		; 
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString; 
		//exit; 
		$results = $this->adapter->query($sqlString)->execute();
		return $this->convertToArray($results); 
	}
	
	public function isWaitingForApproval($id) {
		
		$sqlString = "SELECT id  FROM LeaveForm AS e WHERE id = '".$id."'
		AND (leaveFrom >= '".date('Y-m-d')."' AND approvedLevel < approvalLevel)
		AND isCanceled = '0' ";         		
		$result = $this->adapter->query($sqlString)->execute()->current(); 
        
		if($result) {
			return true;
		}
    	return false; 
	}
	
	public function employeeLeaveCompleteDtls($employeeNumber,DateRange $dateRange = null) {
		// @todo to write condition 
		$sqlString = "SELECT employeeName,LkpLeaveTypeId,leaveFromDate,leaveToDate,
                      isLeaveAllowanceRequired,isAdvanceSalaryRequired,address,
                      daysApproved,holidayLieu,publicHoliday,leaveYear,leaveAddedDate
                      FROM Leave l
                      inner join EmpEmployeeInfoMain m on m.employeeNumber = l.employeeId
				      WHERE employeeId = '".$employeeNumber."' "; 
		/*AND (leaveFrom >= '".date('Y-m-d')."' AND approvedLevel < approvalLevel)
		AND isCanceled = '0' ";*/ 
		//echo $sqlString; 
		//exit; 
		return $this->adapter->query($sqlString)->execute();
		
		/*if($result) {
			return $result;
		}
		return false;*/ 
	} 
	
	public function getEmployeeEntitlement($employeeId,$leaveType,$fromDate,$toDate) {
		// $predicate = new Predicate();
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'EmployeeEntitlement'))
		       ->columns(array('entitledDays'))
		       //->join(array('ep' => 'EmpEmployeeInfoMain'),'ep.employeeNumber = e.employeeId',
				     // array('employeeName'))
		       ->where(array('employeeId' => $employeeId))
		       //->where(array('leaveType' => $leaveType)) 
		;  
		// $select->where($predicate->In('e.id',$ids)); 
		// echo $select->getSqlString(); 
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString;
		//exit;
		$results = $this->adapter->query($sqlString)->execute()->current();  
		if($results) {
			return $results['entitledDays']; 
		}   
		return 0; 
	}   
	
	public function getEmployeeOutstandingBalance($employeeId,$leaveType,$fromDate,$toDate) { 
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'LeaveOutstandingBalance'))
		       ->columns(array('balanceDays')) 
		       ->where(array('employeeId' => $employeeId))
		       //->where(array('leaveType' => $leaveType)) 
		;  
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString;
		//exit;
		$results = $this->adapter->query($sqlString)->execute()->current();  
		if($results) {
			return $results['balanceDays']; 
		}   
		return 0;  
	}  
	
	public function getEmployeeLeaveDaysTaken($employeeId,$leaveType,$fromDate,$toDate) {
		$predicate = new Predicate();
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'Leave')) 
			   ->columns(array('id','employeeId','leaveFromDate','leaveToDate', 
			                   'publicHoliday','holidayLieu')) 
			->where($predicate->greaterThanOrEqualTo('leaveToDate',$fromDate))
		    ->where($predicate->lessThanOrEqualTo('leaveToDate',$toDate))  
			->where(array('employeeId' => $employeeId)) 
			//->where(array('isApproved' => 0))  
		;         
		$sqlString = $sql->getSqlStringForSqlObject($select);  
		//echo $sqlString;    
		//exit;    
		$result = $this->adapter->query($sqlString)->execute();    
		if($result) {  
			return $result;   
		}  
		return array();    
	}   
	
}