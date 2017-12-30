<?php 

namespace Payment\Model; 

use Payment\Model\AbstractAllowance; 

class Representative extends AbstractAllowance { 
    
    
    public function calculateAmount(Employee $employee,DateRange $dateRange) {
    	// @todo implement condition 
        $sgService = $this->service->get('salaryGradeService');
        $splAmount = $sgService->getSpecialAmount($employee->getEmployeeNumber(),$dateRange,$this->getTableName());
        //\Zend\Debug\Debug::dump($splHous);
        //exit;
        if($splAmount[0] == 1) {
            return $splAmount[1];
        }
    	$company = $this->service->get('company'); 
    	if($this->isHaveRepresentative($employee,$company,$dateRange)) { 
	    	return $this->getBasic($employee,$company,$dateRange) 
	    	* ($this->getRepPercentage()/100);  
    	}  
    	return 0; 
	}  
	
	public function calculateExemption(Employee $employee,DateRange $dateRange) {
		return 0; 
	} 
	
	private function getRepPercentage() {
		return 20;
	}
	
	private function isHaveRepresentative(Employee $employee,Company $company,DateRange $dateRange) { 
	    $sgId = $employee->getEmpSalaryGrade(); 
	    $companyId = $company->getId();
	    // representative only for permanent 
	    // @todo check condition from db 
	    if($companyId != 1) { 
	    	return 0; 
	    } 
	    // Note:it is salary grade Id not salary grade itself 
	    if($sgId > 13) { 
	    	return 1; 
	    }	
	    return 0; 
	}  
    
	public function getTableName() { 
		return "Representative"; 
	} 
}   