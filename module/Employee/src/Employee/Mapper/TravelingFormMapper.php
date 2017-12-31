<?php 

namespace Employee\Mapper; 

use Application\Abstraction\AbstractDataMapper;
//use Leave\Model\LeaveFormEntity;
use Payment\Model\DateRange;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Predicate\Predicate;
use Application\Model\TravelFormLocal;

class TravelingFormMapper extends AbstractDataMapper { 
	
	protected $entityTable = "TravelingLocal"; 
	
	protected $entityTableAbroad = "TravelingAbroad";  
	
	protected $seqTable = "TravelApprovalLevel"; 
    
	protected function loadEntity(array $row) { 
	    $entity = new TravelFormLocal();
		return $this->arrayToEntity($row,$entity); 
	} 
    
	// unapproved traveling list, waiting for approval 
	public function getTravelingLocalFormList() {  
	    $predicate = new Predicate(); 
		$sql = $this->getSql(); 
		$select = $sql->select(); 
		$select->from(array('e' => $this->entityTable)) 
		       ->columns(array('*')) 
			   ->where($predicate->greaterThanOrEqualTo('effectiveFrom',date('Y-m-d')))
			   ->where(array('isCanceled' => 0))
			   ->where(array('isApproved' => 0))
		// ->where($predicate->lessThanOrEqualTo('approvedLevel','approvalLevel') )
		;    
		$sqlString = $sql->getSqlStringForSqlObject($select); 
		//echo $sqlString; 
		//exit; 
		return $this->adapter->query($sqlString)->execute(); 
	}   
	
	// unapproved traveling list, waiting for approval
	public function getTravelingLocalFormListAdmin() {
		//$predicate = new Predicate();
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
			   ->columns(array('*'))
			   //->where($predicate->lessThanOr('effectiveFrom',date('Y-m-d')))
			   ->where(array('isCanceled' => 0))
			   ->where(array('isApproved' => 0))
		// ->where($predicate->lessThanOrEqualTo('approvedLevel','approvalLevel') )
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString;
		//exit;
		return $this->adapter->query($sqlString)->execute();
	}
    
	// $ids List  
	public function getTravelLocalFormApprovalList($ids) {  
		$predicate = new Predicate();
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('id','employeeNumberTravelingLocal','effectiveFrom','effectiveTo'))
		       ->join(array('ep' => 'EmpEmployeeInfoMain'),'ep.employeeNumber = e.employeeNumberTravelingLocal',
		       		  array('employeeName'))
		;   
		$select->where($predicate->In('e.id',$ids)); 
		//echo $select->getSqlString(); 
		//exit; 
		return $select;       	 
	}    
	
	public function getTravelLocalApprovalSeqList() { 
		// $predicate = new Predicate();
		$sql = $this->getSql();
		$select = $sql->select(); 
		$select->from(array('e' => $this->seqTable))
		       ->columns(array('id','ApprovalLevelName','ApprovalSequence'))
		; 
		//echo $select->getSqlString(); 
		//exit; 
		return $select; 
	} 
	
	public function getTravelLocalFormApprovedList() {
		//$predicate = new Predicate();
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('id','employeeNumberTravelingLocal','effectiveFrom','effectiveTo'))
		       ->join(array('ep' => 'EmpEmployeeInfoMain'),'ep.employeeNumber = e.employeeNumberTravelingLocal',
				      array('employeeName'))
			   ->where(array('isCanceled' => 0))
			   ->where(array('isApproved' => 1))
		;
		//$select->where($predicate->In('e.id',$ids));
		//echo $select->getSqlString();
		//exit;
		return $select;
	}
    
    public function fetchTravelingById($id) { 
    	if ($this->identityMap->hasId($id)) { 
    		return $this->identityMap->getObject($id);  
    	}
    	$sql = $this->getSql(); 
		$select = $sql->select(); 
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('id','employeeNumberTravelingLocal','travelingFormEmpPosition',
		       		     'effectiveFrom' => new Expression('convert(varchar(10),effectiveFrom,120)'),
		       		     'effectiveTo' => new Expression('convert(varchar(10),effectiveTo,120)'),
		       		     'delegatedEmployee','travelingTo','purposeOfTrip','meansOfTransport',
                         'expensesRequired','fuelLiters','classOfAirTicket','classOfHotel',
                         'expenseApproved','amount','travelingComments','appliedDate','approvalLevel',
                         'isCanceled','approvedLevel','isApproved')) 
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
	
	public function fetchEmployeeTravelLocal($id) {
		if ($this->identityMap->hasId($id)) {
			return $this->identityMap->getObject($id);
		}
		$sql = $this->getSql(); 
		$select = $sql->select(); 
		$select->from(array('e' => $this->entityTable))
			   ->columns(array('id','employeeNumberTravelingLocal','appliedDate', 
						'effectiveFrom' => new Expression('convert(varchar(12),effectiveFrom,107)'),
						'effectiveTo' => new Expression('convert(varchar(12),effectiveTo,107)'),
						'travelingTo','purposeOfTrip','expensesRequired','meansOfTransport',
						'fuelLiters','classOfAirTicket','classOfHotel','expenseApproved',
						'amount','travelingComments'))
			   ->join(array('ep' => 'EmpEmployeeInfoMain'),
			   		        'ep.employeeNumber = e.employeeNumberTravelingLocal',
		       		  array('employeeName'))
		       ->join(array('epp' => 'EmpEmployeeInfoMain'),'epp.employeeNumber = e.delegatedEmployee',
		       		  array('delegatedEmployee' => 'employeeName'))
		       ->join(array('p' => 'Position'),'p.id = e.travelingFormEmpPosition',
		         	  array('positionName' => new Expression("positionName + ' ' +shortDescription")))
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
	
	public function addTravelLocalApproverInfo(array $approverInfo) { 
		$this->setEntityTable('TravelingLocalApprovedLog');  
		$this->insert($approverInfo);  
	} 
	
	public function addToLeave(array $leaveArray) { 
		$this->setEntityTable('Leave'); 
		$this->insert($leaveArray); 
	} 
	
	/*public function updateLeaveForm(array $update) {
		
		$this->update($update); 
	}*/
	
	public function getTravelLocalLevel() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'TravelApprovalLevel'))
		       ->columns(array('id','ApprovalLevelName','ApprovalSequence')) 
		;  
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString; 
		//exit; 
		$results = $this->adapter->query($sqlString)->execute();
		return $this->convertToArray($results); 
	}
	
	// ApprovalSequence
	
	public function getTravelLocalTotAppLevel() {
		$sqlString = "SELECT max(ApprovalSequence) as maxlevel
                      FROM TravelApprovalLevel ";
		/*AND (leaveFrom >= '".date('Y-m-d')."' AND approvedLevel < approvalLevel)
		 AND isCanceled = '0' ";*/ 
		//echo $sqlString; 
		//exit; 
		$row = $this->adapter->query($sqlString)->execute()->current(); 
		if($row) {
			return $row['maxlevel']; 
		}
		return 2; 
		/*$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'TravelApprovalLevel'))
		       ->columns(array('id','ApprovalLevelName','ApprovalSequence'))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString;
		//exit;
		$results = $this->adapter->query($sqlString)->execute();*/ 
	}
	
	public function isWaitingForApproval($id) {
	    
		$sqlString = "SELECT id  FROM TravelingLocal AS e WHERE id = '".$id."'
		AND (effectiveFrom >= '".date('Y-m-d')."' AND approvedLevel < approvalLevel)
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