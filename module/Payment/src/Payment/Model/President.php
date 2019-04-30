<?php
namespace Payment\Model; 

use Payment\Model\AbstractAllowance; 

class President extends AbstractAllowance { 
    
    
    public function calculateAmount(Employee $employee,DateRange $dateRange) { 
    	// @todo is this employee have 
    	return 0; 
    	$sgService = $this->service->get('salaryGradeService');
    	$sgId = $employee->getEmpSalaryGrade();
    	$allowanceId = $this->getAllowanceIdByName($this->getTableName());
    	$company = $this->service->get('company');
    	$companyId = $employee->getCompanyId();
    	return $sgService->salaryGradeAmount($sgId,$allowanceId,$companyId);
	}
	
	public function calculateExemption(Employee $employee,DateRange $dateRange) {
		return 0; 
	} 
    
	public function getTableName() {
		return "President"; 
	}
}   