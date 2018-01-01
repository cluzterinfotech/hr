<?php 

namespace Payment\Model;

use Payment\Model\ReferenceParameter;

class SocialInsuranceCompany extends AbstractDeduction { 

    public function calculateDeductionAmount(Employee $employee,DateRange $dateRange) {   
    	$siAmount = 0;
        if($this->isExemptedFromSI($employee,$dateRange)) {
        	return 0; 
        } 
        
        if($this->isAppointedBefore($employee,$dateRange)) {
        	return 0;
        }
        
        $company = $this->service->get('company');
        $socialInsuranceAllowance = $this->companyAllowance
                                         ->getSocialInsuranceAllowance($company,$dateRange); 
        foreach($socialInsuranceAllowance as $allowanceName => $serviceName) {
        	$amount = 0;
        	$service = $this->service->get($serviceName);
        	$amount = $service->getAmount($employee,$dateRange);
        	
        	$siAmount += $amount;
        	
        } 
        $percentage = $this->getPercentage(); 
    	return ($siAmount * $percentage); 
	}   
    
	public function calculateDeductionExemption(Employee $employee,DateRange $dateRange) { 
	    // 
		return 0;
	}
    
	public function getPercentage() {
		return 0.17;
	}
    
	public function getTableName() {
		return "SocialInsuranceCompany"; 
	} 
	
}