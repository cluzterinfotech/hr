<?php 

namespace Payment\Mapper;

use Application\Abstraction\AbstractDataMapper,  
    Zend\Db\Adapter\Adapter as zendAdapter,
    Employee\Model\Location;
use Employee\Model\EmployeeLocation;
use Payment\Model\Company;
use Employee\Model\NewEmployee;

class LeaveAllowanceMapper extends AbstractDataMapper {
	
	protected $entityTable = "LeaveAllowanceBuffList";
	
	protected $laMstTable = "leaveAllowanceMst"; 
	
	protected $laDtlsTable = "leaveAllowanceDtls"; 
    	
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
	
	public function insertLaDtls($dtlsArray) { 
		$this->setEntityTable($this->laDtlsTable);  
		return $this->insert($dtlsArray); 
	}  
	
	public function removeUnclosedLeaveAllowance(Company $company) { 
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
	
	public function getLastLeaveAllowanceDate($employeeNumber) {
		// 
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		};
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};
		$statement = $adapter->query("select top 1 allowanceTo from ".$qi($this->laMstTable)."
			where employeeId  = '".$employeeNumber."'
			order by allowanceTo desc
		");
		//echo $statement->getSql(); 
		//exit; 
		$results = $statement->execute()->current();
		if($results['allowanceTo']) {
			return $results['allowanceTo'];
		}
		return 0;
	} 
	
	public function selectEmployeeLa() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('id'))
		       ->join(array('c' => 'Company'),'c.id = e.companyId',
		              array('companyName'))
		       ->join(array('m' => 'EmpEmployeeInfoMain'),'m.employeeNumber = e.employeeId',
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
	
	public function removeEmployeeLeaveAllowance($id) {
		$sql = $this->getSql();
		$delete = $sql->delete($this->entityTable);
		$delete->where(array(
				'id' => $id
		));
		//$sqlString = $delete->getSqlString();
		$sqlString = $sql->getSqlStringForSqlObject($delete);
		return $this->adapter->query($sqlString)->execute()->count();
	} 
	
	public function getLeaveAllowanceReport(array $param = array()) {
	    $sql = $this->getSql(); 
		$select = $sql->select(); 
		$select->from(array('e' => $this->laMstTable))
		            ->columns(array('*')) 
		            ->join(array('m' => 'EmpEmployeeInfoMain'),'m.employeeNumber = e.employeeId',
		            		    array('employeeName','empJoinDate')) 
		            ->where(array('fyYear' =>$param['year'])) 
		            ->where(array('isClosed' =>0)) 
	    ;   
	    // echo $sql->getSqlStringForSqlObject($select); 
	    // exit; 
	    $sqlString = $sql->getSqlStringForSqlObject($select); 
		$results = $this->adapter->query($sqlString)->execute(); 
		return $results;  
	} 
	
	public function getReportDtls($id) {
	    $sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->laDtlsTable))
		       ->columns(array('*'))
		       ->join(array('a' => 'Allowance'),'a.id = e.allowanceId',
				      array('allowanceName'))
			   ->where(array('e.leaveAllowanceMstId' =>$id))
			 //->where(array('isClosed' =>0))
		; 
		//echo $sql->getSqlStringForSqlObject($select);
		//exit;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute();
		return $results;
	}
	
	public function closeLeaveAllowance(Company $company) {  
		$sql = $this->getSql();
		$update = $sql->Update($this->laMstTable);
		$array = array(
				'isClosed'  => 1
		); 
		//$id = $array['id'];
		//unset($array['id']);
		$update->set($array);
		$update->where(array(
			'companyId' => $company->getId(),
			'isClosed'  => 0, 
		)); 
		//$sqlString = $update->getSqlString();  
		//echo $sqlString;  
		//exit;   
		$sqlString = $sql->getSqlStringForSqlObject($update);  
		return $this->adapter->query($sqlString)->execute()->count(); 
	}
	
	public function removeAllFromBuffer(Company $company) {
		$sql = $this->getSql();
		$delete = $sql->delete($this->entityTable); 
		$delete->where(array(
				'companyId' => $company->getId()
		)); 
		//$sqlString = $delete->getSqlString();
		$sqlString = $sql->getSqlStringForSqlObject($delete);
		return $this->adapter->query($sqlString)->execute()->count();
	} 
	
	public function getLastBatch(Company $company,$fyYear) { 
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		};
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};
		$statement = $adapter->query("select top 1 batchNo from ".$qi($this->laMstTable)."
			where fyYear  = '".$fyYear."' and companyId = '".$company->getId()."' 
			order by id desc 
		");
		//echo $statement->getSql();
		//exit;
		$results = $statement->execute()->current();
		if($results['batchNo']) {
			return $results['batchNo'];
		}
		return 0; 
	}
	 
	
	
}