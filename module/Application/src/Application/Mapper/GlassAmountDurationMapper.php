<?php

namespace Application\Mapper;

use Application\Abstraction\AbstractDataMapper,  
    Zend\Db\Adapter\Adapter as zendAdapter,
    Application\Model\Bank;
use Application\Model\GlassAmountDuration;

class GlassAmountDurationMapper extends AbstractDataMapper {
	
	protected $entityTable = "GlassAmountDuration";
    	
	protected function loadEntity(array $row) {
		 $entity = new GlassAmountDuration();  
		 return $this->arrayToEntity($row,$entity); 
	} 
}