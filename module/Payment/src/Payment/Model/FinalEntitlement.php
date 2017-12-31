<?php 
namespace Payment\Model;

use Payment\Model\Company;
use Payment\Model\DateRange;

class FinalEntitlement extends Payment { 
    
    protected $finalEntitlement = array();  
    
    protected $leaveAllowanceDtls = array(); 
    
    protected $feMapper; 
    
    public function getFeMapper() {
    	return $this->service->get('finalEntitlementMapper');
    }
    
    public function getNonPayDays($employeeId,$fromDate,$toDate) {
    	$service = $this->service->get('NonPaymentDaysService'); 
    	return $service->getEmployeeFinalEntitlementNonWorkingDays($employeeId,$fromDate,$toDate); 
    	// return $days;  
    } 
    
    public function removeFinalEntitlement(Company $company) {
    	// @todo remove unclosed leave allowance for the company 
    	$this->getFeMapper()->removeFinalEntitlement($company);   
    }    
	   
	public function calculate($employeeId,$routeInfo) {  
	 	try {  
	 	    $this->transaction->beginTransaction();   
	 	    // @todo from last taken LA to now number of days 
	 	    // @todo 
	 	    $this->removeLeaveAllowance($employeeId); 
	 	    
	 	    $fixedAllowanceList = $this->companyAllowance
	 	                               ->getLeaveAllowanceFixed($company,$dateRange); 
	 	    $allowanceList = $this->companyAllowance
	 	                          ->getLeaveAllowanceAllowance($company,$dateRange);  
            
	 	    $employeeList = $this->getFeMapper()
	 	                         ->getLeaveAllowanceEmployeeList($company);  
	 	        
	 	    $feMapper = $this->getFeMapper(); 
	 	    // @todo fetch from DB   
	 	    $dateMethods = $this->service->get('dateMethods');  
	 	    $leaveGross = 0; 
	 	    $fromDate = $dateRange->getFromDate();  
	 	    $toDate = $dateRange->getToDate();  
	 	    $companyId = $company->getId();  
	 	    $batchNo   = 1;//@todo //$this->getBatchNo($fyYear);
	 	    $daysInMonth = $dateMethods->numberOfDaysBetween($fromDate,$toDate); 
            
	 	    foreach($employeeList as $emp) { 
	 	    	//\Zend\Debug\Debug::dump($employee);
	 	    	//exit; 
	 	    	$amount = 0; 
	 	    	$nonPayDays = 0;  
	 	    	
	 	    	$this->finalEntitlement = '';  
	 	    	
	 	    	$employeeId = $emp['employeeId'];  
	 	    	$employee = $this->getEmployeeById($employeeId);  
	 	    	$nonPayDays = $this->getNonPayDays($employeeId,$fromDate,$toDate);  
	 	    	
	 	    	$workDays = $daysInMonth - $nonPayDays; 
	 	    	
		        $this->finalEntitlement['employeeNumber'] = 0;
		        $this->finalEntitlement['employmentDate'] = 0;
		        $this->finalEntitlement['relievingDate'] = 0;
		        $this->finalEntitlement['entitlementDate'] = 0;
		        $this->finalEntitlement['zeroToTenDesc'] = 0;
		        $this->finalEntitlement['zeroToTenAmount'] = 0;
		        $this->finalEntitlement['tenToFifteenDesc'] = 0;
		        $this->finalEntitlement['tenToFifteenAmount'] = 0;
		        $this->finalEntitlement['fifteenToTwentyDesc'] = 0;
		        $this->finalEntitlement['fifteenToTwentyAmount'] = 0;
		        $this->finalEntitlement['twentyToTwentyFiveDesc'] = 0;
		        $this->finalEntitlement['twentyToTwentyFiveAmount'] = 0;
		        $this->finalEntitlement['twentyFiveandAboveDesc'] = 0;
		        $this->finalEntitlement['twentyFiveandAboveAmount'] = 0;
		        $this->finalEntitlement['afterServiceBenefitTotal'] = 0;
		        $this->finalEntitlement['balanceLeaveDays'] = 0;
		        $this->finalEntitlement['leaveDaysAmount'] = 0;
		        $this->finalEntitlement['leaveAllowanceToEmployeeDesc'] = 0;
		        $this->finalEntitlement['leaveAllowanceToEmployee'] = 0;
		        $this->finalEntitlement['leaveAllowanceFromEmployeeDesc'] = 0;
		        $this->finalEntitlement['leaveAllowanceFromEmployee'] = 0;
		        $this->finalEntitlement['personalLoanPending'] = 0;
		        $this->finalEntitlement['AdvanceSalaryPending'] = 0;
		        $this->finalEntitlement['advanceHousingPending'] = 0;
		        $this->finalEntitlement['lastMonthDueToCompany'] = 0;
		        $this->finalEntitlement['lastMonthDueFormCompany'] = 0;
		        
		        $feMapper->insertFeBuffer($this->finalEntitlement); 
		        
	 	    }   
	 	    
	 	    //exit;   
	 	    $this->getCheckListService()->checkListlog($routeInfo);  
		    
		    $this->transaction->commit();  
		} catch(\Exception $e) { 
		 	$this->transaction->rollBack();  
		 	throw $e; 
		} 
		// return $this->paysheet;    
		
	 } 
	 
