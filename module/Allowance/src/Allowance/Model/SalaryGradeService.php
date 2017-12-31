<?php

namespace Allowance\Model;

use Allowance\Model\AllowanceMapper;
use Payment\Model\Company;
use Payment\Model\DateRange;
use Payment\Model\Payment;
use Payment\Model\ReferenceParameter;

class SalaryGradeService extends Payment {
	
	private $salaryGradeMapper;
	
	public function __construct(ReferenceParameter $reference,
			SalaryGradeMapper $salaryGradeMapper) {
		parent::__construct($reference);
		$this->salaryGradeMapper = $salaryGradeMapper; 
	}
	
	public function getSalaryGradeList() {
		return $this->salaryGradeMapper->getSalaryGradeList();
	}
	
	public function selectSalaryGradeAllowance() {
		return $this->salaryGradeMapper->selectSalaryGradeAllowance();
	}
	
	public function selectExistingSalaryGradeAllowance() {
		return $this->salaryGradeMapper->selectExistingSalaryGradeAllowance();
	}
	
	public function sgAllowanceById($id) { 
		return $this->salaryGradeMapper->sgAllowanceById($id); 
	}
	
	// @todo add company 
	public function salaryGradeAmount($sgId,$allowanceId,$companyId) {
		return $this->salaryGradeMapper
		            ->salaryGradeAmount($sgId,$allowanceId,$companyId);
	}
	
	public function isSalaryGradeAmountToAll($sgId,$allowanceId,$companyId) { 
		return $this->salaryGradeMapper
		            ->isSalaryGradeAmountToAll($sgId,$allowanceId,$companyId);
	}
	
	public function removeSgAllowanceBuffer($id) {
		return $this->salaryGradeMapper->removeSgAllowanceBuffer($id);
	}
	
	public function saveSgAllowanceBuffer($formValues,$company) {
		//\Zend\Debug\Debug::dump($formValues);
		//exit; 
		$companyId = $company->getId();
		$isUpdate = 0;
		if($formValues['id']) { 
			$isUpdate = 1; 
		} 
		//$formValues['companyId'] = $companyId; 
		//$formValues['isUpdate'] = $isUpdate;  
		$sgAllowanceInfo = array (
				'lkpSalaryGradeId'  => $formValues['lkpSalaryGradeId'],
				'allowanceId'       => $formValues['allowanceId'],
				'amount'            => $formValues['amount'],
				'isApplicableToAll' => $formValues['isApplicableToAll'], 
				'companyId'         => $companyId, 
				'isUpdate'          => $isUpdate 					
		);  
		return $this->salaryGradeMapper->saveSgAllowanceBuffer($sgAllowanceInfo);   
	} 
	
	public function applySalaryGradeAllowance(Company $company,$effectiveDate) { 
	    try { 
		    $this->transaction->beginTransaction(); 
		    $res = $this->applyAllowance($company,$effectiveDate); 
		    $this->transaction->commit();    
		    return $res; 
		} catch(\Exception $e) {  
			$this->transaction->rollBack();   
			throw $e; 
		} 
		   
	}
    
	// increment SG Allowance list
	public function existingSgAllowanceList(Company $company,
			$allowanceId,$colaPercentage) {
		// $c = 0;  
		$existingSgAllowanceList = $this->salaryGradeMapper 
		                                ->existingSgAllowanceList($company,$allowanceId);   
		foreach ($existingSgAllowanceList as $sgAllowance) {    
			if($sgAllowance['isApplicableToAll']) {
				// @todo enable below line
				// $sgAllowance['amount'] += $sgAllowance['amount'] * ($colaPercentage/100);
			    $this->saveSgAllowanceBuffer($sgAllowance,$company);    		
			} 
	    } 
	}  

	public function incrementList(Company $company) {
		return $this->salaryGradeMapper->incrementList($company);
	}
	
	
	public function applyAllowance(Company $company,$effectiveDate) {
		$c = 0; 
		$newSgAllowanceList = $this->salaryGradeMapper
		                           ->newSgAllowanceList($company);
		foreach ($newSgAllowanceList as $sgAllowance) {
			$c++;
			if($this->isHaveSalaryGradeAllowance($sgAllowance)) {
				return "Salary grade allowance already exists";
			} else {
				$sgId = $sgAllowance['lkpSalaryGradeId'];
				$allowanceId = $sgAllowance['allowanceId'];
				$this->salaryGradeMapper
				     ->removeSgAllowanceBuffer($sgAllowance['id']); 
				//\Zend\Debug\Debug::dump($sgAllowance); 
				//exit;   
				if($sgAllowance['isUpdate']) { 
				     $this->salaryGradeMapper
				          ->updateSgAllowanceMain($sgAllowance); 
				// \Zend\Debug\Debug::dump($sgAllowance); 
				}  else { 
					unset($sgAllowance['id']);
					unset($sgAllowance['isUpdate']); 
					$this->salaryGradeMapper
					     ->saveSgAllowanceMain($sgAllowance);  
				}
				// get employee who belongs to the salary grade 
				$employeeList = $this->salaryGradeMapper
				                     ->SalaryGradeEmployeeList($sgId);
				if($sgAllowance['isApplicableToAll']) { 
					foreach($employeeList as $employee) {
						$employeeId = $employee['employeeNumber'];
						$this->addAllowanceToEmployee($employeeId,$allowanceId,
								$company,$effectiveDate);
					}
				} /*else {
					foreach($employeeList as $employee) {
						$employeeId = $employee['employeeNumber'];
						// $this->
						$this->addAllowanceToEmployee($employeeId,$allowanceId,
								$company,$effectiveDate);
					}
				}*/ 
			} 
		}
		// exit;
		if($c == 0) {
			return "Sorry! no records found";
		}
		return "Salary Grade Allowances Applied successfully";
	}
    
	public function isHaveSalaryGradeAllowance(array $position) {
		// @todo
		return false;
	}
	
	public function getSpecialAmount($employeeNumber,DateRange $dateRange,$tableName) {
		return $this->salaryGradeMapper
		            ->getSpecialAmount($employeeNumber,$dateRange,$tableName); 
	}
	
	public function addEmployeeSalaryGradeAllowance($salGradeId,
			$employeeNumber,$company,$effectiveDate) {
		// @todo add employee salary grade allowance 
		try {
			//$this->transaction->beginTransaction();
		    $sgAllowanceList = $this->salaryGradeMapper
		                            ->getSgAllowanceList($salGradeId,$company);
			foreach($sgAllowanceList as $allowance) {
				$allowanceId = $allowance['allowanceId']; 
				$isForAll = $allowance['isApplicableToAll'];
				if($isForAll) {
			    $this->addAllowanceToEmployee($employeeNumber,
			    		$allowanceId,$company,$effectiveDate);
				}
			   
			}
			
			//$this->transaction->commit(); 
			// return $res;
		} catch(\Exception $e) {
			//$this->transaction->rollBack(); 
			throw $e; 
		}
		
		
	} 
	
	// public function
	//ChangeSalaryGradeAllowance
	//ApproveSalaryGradeAllowance
	//ChangeEmployeeSalaryGrade
	//ChangeSalaryGradeAllowance
    
         	
}