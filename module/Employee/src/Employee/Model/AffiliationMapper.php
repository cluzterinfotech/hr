<?php

namespace Employee\Model;

use Application\Abstraction\AbstractDataMapper; 
use Application\Entity\SalaryGradeEntity;
use Payment\Model\Company;
use Application\Entity\SalaryGradeAllowanceEntity;

class AffiliationMapper extends AbstractDataMapper {
	
	protected $entityTable = "AffiliationAmount"; 
    
	protected function loadEntity(array $row) { 
	    $entity = new SalaryGradeEntity();  
	    return $this->arrayToEntity($row,$entity); 
	}
	
	public function selectAffiliationAmount() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('a' => 'AffiliationAmount'))
		       ->columns(array('id','amount'))
			   ->join(array('d' => 'Deduction'),'d.id = a.deductionId',
				      array('deductionName'))
			   ->join(array('c' => 'Company'), 'c.id = a.companyId',
				      array('companyName'))
			   //->join(array('a' => 'Allowance'), 'a.id = s.allowanceId',
			          //array('allowanceName'))
		; 
		//echo $select->getSqlString(); 
		//exit; 
		return $select; 
	} 
	
	
} 