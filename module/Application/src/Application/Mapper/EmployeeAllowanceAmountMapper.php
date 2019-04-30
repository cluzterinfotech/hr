<?php

namespace Application\Mapper;

use Application\Abstraction\AbstractDataMapper,  
    Zend\Db\Adapter\Adapter as zendAdapter;
use Application\Entity\EmployeeAllowanceAmountEntity;

class EmployeeAllowanceAmountMapper extends AbstractDataMapper {
	
	protected $entityTable = "EmployeeAllowanceAmount";
    	
	protected function loadEntity(array $row) {
		 $entity = new EmployeeAllowanceAmountEntity();
		 return $this->arrayToEntity($row,$entity);
	}
	
	/* public function select() {
		$sql = $this->getSql();
		$select = $sql->select(); 
		$select->from(array('e'=>$this->entityTable))
		       ->columns(array('id','effectiveDate')
		       ->join(array('ei'=>'EmpEmployeeInfo'),'',array(''))	
		       		);
		return $select;
	} */    
}