	 public function getFeDetails($employeeId) {  
	 	
	 	$employee = $this->getEmployeeById($employeeId); 
	 	
	 	//$emp = new Employee();
	 	//$emp->getEmpJoinDate();
	 	$dateRange = $this->service->get('dateRange'); 
	 	
	 	$dateOfJoin = date("Y-m-d",strtotime($employee->getEmpJoinDate()));  
	 	
	 	// @todo get termination date 
	 	$relievingDate = '';//2016-06-01'; 
	 	
	 	if(!$relievingDate) {
	 		$relievingDate = '2017-11-30'; 
	 	}
	 	
	 	$relievingDate = date("Y-m-d",strtotime($relievingDate));   
        
	 	$yearsOfService = $this->dateMethods->numberOfYearsBetween($dateOfJoin,$relievingDate);  
        	 	
	 	$nonPayDays = $this->getNonPayDays($employeeId,$dateOfJoin,$relievingDate); 
	 	
	 	$nonPayYears = $this->dateMethods->numberOfYearsByDays($nonPayDays);  
	 	
	 	$yearsOfService = number_format(($yearsOfService - $nonPayYears) , 3);  
	 	
	 	$zeroToten = 0;
	 	$tenToFifteen = 0;
	 	$fifteenToTwenty = 0;
	 	$twentyToTwentyFive = 0;
	 	$twentyFiveandAboveAmount = 0;
	 	$afterServiceBenefitTot = 0;
	 	$balanceLeaveDays = 0;
	 	$leaveDaysAmount = 0;
	 	$leaveAllowanceToEmp = 0;
	 	$leaveAllowanceFromEmp = 0;
	 	$personalLoan = 0;
	 	$advSalary = 0;
	 	$advHousing = 0;
	 	$lastMonthToCompany = 0;
	 	$lastMonthFromCompany = 0;
	 	$leaveDaysToCompany   = 0;
	 	$overPaymentToCompany = 0; 
	 	$phoneToCompany = 0; 
	 	 
	 	//$specialCompensation  = 0;
	 	//$specialCompensationToCompany  = 0; 
	 	
	 	$salaryDifference  = 0;
	 	$salaryDifferenceToCompany  = 0;
	 	$carRent  = 0;
	 	$carRentToCompany  = 0;
	 	$carLoanToCompany  = 0;
	 	$splLoanToCompany  = 0;
	 	
	 	$totalAllowance = 0;
	 	$totalDeduction = 0;
	 	$finalAmount = 0; 
	 	
	 	// @todo 
	 	$company = $this->service->get('company'); 
	 	$basic = $this->getFEBasic($employee,$company,$relievingDate);  
	 	$gross = $this->getFEGross($employee,$company,$relievingDate); 
        $perday = $gross/30; 
	 	$balanceLeaveDays = $this->getFeBalanceLeaveDays($employee,$relievingDate); 
	 	$lAmount = $this->twoDigit($perday * $balanceLeaveDays);
	 	if($balanceLeaveDays > 0) { 
	 	    $leaveDaysAmount = $lAmount;
	 	} else {
	 		$leaveDaysToCompany = $lAmount * -1; 
	 	}
	 	
	 	$leaveAllowanceToEmp = $this->getFeLeaveAllowanceBalToEmployee($employee, $relievingDate,$dateOfJoin);
	 	
	 	$leaveAllowanceFromEmp = $this->getFeLeaveAllowanceBalToCompany($employee, $relievingDate,$dateOfJoin); 
	 	
	 	$lastMonthFromCompany = $this->getFelastMonthSalToEmployee($employee,$relievingDate);
	 	$lastMonthToCompany = $this->getFelastMonthSalToCompany($employee,$relievingDate);
	 	
	 	$carRent = $this->getFelastMonthCarrentToEmployee($employee,$relievingDate); 
	 	$carRentToCompany = $this->getFelastMonthCarrentToCompany($employee,$relievingDate); 
	 	
	 	// get gross 
	 	// get leave days  
	 	// get suspend days 
	 	// get advance payments 
	 	// car rent 
	 	// salary difference 
	 	
	 	if($yearsOfService <= 10) {
	 		$zeroToten = $this->twoDigit(($basic * 1) * $yearsOfService);
	 		$outputyearOfSer .= "<tr>
			                         <td align='left'>upto 10 Years of Service((Basic * 1) * 10 )</td>
			                         <td align='right'>:&nbsp;" . $zeroToten . "</td>
		                         </tr>";
	 	} elseif($yearsOfService > 10 && $yearsOfService < 21) {
	 		//$tenToFifteen = ($basic * 1) * $yearsOfService;
	 		$tenToFifteenOne = ($basic * 1) * 10;
	 		$totEntitlement += $tenToFifteenOne;
	 		$outputyearOfSer .= "<tr>
			                         <td align='left'>10 Years of Service((Basic * 1) * 10 )</td>
			                         <td align='right'>:&nbsp;" . $tenToFifteenOne . "</td>
		                         </tr>"; 
	 		$years = $yearsOfService - 10;
	 		//$entitlement = 0;
	 		$tenToFifteenTwo = $this->twoDigit(($basic * 2) * $years);
	 		$totEntitlement += $tenToFifteenTwo;
	 		
	 		$outputyearOfSer .= "<tr>
	 		                         <td align='left'>10 - 21 Years of Service((Basic * 2) * $years )</td>
	 		                         <td align='right'>:&nbsp;" . $tenToFifteenTwo . "</td>
		                         </tr>";
	 		$tenToFifteen = $this->twoDigit($tenToFifteenOne + $tenToFifteenTwo); 
	 	} elseif($yearsOfService >= 21 && $yearsOfService <= 25) {
	 		$fifteenToTwentyOne = $this->twoDigit(($basic * 1) * 10);
	 		$totEntitlement += $fifteenToTwentyOne;
	 		
	 		$outputyearOfSer .= "<tr>
			                         <td align='left'>10 Years of Service((Basic * 1) * 10 )</td>
			                         <td align='right'>:&nbsp;" . $fifteenToTwentyOne . "</td>
		                         </tr>"; 
	 		$fifteenToTwentyTwo = $this->twoDigit(($basic * 2) * 10); 
	 		$totEntitlement += $fifteenToTwentyTwo; 
	 		$years = $yearsOfService - 20; 
	 		$outputyearOfSer .= "<tr>
			                         <td align='left'>10 - 20 Years of Service((Basic * 2) * 10 )</td>
			                         <td align='right'>:&nbsp;" . $fifteenToTwentyTwo . "</td>
		                         </tr>";
	 		$fifteenToTwentyThree = $this->twoDigit(($basic * 2.5) * $years);
	 		$totEntitlement += $fifteenToTwentyThree;
	 		$outputyearOfSer .= "<tr>
	 		                         <td align='left'>20 - 25 Years of Service((Basic * 2.5) * $years )</td>
	 		                         <td align='right'>:&nbsp;" . $fifteenToTwentyThree . "</td>
		                    </tr>";
	 		$fifteenToTwenty = $this->twoDigit($fifteenToTwentyOne + $fifteenToTwentyTwo + $fifteenToTwentyThree); 
	 	} elseif($yearsOfService >= 25 && $yearsOfService < 30) {
	 		$twentyToTwentyFive = ($basic * 2.5) * $yearsOfService;
	 		$totEntitlement += $twentyToTwentyFive;
	 		$outputyearOfSer .= "<tr>
			                   <td align='left'>" . $yearsOfService . " Years of Service((Basic * 2.5) * $yearsOfService )</td>
	 					       <td align='right'>:&nbsp;" . $twentyToTwentyFive . "</td>
		                    </tr>";
	 	} elseif($yearsOfService > 30 ) {
	 		$twentyFiveandAboveAmount = $basic * 75;
	 		$totEntitlement += $twentyFiveandAboveAmount;
	 		$outputyearOfSer .= "<tr>
			                         <td align='left'>" . $yearsOfService . " Years of Service(Basic * 75)</td>
			                         <td align='right'>:&nbsp;" . $twentyFiveandAboveAmount . "</td>
		                         </tr>";
	 	} else {
	 		$zeroToten = ($basic * 1) * $yearsOfService;
	 	} 
	 	
	 	$advSalary = $this->getFeAdvSal($employee); 
	 	$advHousing = $this->getFeAdvHousing($employee); 
	 	$personalLoan = $this->getFePersonalLoan($employee); 
	 	
	 	$splLoanToCompany = $this->getFeSplLoan($employee);
	 	$carLoanToCompany = $this->getFeCarLoanAmortization($employee,$relievingDate); 
	 	
	 	$overPaymentToCompany = $this->getFeOverPayment($employee); 
	 	$phoneToCompany = $this->getFePhoneDed($employee); 
	 	
	 	$totalAllowance = $this->twoDigit($zeroToten + $tenToFifteen + $fifteenToTwenty + 
	 	$twentyToTwentyFive + $twentyFiveandAboveAmount + $lastMonthFromCompany + $leaveAllowanceToEmp
	 	+ $carRent + $leaveDaysAmount);
	 	
	 	$totalDeduction = $this->twoDigit($leaveDaysToCompany + $leaveAllowanceFromEmp + $lastMonthToCompany
	 	    + $carRentToCompany + $personalLoan + $advHousing + $advSalary + $splLoanToCompany + $carLoanToCompany
	 	    + $overPaymentToCompany + $phoneToCompany); 
	 	
	 	$finalAmount = $this->twoDigit($totalAllowance - $totalDeduction); 
	 	
	 	$output = "
	 	        <table style = 'padding:10px;'>
	 			    <thead> 
		 			    <tr> 
	                        <td><b>Subject</b></td>
		 			        <td>&nbsp;<b>Entitlement</b></td>
		 			    </tr>
	 			    </thead> 
	 			    <tbody> 
		 			    <tr> 
	                        <td>Employment Date </td>
		 			        <td>:&nbsp;".$dateOfJoin."</td>
		 			    </tr>
	 			        <tr> 
	                        <td>Relieving Date </td>
		 			        <td>:&nbsp;".$relievingDate."</td>
		 			    </tr>
		 			    <tr> 
	                        <td>Basic </td>
		 			        <td>:&nbsp;".$basic."</td>
		 			    </tr>
		 			    <tr> 
	                        <td>Gross </td>
		 			        <td>:&nbsp;".$gross."</td>
		 			    </tr>
	 			        ";
	 	$output .= $outputyearOfSer;
	 	
	 	
	 	
	 	$output .= "<tr> 
	                    <td>Leave Days Amount(Employee) </td>
		 			    <td>:&nbsp;".$leaveDaysAmount."</td>
		 			</tr>
		 		    <tr> 
	                    <td>Leave Allowance(Employee) </td>
		 			    <td>:&nbsp;".$leaveAllowanceToEmp."</td>
		 			</tr>
		 			<tr> 
	                    <td>Salary Difference(Employee) </td>
		 			    <td>:&nbsp;".$salaryDifference."</td>
		 			</tr>
		 			<tr> 
	                    <td>Last Month salary (Employee) </td>
		 			    <td>:&nbsp;".$lastMonthFromCompany."</td>
		 			</tr>
		 			<tr> 
	                    <td>Car Rent(Employee) </td>
		 			    <td>:&nbsp;".$carRent."</td>
		 			</tr>		
		 		    <tr> 
	                    <td>Leave Days Amount(Company) </td>
		 			    <td>:&nbsp;".$leaveAllowanceFromEmp."</td>
		 			</tr>
		 		    <tr> 
	                    <td>Leave Allowance(Company) </td>
		 			    <td>:&nbsp;".$leaveAllowanceFromEmp."</td>
		 			</tr>
		 			<tr> 
	                    <td>Salary Difference(Company) </td>
		 			    <td>:&nbsp;".$salaryDifferenceToCompany."</td>
		 			</tr>
		 			<tr> 
	                    <td>Last Month salary (Company) </td>
		 			    <td>:&nbsp;".$lastMonthToCompany."</td>
		 			</tr>
		 			<tr> 
	                    <td>Car Rent(Company) </td>
		 			    <td>:&nbsp;".$carRentToCompany."</td>
		 			</tr>
		 			<tr> 
	                    <td>Advance Salary </td>
		 			    <td>:&nbsp;".$advSalary."</td>
		 			</tr>
		 			<tr> 
	                    <td>Advance Housing </td>
		 			    <td>:&nbsp;".$advHousing."</td>
		 			</tr>
		 			<tr> 
	                    <td>Personal Loan </td>
		 			    <td>:&nbsp;".$personalLoan."</td>
		 			</tr>
                    <tr> 
	                    <td>Over Payment </td>
		 			    <td>:&nbsp;".$overPaymentToCompany."</td>
		 			</tr>
                    <tr> 
	                    <td>Phone Exceeding </td>
		 			    <td>:&nbsp;".$phoneToCompany."</td>
		 			</tr>
                    <tr> 
	                    <td>Car Loan </td>
		 			    <td>:&nbsp;".$carLoanToCompany."</td>
		 			</tr>
                    <tr> 
	                    <td>Special Loan </td>
		 			    <td>:&nbsp;".$splLoanToCompany."</td>
		 			</tr>
		 			<tr> 
	                    <td>Total Entitlement </td>
		 			    <td>:&nbsp;".$totalAllowance."</td>
		 			</tr>
		 			<tr> 
	                    <td>Total Deduction </td>
		 			    <td>:&nbsp;".$totalDeduction."</td>
		 			</tr>
		 			<tr> 
	                    <td><b>Final Amount </b></td>
		 			    <td>:&nbsp;<b>".number_format($finalAmount,2,'.',',')."</b></td>
		 			</tr>
	 			   "; 
	 	
	    $output .= "<tbody>
	 			</table> 
	    "; 
	 	
	    return array( 
			'employmentDate'                  => $dateOfJoin,   
			'relievingDate'                   => $relievingDate,  
	    	'yearsOfService'                  => $yearsOfService,
	    	'nonPayDays'                      => $nonPayDays,
			'entitlementDate'                 => date('Y-m-d'),  
			'zeroToTenAmount'                 => $zeroToten,
			'tenToFifteenAmount'              => $tenToFifteen,
			'fifteenToTwentyAmount'           => $fifteenToTwenty,
			'twentyToTwentyFiveAmount'        => $twentyToTwentyFive, 
			'twentyFiveandAboveAmount'        => $twentyFiveandAboveAmount, 
			'afterServiceBenefitTotal'        => $afterServiceBenefitTot,
			'balanceLeaveDays'                => $balanceLeaveDays, 
			'leaveDaysAmount'                 => $leaveDaysAmount, 
			'leaveAllowanceToEmployee'        => $leaveAllowanceToEmp, 
			'leaveAllowanceFromEmployee'      => $leaveAllowanceFromEmp, 
	        
			'personalLoanPending'             => $personalLoan, 
			'AdvanceSalaryPending'            => $advSalary,
			'advanceHousingPending'           => $advHousing,
			'lastMonthDueToCompany'           => $lastMonthToCompany, 
			'lastMonthDueFormCompany'         => $lastMonthFromCompany, 
	    	'leaveDaysToCompany'              => $leaveDaysToCompany,
            
	    	//'specialCompensation'             => $specialCompensation,
	    	//'specialCompensationToCompany'    => $specialCompensationToCompany,
	    	'salaryDifference'                => $salaryDifference,
	    	'salaryDifferenceToCompany'       => $salaryDifferenceToCompany,
	    	'carRent'                         => $carRent,
	    	'carRentToCompany'                => $carRentToCompany,
	        'carLoanToCompany'                => $carLoanToCompany,
	        'splLoanToCompany'                => $splLoanToCompany,
	        'phoneToCompany'                  => $phoneToCompany,
	        'overPaymentToCompany'            => $overPaymentToCompany,
	        
	    		
	    	'totalAllowance'                  => $totalAllowance,
	    	'totalDeduction'                  => $totalDeduction,
	    	'finalAmount'                     => $finalAmount,
	    	
	    	'dtls'                            => $output,
	     ); 
     }
	 
