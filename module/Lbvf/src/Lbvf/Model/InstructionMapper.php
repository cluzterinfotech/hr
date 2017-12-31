<?php
namespace Lbvf\Model;

use Application\Abstraction\AbstractDataMapper,  
    Zend\Db\Adapter\Adapter as zendAdapter,
    Employee\Model\Location;
use Lbvf\Model\PeopleManagement;

class InstructionMapper extends AbstractDataMapper {
	
	protected $entityTable = "LbvfInfo";
    	
	protected function loadEntity(array $row) {
		 $entity = new Instruction(); 
		 return $this->arrayToEntity($row,$entity);
	}
	
	/*public function selectById($empId) {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('*'))
				->where(array('employeeNumber' => $empId))
				//->where(array('locationId' => $locationId))
		;
		return $select; 
	}*/
	
	
	/*public function locationList() { 
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('id','locationName'))
		; 
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute();
		return $this->toArrayList($results,'id','locationName');
		//return $select;
	}
	
	public function getLocationAllowanceList($locationId,$company) { 
		$sql = $this->getSql(); 
		$select = $sql->select(); 
		$select->from(array('e' => 'LocationAllowance'))
		       ->columns(array('id','allowanceId',
				               'companyId','locationId'))
			   ->where(array('companyId' => $company->getId()))
			   ->where(array('locationId' => $locationId))
		; 
		$sqlString = $sql->getSqlStringForSqlObject($select);
		// echo $sqlString;
		// exit;
		return $this->adapter->query($sqlString)->execute(); 
	} */
	
}