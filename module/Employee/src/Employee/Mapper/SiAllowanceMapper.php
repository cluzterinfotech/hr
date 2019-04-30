<?php
namespace Employee\Mapper;

use Application\Abstraction\AbstractDataMapper,  
    Zend\Db\Adapter\Adapter as zendAdapter,
    Employee\Model\Location;

class SiAllowanceMapper extends AbstractDataMapper {
	
	protected $entityTable = "Location";
    	
	protected function loadEntity(array $row) {
		 $entity = new Location();
		 return $this->arrayToEntity($row,$entity);
	}
	
	
	public function locationList() { 
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('id','locationName'))
		; 
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute();
		return $this->toArrayList($results,'id','locationName');
		//return $select;
	}
	
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
	
}