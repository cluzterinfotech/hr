<?php

namespace Application\Mapper;

use Application\Abstraction\AbstractDataMapper;
use Application\Model\Currency;

class CurrencyMapper extends AbstractDataMapper {
	
	protected $entityTable = "lkpCurrencies";
    	
	protected function loadEntity(array $row) {
		 $entity = new Currency();  
		 return $this->arrayToEntity($row,$entity); 
	} 
}