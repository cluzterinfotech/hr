<?php

namespace Lbvf\Model;

use Application\Abstraction\AbstractDataMapper;  
use Application\Entity\AssessmentFormOne; 

class AssessmentMapper extends AbstractDataMapper {
	
	protected $entityTable = "LbvfForm01"; 
	protected $formTwo = "LbvfForm02";
	protected $formThree = "LbvfForm03";
	protected $formFour = "LbvfForm04"; 
	
	protected function loadEntity(array $row) { 
	    $entity = new AssessmentFormOne();  
	    return $this->arrayToEntity($row,$entity); 
	}
	
	
	
	/*public function getSalaryGradeList() { 
		$sql = $this->getSql(); 
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('id','salaryGrade'))
		; 
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute();
		return $this->toArrayList($results,'id','salaryGrade');
	}
	
	public function sgAllowanceById($id) { 
		$entity = new SalaryGradeAllowanceEntity();
		$this->setEntityTable('AllowanceSalaryGrade');  
		$statement = $this->fetch(array('id' => $id));
		//\Zend\Debug\Debug::dump($statement); 
		
		if (!$results = $statement->execute()->current()) {
			return null;
		}
		
		return $this->arrayToEntity($results,$entity);
		
		//\Zend\Debug\Debug::dump($obj); 
		//exit; 
	}
	 
	public function selectSalaryGradeAllowance() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('s' => 'AllowanceSalaryGradeBuffer'))
		       ->columns(array('id','amount'))
			   ->join(array('l' => 'lkpSalaryGrade'),'l.id = s.lkpSalaryGradeId',
				      array('salaryGrade'))
			   ->join(array('c' => 'Company'), 'c.id = s.companyId',
				      array('companyName'))
			   ->join(array('a' => 'Allowance'), 'a.id = s.allowanceId',
			          array('allowanceName'))
		; 
		//echo $select->getSqlString(); 
		//exit; 
		return $select; 
	} 
	
	public function selectExistingSalaryGradeAllowance() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('s' => 'AllowanceSalaryGrade'))
		       ->columns(array('id','amount'))
		       ->join(array('l' => 'lkpSalaryGrade'),'l.id = s.lkpSalaryGradeId',
				       array('salaryGrade'))
			   ->join(array('c' => 'Company'), 'c.id = s.companyId',
					  array('companyName'))
			   ->join(array('a' => 'Allowance'), 'a.id = s.allowanceId',
					 array('allowanceName'))
		;
		//echo $select->getSqlString(); 
		//exit; 
		return $select; 
	}
	
	public function removeSgAllowanceBuffer($id) {
		$sql = $this->getSql(); 
		$delete = $sql->delete('AllowanceSalaryGradeBuffer'); 
		$delete->where(array( 
				'id' => $id 
		)); 
		//$sqlString = $delete->getSqlString(); 
		$sqlString = $sql->getSqlStringForSqlObject($delete); 
		return $this->adapter->query($sqlString)->execute()->count();
	}
	 
	public function saveSgAllowanceBuffer($sgAllowanceInfo) {
		$sql = $this->getSql();
		$insert = $sql->Insert('AllowanceSalaryGradeBuffer');
		$insert->values($sgAllowanceInfo);
		$sqlString = $sql->getSqlStringForSqlObject($insert);
		$this->adapter->query($sqlString)->execute();
	}
	
	public function newSgAllowanceList(Company $company) {
		$sql = $this->getSql(); 
		$select = $sql->select(); 
		$select->from(array('e' => 'AllowanceSalaryGradeBuffer'))
		       ->columns(array('id','lkpSalaryGradeId','allowanceId',
		                       'companyId','amount','isApplicableToAll','isUpdate'))
		       ->where(array('companyId' => $company->getId()))
		;   
		$sqlString = $sql->getSqlStringForSqlObject($select); 
		// echo $sqlString; 
		// exit; 
		return $this->adapter->query($sqlString)->execute();  
	} 
	
	public function existingSgAllowanceList(Company $company,$allowanceId) {
		$sql = $this->getSql(); 
		$select = $sql->select(); 
		$select->from(array('e' => 'AllowanceSalaryGrade'))
		       ->columns(array('id','lkpSalaryGradeId','allowanceId',
				    'companyId','amount','isApplicableToAll'))
			   ->where(array('companyId' => $company->getId()))
			   ->where(array('allowanceId' => $allowanceId))
		;  
		$sqlString = $sql->getSqlStringForSqlObject($select); 
		//echo $sqlString; 
		//exit; 
		return $this->adapter->query($sqlString)->execute(); 
	} 
	
	public function incrementList(Company $company) {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'EmployeeIncrement'))
		       ->columns(array('employeeNumber','oldInitial','incrementedValue'))
				->where(array('companyId' => $company->getId()))
				->where(array('applied' => 0))
				;
				$sqlString = $sql->getSqlStringForSqlObject($select);
				//echo $sqlString;
				//exit;
				return $this->adapter->query($sqlString)->execute();
	}
	
	public function saveSgAllowanceMain($sgAllowanceInfo) {
		$sql = $this->getSql();
		$insert = $sql->Insert('AllowanceSalaryGrade');
		$insert->values($sgAllowanceInfo); 
		$sqlString = $sql->getSqlStringForSqlObject($insert);
		// echo $sqlString; 
		// exit; 
		$this->adapter->query($sqlString)->execute(); 
	}
	 
	public function updateSgAllowanceMain($sgAllowanceInfo) { 
		
		$sql = $this->getSql();
		$update = $sql->Update('AllowanceSalaryGrade');
		//$array = $this->entityToArray($entity);
		//$id = $sgAllowanceInfo['id'];
		// unset($array['id']); 
		unset($sgAllowanceInfo['id']); 
		unset($sgAllowanceInfo['isUpdate']); 
		$update->set($sgAllowanceInfo); 
		$update->where(array(
				'lkpSalaryGradeId' => $sgAllowanceInfo['lkpSalaryGradeId'],
				'allowanceId'      => $sgAllowanceInfo['allowanceId'],
				'companyId'        => $sgAllowanceInfo['companyId']
		));   
		$sqlString = $update->getSqlString();
		//echo $sqlString;
		//exit;   
		$sqlString = $sql->getSqlStringForSqlObject($update);
		return $this->adapter->query($sqlString)->execute()->count(); 
	}  
	   
	// employeeList Based on salary grade and company  
	// @todo have to move on employee service
	public function SalaryGradeEmployeeList($sgId) { 
		$sql = $this->getSql(); 
		$select = $sql->select(); 
		$select->from(array('e' => 'EmpEmployeeInfoMain'))
		       ->columns(array('id','employeeNumber'))
		       ->where(array('empSalaryGrade' => $sgId))
		       ->where(array('isActive' => 1)) 
		;    
		$sqlString = $sql->getSqlStringForSqlObject($select); 
		// echo $sqlString; 
		// exit; 
		return $this->adapter->query($sqlString)->execute(); 
	}
	
	public function salaryGradeAmount($sgId,$allowanceId,$companyId) {
		// @return amount
		// return 1234; 
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'AllowanceSalaryGrade'))
		       ->columns(array('id','lkpSalaryGradeId','allowanceId',
				               'companyId','amount','isApplicableToAll'))
			   ->where(array('companyId' => $companyId)) 
			   ->where(array('lkpSalaryGradeId' => $sgId))
			   ->where(array('allowanceId' => $allowanceId))
		; 
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString; 
		//exit; 
		$res = $this->adapter->query($sqlString)->execute()->current();  
		//\Zend\Debug\Debug::dump($res);
		//exit;  
		//if($res['amount'])
		return $res['amount'];  
	}  
	
	public function isSalaryGradeAmountToAll($sgId,$allowanceId,$companyId) {
		// @return amount 
		// return 1234; 
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'AllowanceSalaryGrade'))
		       ->columns(array('id','lkpSalaryGradeId','allowanceId',
				'companyId','amount','isApplicableToAll'))
				->where(array('companyId' => $companyId))
				->where(array('lkpSalaryGradeId' => $sgId))
				->where(array('allowanceId' => $allowanceId))
				;
				$sqlString = $sql->getSqlStringForSqlObject($select);
				//echo $sqlString;
				//exit;
				$res = $this->adapter->query($sqlString)->execute()->current();
				//\Zend\Debug\Debug::dump($res);
				//exit;
				//if($res['amount'])
				return $res['isApplicableToAll'];
	}
	
	public function getSgAllowanceList($salGradeId,$company) {
		
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'AllowanceSalaryGrade'))
		       ->columns(array('id','lkpSalaryGradeId','allowanceId',
				               'companyId','isApplicableToAll'))
			   ->where(array('companyId' => $company->getId()))
			   ->where(array('lkpSalaryGradeId' => $salGradeId))
		;  
	    $sqlString = $sql->getSqlStringForSqlObject($select); 
	    //echo $sqlString; 
	    //exit; 
	    return $this->adapter->query($sqlString)->execute(); 
	}*/ 
	
} 