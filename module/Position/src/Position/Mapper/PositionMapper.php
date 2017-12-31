<?php  
namespace Position\Mapper;

use Position\Model\Position,
    Application\Abstraction\AbstractDataMapper, 
    Application\Contract\EntityCollectionInterface, 
    Application\Contract\DataMapperInterface, 
    Zend\Db\Adapter\Adapter as zendAdapter;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Predicate\Predicate; 

class PositionMapper extends AbstractDataMapper {
	
	protected $entityTable = "Position";
	
	protected $positionMovement = "PositionMovement"; 
	
	protected $posMomtHist = "PositionMovementHistory"; 
    	
	protected function loadEntity(array $row) { 
		 $entity = new Position(); 
		 return $this->arrayToEntity($row,$entity); 
	} 
	
	public function getPositionMovementList() { 
		$sql = $this->getSql(); 
		$select = $sql->select(); 
		$select->from(array('pm' => 'PositionMovement'))
		       ->columns(array('id','positionId','employeeId','currentPositionId'))
		       ->join(array('p' => $this->entityTable),'p.id = pm.positionId',
		           array('positionNam' => new Expression(" levelName+ ' ' +p.positionName")))
		      ->join(array('pc' => $this->entityTable),'pc.id = pm.currentPositionId',
		             array('positionNamCurr' => new Expression(" levelName+ ' ' +pc.positionName")))
		       ->join(array('pl' => 'PositionLevel'),'pl.levelSequence = p.organisationLevel',
		                  array('levelName'),'left')
		       ->join(array('ep' => 'EmpEmployeeInfoMain'),'ep.employeeNumber = pm.employeeId',
		       		  array('employeeName'))
		       //->join(array('l' => 'Location'), 'e.locationId = l.id', 
		       		//array('locationName'))
		; 
		//echo $select->getSqlString(); 
		//exit; 
		return $select; 
	}  
	
