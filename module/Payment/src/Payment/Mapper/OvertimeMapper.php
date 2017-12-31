<?php 

namespace Payment\Mapper; 

use Application\Abstraction\AbstractDataMapper; 
use Zend\Db\Sql\Expression;   
use Payment\Model\DateRange; 
use Payment\Model\OvertimeEntity;
use Zend\Db\Sql\Predicate\Predicate;
use Zend\Db\Sql\Sql;

class OvertimeMapper extends AbstractDataMapper { 
	
	protected $entityTable = "OvertimeByEmployee"; 
	
	protected $attendanceTable = "EmployeeAttendance"; 
	
	protected function loadEntity(array $row) { 
		$entity = new OvertimeEntity(); 
		return $this->arrayToEntity($row,$entity); 
	} 
    // 
	public function selectEmployeeOvertime($employeeNumber) { 
		$sql = $this->getSql(); 
		$select = $sql->select(); 
		$select->from(array('e' => $this->entityTable))
			   ->columns(array('id','empIdOvertime','employeeNoNOHours',
			   		           'employeeNoHOHours',
			   		           'otStatus','endorsedDate','supervisorComments','hrComments')) 
			   ->join(array('ep' => 'EmpEmployeeInfoMain'),'ep.employeeNumber = e.empIdOvertime',
				      array('employeeName'))
			   ->join(array('os' => 'OvertimeStatus'), 'os.id = e.otStatus',
				      array('overtimeStatus')) 
			   ->where(array('empIdOvertime' => $employeeNumber));    
			   //echo $select->getSqlString(); 
			   //exit;   
		return $select;     
	}    
	
	public function selectEmployeeAttendance($arr,$ids) { 
		$predicate = new Predicate();
		$sql = $this->getSql();
		$select = $sql->select(); 
		$select->from(array('e' => $this->attendanceTable))
		       ->columns(array('id','cardId','startingTime','endingTime',
		      		'difference','duration','noOfMeals',
		      		'attendanceDate' => new Expression('CONVERT(varchar(12),attendanceDate,107)'),
		      		'normalHour' => new Expression('CONVERT(varchar(5),normalHour,108)'), 
		      		'holidayHour' => new Expression('CONVERT(varchar(5),holidayHour,108)')
		       )) 
		       ->where($predicate->greaterThanOrEqualTo('attendanceDate',$arr['from']))
		       ->where($predicate->lessThanOrEqualTo('attendanceDate',$arr['to']))
			   ->where(array('cardId' => $arr['emp'])) 
			  //->where($predicate->greaterThan('difference',0)) 
		;   
        if($ids) {
            $select->where($predicate->notIn('empOtId',$ids));
	    }
	    $select->order('attendanceDate ASC');
		//echo $select->getSqlString(); 
		//exit;
		return $select;  
	} 
	
	public function selectEmployeeManualAttendance() {
	    //$predicate = new Predicate(); 
	    $sql = $this->getSql(); 
	    $select = $sql->select(); 
	    $select->from(array('e' => 'OvertimeByEmployee'))
	           ->columns(array('id','empIdOvertime','employeeNoNOHours','employeeNoHOHours',
	               'numberOfMeals','otStatus',
        	        'startingDate' => new Expression('CONVERT(varchar(12),startingDate,107)'),
        	        'endingDate' => new Expression('CONVERT(varchar(12),endingDate,107)'),
        	       // 'holidayHour' => new Expression('CONVERT(varchar(5),holidayHour,108)')
        	   ))
        	   ->join(array('ep' => 'EmpEmployeeInfoMain'),'ep.employeeNumber = e.empIdOvertime',
        	       array('employeeName'))
    	      //->where($predicate->greaterThanOrEqualTo('attendanceDate',$arr['from']))
    	      //->where($predicate->lessThanOrEqualTo('attendanceDate',$arr['to']))
    	      ->where(array('otStatus' => 3))
    	      //->where($predicate->notIn('empOtId',$ids))
    	      //->order('attendanceDate ASC')
    	    //->where($predicate->greaterThan('difference',0))
    	;  
	    //echo $select->getSqlString();
	    //exit;
	    return $select; 
	}
	
