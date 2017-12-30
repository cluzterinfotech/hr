<?php 

namespace Payment\Model;

use Payment\Model\ReferenceParameter;

class OverPayment extends AbstractDeduction { 
    
	// protected $amount; 
    
    public function calculateDeductionAmount(Employee $employee,DateRange $dateRange) {   
    	
        // $company = $this->service->get('company');
        // fetch deduction amount
        // return $this->companyDeduction->getOverPaymentDeduction($employee,$dateRange);
        return 0; 
	}   
    
	public function calculateDeductionExemption(Employee $employee,DateRange $dateRange) { 
	    // 
		return 0;
	}
	
	public function getPercentage() {
		return 0.08;
	}
    
	public function getTableName() {
		return "OverPayment";  
	} 
	
}