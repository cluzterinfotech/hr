<?php
namespace Employee\Mapper;

use Application\Abstraction\AbstractDataMapper,  
    Zend\Db\Adapter\Adapter as zendAdapter,
    Employee\Model\Location;
use Employee\Model\EmployeeLocation;
use Payment\Model\Company;

class EmployeeLocationMapper extends AbstractDataMapper {
	
	protected $entityTable = "EmpEmployeeInfoMain"; 
    	
	protected function loadEntity(array $row) {
		 $entity = new EmployeeLocation();
		 return $this->arrayToEntity($row,$entity);
	}
	
	public function employeeLocationList(Company $company) {
        
		$sql = $this->getSql(); 
		$select = $sql->select(); 
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('id','employeeNumber','empLocation','employeeName'))
		       //->join(array('ep' => 'EmpPersonalInfo'),'ep.id = e.empPersonalInfoId',
		       		//array('employeeName'))
		       ->join(array('l' => 'Location'), 'e.empLocation = l.id', 
		       		array('locationName'))
		       ->where(array('e.companyId' => $company->getId()))
		       ->where(array('isActive' => 1))
		;   
		//echo $select->getSqlString();  
		//exit; 
		
		return $select;         
	}
	
	// used only for test 
	public function locationByEmployee($employeeNumber) {
	    
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('id','employeeNumber','empLocation','employeeName'))
		       //->join(array('ep' => 'EmpPersonalInfo'),'ep.id = e.empPersonalInfoId',
				      //array('employeeName'))
		       ->join(array('l' => 'Location'), 'e.empLocation = l.id',
				      array('locationName'))
			   
		; 
		//echo $select->getSqlString(); 
		//exit; 
		$sqlString = $sql->getSqlStringForSqlObject($select); 
		$res = $this->adapter->query($sqlString)->execute()->current(); 
		return $this->convertToArray($res);
		return $select; 
	}
	
	/*
	public function getMappingList() {
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
		$results = $statement->execute();
		return $this->convertToArray($results);
	}
	
	public function updateEmployeeIds($table,$empIdOld,$empIdNew) {
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		};
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};
		
		$statement = $adapter->query("update " . $qi($table) . " 
				set employeeId = $empIdNew where employeeId = $empIdOld
		");
		//echo $statement->getSql();
		//exit;
		$statement->execute();
	}
	
	public function isHaveId($table,$empIdOld) {
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		};
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};
	
		$statement = $adapter->query("SELECT employeeId
                                       FROM " . $qi($table) . " AS c
		where employeeId = '".$empIdOld."' and effectiveDate = '2015-01-01' ");
		//echo $statement->getSql();
		//exit;
		$results = $statement->execute();
		return $this->convertToArray($results);
	}
	*/
}