<?php

namespace Application\Mapper;

use Application\Abstraction\AbstractDataMapper,  
    Zend\Db\Adapter\Adapter as zendAdapter,
    Application\Model\Bank;
use Application\Model\FamilyMemberType;

class FamilymembertypeMapper extends AbstractDataMapper {
	
	protected $entityTable = "FamilyMemberType";
    	
	protected function loadEntity(array $row) {
		 $entity = new FamilyMemberType();  
		 return $this->arrayToEntity($row,$entity); 
	} 
}