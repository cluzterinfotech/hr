<?php

namespace Application\Mapper;

use Application\Abstraction\AbstractDataMapper,  
    Zend\Db\Adapter\Adapter as zendAdapter,
    Application\Model\Bank;
use Application\Model\Nationality;
use Application\Model\Religion;

class ReligionMapper extends AbstractDataMapper {
	
	protected $entityTable = "lkpReligions";
    	
	protected function loadEntity(array $row) {
		 $entity = new Religion();  
		 return $this->arrayToEntity($row,$entity); 
	} 
}