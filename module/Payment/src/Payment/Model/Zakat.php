<?php

namespace Payment\Model;

use Zend\Db\Adapter\Adapter, 
    Application\Contract\EntityCollectionInterface, 
    Payment\Model\Employee,
    Payment\Model\Company,
    Payment\Model\DateRange;
use Payment\Model\AbstractDeduction;

class Zakat extends AbstractDeduction {
	
    public function calculateDeductionAmount(Employee $employee,DateRange $dateRange) {  
    	$total = 0;
    	$company = $this->service->get('company');
    	$allowanceList = $this->companyAllowance
    	                      ->getPaysheetAllowance($company,$dateRange); 
    	$runtime = $this->companyAllowance
	 	                    ->getRuntimeAllowance($company,$dateRange);
        if($employee->getReligion()  == 1) {
            foreach($allowanceList as $allowanceName => $typeName) { 
		 	    $amount = 0; 
		 	    $n = $typeName;  
		 	    $service = $this->service->get($n); 
			 	$amount = $service->getAmount($employee,$dateRange);  
	 	    	$total += $amount; 
		    }  
		    
		    foreach($runtime as $allowanceName => $typeName) {
		    	$amount = 0;
		    	$n = $typeName;
		    	$service = $this->service->get($n);
		    	$amount = $service->calculateAmount($employee,$dateRange);
		    	$total += $amount;
		    }
		    
		    $zakatAllowanceExemp = $this->zakaAllowanceExemp($employee,$company,$dateRange);
		    //\Zend\Debug\Debug::dump($total);
		    //\Zend\Debug\Debug::dump($zakatAllowanceExemp); 
		    $total = $total - $zakatAllowanceExemp - $this->zakatAmountExemp(); 
		    //\Zend\Debug\Debug::dump($total); 
		    //exit;  
		    $zakatRange = $this->getZakatRange(); 
		    if($total >= $zakatRange) {  
		    	return (($total)*(0.025));  
		    }  
        } else {  
        	return 0;   
        }  
    	return 0;  
	} 
	
	private function zakaAllowanceExemp(Employee $employee,
			Company $company,DateRange $dateRange) {  
		$total = 0; 
		$allowanceExem = $this->companyAllowance
    	                      ->getZakatExemAllowance($company,$dateRange); 
		foreach($allowanceExem as $allowanceName => $typeName) { 
			$amount = 0;
			$n = $typeName;
			$service = $this->service->get($n);
			$amount = $service->getAmount($employee,$dateRange);
			$total += $amount;
		}
		if($total > 0) {
			return $total;
		}
		return 0;
	}
	
	private function zakatAmountExemp() { 
		// @todo fetch from db
		return 5705;
		
	}
	
	private function getZakatRange() {
		// @todo fetch from db
		return 1837; 
	} 
    
	public function calculateDeductionExemption(Employee $employee,DateRange $dateRange) { 
	    return 0;
	}
    
	public function getTableName() {
		return "Zakat";
	} 
    
}