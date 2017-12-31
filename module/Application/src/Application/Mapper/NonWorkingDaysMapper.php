<?php

namespace Application\Mapper;

use Application\Abstraction\AbstractDataMapper; 
use Application\Entity\CompanyEntity;
use Zend\Db\Sql\Predicate\Predicate;

class NonWorkingDaysMapper extends AbstractDataMapper {
	
	protected $entityTable = "Company";
    
	protected function loadEntity(array $row) { 
	    $entity = new  CompanyEntity();
	    return $this->arrayToEntity($row,$entity);
	}
	
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
	
	public function getSickleaveDays() {
		
	}
	
	
	// public function 
	    
}   