	 public function isAlreadyClosed($empId) { 
	 	return 0;
	    // return $this->getFeMapper()->isPaysheetClosed($company,$dateRange); 
	    // return false;    	
	 } 
	 
	 
	 public function close(Company $company,DateRange $dateRange,$routeInfo) {
	 	/*try { 
	 		$this->transaction->beginTransaction(); 
	 		// @todo close 
	 		$this->closePaysheetPFDeduction($company,$dateRange); 
	 		// done but need to test 
	 		$this->closeAdvancePaymentDeduction($company,$dateRange); 
	 		$this->getFeMapper()->closeThisPaysheet($company,$dateRange);  
	 	    $this->getCheckListService()->closeLog($routeInfo); 
	 	    $this->transaction->commit();  
	 	} catch(\Exception $e) {  
	 		$this->transaction->rollBack(); 
	 		throw $e;  
	 	} */ 
	 } 
     
	 public function selectEmployeeLa() {
	 	return $this->getFeMapper()->selectEmployeeLa();  
	 }
	 
	 public function saveEmployeeLeaveAllowance($formValues) {
	 	$leaveEmployeeInfo = array (
	 			'employeeId'       => $formValues['employeeNumberLeaveAllowance'],
	 			'companyId'        => $formValues['companyId']
	 	);
	 	$this->getFeMapper()
	 	     ->saveEmployeeLeaveAllowance($leaveEmployeeInfo);
	 }
	 
