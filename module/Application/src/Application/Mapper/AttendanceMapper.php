<?php

namespace Application\Mapper; 

use Application\Model\PositionTest,
    Application\Abstraction\AbstractDataMapper, 
    Application\Contract\EntityCollectionInterface, 
    Application\Contract\DataMapperInterface, 
    Zend\Db\Adapter\Adapter as zendAdapter;
use Application\Entity\CompanyAllowanceEntity;
use Payment\Model\Company;
use Payment\Model\DateRange;
use Payment\Model\Employee;
use Zend\Db\Sql\Predicate\Predicate;

class AttendanceMapper extends AbstractDataMapper { 
	
	protected $entityTable = "EmployeeAttendance";
	
	protected $empIdCard = "EmployeeIdCard"; 
	
	protected $attendanceSourceTable = "AttendanceSource"; 
	
	protected $allowanceType; 
	                        
	protected $companyId; 
	
	public function selectIdCard() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('i' => 'EmployeeIdCard'))
		       ->columns(array('id','idCard'))
		       ->join(array('e' => 'EmpEmployeeInfoMain'),'i.employeeIdIdCard = e.employeeNumber',
				      array('employeeName'))
			   //->join(array('a' => 'Allowance'), 's.allowanceId = a.id',
					 // array('allowanceName'))
		; 
		//echo $select->getSqlString();
		//exit;
		return $select; 
	}   
	
	public function fetchAttendanceSource() {
		$sql = $this->getSql();
		$select = $sql->select(); 
		$select->from(array('e' => $this->attendanceSourceTable)) 
		       ->columns(array('id','cardId','attendanceDate','registeredTime'))
		; 
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString; 
		//exit; 
		return $this->adapter->query($sqlString)->execute();   
	}   
	
	public function insertAttendance(array $attendanceArray) {
		$this->setEntityTable($this->entityTable); 
		$this->insert($attendanceArray); 
	}
	
	public function deleteAttendance($currDate,$cardId) {
		$adapter = $this->adapter; 
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name); 
		}; 
		$fp = function($name) use ($adapter) { 
			return $adapter->driver->formatParameterName($name); 
		}; 
		$statement = $adapter->query("delete from ".$qi($this->entityTable)." 
				    where
					cardId  = '".$cardId."' and
					attendanceDate  = '".$currDate."' 
		"); 
		//echo $statement->getSql(); 
		//exit; 
		$statement->execute(); 
	} 
	
	public function getAttendanceReport(Company $company,$param) {
		return array(); 
	}
	
	protected function loadEntity(array $row) { 
	    $companyAllowance = new CompanyAllowanceEntity(); 
	    $companyAllowance->setId($row['id']); 
	    $companyAllowance->setCompanyId($this->companyId->fetchById($row['companyId']));      
	    $companyAllowance->setAllowanceTypeId(
	    		$this->allowanceType->fetchById($row['allowanceTypeId'])
	    );  
	    return $companyAllowance;  
	} 
	
	public function checkDate($date,$cardId) { 
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('id')) 
			   ->where(array('attendanceDate' => $date))
			   ->where(array('cardId' => $cardId))
		;  
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString;
		//exit;
		$results = $this->adapter->query($sqlString)->execute()->current();
		if($results['id']) {
			return 1;
		}
		return 0; 
	} 
	
	public function getCardEmpId($cardId) {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->empIdCard))
		       ->columns(array('employeeId'))
		       // ->where(array('attendanceDate' => $date))
		       ->where(array('cardId' => $cardId))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString;
		//exit;
		$results = $this->adapter->query($sqlString)->execute()->current();
		if($results['employeeId']) {
			return $results['employeeId'];
		}
		return 0;
	} 
	
} 