<?php 

namespace Payment\Model;

// calculated at runtime
class Telephone extends AbstractDeduction { 

	// protected $amount; 
    public function calculateDeductionAmount(Employee $employee,DateRange $dateRange) {   
        
	}
    
	public function calculateDeductionExemption(Employee $employee,DateRange $dateRange) { 
	    
	}
    
	public function getTableName() {
		return "Telephone"; 
	} 
	
}