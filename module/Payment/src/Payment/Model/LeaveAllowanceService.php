<?php 
namespace Payment\Model;

use Payment\Model\Company;
use Payment\Model\DateRange;

class LeaveAllowanceService extends Payment { 
    
    protected $paysheet = array(); 
    
    public function getPaysheetMapper() { 
    	return $this->service->get('PaysheetMapper'); 
    } 
    
    /*public function removePreviousCalculation(Company $company) {
        $this->getPaysheetMapper();    	
    }*/  
    
    public function getNonPayDays($employeeId,$fromDate,$toDate) {
    	$service = $this->service->get('NonPaymentDaysService'); 
    	//return 0; 
    	$days = $service->getEmployeePaysheetNonWorkingDays($employeeId,$fromDate,$toDate);
    	/* if($employeeId == '1071') {
    	    echo "lamees non pay days ".$days;
    	    exit;
    	} */
    	return $days;
    }
	 
	public function calculate($employeeList,Company $company,DateRange $dateRange,$routeInfo) {        	
	 	try { 
	 	    $this->transaction->beginTransaction(); 
	 	    
	 	    /*$this->getPaysheetMapper()->removepaysheet($company,$dateRange); 
	 	     
	 	    $allowanceList = $this->companyAllowance
	 	                          ->getPaysheetAllowance($company,$dateRange); 
	 	    $runtimeAllowanceList = $this->companyAllowance
	 	                                 ->getRuntimeAllowance($company,$dateRange); 
            
	 	    $paysheetMapper = $this->service->get('paysheetMapper'); 
	 	    // @todo fetch from DB   
	 	    $dateMethods = $this->service->get('dateMethods'); 
	 	    
	 	    $fromDate = $dateRange->getFromDate();
	 	    $toDate = $dateRange->getToDate(); 
	 	    $companyId = $company->getId();
            	 	    
	 	    $daysInMonth = $dateMethods->numberOfDaysBetween($fromDate,$toDate); 
            
	 	    foreach($employeeList as $employee) { 
	 	    	$amount = 0; 
	 	    	$nonPayDays = 0;  
	 	    	$paysheetSum = 0; 
	 	    	$this->paysheet = '';  
	 	    	
	 	    	$employeeId = $employee->getEmployeeNumber(); 
	 	    	$nonPayDays = $this->getNonPayDays($employeeId,$fromDate,$toDate);  
	 	    	
	 	    	$workDays = $daysInMonth - $nonPayDays; 
	 	    	
	 	    	//echo "days in month ".$daysInMonth."<br/>";
	 	    	//echo "Emp No ".$employeeId." Non Pay Days ".$nonPayDays."<br/>";  
	 	    	
		 	    foreach($allowanceList as $allowanceName => $typeName) { 
		 	    	$amount = 0;
		 	    	// @todo revise 
		 	    	$n = $typeName; //$allowance['allowanceType'];
		 	    	//echo "Type ".$typeName."<br/>"; 
		 	    	$service = $this->service->get($n); 
			 		$amount = $service->getAmount($employee,$dateRange);  
			 		//echo "Amount ".$amount."<br/>"; 
			 		//exit; 
	 	    	    $a = $allowanceName; //$allowance['allowanceName'];
	 	    	    $amount = $this->workingDaysPay($amount,$daysInMonth,$workDays);
	 	    	    $paysheetSum += $amount;
			 		$this->paysheet[$a] = $this->twoDigit($amount);
		        }
		        
                //echo $employee->getEmployeeNumber()."<br/>"; 
                //exit; 
		        $this->paysheet['employeeNumber'] = $employeeId; 
		        $this->paysheet['company'] = $company->getId();
		        $this->paysheet['PsheetClosed'] = 0; 
		        $this->paysheet['paysheetDate'] = $dateRange->getFromDate(); 
		        // \Zend\Debug\Debug::dump($this->paysheet);  
		        $paysheetMapper->insert($this->paysheet);  */
		        // exit;   
	 	    //} 
	 	    // exit; 
	 	    $this->getCheckListService()->checkListlog($routeInfo);   
		    
		    $this->transaction->commit();  
		} catch(\Exception $e) { 
		 	$this->transaction->rollBack(); 
		 	throw $e; 
		} 
		// return $this->paysheet;   
	 } 
	  
	 protected function workingDaysPay($amount,$daysInMonth,$workDays) {
	     return ($amount/$daysInMonth) * $workDays;
	 }
	 
	 public function isPaysheetClosed(Company $company,DateRange $dateRange) { 
	     return $this->getPaysheetMapper()->isPaysheetClosed($company,$dateRange); 
	     // return false;    	
	 }
	 
	 public function close(Company $company,DateRange $dateRange,$routeInfo) {
	 	try { 
	 		$this->transaction->beginTransaction(); 
	 		// @todo close 
	 		$this->closePaysheetPFDeduction($company,$dateRange); 
	 		// done but need to test 
	 		$this->closeAdvancePaymentDeduction($company,$dateRange); 
	 		$this->getPaysheetMapper()->closeThisPaysheet($company,$dateRange);  
	 	    $this->getCheckListService()->closeLog($routeInfo); 
	 	    $this->transaction->commit();  
	 	} catch(\Exception $e) {  
	 		$this->transaction->rollBack(); 
	 		throw $e;  
	 	} 
	 }  
	 
	 // update PF deduction 
	 public function closePaysheetPFDeduction(Company $company,DateRange $dateRange) {
	     // @todo 
	     // get pf deduction 
	 } 
	 
	 // update Advance Payment Deductions 
	 public function closeAdvancePaymentDeduction(Company $company,DateRange $dateRange) {
	     // @todo  
         $advPaymentService = $this->getAdvancePaymentService(); 
         $advPaymentService->closeAdvancePaymentDeduction($company,$dateRange); 
	 } 
	 
	 public function getPaysheetReport(Company $company,$param) {
	 	return $this->getPaysheetMapper()->getPaysheetReport($company,$param);
	 }   
	 
	 public function getAdvancePaymentService() {
	     return $this->service->get('advancePaymentService');
	 }
     
} 