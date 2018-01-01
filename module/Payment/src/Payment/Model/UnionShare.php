<?php 

namespace Payment\Model;

use Payment\Model\ReferenceParameter;

class UnionShare extends AbstractDeduction {  
	
    public function calculateDeductionAmount(Employee $employee,DateRange $dateRange) {   
        
	}
    
	public function calculateDeductionExemption(Employee $employee,DateRange $dateRange) { 
	    
	}
    
	public function getTableName() {
		return "UnionShare";
	} 
	
}