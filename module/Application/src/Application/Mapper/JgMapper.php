<?php

namespace Application\Mapper;

use Application\Abstraction\AbstractDataMapper; 
use Application\Entity\CompanyEntity;
use Payment\Model\Company;
use Application\Model\Jg;

class JgMapper extends AbstractDataMapper {
	
	protected $entityTable = "lkpJobGrade";
    
	protected function loadEntity(array $row) { 
	    $entity = new Jg();  
	    return $this->arrayToEntity($row,$entity);
	}
	
	
}
