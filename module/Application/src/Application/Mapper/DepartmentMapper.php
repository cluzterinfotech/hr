<?php

namespace Application\Mapper;

use Application\Abstraction\AbstractDataMapper,  
    Zend\Db\Adapter\Adapter as zendAdapter,
    Application\Model\Bank;
use Application\Model\Department;

class DepartmentMapper extends AbstractDataMapper {
	
	protected $entityTable = "Department";
    	
	protected function loadEntity(array $row) {
		 $entity = new Department();
		 return $this->arrayToEntity($row,$entity);
	}
	
	
}