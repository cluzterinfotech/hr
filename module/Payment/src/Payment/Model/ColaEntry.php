<?php 

namespace Payment\Model;

use Payment\Model\ReferenceParameter;

class ColaEntry extends AbstractAllowance {  
	
    public function calculateAmount(Employee $employee,DateRange $dateRange) {
        $empService = $this->service->get('employeeService');
    	$employeeNumber = $employee->getEmployeeNumber();
    	return $empService->getEmployeeCola($employeeNumber);
	}
	
	public function calculateExemption(Employee $employee,DateRange $dateRange) {
		return 0; 
	}
    
	public function getTableName() {
		return "Cola";
	}
    
}