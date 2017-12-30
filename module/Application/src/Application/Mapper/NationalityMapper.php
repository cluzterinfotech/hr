<?php

namespace Application\Mapper;

use Application\Abstraction\AbstractDataMapper,  
    Zend\Db\Adapter\Adapter as zendAdapter,
    Application\Model\Bank;
use Application\Model\Nationality;

class NationalityMapper extends AbstractDataMapper {
	
	protected $entityTable = "lkpNationality";
    	
	protected function loadEntity(array $row) {
		 $entity = new Nationality(); 
		 return $this->arrayToEntity($row,$entity);
	}
	
	
}