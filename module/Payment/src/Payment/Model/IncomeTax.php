<?php 

namespace Payment\Model;

use Payment\Model\ReferenceParameter;

class IncomeTax extends AbstractDeduction { 

	// protected $amount;
	
    protected $paysheet = array(); 
    
    public function getCustomAmount($name) {
        return $this->paysheet[$name]; 
    }
	
    public function customTax(Employee $employee,DateRange $dateRange,$paysheetArray) {
        $this->paysheet = $paysheetArray; 
        //\Zend\Debug\Debug::dump($this->paysheet);
        return $this->calculateDeductionAmount($employee,$dateRange); 
    }
	
	public function calculateDeductionAmount(Employee $employee,DateRange $dateRange) {   
		try { 
			$taxable = 0;
			$temp = 0;
			$incometax = 0;
			$amount = 0;
			$exemption = 0;
			// $company = $employee->getCompanyId(); 
			$company = $this->service->get('company');
	 	    $allowanceList = $this->companyAllowance
	 	                          ->getIncometaxAllowance($company,$dateRange); 
	 	    $runtime = $this->companyAllowance
	 	                    ->getRuntimeAllowance($company,$dateRange);
	 	    $incometaxExemptionDeduction = $this->companyDeduction
	 	                                ->getIncometaxExemptedDeduction($company,$dateRange); 
            
		 	foreach($allowanceList as $allowanceName => $typeName) {       
		 		$temp = 0;  
		 		$service = $this->service->get($typeName); 
		 		$amount = $this->getCustomAmount($allowanceName);
			 	//$amount = $service->getAmount($employee,$dateRange);
		 		//\Zend\Debug\Debug::dump($typeName);
			 	$exemption = $service->getExemption($employee,$dateRange);
		 	    $temp = $amount - $exemption;
		 	    //echo $allowanceName." : ".$amount."<br/>"; 
		 	   // echo $allowanceName." : ".$exemption."<br/>";
		 	    //echo $temp."<br/>";
	 	        if($temp > 0) {
	 	    	    $taxable += $temp;
	 	        }
		    } 
		    //echo "Allowance".$taxable."<br/>";
		    foreach($runtime as $allowanceName => $typeName) {
		    	$temp = 0;
		    	$service = $this->service->get($typeName);
		    	$amount = $this->getCustomAmount($allowanceName); 
		    	//$amount = $service->calculateAmount($employee,$dateRange);
		    	// \Zend\Debug\Debug::dump($employee);
		    	$exemption = $service->calculateExemption($employee,$dateRange);
		    	$temp = $amount - $exemption;
		    	//echo $allowanceName." : ".$amount."<br/>";
		    	//echo $allowanceName." : ".$exemption."<br/>";
		    	//echo $temp."<br/>";
		    	if($temp > 0) {
		    		$taxable += $temp; 
		    	} 
		    } 
		    //echo "Runtime Allowance".$taxable."<br/>"; 
		    //\Zend\Debug\Debug::dump($taxable); 
	        // incometax exemption deduction 	    
	 	    foreach($incometaxExemptionDeduction as $key => $deductionName) { 
	 	    	$temp = 0; 
		 	    $service = $this->service->get($deductionName); 
		 	    
		 	    $amount = $this->getCustomAmount($key); 
			 	//echo $deductionName." : ".$amount."<br/>"; 
			 	//echo $deductionName."<br/>";
			 	//echo $amount."<br/>";
			 	$taxable -= $amount;  
		    }   
		   // echo "Ded exemption".$taxable."<br/>";
		   // \Zend\Debug\Debug::dump($taxable); 
		    $ageExem = $this->getAgeExemptionAmount($employee,$dateRange); 
		    $taxable = $taxable - $ageExem; 
		    //echo "age exemption".$ageExem."<br/>";
		    //\Zend\Debug\Debug::dump($taxable); 
            $incometax = $this->companyDeduction->getTax($taxable);
           // \Zend\Debug\Debug::dump($incometax);
           // exit; 
	 	} catch(\Exception $e) { 
	 		throw $e; 
	 	} 
	 	
	 	//if($employee->getEmployeeNumber() == '1009') {
	 	    //echo $incometax; 
	 	    //exit; 
	 	//}
	 	//echo $incometax;
	 	//exit; 
	 	return $incometax; 
	} 
	
	private function getAgeExemptionAmount(Employee $employee,DateRange $dateRange) {
		if($this->isExemptedFromTax($employee,$dateRange)) {
			return 1214; 
		} 
		return 0; 
	} 
	
	public function calculateDeductionExemption(Employee $employee,DateRange $dateRange) { 
		return 0; 
	}
    
	public function getTableName() {
		return "IncomeTax";
	} 
	
}