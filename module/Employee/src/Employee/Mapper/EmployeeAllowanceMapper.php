<?php
namespace Employee\Mapper;

use Application\Abstraction\AbstractDataMapper,  
    Zend\Db\Adapter\Adapter as zendAdapter,
    Employee\Model\Location;
use Employee\Model\EmployeeLocation;
use Employee\Model\EmployeeInitial;
use Zend\Db\Sql\Expression;
use Employee\Model\EmployeeAllowance;

class EmployeeAllowanceMapper extends AbstractDataMapper {
	
	protected $entityTable = "Initial"; 
    	
	protected function loadEntity(array $row) {
		 $entity = new EmployeeAllowance(); // EmployeeInitial(); 
		 return $this->arrayToEntity($row,$entity); 
	}
	
	public function employeeAllowanceList($table = 'Initial') {
        // @todo revise the query to fetch recent initial value
		$sql = $this->getSql(); 
		$select = $sql->select(); 
		$select->from(array('e' => 'EmpEmployeeInfoMain'))
		       ->columns(array('tableName' => new Expression("cast('".$table."' as varchar(20))"),	
		       'employeeNumber','employeeName'))
		       //->join(array('ep' => 'EmpPersonalInfo'),'ep.id = e.empPersonalInfoId',
		       		//array('employeeName'))
		       ->join(array('i' => $table), 'e.employeeNumber = i.employeeId', 
		       		array('id','amount'))
		; 
		//echo $select->getSqlString();  
		//exit; 
		return $select;         
	}
	
	public function insertAllowance($array) {
		$this->setEntityTable($array['allowanceNameText']);
		unset($array['allowanceNameText']);
		$this->insert($array);
	}
	
	public function updateAllowance($array) {
		$this->setEntityTable($array['allowanceNameText']);
		unset($array['allowanceNameText']);
		$this->update($array);
	}
    
	public function fetchEmployeeAllowance($id,$tableName) {
		
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'EmpEmployeeInfoMain'))
		       ->columns(array('employeeNumber','employeeName'))
		       //->join(array('ep' => 'EmpPersonalInfo'),'ep.id = e.empPersonalInfoId',
		       		//array('employeeName'))
		       ->join(array('i' => $tableName), 'e.employeeNumber = i.employeeId', 
		       		array('id','amount'))
			   ->where(array('i.id' => $id))
		; 
		//echo $select->getSqlString(); 
		//exit; 
		$sqlString = $sql->getSqlStringForSqlObject($select); 
		$results = $this->adapter->query($sqlString)->execute()->current(); 
        
		$row['employeeId'] = $results['employeeNumber'];
		$row['id'] = $results['id'];
		$row['amount'] = $results['amount'];
		$row['allowanceNameText'] = $tableName; 
		return $this->loadEntity($row);  
	} 
	
	public function toEntityArray($results) {
		foreach ($results as $result) {
			$records[] = $result;
		}
		return $records;
	}
    
	/* public function employeeInitialList($table = 'Initial') {
		// @todo revise the query to fetch recent initial value
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'EmpEmployeeInfo'))
		->columns(array('id','tableName' => new Expression("cast('".$table."' as varchar(20))"),'employeeNumber'))
		->join(array('ep' => 'EmpPersonalInfo'),'ep.id = e.empPersonalInfoId',
				array('employeeName'))
		->join(array('i' => $table), 'e.employeeNumber = i.employeeId',
				array('amount'))
		;
		//echo $select->getSqlString();
		//exit;
		return $select;
	} */
	
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