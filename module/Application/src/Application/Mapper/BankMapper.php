<?php

namespace Application\Mapper;

use Application\Abstraction\AbstractDataMapper,  
    Zend\Db\Adapter\Adapter as zendAdapter,
    Application\Model\Bank;

class BankMapper extends AbstractDataMapper {
	
	protected $entityTable = "lkpBank";
    	
	protected function loadEntity(array $row) {
		 $entity = new Bank();
		 return $this->arrayToEntity($row,$entity);
	}
	
	
}