	public function getDelegationList() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('d' => 'EmployeeDelegation'))
		       ->columns(array('id','delegatedFrom','delegatedTo'))
		       ->join(array('p' => 'EmpEmployeeInfoMain'),'p.employeeNumber = d.delegatedEmployeeId',
				      array('delegatedEmp' => 'employeeName'))
			   ->join(array('ep' => 'EmpEmployeeInfoMain'),'ep.employeeNumber = d.employeeId',
					  array('employeeName'))
			    //->join(array('l' => 'Location'), 'e.locationId = l.id',
				//array('locationName'))
				//array('positionNam' => new Expression("empType + ' ' +positionName + ' ' +shortDescription")))
		;
		//echo $select->getSqlString();
		//exit;
		return $select; 
	}
	
	public function fetchPositionMovementBuffList() { 
		$sql = $this->getSql();
		$select = $this->getPositionMovementList();  
		//$select->order('')
		//echo $select;
		//exit; 
		$sqlString = $sql->getSqlStringForSqlObject($select); 
		return $this->adapter->query($sqlString)->execute(); 
		
	}
	
	public function getVacantPositionList() { 		
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		};
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		}; 
	
		$statement = $adapter->query("SELECT p.id,
				(levelName + ' ' + positionName) as positionNam
				FROM Position p
                inner join PositionLevel pl on p.organisationLevel = pl.levelSequence
				where p.id not in (
				  select empPosition from EmpEmployeeInfoMain 
				  where positionTerminationReferenceNumber = 0
				) and status = 1 
		");
		//  and status = 1 
		//echo $statement->getSql();
		$results = $statement->execute();
		return $this->toArrayList($results,'id','positionNam');
	
	} 
	
	public function isPositionVacant($positionId) {
	    $adapter = $this->adapter;
	    $qi = function($name) use ($adapter) {
	        return $adapter->platform->quoteIdentifier($name);
	    };
	    $fp = function($name) use ($adapter) {
	        return $adapter->driver->formatParameterName($name);
	    };
	    
	    $statement = $adapter->query("SELECT p.id as posId
				FROM Position p 
				where p.id = '".$positionId."' and p.id not in (
				  select empPosition from EmpEmployeeInfoMain
				  where positionTerminationReferenceNumber = 0 
				) and status = 1
		"); 
	    //  and status = 1
	    //echo $statement->getSql();
	    //exit; 
	    $results = $statement->execute()->current();
	    if($results['posId']) {
	        return 1;
	    }
	    return 0; 
	} 
	
	public function isPositionInCurrentMovement($positionId) {
	    $sql = $this->getSql();
	    $select = $sql->select();
	    $select->from(array('p' => 'PositionMovement'))
    	       ->columns(array('id'))
    	       ->where(array('currentPositionId' => $positionId))
    	       //->where(array('empPosition' => $positionId))
	    ;
	    //echo $select->getSqlString();
	    //exit;
	    $sqlString = $sql->getSqlStringForSqlObject($select);
	    $results = $this->adapter->query($sqlString)->execute()->current();
	    if($results['id']) {
	        return 1;
	    }
	    return 0;
	}
	
	// getTopOneVacantPosition  
	public function getTopOneVacantPosition() { 
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		};
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};
		$statement = $adapter->query("SELECT id_in_hr, is_in_new_system
                                     FROM " . $qi('Mapping_Employee_Id') . " AS c
		");
		//echo $statement->getSql();
		$results = $statement->execute()->current();  	
	}
	
	public function savePositionMovement($data) {
		$sql = $this->getSql(); 
		$insert = $sql->Insert('PositionMovement'); 
		$insert->values($data); 
		$sqlString = $sql->getSqlStringForSqlObject($insert);  
		$res = $this->adapter->query($sqlString)->execute(); 
		return $res->getGeneratedValue(); 
	} 
	
	public function saveDelegation($data) {
		$sql = $this->getSql();
		$insert = $sql->Insert('EmployeeDelegation'); 
		$insert->values($data);
		$sqlString = $sql->getSqlStringForSqlObject($insert);
		$res = $this->adapter->query($sqlString)->execute();
		return $res->getGeneratedValue();
	} 
	
	public function savePositionMovementHist($data) {
		$sql = $this->getSql();
		$insert = $sql->Insert($this->posMomtHist);
		$insert->values($data);
		$sqlString = $sql->getSqlStringForSqlObject($insert);
		$res = $this->adapter->query($sqlString)->execute();
		return $res->getGeneratedValue();
	}
	
	public function isEmployeeAlreadyInCurrentPosition($employeeId,$positionId) {
		//EmpEmployeeInfoMain
		// return 0;
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'EmpEmployeeInfoMain'))
		       ->columns(array('id'))
		       ->where(array('employeeNumber' => $employeeId))
		       ->where(array('empPosition' => $positionId))
		;       
		//echo $select->getSqlString(); 
		//exit; 
		$sqlString = $sql->getSqlStringForSqlObject($select);  
		$results = $this->adapter->query($sqlString)->execute()->current();   
		if($results['id']) { 
			return 1;  
		}   
		return 0;  
	}

	public function isHaveSubordinatesByPosition($positionId) {
		//EmpEmployeeInfoMain
		// return 0;
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('id'))
		       ->where(array('reportingPosition' => $positionId))
		;
		//echo $select->getSqlString();
		//exit;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute()->current();
		if($results['id']) {
			return 1;
		}
		return 0; 
	}
	
	public function isNonExecutive($positionId) {
		//EmpEmployeeInfoMain
		// return 0;
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('organisationLevel'))
		       ->where(array('id' => $positionId))
		;
		//echo $select->getSqlString();
		//exit;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute()->current();
		if($results['organisationLevel'] == 6) {
			return 1;
		}
		return 0;
	}
	
	public function removePositionMovement($id) {
        		
		$sql = $this->getSql();
		$delete = $sql->delete('PositionMovement');
		$delete->where(array(
				'id' => $id
		)); 
		//$sqlString = $delete->getSqlString();
		$sqlString = $sql->getSqlStringForSqlObject($delete);
		return $this->adapter->query($sqlString)->execute()->count();
	}
	
	public function removeDelegation($id) {
        		
		$sql = $this->getSql();
		$delete = $sql->delete('EmployeeDelegation');
		$delete->where(array(
				'id' => $id
		)); 
		//$sqlString = $delete->getSqlString();
		$sqlString = $sql->getSqlStringForSqlObject($delete);
		return $this->adapter->query($sqlString)->execute()->count();
	} 
	
	public function getPositionNameById($positionId) {
		$predicate = new Predicate();
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('id',
				'positionNam' => 
		       		new Expression(" jobGrade +' - '+levelName+ ' - ' + positionName")))
		       		//->where($predicate->lessThan('organisationLevel',$id))
		       ->join(array('pl' => 'PositionLevel'),'pl.levelSequence = e.organisationLevel',
		           array('levelName'),'left')
		       ->join(array('j' => 'lkpJobGrade'),'j.id = e.jobGradeId',
		               array('jobGrade'),'left')
		       ->where(array('e.id' => $positionId))
		       ->where(array('e.status' => 1)); 
		;       
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString; 
		//exit; 
		$results = $this->adapter->query($sqlString)->execute()->current();
		if($results)   {
			return $results['positionNam'];
		}
		return 'not available'; 
	}
	
	public function getHigherPosition($id) {
		$predicate = new Predicate();
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('id',
				'positionNam' => 
		           new Expression(" levelName+ ' ' +positionName")))

		       		->join(array('pl' => 'PositionLevel'),'pl.levelSequence = e.organisationLevel',
		       		    array('levelName'),'left')
		       		->where($predicate->lessThan('organisationLevel',$id))
		       ->where(array('e.status' => 1)); 
		;       
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString; 
		//exit; 
		$results = $this->adapter->query($sqlString)->execute(); 
		return $this->toArrayList($results,'id','positionNam'); 
	} 
	
	public function getLevelByEmployee($employeeId) {
		// 
		$sql = $this->getSql(); 
		$select = $sql->select();
		$select->from(array('pe' => 'positionEmployee'))
		       ->columns(array('id','employeeId','positionId')) 
		       ->join(array('p' => 'Position'),'p.id = pe.positionId',
		              array('organisationLevel'))
		       ->where(array('employeeId' => $employeeId)) 
		; 
		$sqlString = $sql->getSqlStringForSqlObject($select); 
		$results = $this->adapter->query($sqlString)->execute()->current(); 
		return $results['organisationLevel']; 
	}
	
	public function getFirstLevelPositionId() {
		//
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('p' => 'Position'))
				->columns(array('id'))
				->where(array('organisationLevel' => 1))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
			$results = $this->adapter->query($sqlString)->execute()->current();
			return $results['id'];
	}
	
	public function getChairmanLevelPositionId() {
	    return '153';
	    /*$sql = $this->getSql();
	    $select = $sql->select();
	    $select->from(array('p' => 'Position'))
	           ->columns(array('id'))
	           ->where(array('id' => '153'))
	    ;
	    $sqlString = $sql->getSqlStringForSqlObject($select);
	    $results = $this->adapter->query($sqlString)->execute()->current();
	    return $results['id'];*/ 
	}
	
	public function getSubOrdinatesByPosition($positionId) {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('p' => 'Position'))
			->columns(array('*'))
			->where(array('reportingPosition' => $positionId))
			->where(array('status' => 1))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute();
		return $results;
	}
	
	public function updatePositionForMovement($employeeId,$positionId,$tempNumber) {
	    $adapter = $this->adapter;
	    $qi = function($name) use ($adapter) {
	        return $adapter->platform->quoteIdentifier($name);
	    };
	    $fp = function($name) use ($adapter) {
	        return $adapter->driver->formatParameterName($name);
	    };
	    $statement = $adapter->query("update ".$qi('EmpEmployeeInfoMain')." set 
                         positionTerminationReferenceNumber = '".$tempNumber."' , 
                         empPosition = '".$positionId."' where employeeNumber = '".$employeeId."'
		");
	    $statement->execute(); 
	}
	
	public function revertPositionMovementTemp($tempNumber) {
	    $adapter = $this->adapter;
	    $qi = function($name) use ($adapter) {
	        return $adapter->platform->quoteIdentifier($name);
	    };
	    $fp = function($name) use ($adapter) {
	        return $adapter->driver->formatParameterName($name);
	    };
	    $statement = $adapter->query("update ".$qi('EmpEmployeeInfoMain')." set
                         positionTerminationReferenceNumber = '0' 
                         where positionTerminationReferenceNumber = '".$tempNumber."'
		");
	    $statement->execute();
	}
	
	public function getImmediateSupervisorByEmployee($employeeId) { 
		if($this->getLevelByEmployee($employeeId) == 1) {
		    return false;
		} 
		$positionId = $this->getPositionByEmployee($employeeId); 
		$repPos = $this->getReportingPosition($positionId); 
		return $this->getEmployeeByPosition($repPos); 
	}
	
	public function getHodByEmployee($employeeId) { 
		// @todo return 
		if($this->getLevelByEmployee($employeeId) == 1) {
			return false;
		}
		$positionId = $this->getPositionByEmployee($employeeId);
		$repPos = $this->getReportingPosition($positionId);
		// @todo check the levels 
		$level = $this->getReportingLevel($repPos); 
		if($level == 2) {
			return $this->getEmployeeByPosition($repPos); 
		} else {
			$repPosOne = $this->getReportingPosition($repPos); 
			$level = $this->getReportingLevel($repPosOne);
			if($level == 2) {
				// return 0; 
				return $this->getEmployeeByPosition($repPosOne); 
			}
		}   
		return 0; 
		// return $this->getEmployeeByPosition($repPos);  
	} 
	
	// methods below here are for special 
	public function getHrManagerId() {
		// @todo 
		$positionId = 145;
		//echo "yes.......<br/>";
		return $this->getEmployeeByPosition($positionId);
		//exit; 
		// return $hrManager;
	} 
	
	public function getGmId() {
		//@todo if required 
		$positionId = 133; 
		return $this->getEmployeeByPosition($positionId);
	}
	
	public function getHrServiceId() {
		$positionId = 116;
		return $this->getEmployeeByPosition($positionId); 
	}
	
	// empType + ' ' + 
	public function getPositionList() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('id', 
		           'positionNam' => new Expression(" levelName+ ' ' +positionName")))
		->join(array('pl' => 'PositionLevel'),'pl.levelSequence = e.organisationLevel',
		    array('levelName'),'left')
		    ->where(array('e.status' => 1))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString; 
		//exit; 
		$results = $this->adapter->query($sqlString)->execute(); 
		return $this->toArrayList($results,'id','positionNam'); 
	}
	
	public function selectList() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('id','positionLocation','organisationLevel','positionName',
		           'positionNam' => new Expression(" levelName+ ' ' +positionName")))
			   ->join(array('o' => 'PositionLevel'),'o.levelSequence = e.organisationLevel',
					  array('levelName'),'left')
			   ->join(array('s' => 'Section'),'s.id = e.section',
					  array('sectionCode'),'left')
			   ->join(array('l' => 'Location'),'l.id = e.positionLocation',
					   array('locationName'),'left')
			   ->join(array('j' => 'lkpJobGrade'),'j.id = e.jobGradeId',
					  array('jobGrade'),'left')
		       //->where(array('status' => 1))
		;  
	    $sqlString = $sql->getSqlStringForSqlObject($select); 
	    //echo $sqlString; 
	    //exit; 
		return $select;  
	}    
	
	public function getEmployeeByPosition($positionId) {
		//echo $positionId."<br/>";
		$sql = $this->getSql(); 
		$select = $sql->select();
		$select->from(array('e' => 'EmpEmployeeInfoMain'))
		       ->columns(array('empPosition','employeeNumber'))
		       ->where(array('empPosition' => $positionId))
		       ->where(array('isActive' => 1))
		       ->where(array('positionTerminationReferenceNumber' => 0))
		;   
		$sqlString = $sql->getSqlStringForSqlObject($select);
        //echo $sqlString; 
		//exit; 
		$results = $this->adapter->query($sqlString)->execute()->current();  
		return $results['employeeNumber']; 
	} 
	
	public function getReportingPosition($positionId) {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('reportingPosition'))
		       ->where(array('id' => $positionId))
		       //->where(array('isActive' => 1))
		       //->where(array('positionTerminationReferenceNumber' => 0))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString;
		//exit;
		$results = $this->adapter->query($sqlString)->execute()->current();
		return $results['reportingPosition'];
	}
	
	public function getReportingLevel($positionId) {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('organisationLevel'))
		       ->where(array('id' => $positionId))
		//->where(array('isActive' => 1))
		//->where(array('positionTerminationReferenceNumber' => 0))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString;
		//exit;
		$results = $this->adapter->query($sqlString)->execute()->current();
		return $results['organisationLevel'];
	}   
	
	public function getPositionByEmployee($employeeId) {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'EmpEmployeeInfoMain'))
		       ->columns(array('empPosition','employeeNumber'))
		       ->where(array('employeeNumber' => $employeeId))
		       ->where(array('isActive' => 1))
		       ->where(array('positionTerminationReferenceNumber' => 0))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString;
		//exit;
		$results = $this->adapter->query($sqlString)->execute()->current();
		return $results['empPosition'];
	}
	
	public function isEmployeeInCurrentMovementList($employeeId) { 
		//EmpEmployeeInfoMain
		// return 0;
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->positionMovement))
		       ->columns(array('id'))
		       ->where(array('employeeId' => $employeeId))
		;
		//echo $select->getSqlString();
		//exit;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute()->current();
		if($results['id']) {
			return 1;
		}
		return 0;
	}
	
	public function fetchRowByEmployee($employeeId) {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->positionMovement))
		       ->columns(array('id','positionId','employeeId')) 
		       ->where(array('employeeId' => $employeeId)) 
		; 
		//echo $select->getSqlString(); 
		//exit; 
		$sqlString = $sql->getSqlStringForSqlObject($select); 
		$results = $this->adapter->query($sqlString)->execute()->current(); 
		if($results) {
			return $results;
		}
		return 0;
	}
	
	
}