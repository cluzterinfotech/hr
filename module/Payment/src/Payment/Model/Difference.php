<?php 
namespace Payment\Model;

use Payment\Model\Company;
use Payment\Model\DateRange;

class Difference extends Payment { 
    
    protected $difference = array();  
    
    public function getDifferenceMapper() { 
    	return $this->service->get('differenceMapper'); 
    } 
    
    /*public function removePreviousCalculation(Company $company) {
        $this->getDifferenceMapper();    	
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
	 
	public function calculate($data,Company $company,$routeInfo) { 
	            	
	 	try { 
	 	    $this->transaction->beginTransaction(); 
	 	    $dateMethods = $this->service->get('dateMethods');
	 	    $employeeMapper = $this->service->get('paysheet');
	 	    $fromDate = $data->getDifferenceFromDate();
	 	    $toDate = $data->getDifferenceToDate();
	 	    
	 	    $fromDate = $dateMethods->getFirstDayOfDate($fromDate);
	 	    $toDate = $dateMethods->getFirstDayOfDate($toDate);
	 	    
	 	    $shortDesc = $data->getDiffShortDescription();
	 	     
	 	    $differenceMapper = $this->getDifferenceMapper();
	 	    
	 	    $this->getDifferenceMapper()->removedifference($company);
	 	    
	 	    if($fromDate == $toDate) {
	 	    	$noOfMonths = 1; 
	 	    } else {
	 	        $noOfMonths = $dateMethods->numberOfMonthsBetween($fromDate,$toDate); 
	 	    } 
	 	    //\Zend\Debug\Debug::dump($noOfMonths); 
	 	    //exit;           
	 	    for($i=0;$i<=$noOfMonths;$i++) {
	 	        //echo $i."<br/>"; 
	 	    	$mydate = date("Y-m-d",mktime(0, 0, 0,date("m",strtotime($fromDate)) + $i,
	 	    			date("d",strtotime($fromDate)),date("Y",strtotime($fromDate))
	 	    	)); 
	 	    	$dateRange = $this->prepareDateRange($mydate);
	 	    	//\Zend\Debug\Debug::dump($dateRange);
	 	    	//exit; 
	 	    	$daysInMonth = $dateMethods->numberOfDaysInMonth($fromDate);
                	 	    	 
	 	    	$allowanceList = $this->companyAllowance
	 	    	                      ->getPaysheetAllowance($company,$dateRange);
	 	    	$runtimeAllowanceList = $this->companyAllowance
	 	    	                             ->getRuntimeAllowance($company,$dateRange);
	 	    	$compulsoryDeduction = $this->companyDeduction
	 	    	                            ->getPaysheetCompulsoryDeduction($company, $dateRange);
	 	    	$normalDeduction = $this->companyDeduction
	 	    	                        ->getPaysheetNormalDeduction($company,$dateRange);
	 	    	$advancePaymentDeduction = $this->companyDeduction
	 	    	                                ->getAdvancePaymentDeduction($company,$dateRange);
	 	    	$companyContributionDeduction = $this->companyDeduction
	 	    	                                     ->getCompanyContributionDeduction($company,$dateRange);
	 	    	
	 	    	$paysheetList = $employeeMapper->fetchPaysheetEmployee($company,$dateRange); 
	 	    	
	 	    	//\Zend\Debug\Debug::dump($paysheetList);
	 	    	
	 	    	foreach($paysheetList as $paysheet) {
	 	    		$amount = 0;
	 	    		$nonPayDays = 0;
	 	    		$paysheetSum = 0;
	 	    		$differenceSum = 0; 
	 	    		$this->difference = '';
	 	    		//\Zend\Debug\Debug::dump($paysheet);
	 	    		//exit; 
	 	    		$employeeId = $paysheet['employeeNumber']; 
	 	    		
	 	    		$employee = $this->getEmployeeById($employeeId); 
	 	    		
	 	    		$nonPayDays = $this->getNonPayDays($employeeId,$fromDate,$toDate); 
	 	    		
	 	    		$workDays = $daysInMonth - $nonPayDays; 
	 	    		
	 	    		// $paidAsDifference = $this->getPaidDifferenceAmount($employeeId,$dateRange); 
	 	    		
	 	    		foreach($allowanceList as $allowanceName => $typeName) { 
	 	    			$amount = 0;
	 	    			//\Zend\Debug\Debug::dump($allowanceList); 
	 	    			$paidAsSalary = $paysheet[$allowanceName]; 
	 	    			//echo "Allowance ".$allowanceName."<br/>"; 
	 	    			//echo "In Salary ".$paidAsSalary."<br/>"; 
	 	    			$service = $this->service->get($typeName); 
	 	    			$actual = $service->getAmount($employee,$dateRange); 
	 	    			//echo "Actual ".$actual."<br/>"; 
	 	    			$paidAsDifference = $this->getPaidDifferenceAmount($employeeId,$dateRange,
	 	    					$allowanceName,$typeName); 
	 	    			//echo "Difference Paid Already ".$paidAsDifference."<br/>"; 
	 	    			$amount = $actual - ($paidAsSalary + $paidAsDifference); 
	 	    			//echo "Difference ".$amount."<br/>"; 
	 	    			$a = $allowanceName; //$allowance['allowanceName'];
	 	    			$amount = $this->workingDaysPay($amount,$daysInMonth,$workDays);
	 	    			$differenceSum += $amount;
	 	    			//echo $allowanceName." - ".$amount."<br/>";  
	 	    			$this->difference[$a] = $this->twoDigit($amount); 
	 	    			
	 	    		}
	 	    		
	 	    		foreach($runtimeAllowanceList as $allowanceName => $typeName) {
	 	    			$amount = 0;
	 	    			$paidAsSalary = $paysheet[$allowanceName];
	 	    			$service = $this->service->get($typeName);
	 	    			$actual = $service->calculateAmount($employee,$dateRange);
	 	    		
	 	    			$paidAsDifference = $this->getPaidDifferenceAmount($employeeId,$dateRange,
	 	    					$allowanceName,$typeName);
	 	    		
	 	    			$amount = $actual - ($paidAsSalary + $paidAsDifference);
	 	    			$a = $allowanceName; //$allowance['allowanceName'];
	 	    			$amount = $this->workingDaysPay($amount,$daysInMonth,$workDays);
	 	    			$differenceSum += $amount;
	 	    			//echo $allowanceName." - ".$amount."<br/>";  
	 	    			$this->difference[$a] = $this->twoDigit($amount);
	 	    		
	 	    		} 
	 	    		
	 	    		foreach($compulsoryDeduction as $allowanceName => $typeName) {
	 	    			$amount = 0;
	 	    			$paidAsSalary = $paysheet[$allowanceName];
	 	    			$service = $this->service->get($typeName);
	 	    			$actual = $service->calculateDeductionAmount($employee,$dateRange);
	 	    			 
	 	    			$paidAsDifference = $this->getPaidDifferenceAmount($employeeId,$dateRange,
	 	    					$allowanceName,$typeName);
	 	    			 
	 	    			$amount = $actual - ($paidAsSalary + $paidAsDifference);
	 	    			$a = $allowanceName; //$allowance['allowanceName'];
	 	    			$amount = $this->workingDaysPay($amount,$daysInMonth,$workDays);
	 	    			//$differenceSum += $amount;
	 	    			//echo $allowanceName." - ".$amount."<br/>";  
	 	    			$this->difference[$a] = $this->twoDigit($amount);
	 	    			 
	 	    		}
	 	    		
	 	    		$amount = 0;
	 	    		$paidTax = $paysheet['IncomeTax']; 
	 	    		$service = $this->service->get('IncomeTax'); 
	 	    		//\Zend\Debug\Debug::dump($differenceSum);  
	 	    		//exit; 
	 	    		// $amount = $service->customTax($employee,$dateRange,$this->difference);
	 	    		if($paidTax) {
	 	    		    $itAmount = $differenceSum - $this->difference['SocialInsurance'] 
	 	    		              - $this->difference['ProvidentFund']; 
	 	    		              //\Zend\Debug\Debug::dump($this->difference['SocialInsurance']);
	 	    		             // \Zend\Debug\Debug::dump($this->difference['ProvidentFund']);
	 	    		             // \Zend\Debug\Debug::dump($this->difference['Zakat']);
	 	    		    $amount = ($itAmount * 0.15); 
	 	    		    if($amount < 0) { 
	 	    		        $amount = 0;  
	 	    		    } 
	 	    		} 
	 	    		//$paidAsDifference = $this->getPaidDifferenceAmount($employeeId,$dateRange,
	 	    		  //  'IncomeTax','IncomeTax');
	 	    		
	 	    		//$amount = $actual - ($paidAsSalary + $paidAsDifference);
	 	    		//$amount = $service->calculateDeductionAmount($employee,$dateRange);
	 	    		// @todo if social insurance and first month
	 	    		//$amount = $this->workingDaysPay($amount,$daysInMonth,$workDays);
	 	    		// Compulsory deduction is based on amount received, so never be negative
	 	    		//$amount = $this->workingDaysPay($amount,$daysInMonth,$workDays);
	 	    		$differenceSum += $amount;
	 	    		$this->difference['IncomeTax'] = $this->twoDigit($amount);
	 	    		//}
	 	    		
	 	    		foreach($normalDeduction as $allowanceName => $typeName) {
	 	    			$amount = 0;
	 	    			$paidAsSalary = $paysheet[$allowanceName];
	 	    			$service = $this->service->get($typeName);
	 	    			$actual = $service->getDeductionAmount($employee,$dateRange);
	 	    			 
	 	    			$paidAsDifference = $this->getPaidDifferenceAmount($employeeId,$dateRange,
	 	    					$allowanceName,$typeName);
	 	    			 
	 	    			$amount = $actual - ($paidAsSalary + $paidAsDifference);
	 	    			$a = $allowanceName; //$allowance['allowanceName'];
	 	    			$amount = $this->workingDaysPay($amount,$daysInMonth,$workDays);
	 	    			//$differenceSum += $amount;
	 	    			$this->difference[$a] = $this->twoDigit($amount);
	 	    			 
	 	    		}
	 	    		
	 	    		foreach($companyContributionDeduction as $allowanceName => $typeName) {
	 	    			$amount = 0;
	 	    			$paidAsSalary = $paysheet[$allowanceName];
	 	    			$service = $this->service->get($typeName);
	 	    			$actual = $service->calculateDeductionAmount($employee,$dateRange);
	 	    			 
	 	    			$paidAsDifference = $this->getPaidDifferenceAmount($employeeId,$dateRange,
	 	    					$allowanceName,$typeName);
	 	    			 
	 	    			$amount = $actual - ($paidAsSalary + $paidAsDifference);
	 	    			$a = $allowanceName; //$allowance['allowanceName'];
	 	    			$amount = $this->workingDaysPay($amount,$daysInMonth,$workDays);
	 	    			//$differenceSum += $amount;
	 	    			$this->difference[$a] = $this->twoDigit($amount);
	 	    			 
	 	    		}
	 	    		
	 	    	    
	 	    		// @todo Leave Allowance  Difference  
		            //$leaveAllowance = $this->getLeaveAllowance(); 
		            //$leaveAllowanceDiff = $this->getLeaveAllowanceDiff();  
		            //$leaveAllowanceTaken = $this->getLeaveAllowanceTaken();  
		            
		            $this->difference['LeaveAllowance'] = 0; 
		            //$leaveAllowance - $leaveAllowanceDiff - $leaveAllowanceTaken; 
		            $this->difference['Eid'] = 0;
	 	    		
	 	    		$this->difference['employeeNumber'] = $employeeId;
	 	    		$this->difference['companyId'] = $company->getId();
	 	    		$this->difference['isClosed'] = 0;
	 	    		$this->difference['differenceDate'] = $dateRange->getFromDate();
	 	    		$this->difference['shortDescription'] = $shortDesc; 
	 	    		
	 	    		//\Zend\Debug\Debug::dump($this->difference);
	 	    		//exit; 
	 	    		 
	 	    		$differenceMapper->insert($this->difference); 
	 	    		
	 	    	}  
	 	    	
                
	 	    } 

	 	    
	 	    //exit;
	 	     
	 	    // get paysheet employee for that month 
	 	    
	 	    /* 
	 	    
	 	    $allowanceList = $this->companyAllowance
	 	                          ->getPaysheetAllowance($company,$dateRange); 
	 	    $runtimeAllowanceList = $this->companyAllowance
	 	                                 ->getRuntimeAllowance($company,$dateRange); 
	 	    $compulsoryDeduction = $this->companyDeduction
	 	                                ->getPaysheetCompulsoryDeduction($company, $dateRange);
	 	    $normalDeduction = $this->companyDeduction
	 	                            ->getPaysheetNormalDeduction($company,$dateRange);
	 	    $advancePaymentDeduction = $this->companyDeduction
	 	                            ->getAdvancePaymentDeduction($company,$dateRange);
	 	    $companyContributionDeduction = $this->companyDeduction
	 	                            ->getCompanyContributionDeduction($company,$dateRange);
	 	     
	 	    // @todo fetch from DB   
	 	    $dateMethods = $this->service->get('dateMethods'); 
	 	    
	 	    $fromDate = $dateRange->getFromDate(); 
	 	    $toDate = $dateRange->getToDate(); 
	 	    $companyId = $company->getId();
	 	    
	 	    $advancePaymentService = $this->getAdvancePaymentService();
	 	    $advancePaymentService->removeThisMonthDue($company); 
	 	    
	 	    $daysInMonth = $dateMethods->numberOfDaysBetween($fromDate,$toDate); 
            */
	 	    
