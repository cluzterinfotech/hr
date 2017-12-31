<?php 

namespace Payment\Model;

use Payment\Model\ReferenceParameter;

class Initial extends AbstractAllowance {  
	
    public function calculateAmount(Employee $employee,DateRange $dateRange) { 
		$empService = $this->service->get('employeeService'); 
		$employeeNumber = $employee->getEmployeeNumber();  
		return $empService->getEmployeeInitialFromBuffer($employeeNumber);  
	}
	
	public function calculateExemption(Employee $employee,DateRange $dateRange) {
	    // @todo fetch from db 
		//return '787.5'; 
		return 0; 
	} 
    
	public function getTableName() { 
		return "Initial"; 
	}    
}