	 public function removeEmployeeLeaveAllowance($id) {
	 	return $this->getFeMapper()
	 	            ->removeEmployeeLeaveAllowance($id); 
	 }
	 
	 public function getFEGross(Employee $employee,Company $company,$relievingDate) {
	 	$dateRange = $this->prepareCompleteDateRange($relievingDate);
	 	return $this->getGross($employee, $company, $dateRange); 
	 	
	 } 
	 
	 public function getFEBasic(Employee $employee,Company $company,$relievingDate) { 
	 	$dateRange = $this->prepareCompleteDateRange($relievingDate); 
	 	return $this->getBasic($employee,$company,$dateRange); 
	 } 
	 
	 public function getFeBalanceLeaveDays(Employee $employee,$doj,$relievingDate) { 
	 	$service = $this->getLeaveService();
	 	return $service->getTotalLeaveBalance($employee,$doj,$relievingDate);   
	 	// return 55;  
	 } 
	 
	 public function getFeLeaveAllowanceBalToEmployee(Employee $employee,$relievingDate) {
	     $service = $this->getLeaveAllowanceService(); 	
	     return $service->getFeLeaveAllowanceBalToEmployee($employee,$relievingDate);  
	 }
	 
	 public function getFeLeaveAllowanceBalToCompany(Employee $employee,$relievingDate) {
	 	$service = $this->getLeaveAllowanceService();
	 	return $service->getFeLeaveAllowanceBalToCompany($employee,$relievingDate);
	 }
	 
