<?php

namespace Payment\Model;

use Zend\Db\Adapter\Adapter, 
    Application\Contract\EntityCollectionInterface, 
    Payment\Model\Employee,
    Payment\Model\Company,
    Payment\Model\DateRange;
use Payment\Model\AbstractDeduction;

class ZakatVTwo extends AbstractDeduction {
	
    public function calculateDeductionAmount(Employee $employee,DateRange $dateRange) {  
    	$total = 0;
    	$company = $this->service->get('company');
    	$allowanceList = $this->companyAllowance
    	                      ->getPaysheetAllowance($company,$dateRange); 
        if($employee->getReligion()  == 1) {
            foreach($allowanceList as $allowanceName => $typeName) { 
		 	    $amount = 0;
		 	    $n = $typeName; 
		 	    $service = $this->service->get($n); 
			 	$amount = $service->getAmount($employee,$dateRange);  
	 	    	$total += $amount;
		    }  
		    //\Zend\Debug\Debug::dump($total); 
		    //exit;  
		    $zakatRange = $this->getZakatRange(); 
		    if($total >= $zakatRange) {  
		    	return (($total - $zakatRange)*(0.025));  
		    }  
        } else {  
        	return 0;   
        }  
    	return 0;  
	} 
	
	private function getZakatRange() {
		// @todo fetch from db
		return 520;
	} 
    
	public function calculateDeductionExemption(Employee $employee,DateRange $dateRange) { 
	    return 0;
	}
    
	public function getTableName() {
		return "Zakat";
	} 
    
}