	public function removeManualOt($id) {
	    $sql = $this->getSql();
	    $delete = $sql->delete('OvertimeByEmployee');
	    $delete->where(array(
	        'id' => $id
	    ));
	    //$sqlString = $delete->getSqlString();
	    $sqlString = $sql->getSqlStringForSqlObject($delete);
	    return $this->adapter->query($sqlString)->execute()->count();
	}
	
	public function getSubmittedOtIds($arr) { 
		$adapter = $this->adapter; 
		$qi = function($name) use ($adapter) { 
			return $adapter->platform->quoteIdentifier($name); 
		}; 
		$fp = function($name) use ($adapter) { 
			return $adapter->driver->formatParameterName($name); 
		}; 
		$statement = $adapter->query("
				select id from OvertimeByEmployee where
		(startingDate >= '".$arr['from']."' AND startingDate <= '".$arr['to']."')
		or
		(endingDate >= '".$arr['from']."' AND endingDate <= '".$arr['to']."')
		AND empIdOvertime = '".$arr['emp']."'  
		");   
		//echo $statement->getSql(); 
		//exit; 
		$row = $statement->execute();   
		if($row) {
			$i = array();
			foreach ($row as $r) {
				$i[] = $r['id']; 
			} 
			if($i) {
			    return $i;    
			}  
		}
		return 0;
     
	}
	//->join(array('ec' => 'EmployeeIdCard'), 'ec.idCard = e.cardId',
	//array('idCard'))
	//->join(array('ep' => 'EmpEmployeeInfoMain'),'ep.employeeNumber = ec.employeeIdIdCard',
	//array('employeeName'))
	public function updateAttendance($array) { 
		$sql = $this->getSql();
		$update = $sql->Update($this->attendanceTable);
		//$update->set($array); 
		$id = $array['id'];
		unset($array['id']);
		$update->set($array);
		$update->where(array(
				'id' => $id
		)); 
		//$sqlString = $update->getSqlString(); 
		$sqlString = $sql->getSqlStringForSqlObject($update);  
		//echo $sqlString;
		//exit;
		return $this->adapter->query($sqlString)->execute()->count();
	}
	
	public function updateEmployeeAttendance($updateAtten,$from,$to,$empId) {
		$predicate = new Predicate();
		$sql = $this->getSql();
		$update = $sql->Update($this->attendanceTable);
		$update->set($updateAtten);
		$update->where($predicate->greaterThanOrEqualTo('attendanceDate',$from)); 
		$update->where($predicate->lessThanOrEqualTo('attendanceDate',$to));
		$update->where(array('cardId' => $empId)); 
		//$sqlString = $update->getSqlString();
		$sqlString = $sql->getSqlStringForSqlObject($update);
		//echo $sqlString; 
		//exit; 
		return $this->adapter->query($sqlString)->execute()->count();
	}
	
	public function getOvertimeFormList() {
		// $this->fetchById($id)
		$predicate = new Predicate();
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('*'))
		       ->where($predicate->lessThanOrEqualTo('otStatus',1))
		       //->where(array('isCanceled' => 0))
		       //->where(array('isApproved' => 0))
		       //->where($predicate->lessThanOrEqualTo('approvedLevel','approvalLevel') )
		; 
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString; 
		//exit; 
		return $this->adapter->query($sqlString)->execute(); 
	}  
	
