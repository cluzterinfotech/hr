<?php

namespace Application\Mapper;

use Application\Abstraction\AbstractDataMapper;
use Application\Model\Policy;
    
class PolicyMapper extends AbstractDataMapper {
	
	protected $entityTable = "policy";
    	
	protected function loadEntity(array $row) {
		 $entity = new Policy();
		 return $this->arrayToEntity($row,$entity);
	}
	
	public function fetchManual() {
	    $select = $this->select();
	    $sql = $this->getSql(); 
	    $query = $sql->getSqlStringForSqlObject($select); 
	    return $this->adapter->query($query)->execute();
	    //return $query->execute();
	} 
}