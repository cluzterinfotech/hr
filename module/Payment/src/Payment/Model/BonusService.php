<?php 
namespace Payment\Model;

use Payment\Model\Company;
use Payment\Model\DateRange;

class BonusService extends Payment {  
    
    protected $paysheet = array(); 
    
    public function getPaysheetMapper() { 
    	return $this->service->get('PaysheetMapper'); 
    } 
    
    public function getNonPayDays($employeeId,$fromDate,$toDate) {
    	$service = $this->service->get('NonPaymentDaysService'); 
    	$days = $service->getEmployeePaysheetNonWorkingDays($employeeId,$fromDate,$toDate); 
    	return $days;
    }
	 
	public function calculate($employeeList,Company $company,DateRange $dateRange,$routeInfo) { 
	    	
	 	try { 
	 	    $this->transaction->beginTransaction(); 
	 	    $this->getPaysheetMapper()->removepaysheet($company,$dateRange);  
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
	 	    $paysheetMapper = $this->service->get('paysheetMapper'); 
	 	    // @todo fetch from DB   
	 	    $dateMethods = $this->service->get('dateMethods'); 
	 	    
	 	    $fromDate = $dateRange->getFromDate();
	 	    $toDate = $dateRange->getToDate(); 
	 	    $companyId = $company->getId();
	 	    
	 	    $advancePaymentService = $this->getAdvancePaymentService();
	 	    $advancePaymentService->removeThisMonthDue($company); 
	 	    
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
	 	    	//\Zend\Debug\Debug::dump($allowanceList);
		 	    foreach($allowanceList as $allowanceName => $typeName) { 
		 	    	
		 	        //\Zend\Debug\Debug::dump($allowanceName);
		 	        //\Zend\Debug\Debug::dump($typeName);
		 	        //exit; 
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
		        // exit; 
		        // runtime calculation allowance  
		        foreach($runtimeAllowanceList as $allowanceName => $typeName) { 
		        	$amount = 0;
		        	// @todo revise
		        	$n = $typeName; //$allowance['allowanceType']; 
		        	$service = $this->service->get($n); 
		        	$amount = $service->calculateAmount($employee,$dateRange); 
		        	$a = $allowanceName; //$allowance['allowanceName']; 
		        	$amount = $this->workingDaysPay($amount,$daysInMonth,$workDays); 
		        	$paysheetSum += $amount; 
		        	$this->paysheet[$a] = $this->twoDigit($amount);  
		        }  
		        // echo "Paysheet Sum".$paysheetSum."<br/>"; 
		        // echo "Compulsory <br/>"; 
	 	        foreach($compulsoryDeduction as $key => $deductionName) {  
	 	        	$amount = 0; 
		 	    	$service = $this->service->get($deductionName);  
		 	    	//echo $deductionName."<br/>"; 
			 		$amount = $service->calculateDeductionAmount($employee,$dateRange);  
			 		
			 		// @todo if social insurance and first month  
			 		$amount = $this->workingDaysPay($amount,$daysInMonth,$workDays); 
			 		//\Zend\Debug\Debug::dump($paysheetSum); 
			 		//\Zend\Debug\Debug::dump($amount); 
			 		//exit; 
			 		// Compulsory deduction is based on amount received, so never be negative
			 		if($paysheetSum > $amount) {
			 		    $paysheetSum -= $amount;
			 		    $this->paysheet[$key] = $this->twoDigit($amount); 
			 		} 
		        }  
		        //echo "Paysheet Sum".$paysheetSum."<br/>"; 
		        //echo "Normal <br/>";  
	 	        foreach($normalDeduction as $key => $deductionName) { 
	 	        	$amount = 0; 
		 	    	$service = $this->service->get($deductionName); 
		 	    	//echo $deductionName."<br/>"; 
			 		$amount = $service->getDeductionAmount($employee,$dateRange); 
			 		$amount = $this->workingDaysPay($amount,$daysInMonth,$workDays); 
			 		//echo "Amount".$amount."<br/>"; 
			 		if($paysheetSum > $amount) { 
			 			$paysheetSum -= $amount; 
			 		    $this->paysheet[$key] = $this->twoDigit($amount); 
			 		} 
		        } 
		        // Advance payments deduction 
		        foreach($advancePaymentDeduction as $key => $deductionName) { 
		        	$amount = 0;  
		        	$info = $advancePaymentService->getThisMonthEmpAdvPaymentDue 
		        	                        ($deductionName,$employeeId,$dateRange);  
		        	if($info) { 
		        		$dueId = $info['id']; 
		        		$amount = $info['dueAmount'];  
		        		if($paysheetSum > $amount) {
		        			$paysheetSum -= $amount;
		        			$advancePaymentService->addThisMonthDue($deductionName,
		        					$dueId,$companyId,$dateRange);
		        			$this->paysheet[$key] = $this->twoDigit($amount);
		        		} else {
		        			$this->paysheet[$key] = 0; 
		        		}
		        	}  else {
		        		$this->paysheet[$key] = 0; 
		        	}  
		        }   
		         
		        // company contribution deduction 
		        foreach($companyContributionDeduction as $key => $deductionName) { 
		        	// @todo sync with employee contribution 
		        	$amount = 0;  
		        	$service = $this->service->get($deductionName); 
		        	//echo $deductionName."<br/>"; 
		        	$amount = $service->calculateDeductionAmount($employee,$dateRange); 
		        	$amount = $this->workingDaysPay($amount,$daysInMonth,$workDays); 
		        	//echo "Amount".$amount."<br/>"; 
		        	//if($paysheetSum > $amount) { 
		        		//$paysheetSum -= $amount; 
		        	$this->paysheet[$key] = $this->twoDigit($amount);
		        	//} 
		        } 
		        // \Zend\Debug\Debug::dump($this->paysheet);
		        // \Zend\Debug\Debug::dump($this->paysheet['Housing']); 
                
		        // if have advance housing
		        $advHous = $advancePaymentService->getThisMonthEmpAdvPaymentDue 
		        	                        ('AdvanceHousing',$employeeId,$dateRange);
		        if($advHous) {  
		        	//echo $this->paysheet['Housing']."<br/>"; 
		        	//echo "inside adv housing Deductable<br/>";
		        	$this->paysheet['Housing'] = 0;  
		        	$dueId = $advHous['id']; 
		        	$amount = $advHous['dueAmount']; 
		        	if($paysheetSum > $amount) { 
		        		$advancePaymentService->addThisMonthDue($deductionName,
		        				$dueId,$companyId,$dateRange); 
		        	} else {
		        		//echo "inside adv housing non deductable";
		        		$housing = 0;
		        		$zakat = 0;
		        		$si = 0;
		        		$coSi = 0;
		        		$tax = 0;
		        		$siAmt = 0;
		        		$housing = $this->paysheet['Housing'];
		        		// alter zakat
		        		$zakat = $this->paysheet['Zakat'];
		        		$zakat -= ($housing * .025);
		        		$this->paysheet['Zakat'] = $zakat;
		        		// alter social insurance
		        		$si = $this->paysheet['SocialInsurance'];
		        		$siAmt = ($housing * .08);
		        		$si -= $siAmt;
		        		$this->paysheet['SocialInsurance'] = $si;
		        		// alter social insurance company
		        		$coSi = $this->paysheet['SocialInsuranceCompany'];
		        		$coSi -= ($housing * .17);
		        		$this->paysheet['SocialInsuranceCompany'] = $coSi;
		        		// alter tax
		        		$tax = $this->paysheet['IncomeTax'];
		        		$tax -= ($siAmt * .15);
		        		$this->paysheet['SocialInsuranceCompany'] = $tax;
		        	}
		        } 
		        
		        // $isHaveAdvHous
		        // check is more than net pay 
		        // 
		        
                //echo $employee->getEmployeeNumber()."<br/>"; 
                //exit;  
		        $this->paysheet['employeeNumber'] = $employeeId;// $employee->getEmployeeNumber(); 
		        $this->paysheet['company'] = $company->getId();
		        $this->paysheet['PsheetClosed'] = 0; 
		        $this->paysheet['paysheetDate'] = $dateRange->getFromDate(); 
		        // \Zend\Debug\Debug::dump($this->paysheet);  
		        // @todo add company contribution deduction  
		        $paysheetMapper->insert($this->paysheet);  
		        // exit;   
	 	    }  
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
	 
	 public function isPaysheetClosed(Company $company,DateRange $dateRange) { 
	     return $this->getPaysheetMapper()->isPaysheetClosed($company,$dateRange); 
	     // return false;    	
	 }
	 
	 public function fetchPaysheetEmployee(Company $company,DateRange $dateRange) { 
	 	return $this->getPaysheetMapper()->fetchPaysheetEmployee($company,$dateRange); 
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

	 public function fetchPaysheetView(Company $company,$param) {
	 	return $this->getPaysheetMapper()->fetchPaysheetView($company,$param);
	 }
	 
	 public function getAdvancePaymentService() {
	     return $this->service->get('advancePaymentService');
	 }
	 
	 public function getLastMonthPendingToEmployee(Employee $employee,$relievingDate) {
	     list($year,$month,$day) = explode('-', $relievingDate); 
	     $firstDay = $this->dateMethods->getFirstDayOfDate($relievingDate);
	     $dateRange = $this->prepareDateRange($firstDay); 
	     $paysheetMapper = $this->getPaysheetMapper(); 
	 	 $employeeId = $employee->getEmployeeNumber(); 
	 	 $isLastPayTaken = $paysheetMapper->isTakenThisMonthSal($employeeId,$dateRange); 
	 	 
	 	 if(!$isLastPayTaken) { 
	 	     $fromDate = $dateRange->getFromDate(); 
	 		 $numberOfDays = $this->dateMethods->numberOfDaysBetween($fromDate,$relievingDate);  
	 		 //$dateRange = $this->prepareDateRange($firstDay);
	 		 $company = $this->service->get('company');
	 		 
	 		 $gross = $this->getGross($employee,$company,$dateRange); 
	 		 $per = ($gross)/30;
	 		 return $numberOfDays * $per;
	 	}
	 	return 0;
	 }
	 
	 public function getLastMonthPendingToCompany(Employee $employee,$relievingDate) {
	 	list($year,$month,$day) = explode('-', $relievingDate);
	 	$firstDay = $this->dateMethods->getFirstDayOfDate($relievingDate);
	 	$dateRange = $this->prepareDateRange($firstDay);
	 	$paysheetMapper = $this->getPaysheetMapper();
	 	$employeeId = $employee->getEmployeeNumber();
	 	$isLastPayTaken = $paysheetMapper->isTakenThisMonthSal($employeeId,$dateRange);
	 
	 	if($isLastPayTaken) {
	 		$toDate = $dateRange->getToDate();
	 		$numberOfDays = $this->dateMethods->numberOfDaysBetween($relievingDate,$toDate);
	 		//$dateRange = $this->prepareDateRange($firstDay);
	 		$company = $this->service->get('company');
	 	 	
	 		$gross = $this->getGross($employee,$company,$dateRange);
	 		$per = ($gross)/30;
	 		return $numberOfDays * $per;
	 	}
	 	return 0;
	 } 
     
} 