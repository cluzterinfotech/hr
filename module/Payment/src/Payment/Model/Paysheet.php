<?php 
namespace Payment\Model;

use Payment\Model\Company;
use Payment\Model\DateRange;
use Payment\Model\Employee; 

class Paysheet extends Payment { 
    
    //protected $paysheet = array(); 
    
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
    
    protected function loadEntity(array $row) {
        $employee = new Employee(); 
        $employee->setId($row['id']);
        $employee->setEmployeeName(trim($row['employeeName']));
        $employee->setEmployeeNumber(trim($row['employeeNumber']));
        $employee->setEmpJoinDate($row['empJoinDate']);
        $employee->setEmpSalaryGrade($row['empSalaryGrade']);
        $employee->setCompanyId($row['companyId']);
        $employee->setEmpDateOfBirth($row['empDateOfBirth']);
        $employee->setReligion($row['religion']);
        $employee->setEmpPosition($row['empPosition']);
        $employee->setMaritalStatus($row['maritalStatus']);
        $employee->setNumberOfDependents($row['numberOfDependents']);
        $employee->setEmpLocation($row['empLocation']);
        //$employee->setCompanyId($row['religion']);
        //$employee->setSalaryGradeId($row['lkpSalaryGradeId']);
        //$employee->setEmpPersonalInfoId(
        //$this->person->fetchById($row['empPersonalInfoId'])
        //);
        return $employee;
    }
    
    /*public function getPaysheetEmployeeList($condition) {
        return $this->companyAllowance->getPaysheetEmployeeList($condition);
    }*/
	 
