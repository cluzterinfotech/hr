<?php

namespace Application\Mapper;

use Application\Abstraction\AbstractDataMapper; 
use Application\Model\BabyCare;

class BabyCareMapper extends AbstractDataMapper {
	
	protected $entityTable = "AttendanceBabyCareException";
    	
	protected function loadEntity(array $row) {
		 $entity = new BabyCare(); 
		 return $this->arrayToEntity($row,$entity);
	}
	
	public function selectBabyCare() { 
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('*'))
		       ->join(array('d' => 'EmpEmployeeInfoMain'),'e.employeeNumber = d.employeeNumber',
				array('employeeName'))
				//->where(array('employeeId' => $employeeId))
		;
		return $select; 
	}
}