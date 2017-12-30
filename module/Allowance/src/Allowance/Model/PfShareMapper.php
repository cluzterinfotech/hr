<?php

namespace Allowance\Model;

use Application\Abstraction\AbstractDataMapper; 
//use Application\Entity\SalaryGradeEntity;
use Allowance\Model\PfShare; 
//use Application\Entity\SalaryGradeAllowanceEntity;

class PfShareMapper extends AbstractDataMapper {  
	
	protected $entityTable = "ProvidentFundShare"; 
    
	protected function loadEntity(array $row) { 
	    $entity = new PfShare();  
	    return $this->arrayToEntity($row,$entity); 
	}
	
	public function selectPfShare() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('p' => $this->entityTable))
		       ->columns(array('*'))
			   ->join(array('e' => 'EmpEmployeeInfoMain'),'p.employeeId = e.employeeNumber',
				      array('employeeName'))
		; 
		//echo $select->getSqlString(); 
		//exit; 
		return $select; 
	} 
	
} 