	public function calculate($condition,Company $company,DateRange $dateRange,$routeInfo) { 
	 	try { 
	 	    $this->transaction->beginTransaction(); 
	 	    $this->getPaysheetMapper()->removepaysheet($company,$dateRange);  
	 	    $allowanceList = $this->companyAllowance
	 	                          ->getPaysheetAllowance($company,$dateRange); 
	 	    //\Zend\Debug\Debug::dump($allowanceList);
	 	    //exit; 
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
	 	    //echo "from date".$fromDate;
	 	    //echo "<br/>to date".$toDate;
	 	    //exit; 
	 	    $advancePaymentService = $this->getAdvancePaymentService();
	 	    $advancePaymentService->removeThisMonthDue($company); 
	 	    $daysInMonth = $dateMethods->numberOfDaysBetween($fromDate,$toDate); 
	 	    $employeeList = $this->companyAllowance->getPaysheetEmployeeList($condition); 
	 	    
	 	    foreach($employeeList as $employ) { 
	 	    	$amount = 0; 
	 	    	$nonPayDays = 0;  
	 	    	$paysheetSum = 0; 
	 	    	$paysheetArray = array(); 
	 	    	$employee = $this->loadEntity($employ); 
	 	    	$employeeId = $employee->getEmployeeNumber(); 
	 	    	$nonPayDays = $this->getNonPayDays($employeeId,$fromDate,$toDate);  
	 	    	$workDays = $daysInMonth - $nonPayDays; 
	 	    	if($nonPayDays > 0) {
	 	    	    $paysheetArray['nonPayDays'] = $nonPayDays; 
	 	    	    $paysheetArray['notes'] = "Employee in loss of pay"; 
	 	    	} 
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
			 		$paysheetArray[$a] = $this->twoDigit($amount);
		        }
		         //exit; 
		        // runtime calculation allowance  
		        foreach($runtimeAllowanceList as $allowanceName => $typeName) { 
		        	$amount = 0;
		        	// @todo revise
		        	$n = $typeName; //$allowance['allowanceType']; 
		        	$service = $this->service->get($n); 
		        	//\Zend\Debug\Debug::dump($dateRange);
		        	//exit;
		        	$amount = $service->calculateAmount($employee,$dateRange); 
		        	
		        	$a = $allowanceName; //$allowance['allowanceName']; 
		        	$amount = $this->workingDaysPay($amount,$daysInMonth,$workDays); 
		        	$paysheetSum += $amount; 
		        	$paysheetArray[$a] = $this->twoDigit($amount);  
		        }  
		        // echo "Paysheet Sum".$paysheetSum."<br/>"; 
		        // echo "Compulsory <br/>"; 
	 	        foreach($compulsoryDeduction as $key => $deductionName) {  
	 	        	$amount = 0; 
		 	    	$service = $this->service->get($deductionName);  
			 		$amount = $service->calculateDeductionAmount($employee,$dateRange);  
			 		// @todo if social insurance and first month  
			 		$amount = $this->workingDaysPay($amount,$daysInMonth,$workDays); 
			 		// Compulsory deduction is based on amount received, so never be negative
			 		if($paysheetSum > $amount) {
			 		    $paysheetSum -= $amount;
			 		    $paysheetArray[$key] = $this->twoDigit($amount); 
			 		} 
		        }  
		        
		        // Income tax 'IncomeTax'       => 'IncomeTax',
		        $amount = 0;
		        $service = $this->service->get('IncomeTax');
		        $amount = $service->customTax($employee,$dateRange,$paysheetArray); 
		        //$amount = $service->calculateDeductionAmount($employee,$dateRange);
		        // @todo if social insurance and first month
		        //$amount = $this->workingDaysPay($amount,$daysInMonth,$workDays);
		        // Compulsory deduction is based on amount received, so never be negative
		        if($paysheetSum > $amount) {
		            $paysheetSum -= $amount;
		            $paysheetArray['IncomeTax'] = $this->twoDigit($amount);
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
			 		    $paysheetArray[$key] = $this->twoDigit($amount); 
			 		} 
		        } 
		        // Advance payments deduction 
		        foreach($advancePaymentDeduction as $key => $deductionName) { 
		        	$amount = 0;  
		        	$info = $advancePaymentService->getThisMonthEmpAdvPaymentDue 
		        	                        ($deductionName,$employeeId,$dateRange);  
		        	 //\Zend\Debug\Debug::dump($info);
		        	if($info) { 
		        		$dueId = $info['id']; 
		        		$amount = $info['dueAmount'];  
		        		if($paysheetSum > $amount) {
		        			$paysheetSum -= $amount;
		        			$advancePaymentService->addThisMonthDue($deductionName,
		        					$dueId,$companyId,$dateRange);
		        			$paysheetArray[$key] = $this->twoDigit($amount); 
		        		} else {
		        			$paysheetArray[$key] = 0; 
		        		}
		        	}  else {
		        		$paysheetArray[$key] = 0; 
		        	}  
		        }   
		        //exit; 
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
		        	$paysheetArray[$key] = $this->twoDigit($amount);
		        	//} 
		        }   
		        // if have advance housing
		        $advHousingTable = 'AdvanceHousing'; 
		        $advHous = $advancePaymentService->getThisMonthEmpAdvPaymentDue 
		        	                        ($advHousingTable,$employeeId,$dateRange); 
		        if($advHous) { 
		            $dedHous = 0; 
		            $pending = 0; 
		        	$dueId = $advHous['id']; 
		        	$amount = $advHous['dueAmount']; 
		        	$paysheetArray['Housing'] = 0; 
		        	if($nonPayDays) {
		        	    $dedHous = ($amount/$daysInMonth) * $workDays;
		        	    $pending = $amount - $dedHous;
		        	    $paysheetArray['flag'] = 10;
		        	    $paysheetArray['flagAmount'] = $pending; 
		        	}
		        	if($paysheetSum > $amount) { 
		        		$advancePaymentService->addThisMonthDue($advHousingTable,
		        				$dueId,$companyId,$dateRange);
		        		if($paysheetArray['SocialInsurance'] > 0) {
		        		    $tax = $paysheetArray['IncomeTax'];
		        		    $siAmt = ($amount * .08); 
		        		    $tax -= ($amount * .15); 
		        		    $paysheetArray['IncomeTax'] = $tax;
		        		}
		        		
		        	} else { 
		        	    if($paysheetArray['SocialInsurance'] > 0) {
    		        		$housing = 0;
    		        		$zakat = 0;
    		        		$si = 0;
    		        		$coSi = 0;
    		        		$tax = 0;
    		        		$siAmt = 0;
    		        		$housing = $amount;//$paysheetArray['Housing'];
    		        		// alter zakat
    		        		$zakat = $paysheetArray['Zakat'];
    		        		$zakat -= ($housing * .025);
    		        		$paysheetArray['Zakat'] = $zakat;
    		        		// alter social insurance
    		        		$si = $paysheetArray['SocialInsurance'];
    		        		$siAmt = ($housing * .08);
    		        		$si -= $siAmt;
    		        		$paysheetArray['SocialInsurance'] = $si;
    		        		// alter social insurance company
    		        		$coSi = $paysheetArray['SocialInsuranceCompany'];
    		        		$coSi -= ($housing * .17);
    		        		$paysheetArray['SocialInsuranceCompany'] = $coSi;
    		        		// alter tax
    		        		$tax = $paysheetArray['IncomeTax'];
    		        		$tax -= ($housing * .15);
    		        		$tax -= ($siAmt * .15);
    		        		$paysheetArray['IncomeTax'] = $tax;
		        	    }
		        	}
		        } 		        
                //echo $employee->getEmployeeNumber()."<br/>"; 
                //exit;  
		        $paysheetArray['employeeNumber'] = $employeeId;// $employee->getEmployeeNumber(); 
		        $paysheetArray['company'] = $company->getId();
		        $paysheetArray['PsheetClosed'] = 0; 
		        $paysheetArray['paysheetDate'] = $dateRange->getFromDate(); 
		        
