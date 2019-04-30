<?php

namespace Allowance\Model;

use Application\Abstraction\AbstractDataMapper; 
use Application\Entity\CompanyAllowanceEntity;
use Application\Entity\AllowanceEntity;

class AllowanceMapper extends AbstractDataMapper {
	
	protected $entityTable = "Allowance";
    
	protected function loadEntity(array $row) { 
	    $entity = new  AllowanceEntity();
	    return $this->arrayToEntity($row,$entity);
	}
	
	public function getAllowanceList() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('id','allowanceName'))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute();
		return $this->toArrayList($results,'id','allowanceName');
	}
	
}
