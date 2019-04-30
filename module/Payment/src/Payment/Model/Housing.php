<?php 
namespace Payment\Model;  

use Payment\Model\AbstractAllowance; 

class Housing extends AbstractAllowance { 
    
    public function calculateAmount(Employee $employee,DateRange $dateRange) {
    	//exit; 
        $sgService = $this->service->get('salaryGradeService'); 
        $splAmount = $sgService->getSpecialAmount($employee->getEmployeeNumber(),$dateRange,$this->getTableName()); 
		//\Zend\Debug\Debug::dump($splHous);
		//exit; 
		if($splAmount[0] == 1) {
		    return $splAmount[1];  
		}
		return $this->getElegibleAmount($employee, $dateRange); 
	} 
	
	public function calculateExemption(Employee $employee,DateRange $dateRange) {
		return 0; 
	} 
	
	public function getElegibleAmount(Employee $employee, DateRange $dateRange) {
	    $sgService = $this->service->get('salaryGradeService'); 
	    $sgId = $employee->getEmpSalaryGrade();
	    $allowanceId = $this->getAllowanceIdByName($this->getTableName());
	    $companyId = $employee->getCompanyId();
	    return $sgService->salaryGradeAmount($sgId,$allowanceId,$companyId); 
	}
    
	public function getTableName() { 
		return "Housing";  
	}
   
 
}   