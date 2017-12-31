<?php
namespace Employee\Mapper;

use Application\Abstraction\AbstractDataMapper,  
    Zend\Db\Adapter\Adapter as zendAdapter,
    Employee\Model\Location;
use Employee\Model\EmployeeLocation;
use Payment\Model\Company;
use Payment\Model\DateRange;
use Zend\Db\Sql\Predicate\Predicate; 

class EmployeeDeductionMapper extends AbstractDataMapper {
	
	protected $entityTable = "PhoneDeduction"; 
	
	protected $phoneBuffer = "PhoneDeductionBuffer";  
	
	protected $phoneMst = "PhoneDeductionMst";  
    	
	protected function loadEntity(array $row) {
		 $entity = new EmployeeLocation();
		 return $this->arrayToEntity($row,$entity);
	}
	
	public function saveEmployeeDeduction($data,$table) {
		$sql = $this->getSql();
		$insert = $sql->Insert($table);
		$insert->values($data);
		$sqlString = $sql->getSqlStringForSqlObject($insert);
		$this->adapter->query($sqlString)->execute(); 
	}
	
	public function getEmployeeIdByPhone($phone,$table) {
	
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $table))
		       ->columns(array('employeeNumberTelephone'))
		       ->where(array('phoneNumber' => $phone))
				//->join(array('l' => 'Location'), 'e.locationId = l.id',
		//array('locationName'))
		;
		//echo $select->getSqlString();
		//exit;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$res = $this->adapter->query($sqlString)->execute()->current(); 
		if($res['employeeNumberTelephone']) {
			return $res['employeeNumberTelephone'];  
		} 
		return 0; 
	} 
	
	public function removeEmployeeDeduction($id,$table) {
	    
		$sql = $this->getSql(); 
		$delete = $sql->delete($table); 
		$delete->where(array( 
				'id' => $id 
		)); 
		//$sqlString = $delete->getSqlString(); 
		$sqlString = $sql->getSqlStringForSqlObject($delete); 
		return $this->adapter->query($sqlString)->execute()->count(); 
	}
	
	public function removeUnclosedPhone($companyId,$lastMonth) {
		 
		$sql = $this->getSql();
		$delete = $sql->delete($this->phoneMst); 
		$delete->where(array(
				'companyId' => $companyId,
				'deuStartingDate' => $lastMonth,
		)); 
		//$sqlString = $delete->getSqlString();
		$sqlString = $sql->getSqlStringForSqlObject($delete);
		return $this->adapter->query($sqlString)->execute()->count();
	} 
	
	public function closeTelephone($companyId,$lastMonth) { 
		$sql = $this->getSql();
		$update = $sql->update($this->phoneMst);
		$array = array('isClosed' => 1); 
		$update->set($array);
		$update->where(array('companyId' => $companyId));
		$update->where(array('deuStartingDate' => $lastMonth)); 
		$sqlString = $sql->getSqlStringForSqlObject($update);
		//echo $sqlString;
		//exit; 
		return $this->adapter->query($sqlString)->execute();
	}
    
	public function selectEmployeeTelephone($table) {
	
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $table))
		       ->columns(array('*'))
		       ->join(array('m' => 'EmpEmployeeInfoMain'),'m.employeeNumber = e.employeeNumberTelephone',
				      array('employeeName'))
			   //->join(array('l' => 'Location'), 'e.locationId = l.id',
					  //array('locationName'))
			   ; 
	    //echo $select->getSqlString();
		//exit;  
		return $select; 
	}    
	
	public function fetchPhoneBufferList(Company $company,DateRange $dateRange) {  
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->phoneBuffer))
		       ->columns(array('*')) 
		       ->where(array('companyId' => $company->getId())) 
		;
		//echo $select->getSqlString(); 
		//exit;
		$sqlString = $sql->getSqlStringForSqlObject($select); 
		return $this->adapter->query($sqlString)->execute(); 
	}   
	
	public function insertPhoneMst($mst) {
		$this->setEntityTable($this->phoneMst); 
		return $this->insert($mst); 
	} 
	
	public function insertPhoneDtls($dtls) {
		$this->setEntityTable('PhoneDeduction');
		//\Zend\Debug\Debug::dump($this->phoneMst);
		//\Zend\Debug\Debug::dump($this->entityTable);
		//\Zend\Debug\Debug::dump($dtls);
		//exit;
		return $this->insert($dtls);  
	}
	
	public function insertPhone($dtls) {
		$this->setEntityTable('PhoneDeduction'); 
		return $this->insert($dtls);
	}
	
	public function isPhoneClosed($companyId,$lastMonth) {
		// $predicate = new Predicate();
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->phoneMst))
			   ->columns(array('id','isClosed'))
			   ->where(array('companyId' => $companyId)) 
			   ->where(array('deuStartingDate' => $lastMonth)) 
			   ->where(array('isClosed' => 1)) 
			   //->where($predicate->greaterThanOrEqualTo('month',$dateRange->getFromDate()))
		       //->where($predicate->lessThanOrEqualTo('month',$dateRange->getToDate())) 
		;  
		//echo $select->getSqlString();
		//exit;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$res = $this->adapter->query($sqlString)->execute()->current(); 
		if($res['id']) {
			return $res;    
		} 
		return 0; 
	}
}