		        //$paysheetArray['flag']
		        //$paysheetArray['flagAmount']
		        //$paysheetArray['nonPayDays'] 
		        //$paysheetArray['notes'] 
		        
		        //\Zend\Debug\Debug::dump($dateRange->getFromDate());  
		        //exit;   
		        $paysheetMapper->insert($paysheetArray);  
		        //exit;  
		        //\Zend\Debug\Debug::dump($paysheetArray);   
	 	    }  
	 	    //exit; 
	 	    $this->getCheckListService()->checkListlog($routeInfo);  
		    $this->transaction->commit(); 
		    
		} catch(\Exception $e) { 
		 	$this->transaction->rollBack(); 
		 	throw $e; 
		} 
		// return $paysheetArray;   
	 } 
	 
	 
	 /*protected function workingDaysPay($amount,$daysInMonth,$workDays) {
	     return ($amount/$daysInMonth) * $workDays;
	 }*/ 
	 
	 public function calculateIndividualNet($condition,Company $company,DateRange $dateRange) {
	     //return 12;
	     try {
	         //$this->transaction->beginTransaction();
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
	         $dateMethods = $this->service->get('dateMethods');
	         
	         $fromDate = $dateRange->getFromDate();
	         $toDate = $dateRange->getToDate();
	         $companyId = $company->getId();
	         
	         $advancePaymentService = $this->getAdvancePaymentService();
	         $advancePaymentService->removeThisMonthDue($company);
	         $daysInMonth = $dateMethods->numberOfDaysBetween($fromDate,$toDate);
	         $employeeList = $this->companyAllowance->getIndividualEmployee($condition);
	         
	         foreach($employeeList as $employ) { 
	             $totAllowance = 0; 
	             $totDeduction = 0;
	             $amount = 0;
	             $nonPayDays = 0; 
	             $paysheetSum = 0;
	             $paysheetArray = array();
	             $employee = $this->loadEntity($employ);
	             $employeeId = $employee->getEmployeeNumber();
	             $nonPayDays = $this->getNonPayDays($employeeId,$fromDate,$toDate);
	             $workDays = $daysInMonth - $nonPayDays;
	             foreach($allowanceList as $allowanceName => $typeName) {
	                 $amount = 0;
	                 $n = $typeName;
	                 $service = $this->service->get($n);
	                 $amount = $service->getAmount($employee,$dateRange);
	                 $a = $allowanceName;
	                 $amount = $this->workingDaysPay($amount,$daysInMonth,$workDays);
	                 $paysheetSum += $amount;
	                 $paysheetArray[$a] = $this->twoDigit($amount);
	             }
	             // runtime calculation allowance
	             /*foreach($runtimeAllowanceList as $allowanceName => $typeName) {
	                 $amount = 0;
	                 $n = $typeName; //$allowance['allowanceType'];
	                 $service = $this->service->get($n);
	                 $amount = $service->calculateAmount($employee,$dateRange);
	                 $a = $allowanceName; //$allowance['allowanceName'];
	                 $amount = $this->workingDaysPay($amount,$daysInMonth,$workDays);
	                 $paysheetSum += $amount;
	                 $paysheetArray[$a] = $this->twoDigit($amount);
	             }*/
	             foreach($compulsoryDeduction as $key => $deductionName) {
	                 $amount = 0;
	                 $service = $this->service->get($deductionName);
	                 $amount = $service->calculateDeductionAmount($employee,$dateRange);
	                 // @todo if social insurance and first month
	                 $amount = $this->workingDaysPay($amount,$daysInMonth,$workDays);
	                 // Compulsory deduction is based on amount received, so never be negative
	                 if($paysheetSum > $amount) {
	                     $paysheetSum -= $amount;
	                     $paysheetArray[$key] = $this->twoDigit($amount);
	                 }
	             }
	             foreach($normalDeduction as $key => $deductionName) {
	                 $amount = 0;
	                 $service = $this->service->get($deductionName);
	                 //echo $deductionName."<br/>";
	                 $amount = $service->getDeductionAmount($employee,$dateRange);
	                 $amount = $this->workingDaysPay($amount,$daysInMonth,$workDays);
	                 //echo "Amount".$amount."<br/>";
	                 if($paysheetSum > $amount) {
	                     $paysheetSum -= $amount;
	                     $paysheetArray[$key] = $this->twoDigit($amount);
	                 }
	             }
	             // Advance payments deduction
	             foreach($advancePaymentDeduction as $key => $deductionName) {
	                 $amount = 0;
	                 $info = $advancePaymentService->getThisMonthEmpAdvPaymentDue
	                 ($deductionName,$employeeId,$dateRange);
	                 //\Zend\Debug\Debug::dump($info);
	                 if($info) {
	                     $dueId = $info['id'];
	                     $amount = $info['dueAmount'];
	                     if($paysheetSum > $amount) {
	                         $paysheetSum -= $amount;
	                         $advancePaymentService->addThisMonthDue($deductionName,
	                             $dueId,$companyId,$dateRange);
	                         $paysheetArray[$key] = $this->twoDigit($amount);
	                     } else {
	                         $paysheetArray[$key] = 0;
	                     }
	                 }  else {
	                     $paysheetArray[$key] = 0;
	                 }
	             }
	             //exit;
	             // company contribution deduction
	             foreach($companyContributionDeduction as $key => $deductionName) {
	                 // @todo sync with employee contribution
	                 $amount = 0;
	                 $service = $this->service->get($deductionName);
	                 //echo $deductionName."<br/>";
	                 $amount = $service->calculateDeductionAmount($employee,$dateRange);
	                 $amount = $this->workingDaysPay($amount,$daysInMonth,$workDays);
	                 $paysheetArray[$key] = $this->twoDigit($amount);
	                 //}
	             }
	             // if have advance housing
	             $advHousingTable = 'AdvanceHousing';
	             $advHous = $advancePaymentService->getThisMonthEmpAdvPaymentDue
	             ($advHousingTable,$employeeId,$dateRange);
	             if($advHous) { 
	                 $paysheetArray['Housing'] = 0;
	                 $dueId = $advHous['id'];
	                 $amount = $advHous['dueAmount'];
	                 if($paysheetSum > $amount) {
	                    // $advancePaymentService->addThisMonthDue($advHousingTable,$dueId,$companyId,$dateRange);
	                 } else {
	                     //echo "inside adv housing non deductable";
	                     $housing = 0;
	                     $zakat = 0;
	                     $si = 0;
	                     $coSi = 0;
	                     $tax = 0;
	                     $siAmt = 0;
	                     $housing = $paysheetArray['Housing'];
	                     // alter zakat
	                     $zakat = $paysheetArray['Zakat'];
	                     $zakat -= ($housing * .025);
	                     $paysheetArray['Zakat'] = $zakat;
	                     // alter social insurance
	                     $si = $paysheetArray['SocialInsurance'];
	                     $siAmt = ($housing * .08);
	                     $si -= $siAmt;
	                     $paysheetArray['SocialInsurance'] = $si;
	                     // alter social insurance company
	                     $coSi = $paysheetArray['SocialInsuranceCompany'];
	                     $coSi -= ($housing * .17);
	                     $paysheetArray['SocialInsuranceCompany'] = $coSi;
	                     // alter tax
	                     $tax = $paysheetArray['IncomeTax'];
	                     $tax -= ($siAmt * .15);
	                     $paysheetArray['SocialInsuranceCompany'] = $tax;
	                 }
	             }   
	             return $paysheetSum; 
	         }
	     } catch(\Exception $e) {
	         //$this->transaction->rollBack();
	         throw $e;
	     } 
	 }
	 
	 public function getEmployeeBasic($employeeNumber,Company $company,DateRange $dateRange) {
	     $employee = $this->getEmployeeById($employeeNumber); 
	     return $this->getBasic($employee, $company, $dateRange); 
	 }
	 
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
	 		$this->closePaysheetPFDeduction($company,$dateRange); 
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
	 	$pfList = $this->getPaysheetMapper()->getPfList($company,$dateRange); 
	 	foreach($pfList as $lst) { 
	 		$employeeId = $lst['employeeNumber'];
	 		$empShare = $lst['ProvidentFund'];
	 		$companyShare = $lst['ProvidentFundCompany']; 
	 		$employee = $this->getEmployeeById($employeeId); 
	 	    $fivePer = ($this->getBasic($employee, $company, $dateRange) * (5 / 100)); 
	 	    $fivePer = number_format($fivePer, 2, '.', '');
	 	    $optAmt = $empShare - $fivePer;
	 	    if ($optAmt < 0) {
	 	    	$optAmt = 0;
	 	    }
	 	    $data = array(
	 	    		'employeeId'         => $employeeId,
	 	    		'deductionDate'      => $lst['paysheetDate'],
	 	    		'empShare'           => $empShare,
	 	    		'companyShare'       => $companyShare,
	 	    		'fivePercentage'     => $fivePer,
	 	    		'optionalAmount'     => $optAmt,
	 	    );
	 	    $this->getPaysheetMapper()->insertPfDed($data); 	
	 	}  
	 	//exit; 
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
	 
	 public function getPaysheetByFunction(Company $company,$param) {
	 	return $this->getPaysheetMapper()->getPaysheetByFunction($company,$param);
	 } 
	 
	 public function getPaysheetByBank(Company $company,$param) {
	 	return $this->getPaysheetMapper()->getPaysheetByBank($company,$param);
	 }
	 
	 public function getPaysheetBankSummary(Company $company,$param) {
	 	return $this->getPaysheetMapper()->getPaysheetBankSummary($company,$param);
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
	 
	 public function getPayslipReport(Company $company,$param) {
	 	return $this->getPaysheetMapper()->getPayslipReport($company,$param);
	 } 
	 
	 public function getEmployeeGeneralGross($employeeId,Company $company) {
	     $output = array(); 
	     $employee = $this->getEmployeeById($employeeId); 
	     $dateRange = $this->service->get('dateRange'); 
	     $allowanceList = $this->companyAllowance
	                           ->getPaysheetAllowance($company,$dateRange); 
	     foreach($allowanceList as $allowanceName => $typeName) {
	         $amount = 0;
	         $n = $typeName;
	         $service = $this->service->get($n);
	         $amount = $service->getAmount($employee,$dateRange); 
	         $output[$allowanceName] = $amount; 
	     } 
	     return $output; 
	 }
	 
	 public function getPaysheetColums() {
	     return array(
	         'Initial'    => 'Initial',
             'Airport'    => 'Airport',
	         'Breakfast'  => 'Breakfast',
	         'Cashier'    => 'Cashier',
	         'Cola'       => 'Cola',
	         'Fitter'     => 'Fitter',
	         'Hardship'   => 'Hardship',
	         'Housing'    => 'Housing',  
	         'SpecialAllowance' => 'SpecialAllowance',
	         //'President'   => 'President',
	         'Meal'         => 'Meal',
	         'NatureofWork' => 'NatureofWork',
	         'Overtime'       => 'Overtime',
	         'Representative' => 'Representative',
	         'Shift'          => 'Shift',
	         'Transportation' => 'Transportation',
	         'OtherAllowance' => 'OtherAllowance',
	         'OtMeal'          => 'OtMeal',
	         'SocialInsuranceCompany' => 'SocialInsuranceCompany',
	         'ProvidentFundCompany' => 'ProvidentFundCompany',
	         'Zamala'              => 'Zamala',
	         'Zakat'                => 'Zakat',
	         'UnionShare'           => 'UnionShare',
	         'PhoneDeduction'       => 'PhoneDeduction',
	         'SocialInsurance'      => 'SocialInsurance',
	         'Punishment'           => 'Punishment',
	         'ProvidentFund'        => 'ProvidentFund',
	         'OtherDeduction'       => 'OtherDeduction',
	         'KhartoumUnion'        => 'KhartoumUnion',
	         'IncomeTax'            => 'IncomeTax',
	         'Cooperation'          => 'Cooperation',
	         'AdvanceSalary'        => 'AdvanceSalary',
	         'Absenteeism'          => 'Absenteeism',
	         'PersonalLoan'         => 'PersonalLoan',
	         //'AdvanceHousing'       => 'AdvanceHousing',
	         'OverPayment'          => 'OverPayment',
	     );
	 }
	 
	 public function prepareHeader() {
	     $o = "";
	     $columns = $this->getPaysheetColums();
	     foreach($columns as $c) {
	         $o .="<th>".$c." First</th>
	         <th>".$c." Second</th>
	         <th class = 'cy'>".$c." Diff</th>";
	     }
	     return $o;
	 }
	 
	 public function outputDiff($first,$second) {
	     $output = ""; 
	     $initialF = $first;
	     $initialT = $second;
	     $initialD = $initialT - $initialF;
	     $output .= "<td >$initialF</td>";
	     $output .= "<td >$initialT</td>";
	     if($initialD != 0) {
	         $output .= "<td class = 'compdiff'>$initialD</td>";
	     } else {
	         $output .= "<td >$initialD</td>";
	     }
	     return $output;
	 }
	 
	 public function getPaysheetComparisonReport(Company $company,$fromDate,$toDate) {
	     $i = 1; 
	     $output = "<table class='sortable'> 
	     <thead><tr><th>#</th><th>Employee No.</th><th>Employee Name</th>";
	     $output .= $this->prepareHeader();
         $output .= "</thead>  
         <tbody class='scrollingContent'>"; 
	     $result = $this->getPaysheetMapper()->getPaysheetCompleteReport($company,$fromDate);
	     $foot = array(); 
	     foreach($result as $f) {
	         $output .= "<tr><td>".$i++."</td>";
	         $employeeNumber = $f['employeeNumber'];  
	         $output .= "<td>$employeeNumber</td>"; 
	         $t = $this->getPaysheetMapper()->getPaysheetIndividualReport($company,$toDate,$employeeNumber);
	         $output .= "<td>".$t['employeeName']."</td>";
	         $columns = $this->getPaysheetColums();  
	         foreach($columns as $k => $v) {
	             $diffAll = $this->outputDiff($f[$v],$t[$v]); 
	             $output .= $diffAll; 
	         }   
	         $output .= "</tr>"; 
	     }
	     $output .= "</tbody></table>";
	     return $output; 
	 } 
} 