	 public function getFelastMonthSalToEmployee(Employee $employee,$relievingDate) {
	 	$service = $this->getPaysheetService();
	 	return $service->getLastMonthPendingToEmployee($employee,$relievingDate);
	 }
	 
	 public function getFelastMonthSalToCompany(Employee $employee,$relievingDate) {
	 	$service = $this->getPaysheetService();
	 	return $service->getLastMonthPendingToCompany($employee,$relievingDate);
	 }
	 
	 public function getFelastMonthCarrentToEmployee(Employee $employee,$relievingDate) {
	 	return 0; 
	 	$service = $this->getLeaveAllowanceService();
	 	return $service->getFeLeaveAllowanceBalToEmployee($employee,$relievingDate);
	 }
	 
	 public function getFelastMonthCarrentToCompany(Employee $employee,$relievingDate) {
	 	return 0; 
	 	$service = $this->getLeaveAllowanceService();
	 	return $service->getFeLeaveAllowanceBalToCompany($employee,$relievingDate);
	 }
	 
	 public function getFeAdvSal(Employee $employee) {
	 	$service = $this->getAdvancePaymentService();  
	 	return $service->getFeAdvSal($employee); 
	 }
	 
	 public function getFeAdvHousing(Employee $employee) {
	 	$service = $this->getAdvancePaymentService();
	 	return $service->getFeAdvHousing($employee);
	 }
	 
