<?php

namespace Application\Mapper;

use Application\Abstraction\AbstractDataMapper; 
use Application\Entity\CompanyEntity;
use Payment\Model\Company;
use Application\Model\Sg;
use Application\Model\Section;

class SectionMapper extends AbstractDataMapper {
	
	protected $entityTable = "Section";
    
	protected function loadEntity(array $row) {  
	    $entity = new Section();   
	    return $this->arrayToEntity($row,$entity); 
	}
	
	public function selectSection() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('*'))
		       ->join(array('d' => 'Department'),'e.department = d.id',
				      array('departmentName'))
			   //->where(array('employeeId' => $employeeId))
		;
		return $select; 
		//$sqlString = $sql->getSqlStringForSqlObject($select);
		//$results = $this->adapter->query($sqlString)->execute()->current();
		//return $results['organisationLevel'];
	}
	
	
}
