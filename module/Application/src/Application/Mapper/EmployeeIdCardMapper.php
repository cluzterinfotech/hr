<?php

namespace Application\Mapper;

use Application\Abstraction\AbstractDataMapper,  
    Zend\Db\Adapter\Adapter as zendAdapter,
    Employee\Model\IdCard;

class EmployeeIdCardMapper extends AbstractDataMapper {
	
	protected $entityTable = "EmployeeIdCard";
    	
	protected function loadEntity(array $row) {
		 $entity = new IdCard();
		 return $this->arrayToEntity($row,$entity); 
	}
	
	
}