	 public function getFePersonalLoan(Employee $employee) {
	 	$service = $this->getAdvancePaymentService();
	 	return $service->getFePersonalLoan($employee);
	 }
	 
	 public function getFeSplLoan(Employee $employee) { 
	     $service = $this->getAdvancePaymentService();
	     return $service->getFeSpecialLoan($employee);
	 }
	 
	 public function getFeCarLoanAmortization(Employee $employee,$relievingDate) {
	     $service = $this->getAdvancePaymentService();
	     return $service->getFeCarLoanAmortization($employee,$relievingDate);
	 }
	 
	 public function getFeOverPayment(Employee $employee) {
	     $service = $this->getAdvancePaymentService();
	     return $service->getFeOverPayment($employee); 
	 }
	 
	 public function getFePhoneDed(Employee $employee) {
	     $service = $this->getAdvancePaymentService();
	     return $service->getFePhoneDed($employee); 
	 }
	 
	 public function getLeaveService() { 
	 	return $this->service->get('leaveService');   
	 }  
	 
	 public function getLeaveAllowanceService() { 
	 	return $this->service->get('leaveAllowanceService');  
	 } 
	 
	 public function getPaysheetService() {
	 	return $this->service->get('paysheet');
	 } 
	 
	 public function getAdvancePaymentService() {
	 	return $this->service->get('advancePaymentService');
	 }
	 
	 
} 