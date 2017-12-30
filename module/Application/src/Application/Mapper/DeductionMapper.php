<?php

namespace Application\Mapper;

use Application\Abstraction\AbstractDataMapper; 
use Payment\Model\DeductionEntity;


class DeductionMapper extends AbstractDataMapper {
	
	protected $entityTable = "Deduction";
    
	protected function loadEntity(array $row) { 
	    $entity = new DeductionEntity();
	    return $this->arrayToEntity($row,$entity);
	}
	
}
