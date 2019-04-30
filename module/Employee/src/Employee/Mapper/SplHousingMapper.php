<?php
namespace Employee\Mapper;

use Application\Abstraction\AbstractDataMapper,  
    Zend\Db\Adapter\Adapter as zendAdapter,
    Employee\Model\SplHousing;

class SplHousingMapper extends AbstractDataMapper {
	
	protected $entityTable = "SpecialHousing";
    	
	protected function loadEntity(array $row) {
		 $entity = new SplHousing();
		 return $this->arrayToEntity($row,$entity);
	}
	
	public function selectSplHousList() {
	    
		$sql = $this->getSql(); 
		$select = $sql->select(); 
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('id','employeeId','amount'))
		       ->join(array('ep' => 'EmpEmployeeInfoMain'),'ep.employeeNumber = e.employeeId',
		       		array('employeeName'))
			   
		; 
		return $select; 
		//$sqlString = $sql->getSqlStringForSqlObject($select);
		// echo $sqlString;
		// exit;
		//return $this->adapter->query($sqlString)->execute(); 
		
	} 
	
}