	public function getAttenDetails($id) { 
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->attendanceTable))
		       ->columns(array('id','cardId','startingTime','endingTime',
		      		'difference','duration','noOfMeals',
		      		'attendanceDate' => new Expression('CONVERT(varchar(12),attendanceDate,107)'),
		      		'normalHour' => new Expression('CONVERT(varchar(5),normalHour,108)'), 
		      		'holidayHour' => new Expression('CONVERT(varchar(5),holidayHour,108)')))
		       ->where(array('empOtId' => $id)) 
		       ->order('attendanceDate asc')
		;  
		$sqlString = $sql->getSqlStringForSqlObject($select); 
		//echo $sqlString;
		//exit;
		return $this->adapter->query($sqlString)->execute();
	}
	
	public function fetchAllEndorsedOt() {
		$sql = $this->getSql();
		$select = $sql->select(); 
		$select->from(array('e' => $this->attendanceTable))
		       ->columns(array('id','cardId','attendanceDate','normalHour',
		                       'holidayHour','noOfMeals'))
				->where(array('isUsed' => 0))
				->where(array('isEndorsed' => 1)) 
				//->order('attendanceDate asc')
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString;
		//exit;
		return $this->adapter->query($sqlString)->execute();  
	}
	
	public function getOvertimeFormWaitingAppList() {
		$predicate = new Predicate();
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('*'))
		       ->where($predicate->greaterThan('otStatus',1))
		       ->where($predicate->lessThan('otStatus',5))
		       
		//->where(array('isCanceled' => 0))
		//->where(array('isApproved' => 0))
		//->where($predicate->lessThanOrEqualTo('approvedLevel','approvalLevel') )
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString;
		//exit;
		return $this->adapter->query($sqlString)->execute();
	}
	
	// $ids List
	public function getOvertimeFormApprovalList($ids) {
		$predicate = new Predicate();
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('id','empIdOvertime','numberOfMeals',
		       		'startingDate' => new Expression('CONVERT(varchar(12),startingDate,107)'),
		       		'endingDate' => new Expression('CONVERT(varchar(12),endingDate,107)'),
		       		'employeeNoNOHours' => new Expression('CONVERT(varchar(5),employeeNoNOHours,108)'),
		       		'employeeNoHOHours' => new Expression('CONVERT(varchar(5),employeeNoHOHours,108)'),
			   		'otStatus','endorsedDate','supervisorComments','hrComments')) 
			   ->join(array('ep' => 'EmpEmployeeInfoMain'),'ep.employeeNumber = e.empIdOvertime',
				      array('employeeName'))
			   ->join(array('os' => 'OvertimeStatus'), 'os.id = e.otStatus',
				      array('overtimeStatus'))
			   ->where(array('e.otStatus' => 2))
		; 
		$select->where($predicate->In('e.id',$ids)); 
		//echo $select->getSqlString(); 
		//exit;
		return $select; 
	}
	
	public function endorseAllByHr() {
	    $select = $this->getOvertimeFormApprovalListHr('1'); 
	    $sql = $this->getSql();
	    /*$select = $sql->select();
	    $select->from(array('e' => $this->entityTable))
        	    ->columns(array('*'))
        	    ->where($predicate->greaterThan('otStatus',1))
        	    ->where($predicate->lessThan('otStatus',5))
	    
	    //->where(array('isCanceled' => 0))
	    //->where(array('isApproved' => 0))
	    //->where($predicate->lessThanOrEqualTo('approvedLevel','approvalLevel') )
	    ;*/
	    $sqlString = $sql->getSqlStringForSqlObject($select);
	    //echo $sqlString;
	    //exit;
	    return $this->adapter->query($sqlString)->execute();
	}
	
	public function getOvertimeFormApprovalListHr($ids) {
	    $predicate = new Predicate();
	    $sql = $this->getSql();
	    $select = $sql->select();
	    $select->from(array('e' => $this->entityTable))
	           ->columns(array('id','empIdOvertime','numberOfMeals',
                	        'startingDate' => new Expression('CONVERT(varchar(12),startingDate,107)'),
                	        'endingDate' => new Expression('CONVERT(varchar(12),endingDate,107)'),
                	        'employeeNoNOHours',
                	        'employeeNoHOHours',
                	        'otStatus','endorsedDate','supervisorComments','hrComments'))
	           ->join(array('ep' => 'EmpEmployeeInfoMain'),'ep.employeeNumber = e.empIdOvertime',
	                  array('employeeName'))
	           ->join(array('os' => 'OvertimeStatus'), 'os.id = e.otStatus',
	                  array('overtimeStatus'))
	           ->where(array('e.otStatus' => 3))
	    ;
	    //\Zend\Debug\Debug::dump($ids);//     echo $ids;
	    //if($ids) {
	        //$select->where($predicate->In('e.id',$ids));
	    //}
	    //echo $select->getSqlString();
	    //exit;
	    return $select;
	}
	
	public function getOvertimeById($id) {
		// $predicate = new Predicate();
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('id','empIdOvertime','numberOfMeals',
				   'startingDate' => new Expression('CONVERT(varchar(12),startingDate,107)'),
				   'endingDate' => new Expression('CONVERT(varchar(12),endingDate,107)'),
				   'employeeNoNOHours' => new Expression('CONVERT(varchar(5),employeeNoNOHours,108)'),
				   'employeeNoHOHours' => new Expression('CONVERT(varchar(5),employeeNoHOHours,108)'),
				   'otStatus','endorsedDate','supervisorComments','hrComments'))
			   ->join(array('ep' => 'EmpEmployeeInfoMain'),'ep.employeeNumber = e.empIdOvertime',
					  array('employeeName'))
			   ->join(array('os' => 'OvertimeStatus'), 'os.id = e.otStatus',
					  array('overtimeStatus'))
		;
		$select->where(array('e.id' => $id));  
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString;
		//exit;
		return $this->adapter->query($sqlString)->execute()->current(); 
		// return $results;
	}
	
	/*public function fetchOtById($id) {
		$this->setEntityTable($this->entityTable); 
		$this->fetchById($id); 
	}*/
	
	// select only waiting for approval based on user 
	public function selectApprovalOvertime($employeeNumber) {
	    	
	}
	
	// select only waiting for HR Endorsement 
	public function selectEndorseOvertime() { 
	        
	} 
	
	public function getEmployeeOvertimeHours($employeeNumber) {
		$adapter = $this->adapter; 
		$qi = function($name) use ($adapter) { 
			return $adapter->platform->quoteIdentifier($name); 
		}; 
		$fp = function($name) use ($adapter) { 
			return $adapter->driver->formatParameterName($name); 
		}; 
		$statement = $adapter->query("
				select top 1 employeeNoNOHours,
			    employeeNoHOHours,month,year from OvertimeByEmployee where 
                otStatus <= '1' and  empIdOvertime = '".$employeeNumber."' order by id desc  
		");   
		//echo $statement->getSql(); 
		//exit; 
		$row = $statement->execute()->current(); 
		if($row) {
		    return $row;    
		}   
		return 0; 
	}  
	
	public function getAttendanceReport($company,$values) { 
		$companyId = $company->getId(); 
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		};
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};
		$where = " where (1=1) ";
		$fromDate = $values['fromDate'];
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
		$where .= " and attendanceDate <= '".$toDate."' ";  
		//$order = " order by c.effectiveDate,c.id ASC"; 
		$statement = $adapter->query("
				select departmentName,employeeName,locationName,cardId,attendanceDate,
				CONVERT(varchar(12),attendanceDate,106) as attendanceDt,
				startingTime,endingTime,duration,difference,dayStatus,description,
				noTransaction,overTime,lateEntryReason,
				CASE WHEN isLateEntry = 1 THEN 'Yes' ELSE 'No' END AS isLateEntry,
				CASE WHEN isEarlyExit = 1 THEN 'Yes' ELSE 'No' END AS isEarlyExit,
				CASE WHEN isNoAttendance = 1 THEN 'Yes' ELSE 'No' END AS isNoAttendance,
				earlyExitReason,reason
				from EmployeeAttendance e 
				inner join EmpEmployeeInfoMain em on em.employeeNumber = e.cardId
				left join Position p on P.id = em.empPosition   
				left join Location l on l.id = p.positionLocation
			    left join section se on se.id = p.section
			    left join Department d on d.id = se.department 
			    left join NoAttendanceReason n on n.id = e.noAttendanceReason
				$where
				order by attendanceDate desc
		");    
		//echo $statement->getSql(); 
		//exit; 
		$row = $statement->execute();   
		if($row) { 
			return $row; 
		} 
		return 0; 
	} 
	
	public function getAttendanceOtSum($arr,$ids) {
		//\Zend\Debug\Debug::dump($ids);
		//exit; 
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		};
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		}; 
		$wh = " "; 
		if($ids) {
		    $i = implode(",",$ids);
		} 
		if($i) {
		    $wh = " and empOtId not in(".$i.")"; 
		}
		//\Zend\Debug\Debug::dump($ids);
		//exit;
		$statement = $adapter->query("
				select 
				convert(varchar(5),cast(DATEADD(ms, SUM(DATEDIFF(ms, '00:00', normalHour)), '00:00') as time),108) as normalHour,
				convert(varchar(5),cast(DATEADD(ms, SUM(DATEDIFF(ms, '00:00', holidayHour)), '00:00') as time),108) as holidayHour,
				sum(noOfMeals) as noOfMeals from EmployeeAttendance where
                 cardId = '".$arr['emp']."' and attendanceDate >= '".$arr['from']."'
				and attendanceDate <= '".$arr['to']."'  
				
		"); 
		// isUsed = 0 and
		// echo $statement->getSql();
		// exit; 
		$row = $statement->execute()->current();
		if($row) {
			return $row;
		}
		return array(); 
	} 
	
	public function saveEmpOt($empOt) {
		$sql = $this->getSql(); 
		$insert = $sql->Insert($this->entityTable);	
		$insert->values($empOt);
		$sqlString = $sql->getSqlStringForSqlObject($insert);
		$sqlString = $insert->getSqlString();
		//echo $sqlString."<br />";
		//exit;
		$res = $this->adapter->query($sqlString)->execute();
		$id = $res->getGeneratedValue(); 
		return $id; 		
	}
	
	public function insertOtAttendancePaysheet($arr) { 
		$sql = $this->getSql();
		$insert = $sql->Insert('OtAttendancePaysheet');
		$insert->values($arr);
		$sqlString = $sql->getSqlStringForSqlObject($insert);
		$sqlString = $insert->getSqlString();
		//echo $sqlString."<br />";
		//exit;
		$res = $this->adapter->query($sqlString)->execute();
		$id = $res->getGeneratedValue();
		return $id;
	} 
	
	
	/*public function insertOtPaysheet($arr) {
	    $sql = $this->getSql();
	    $insert = $sql->Insert('OtAttendancePaysheet');
	    $insert->values($arr);
	    $sqlString = $sql->getSqlStringForSqlObject($insert);
	    $sqlString = $insert->getSqlString();
	    //echo $sqlString."<br />";
	    //exit;
	    $res = $this->adapter->query($sqlString)->execute();
	    $id = $res->getGeneratedValue();
	    return $id;
	}*/
	
	public function insertOtMealPaysheet($arr) {
	    $sql = $this->getSql();
	    $insert = $sql->Insert('mealDtls');
	    $insert->values($arr);
	    $sqlString = $sql->getSqlStringForSqlObject($insert);
	    $sqlString = $insert->getSqlString();
	    //echo $sqlString."<br />";
	    //exit;
	    $res = $this->adapter->query($sqlString)->execute();
	    $id = $res->getGeneratedValue();
	    return $id;
	}
	
	/*public function updateOtByEmployee() {
	    $adapter = $this->adapter;
	    $qi = function($name) use ($adapter) {
	        return $adapter->platform->quoteIdentifier($name);
	    };
	    $fp = function($name) use ($adapter) {
	        return $adapter->driver->formatParameterName($name);
	    };
	    $statement = $adapter->query("
				update OvertimeByEmployee set otStatus =  otStatus + 1 where
                id = '".$id."'
		");
	    //echo $statement->getSql();
	    //exit;
	    $row = $statement->execute();
	    if($row) {
	        return 1;
	    }
	    return 0;
	}*/
	
	public function saveManualOt($arr) {
	    $sql = $this->getSql();
	    $insert = $sql->Insert('OvertimeByEmployee');  
	    $insert->values($arr);
	    $sqlString = $sql->getSqlStringForSqlObject($insert);
	    $sqlString = $insert->getSqlString();
	    //echo $sqlString."<br />";
	    //exit;
	    $res = $this->adapter->query($sqlString)->execute();
	    $id = $res->getGeneratedValue();
	    return $id;
	}
	
	/*public function saveAndSubmitOvertime($data) {  
	    return $this->insert($data);       	
	}*/ 
    
	public function isHaveThisMonthOt($user,DateRange $dateRange) {
		
		$from = $dateRange->getFromDate(); 
		//\Zend\Debug\Debug::dump($from);
		//exit; 
		
		list($year,$month,$day) = explode('-', $from); 
		//\Zend\Debug\Debug::dump($month);
		//\Zend\Debug\Debug::dump($year);
		//exit; 
		$adapter = $this->adapter; 
		$qi = function($name) use ($adapter) { 
			return $adapter->platform->quoteIdentifier($name); 
		}; 
		$fp = function($name) use ($adapter) { 
			return $adapter->driver->formatParameterName($name); 
		}; 
		$statement = $adapter->query("
				select top 1 employeeNoNOHours,
			   		           employeeNoHOHours from OvertimeByEmployee where 
                empIdOvertime = '".$user."' 
				and month = '".$month."' and year = '".$year."'
				order by id desc  
		");      
		//echo $statement->getSql(); 
		//exit; 
		$row = $statement->execute()->current();  
		if($row) { 
		    return $row;    
		}   
		return 0;    
	} 
	
	public function isWaitingForApproval($id) {   
		$adapter = $this->adapter; 
		$qi = function($name) use ($adapter) { 
			return $adapter->platform->quoteIdentifier($name); 
		}; 
		$fp = function($name) use ($adapter) { 
			return $adapter->driver->formatParameterName($name); 
		}; 
		$statement = $adapter->query("
				select id from OvertimeByEmployee where 
                otStatus > '1' and otStatus < '4' and  id = '".$id."' 
				 
		");     
		//echo $statement->getSql(); 
		//exit; 
		$row = $statement->execute()->current(); 
		if($row['id']) {
			return 1;    
		}   
		return 0;    
	}   
    
	public function supervisorApproval($id) { 
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		};
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};
		$statement = $adapter->query("
				update OvertimeByEmployee set otStatus =  otStatus + 1 where
                id = '".$id."' 		
		");
		//echo $statement->getSql();  
		//exit;
		$row = $statement->execute(); 
		if($row) { 
			return 1; 
		}
		return 0; 
	} 
	
	// @todo @todo delete instead of update 
	public function supervisorReject($id) {
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		};
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};
		// update OvertimeByEmployee set otStatus =  1
		$statement = $adapter->query("
				update OvertimeByEmployee set otStatus =  1 where
                id = '".$id."'
				
		");
		//echo $statement->getSql();
		//exit;
		$row = $statement->execute();
		if($row) {
			return 1;
		}
		return 0; 
	} 
	
	public function reverseAttendance($id) {
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		};
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};
		// update OvertimeByEmployee set otStatus =  1
		$statement = $adapter->query("
				update EmployeeAttendance set empOtId =  0 where
                empOtId = '".$id."'
		");
		//echo $statement->getSql();
		//exit;
		$row = $statement->execute();
		if($row) {
			return 1;
		}
		return 0;
	} 
	
	public function isAllowedToEdit($id) {
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		};
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};
		$statement = $adapter->query("
				select  id from OvertimeByEmployee where
                otStatus <= '1' and  id = '".$id."'
				
		"); 
		//echo $statement->getSql();
		//exit;
		$row = $statement->execute()->current();
		if($row['id']) {
			return 1;
		}
		return 0; 
	}
	
}