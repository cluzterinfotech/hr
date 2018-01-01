<?php

namespace Application\Mapper;

use Application\Abstraction\AbstractDataMapper; 
use Application\Entity\CompanyEntity;
use Payment\Model\Company;
use Application\Model\Sg;

class SgMapper extends AbstractDataMapper {
	
	protected $entityTable = "lkpSalaryGrade";
    
	protected function loadEntity(array $row) { 
	    $entity = new Sg();  
	    return $this->arrayToEntity($row,$entity);
	}
	
	
}
