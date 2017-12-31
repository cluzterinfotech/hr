<?php 

namespace Payment\Model;

use Payment\Model\ReferenceParameter;
// calculated at runtime
class ProvidentFund extends AbstractDeduction { 

	// protected $amount; 
	
    public function calculateDeductionAmount(Employee $employee,DateRange $dateRange) { 
    	
    	if($this->isAppointedBefore($employee,$dateRange)) {
    		$amount = 0;
    		$company = $this->service->get('company');
    		$pfAllowances = $this->companyAllowance
    		                     ->getPFAllowance($company,$dateRange); 
    		$per = $this->getProvidentFundShare($employee,$dateRange); 
    		foreach ($pfAllowances as $allowanceName => $typeName) { 
    			$allowance = $this->service->get($typeName); 
    			$amount += $allowance->getAmount($employee,$dateRange);  
    		} 
    		//echo $amount;
    		//exit;
    		if ($amount) {
    			return $amount * ($per['employeeShare']/100); 
    		} else {
    			return 0;
    		}
    	} else {
    		return 0; 
    	} 
	}
    
	public function calculateDeductionExemption(Employee $employee,DateRange $dateRange) { 
	    return 0;
	}
    
	public function getTableName() {
		return "ProvidentFund";
	} 
	
}