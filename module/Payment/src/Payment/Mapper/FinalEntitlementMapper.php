<?php 

namespace Payment\Mapper;

use Application\Abstraction\AbstractDataMapper,  
    Zend\Db\Adapter\Adapter as zendAdapter,
    Employee\Model\Location;
use Employee\Model\EmployeeLocation;
use Payment\Model\Company;
use Employee\Model\NewEmployee;

class FinalEntitlementMapper extends AbstractDataMapper {
	
	protected $entityTable = "FinalEntitlementBuffer";
	
	protected $mainTable = "FinalEntitlement"; 
        	
	protected function loadEntity(array $row) {
		 $entity = new EmployeeLocation();
		 return $this->arrayToEntity($row,$entity);
	}
	
	public function saveEmployeeLeaveAllowance($leaveEmployeeInfo) {
		$sql = $this->getSql();
		$insert = $sql->Insert($this->entityTable);
		$insert->values($leaveEmployeeInfo);
		$sqlString = $sql->getSqlStringForSqlObject($insert);
		$this->adapter->query($sqlString)->execute(); 
	}
	
	public function insertLaMst($mstArray) { 
		$this->setEntityTable($this->laMstTable); 
		return $this->insert($mstArray);  
	} 
	
	public function removePreviousEntitlement($employeeId) { 
		$sql = $this->getSql();
		$delete = $sql->delete($this->laMstTable);
		$delete->where(array(
				'companyId'  => $company->getId(),
				'isClosed'   => 0 
		));  
		$sqlString = $sql->getSqlStringForSqlObject($delete);
		//echo $sqlString;
		//exit;
		return $this->adapter->query($sqlString)->execute()->count(); 
	} 
	
	public function selectEmployeeLa() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('id'))
		       ->join(array('c' => 'Company'),'c.id = e.companyId',
		              array('companyName'))
		       ->join(array('m' => 'EmpEmployeeInfoMain'),
		    		'm.employeeNumber = e.employeeId',
				   array('employeeName'))  
			//->where(array('isActive' => 1))
			   ->order('employeeName asc')
	    ; 
	    // echo $sql->getSqlStringForSqlObject($select);
	    // exit;
	    return $select; 
	}
	
	public function getLeaveAllowanceEmployeeList(Company $company) { 
		$sql = $this->getSql(); 
		$select = $sql->select(); 
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('employeeId')) 
		       ->where(array('companyId' => $company->getId())) 
	    ;     
	    // echo $sql->getSqlStringForSqlObject($select); 
	    // exit; 
	    $sqlString = $sql->getSqlStringForSqlObject($select); 
		$results = $this->adapter->query($sqlString)->execute(); 
		return $results; 
	} 
	
	
}