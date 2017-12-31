<?php 

namespace Payment\Model;

use Payment\Model\ReferenceParameter;
// calculated at runtime
class Cooperation extends AbstractDeduction { 

	// protected $amount; 
    public function calculateDeductionAmount(Employee $employee,DateRange $dateRange) {   
        return 0;
	}
    
	public function calculateDeductionExemption(Employee $employee,DateRange $dateRange) { 
	    return 0;
	}
    
	public function getTableName() {
		return "Cooperation";  
	} 
	
}