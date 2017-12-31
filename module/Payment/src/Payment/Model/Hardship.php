<?php 

namespace Payment\Model; 

use Payment\Model\AbstractAllowance; 

class Hardship extends AbstractAllowance { 
    
	/*
	 * This is hardship based 
	 */ 
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
		$employeeId = $employee->getEmployeeNumber(); 
		$positionId = $employee->getEmpPosition(); 
		if($this->isHaveHardship($positionId,$company,$dateRange)) {
		    return $this->getBasic($employee,$company,$dateRange)
		    * ($this->getHardshipPercentage()/100);
		}
		return 0; 
	}
	
	public function calculateExemption(Employee $employee,DateRange $dateRange) {
		return 0; 
	} 
	
	public function getHardshipPercentage() { 
		return 70; 
	}
	
	public function isHaveHardship($positionId,Company $company,DateRange $dateRange) { 
		
		
		 $isHave = $this->companyAllowance
		                ->isHaveHardship($positionId,$company);
		 // if($employeeId == '1249') {
		  //echo $isHave;
		  //exit;
		  //}
		  return $isHave;
		// for this company
		// for this time duration
		// do they have hardship allowance for this location for that particular time 
		// return 1;  
	} 
    
	public function getTableName() { 
		return "Hardship"; 
	}  
     
}   