	 	    // exit; 
	 	    $this->getCheckListService()->checkListlog($routeInfo);  
		    
		    $this->transaction->commit();  
		    
		} catch(\Exception $e) { 
		 	$this->transaction->rollBack(); 
		 	throw $e; 
		} 
		// return $this->paysheet;   
	 } 
	  
	 /*protected function workingDaysPay($amount,$daysInMonth,$workDays) {
	     return ($amount/$daysInMonth) * $workDays;
	 }*/ 
	 
	 protected function adjustAdvHousingSi() {
	     $housing = 0;
	 	 $zakat = 0;
	 	 $si = 0;
	 	 $coSi = 0;
	 	 $tax = 0;
	 	 $siAmt = 0;
	 	 $housing = $this->difference['Housing'];
	 	 // alter zakat
	 	 $zakat = $this->difference['Zakat'];
	 	 $zakat -= ($housing * .025);
	 	 $this->difference['Zakat'] = $zakat;
	 	 // alter social insurance
	 	 $si = $this->difference['SocialInsurance'];
	 	 $siAmt = ($housing * .08);
	 	 $si -= $siAmt;
	 	 $this->difference['SocialInsurance'] = $si;
	 	 // alter social insurance company
	 	 $coSi = $this->difference['SocialInsuranceCompany'];
	 	 $coSi -= ($housing * .17);
	 	 $this->difference['SocialInsuranceCompany'] = $coSi;
	 	 // alter tax
	 	 $tax = $this->difference['IncomeTax'];
	 	 $tax -= ($siAmt * .15);
	 	 $this->difference['SocialInsuranceCompany'] = $tax; 
	 }
	 
	 public function isPaysheetClosed(Company $company,DateRange $dateRange) { 
	     return $this->getDifferenceMapper()->isPaysheetClosed($company,$dateRange); 
	     // return false;    	
	 } 
	  
	 public function close(Company $company,$description,$routeInfo) { 
	 	try {  
	 		$this->transaction->beginTransaction();  
	 		$this->getDifferenceMapper()->closeThisDifference($company,$description);   
	 	    $this->getCheckListService()->closeLog($routeInfo);  
	 	    $this->transaction->commit();   
	 	} catch(\Exception $e) {  
	 		$this->transaction->rollBack(); 
	 		throw $e;  
	 	} 
	 	return "Difference closed successfully"; 
	 }  
	 
	 public function differenceDescription(Company $company) {
	 	return $this->getDifferenceMapper()->differenceDescription($company);
	 }
	 
	 public function getPaidDifferenceAmount($employeeId,DateRange $dateRange,$name,$type) {
	     return $this->getDifferenceMapper()->getPaidDifferenceAmount($employeeId,$dateRange,$name,$type); 	
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
	 
	 public function getDifferenceReport(Company $company,$param) {
	 	return $this->getDifferenceMapper()->getDifferenceReport($company,$param);
	 }   
	 
	 public function getAdvancePaymentService() {
	     return $this->service->get('advancePaymentService');
	 }
     
} 