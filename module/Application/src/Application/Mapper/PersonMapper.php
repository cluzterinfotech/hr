<?php

namespace Application\Mapper;

use Application\Abstraction\AbstractDataMapper; 
use Payment\Model\Person;

class PersonMapper extends AbstractDataMapper {
	
	protected $entityTable = "EmpPersonalInfo"; 
    
	protected function loadEntity(array $row) { 
	    $entity = new Person();
	    return $this->arrayToEntity($row,$entity);
	}
	
	
	
	
}
