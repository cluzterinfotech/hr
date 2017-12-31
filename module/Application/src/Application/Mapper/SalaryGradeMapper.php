<?php

namespace Application\Mapper;

use Application\Abstraction\AbstractDataMapper; 
use Application\Entity\CompanyAllowanceEntity;
use Application\Entity\AllowanceEntity;
use Application\Model\Sg;

class SalaryGradeMapper extends AbstractDataMapper {
	
	protected $entityTable = "lkpSalaryGrade";
    
	protected function loadEntity(array $row) { 
	    $entity = new  Sg();
	    return $this->arrayToEntity($row,$entity);
	}
	
	public function salaryGradeList() {
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		};
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};
		
		$where  = " (1=1) ";
		//$where .= " and c.companyId = '".$company->getId()."' ";
        		
		$statement = $adapter->query("
			select lkpSalaryGradeId,salaryGrade from ".$qi('lkpSalaryGrade')." c
            where  $where
		");
		$results = $statement->execute();
		return $this->toArrayList($results,'lkpSalaryGradeId','salaryGrade'); 
		//return array('' => '','12' => '20','13' => '21','14' => '22','15' => '23');
	}
	
}
