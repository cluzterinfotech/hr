<?php 

namespace Leave\Mapper; 

use Application\Abstraction\AbstractDataMapper;
use Application\Utility\DateRange;
use Leave\Model\LeaveFormEntity;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Predicate\Predicate;
use Leave\Model\LeaveAdmin;
use Payment\Model\Company;

class LeaveFormMapper extends AbstractDataMapper {
	
	protected $entityTable = "LeaveForm";
	
	protected $leave = "Leave"; 
	
	protected $outstandingBalance = "LeaveOutstandingBalance"; 
    	
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
		       ->columns(array('id','employeeId','appliedDate','joinDate'
		                      ,'positionId','departmentId','locationId','leaveFrom'
                              ,'leaveTo','leaveAllowanceRequest','advanceSalaryRequest'
		                      ,'address','daysEntitled','outstandingBalance','daysTaken'
		                      ,'thisLeaveDays','revisedDays','publicHoilday','remainingDays'
		                      ,'delegatedPositionId','approvedLevel','approvalLevel'
		)) 
			   ->where($predicate->greaterThanOrEqualTo('leaveFrom',date('Y-m-d')))
			   ->where(array('isCanceled' => 0))
			   ->where(array('isApproved' => 0))
		// ->where($predicate->lessThanOrEqualTo('approvedLevel','approvalLevel') )
		; 
		$sqlString = $sql->getSqlStringForSqlObject($select); 
		//echo $sqlString; 
		//exit;  
		return $this->adapter->query($sqlString)->execute();  
	} 
	
	public function isHaveExceptionAll($date,$loc,$day) { 
	    // @todo @return array 	
	    return array(); 
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
	
	public function outstandingBalanceList() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('o' => $this->outstandingBalance))
		       ->columns(array('id','employeeId','balanceDays'))
		       ->join(array('e' => 'EmpEmployeeInfoMain'),'e.employeeNumber = o.employeeId',
				      array('employeeName'))
		; 
		//echo $select->getSqlString(); 
		//exit; 
		return $select;
	}
	
	public function employeeDoj($employeeId) {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'EmpEmployeeInfoMain'))
		       ->columns(array('empJoinDate'))
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
	
	public function employeeCompany($employeeId) {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'EmpEmployeeInfoMain'))
		->columns(array('companyId'))
		->where(array('employeeNumber' => $employeeId));
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString;
		//exit;
		$results = $this->adapter->query($sqlString)->execute()->current();
		//var_dump($results);
		//exit;
		if($results) {
			return $results['companyId'];
		}
		return 0;
	} 
	
	public function selectAdminLeave() {
		//$predicate = new Predicate();
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->leave))
		       ->columns(array('id','leaveFromDate','leaveToDate'))
		       ->join(array('ep' => 'EmpEmployeeInfoMain'),'ep.employeeNumber = e.employeeId',
				     array('employeeName'))
			   ->join(array('l' => 'LkpLeaveType'),'l.id = e.LkpLeaveTypeId',
				     array('leaveName'))
			   ->order('e.id desc')     
			   //->where(array('id' => $id))
		; 
		//echo $select->getSqlString();
		//exit;
		return $select;
	}
	
	public function insertAdminLeave($entity) {
		$this->setEntityTable($this->leave);
		return $this->insert($entity);
	}
	
	public function isHaveHajjLeave($employeeId) {
	    $sql = $this->getSql();
	    $select = $sql->select();
	    $select->from(array('e' => 'Leave'))
        	   ->columns(array('id'))
        	   ->where(array('employeeId' => $employeeId))
        	    ->where(array('LkpLeaveTypeId' => 4))
	    ;
	    $sqlString = $sql->getSqlStringForSqlObject($select);
	    //echo $sqlString;
	    //exit;
	    $results = $this->adapter->query($sqlString)->execute()->current();
	    if($results) {
	        return 1;
	    }
	    return 0; 
	}
	
	public function isHaveHajjLeaveId($employeeId,$id) {
	    $adapter = $this->adapter;
	    $qi = function($name) use ($adapter) {
	        return $adapter->platform->quoteIdentifier($name);
	    };
	    $fp = function($name) use ($adapter) {
	        return $adapter->driver->formatParameterName($name);
	    };
	    $statement = $adapter->query("select top 1 id from ".$qi('Leave')." where
					employeeId  = '".$employeeId."' and
					LkpLeaveTypeId  = '4' and
					id   != '".$id."'
		");
	    // echo $statement->getSql();
	    // exit;
	    $results = $statement->execute()->current();
	    if($results['id']) {
	        return 1;
	    }
	    return 0;
	}
	
	public function updateAdminLeave($entity) {
		$this->setEntityTable($this->leave);
		$sql = $this->getSql();
		$update = $sql->Update($this->entityTable);
		$array = $this->entityToArray($entity);
		$id = $array['id'];
		unset($array['id']);
		$update->set($array);
		$update->where(array(
				'id' => $id
		));
		$sqlString = $update->getSqlString();
		// echo $sqlString;
		// exit;
		$sqlString = $sql->getSqlStringForSqlObject($update);
		return $this->adapter->query($sqlString)->execute()->count();
		//return $this->update($entity);
	}
	
	public function fetchAdminLeaveById($id) {
		$this->setEntityTable($this->leave);
		$statement = $this->fetch(array(
				'id' => $id
		) );
		if (!$results = $statement->execute()->current()) {
			return null;
		}
		return $this->loadAdminLeave($results);
	}
	
	protected function loadAdminLeave(array $row) {
		$entity = new LeaveAdmin(); 
		return $this->arrayToEntity($row,$entity);
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
	
	public function isAttendancePrepared($date) { 
	    //$date = new date('Y-m-d')
	    $sqlString = "SELECT id  FROM AttendancePreparedDate  WHERE 
                      lastPreparedDate = '".$date."' ";
	    //echo $sqlString;
	    //exit; 
	    $result = $this->adapter->query($sqlString)->execute()->current();
	    if($result) {
	        return 1;
	    }
	    return 0; 
	} 
	
	public function insertEmployeeAttendance($attendance) {
	    $this->setEntityTable('EmployeeAttendance');
	    return $this->insert($attendance);
	}
	
	public function addAttendancePreparedDate($date) {
	    $this->setEntityTable('AttendancePreparedDate'); 
	    $array = array(
	        'lastPreparedDate'  => $date
	    ); 
	    return $this->insert($array);   
	} 
	
	public function getEmployeeAllRecentLeave(Company $company,$values,$from,$to) {
	    $leaveTypeId = $values['leaveTypeReport'];
	    $leaveLocationId = $values['leaveLocation'];
	    $leaveDepartmentId = $values['leaveDepartment'];
	    $leaveEmployeeId = $values['employeeLeaveReport'];
	    $adapter = $this->adapter;
	    $qi = function($name) use ($adapter) {
	        return $adapter->platform->quoteIdentifier($name);
	    };
	    $fp = function($name) use ($adapter) {
	        return $adapter->driver->formatParameterName($name);
	    };
	    $top = 100;
	    $where = " where (1=1) "; 
	    if($leaveLocationId) {
	        $where .= " and p.positionLocation = '".$leaveLocationId."' ";
	    }
	    if($leaveEmployeeId) {
	        $where .= " and m.employeeNumber = '".$leaveEmployeeId."' ";
	    }
	    if($leaveTypeId) {
	        $where .= " and LkpLeaveTypeId = '".$leaveTypeId."' ";
	    }
	    if($leaveDepartmentId) {
	        $where .= " and d.id = '".$leaveDepartmentId."' ";
	    }
	    $where .= " and leaveFromDate >= '".$from."' "; 
	    $where .= " and leaveToDate <= '".$to."' "; 
	    $where .= " and  companyId = '".$company->getId()."' ";  
	    $sqlString = "SELECT employeeName,LkpLeaveTypeId,leaveName,
                      CONVERT(varchar(10),leaveFromDate,120) as leaveFromDate ,
                      CONVERT(varchar(10),leaveToDate,120) as leaveToDate,
                      isLeaveAllowanceRequired,isAdvanceSalaryRequired,address,
                      daysApproved,holidayLieu,publicHoliday,leaveYear,leaveAddedDate
                      FROM Leave l
                      inner join EmpEmployeeInfoMain m on m.employeeNumber = l.employeeId
                      inner join LkpLeaveType lt on lt.id = l.LkpLeaveTypeId
                      left join Position p on p.id = m.empPosition
                      left join Section s on s.id = p.section 
                      left join Department d on d.id = s.department 
 				      $where
				      order by leaveFromDate desc ";
	    //echo $sqlString;
	    //exit; 
	    return $this->adapter->query($sqlString)->execute(); 
	}
	
	public function employeeLeaveCompleteDtls($employeeNumber,DateRange $dateRange = null) {
		// @todo to write condition 
	    //$companyId = $company->getId();
	    $adapter = $this->adapter;
	    $qi = function($name) use ($adapter) {
	        return $adapter->platform->quoteIdentifier($name);
	    }; 
	    $fp = function($name) use ($adapter) {
	        return $adapter->driver->formatParameterName($name);
	    };
	    $top = 100; 
	    $where = " where (1=1) ";
	    /*$fromDate = $values['fromDate'];
	    $toDate = $values['toDate'];
	    $isNoAttendance = $values['noAttendanceReason'];
	    $location = $values['locationAttendance'];
	    $department = $values['departmentAttendance'];
	    $fromTime = $values['fromTime'];
	    $toTime = $values['toTime'];
	    $type = $values['reportType'];
	    $emp = $values['empIdAttendance'];
	    if($isNoAttendance) {
	        $where .= " and noAttendanceReason = '".$isNoAttendance."' ";
	    }
	    if($location) {
	        $where .= " and p.positionLocation = '".$location."' ";
	    }
	    if($emp) {
	        $where .= " and e.cardId = '".$emp."' ";
	    }
	    if($department) {
	        $where .= " and se.department = '".$department."' ";
	    }
	    if($fromTime) {
	        $where .= " and startingTime >= '".$fromTime."' ";
	    }
	    if($toTime) {
	        $where .= " and endingTime <= '".$toTime."' ";
	    }
	    if($type == 1) {
	        $where .= " and (isAbscent = '1' and isAbscentJustified = '1') ";
	    }
	    if($type == 2) {
	        $where .= " and (isAbscent = '1' and isAbscentJustified = '0') ";
	    }
	    //
	    $where .= " and attendanceDate >= '".$fromDate."' ";
	    $where .= " and attendanceDate <= '".$toDate."' "; */ 
	    // CONVERT(varchar(12),attendanceDate,106) as attendanceDt 
		$sqlString = "SELECT top 100 employeeName,LkpLeaveTypeId,
                      leaveFromDate,
                      leaveToDate,
                      isLeaveAllowanceRequired,isAdvanceSalaryRequired,address,
                      daysApproved,holidayLieu,publicHoliday,leaveYear,leaveAddedDate
                      FROM Leave l
                      inner join EmpEmployeeInfoMain m on m.employeeNumber = l.employeeId
				      $where
				      order by leaveFromDate desc "; 
		//WHERE employeeId = '".$employeeNumber."'
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
	
	public function getEmployeeEntitlement($yearsOfService,$companyId) {
		// $predicate = new Predicate();
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'LeaveEntitlement'))
		       ->columns(array('numberOfDays'))
		       //->join(array('ep' => 'EmpEmployeeInfoMain'),'ep.employeeNumber = e.employeeId',
				     // array('employeeName'))
		       ->where(array('yearsOfService' => $yearsOfService))
		       ->where(array('companyId' => $companyId)) 
		;  
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString;
		//exit;
		$results = $this->adapter->query($sqlString)->execute()->current();  
		if($results) {
			return $results['numberOfDays']; 
		}   
		return 0; 
	}   
	
	public function getLastAttendanceDate() {
	    $adapter = $this->adapter;
	    $qi = function($name) use ($adapter) {
	        return $adapter->platform->quoteIdentifier($name);
	    };
	    $fp = function($name) use ($adapter) {
	        return $adapter->driver->formatParameterName($name);
	    };
	    
	    $statement = $adapter->query("SELECT top 1 lastPreparedDate
			FROM AttendancePreparedDate
            ORDER BY lastPreparedDate DESC
		"); 
	    //echo $statement->getSql();
	    //exit;
	    $row = $statement->execute()->current();
	    if($row['lastPreparedDate']) {
	        return $row['lastPreparedDate'];
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
	
	/*public function getAllLocationOvertime() { 
		$sql = $this->getSql(); 
		$select = $sql->select(); 
		$select->from(array('a' => 'AttendanceLocationWorkingHrs'))
		       ->columns(array('DayName','Status','WorkingHours','location'))
		       //->where(array('isActive' => 1))
		       //->where(array('employeeNumber' => '1264'))
		;  
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString;
		//exit;
		$results = $this->adapter->query($sqlString)->execute(); 
		if($results) {
			return array_values(iterator_to_array($results));
			//return $results;
		}
		return 0;
	}*/ 
	
	/*
	 select locationGroup,agt.eventId,DayName,Status,
	 convert(varchar(5),cast(DATEADD(ms,DATEDIFF(ms,'00:00',WorkingHours),'00:00') as time),108) as WorkingHours,
	 convert(varchar(5),cast(DATEADD(ms,DATEDIFF(ms,'00:00',startTime),'00:00') as time),108) as startTime,
	 convert(varchar(5),cast(DATEADD(ms,DATEDIFF(ms,'00:00',endTime),'00:00') as time),108) as endTime
	 from AttendanceEventGroupTiming agt
	 inner join AttendanceEvent ae on ae.id = agt.eventId
	 inner join AttendanceEventDuration ad on ad.eventId = ae.id
	 inner join AttendanceGroup ag on ag.id = agt.locationGroup 
	 inner join AttendanceLocationGroup al on al.attendanceGroupId = ag.id
	 where agt.locationGroup =1 and al.locationId = 1 and agt.eventId = 2
	 and (ad.startingDate >= '2017-11-01' or ad.endingDate <= '2017-11-01')
	 */
	
	public function getAllLocationOvertime() {
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		};
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		}; 
		$statement = $adapter->query("
			select DayName,Status,locationGroup, 
			convert(varchar(5),cast(DATEADD(ms,DATEDIFF(ms,'00:00',WorkingHours),'00:00') as time),108) as WorkingHours,
			convert(varchar(5),cast(DATEADD(ms,DATEDIFF(ms,'00:00',startTime),'00:00') as time),108) as startTime,
			convert(varchar(5),cast(DATEADD(ms,DATEDIFF(ms,'00:00',endTime),'00:00') as time),108) as endTime
			from AttendanceLocationWorkingHrs 
		"); 
		$sqlString = $statement->getSql(); 
		//echo $statement->getSql();
		//exit;  
		$results = $this->adapter->query($sqlString)->execute();
		//$results = $statement->execute()->current();
		if($results) {
			return array_values(iterator_to_array($results)); 
		}
		return array(); 
	} 
	
	// @todo 
	public function getAllActiveEmployee() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'EmpEmployeeInfoMain'))
			   ->columns(array('employeeNumber'))
			   //->join($name, $on) 
			   ->join(array('p' => 'Position'),'p.id = e.empPosition',
			   		array('positionLocation'))
			   ->where(array('isActive' => 1))
			   //->where(array('employeeNumber' => '1264'))
		; 
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//
	     //echo $sqlString; 
		// exit; 
		$results = $this->adapter->query($sqlString)->execute();
		if($results) {
			return $results;
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
	
	public function fetchStatingTime($employeeId,$starting,$ending) {
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		};
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};
		
		$statement = $adapter->query("SELECT top 1 EnrollNumber,sTime
			FROM attendance_Raw
			WHERE (sTime >= '".$starting."' AND sTime <= '".$ending."')
			AND EnrollNumber = '".$employeeId."' ORDER BY sTime ASC
		"); 
		//echo $statement->getSql();
		//exit; 
		$row = $statement->execute()->current(); 
		if($row['sTime']) {
		    return $row['sTime']; 
		}
		return '00:00'; 
	}
	
	public function fetchEndingTime($employeeId,$starting,$ending) {
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		};
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};
	
		$statement = $adapter->query("SELECT top 1 EnrollNumber,sTime
			FROM attendance_Raw
			WHERE (sTime >= '".$starting."' AND sTime <= '".$ending."')
			AND EnrollNumber = '".$employeeId."' ORDER BY sTime DESC
		");
		//echo $statement->getSql();
		//exit; 
		$row = $statement->execute()->current();
		if($row['sTime']) {
			return $row['sTime'];
		}
		return '00:00';
	}
		
	/*	$predicate = new Predicate();
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'attendance_Raw'))
		       ->columns(array('EnrollNumber','sTime'))
			   ->where($predicate->greaterThanOrEqualTo('sTime',$starting))
			   ->where($predicate->lessThanOrEqualTo('sTime',$ending))
		       // ->where(array('sTime' => $lastDate))
				->where(array('EnrollNumber' => $employeeId))
				->order('sTime ASC') 
		; 
		$sqlString = $sql->getSqlStringForSqlObject($select);
		echo $sqlString;
		exit;
		$result = $this->adapter->query($sqlString)->execute(); 
		if($result) {
			return $result; 
		} 
		return array();
	}*/
	
}