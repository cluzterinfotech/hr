<?php 
namespace Payment\Model;

use Payment\Model\Company;
use Payment\Model\DateRange;

class LeaveAllowance extends Payment { 
    
    protected $leaveAllowanceMst = array();  
    
    protected $leaveAllowanceDtls = array(); 
    
    protected $laMapper; 
    
    public function getLaMapper() {
    	return $this->service->get('leaveAllowanceMapper');
    }
    
    public function getAdvancePaymentService() {
        return $this->service->get('advancePaymentService');
    } 
    
    public function getNonPayDays($employeeId,$fromDate,$toDate) {
    	$service = $this->service->get('NonPaymentDaysService'); 
    	return $service->getEmployeeLeaveAllowanceNonWorkingDays($employeeId,$fromDate,$toDate); 
    	// return $days;  
    } 
    
    public function removeLeaveAllowance(Company $company) {
    	// @todo remove unclosed leave allowance for the company 
    	$this->getLaMapper()->removeUnclosedLeaveAllowance($company);  
    	
    } 
	   
	public function calculate(Company $company,DateRange $dateRange,$routeInfo) {  
	 	try {  
	 	    $this->transaction->beginTransaction();   
	 	    // @todo from last taken LA to now number of days 
	 	    // @todo 
	 	    $this->removeLeaveAllowance($company); 
	 	    // get employee list based on company 
	 	    // $employeeList = 
	 	    $fixedAllowanceList = $this->companyAllowance 
	 	                               ->getLeaveAllowanceFixed($company,$dateRange);  
	 	    $allowanceList = $this->companyAllowance 
	 	                          ->getLeaveAllowanceAllowance($company,$dateRange);   
            
	 	    $employeeList = $this->getLaMapper() 
	 	                         ->getLeaveAllowanceEmployeeList($company);   
	 	         
	 	    $laMapper = $this->getLaMapper();  
	 	    // @todo fetch from DB   
	 	    $dateMethods = $this->service->get('dateMethods');  
	 	    $leaveGross = 0; 
	 	    $fromDate = $dateRange->getFromDate();  
	 	    $toDate = $dateRange->getToDate();  
	 	    $companyId = $company->getId();  
	 	    $fyYear = date('Y'); 
	 	    $batchNo   = $this->getBatchNo($company,$fyYear);  
	 	    $daysInMonth = $dateMethods->numberOfDaysBetween($fromDate,$toDate); 
            
	 	    foreach($employeeList as $emp) { 
	 	    	//\Zend\Debug\Debug::dump($employee);
	 	    	//exit; 
	 	    	$amount = 0; 
	 	    	$nonPayDays = 0;  
	 	    	$grossAmount = 0;
	 	    	
	 	    	$this->leaveAllowanceMst = '';  
	 	    	
	 	    	$employeeId = $emp['employeeId'];  
	 	    	$employee = $this->getEmployeeById($employeeId);  
	 	    	$nonPayDays = $this->getNonPayDays($employeeId,$fromDate,$toDate);  
	 	    	
	 	    	$workDays = $daysInMonth - $nonPayDays; 
	 	    	
	 	    	foreach($fixedAllowanceList as $allowanceName => $typeName) {
	 	    		$amount = 0;
	 	    		// @todo revise
	 	    		$n = $typeName; //$allowance['allowanceType'];
	 	    		//echo "Type ".$typeName."<br/>";
	 	    		$service = $this->service->get($n);
	 	    		$amount = $service->getAmount($employee,$dateRange);
	 	    		//echo "Amount ".$amount."<br/>";
	 	    		//exit;
	 	    		$a = $allowanceName; //$allowance['allowanceName'];
	 	    		$amount = $this->twoDigit($this->workingDaysPay($amount,$daysInMonth,$workDays));
	 	    		
	 	    		$this->leaveAllowanceMst[$a] = $amount;  
	 	    		$grossAmount += $amount;
	 	    	}
	 	    	
	 	    	$leaveAllowance = ($this->leaveAllowanceMst['Initial'] 
	 	    	+ $this->leaveAllowanceMst['Cola']) * 6;
	 	    	
	 	    	$laOneMonth = $leaveAllowance/12; 
	 	    	
	 	    	$this->leaveAllowanceMst['leaveAllowance'] = $laOneMonth;  
	 	    	
	 	    	$grossAmount += $this->twoDigit($laOneMonth);
	 	    	
		 	    foreach($allowanceList as $allowanceName => $typeName) {  
		 	    	$amount = 0; 
		 	    	// @todo revise  
		 	    	$n = $typeName; // $allowance['allowanceType']; 
		 	    	//echo "Type ".$typeName."<br/>";  
		 	    	$service = $this->service->get($n);  
			 		$amount = $service->getAmount($employee,$dateRange);   
			 		//echo "Amount ".$amount."<br/>";  
			 		//exit;  
	 	    	    $a = $allowanceName; //$allowance['allowanceName'];
	 	    	    $amount = $this->twoDigit($this->workingDaysPay($amount,$daysInMonth,$workDays));
	 	    	    
			 		$this->leaveAllowanceDtls[$a] = $amount; 
			 		$grossAmount += $amount;
		        }  
		        
                //echo $employee->getEmployeeNumber()."<br/>"; 
                //exit; 
		        $this->leaveAllowanceMst['employeeId'] = $employeeId;  
		        $this->leaveAllowanceMst['isClosed'] = 0;  
		        
		        $this->leaveAllowanceMst['fyYear'] = date('Y'); 
		        $this->leaveAllowanceMst['batchNo'] = $batchNo;   
		        $this->leaveAllowanceMst['leaveDays'] = $nonPayDays; 
		        
		        $this->leaveAllowanceMst['functionCode'] = $this->getFunctionCode($employeeId);   
		        $this->leaveAllowanceMst['lkpDept'] = $this->getEmpDept($employeeId); 
		        
		        $this->leaveAllowanceMst['maritalStatus'] = $employee->getMaritalStatus();  
		        
		        $dependents = $employee->getNumberOfDependents(); 
		          
		        $this->leaveAllowanceMst['issueDate'] = date("Y-m-d"); 
		        $this->leaveAllowanceMst['isClosed'] = 0;
		        $this->leaveAllowanceMst['companyId'] = $company->getId();
		        $desc = " "; 
		        // @todo gross times 2 if have dependents
		        if($dependents) {
		            $exempted = $grossAmount * 2;
		            $desc = " gross * 2"; 
		        } else {
		        	$exempted = $grossAmount;
		        	$desc = " gross * 1";
		        } 
		        $splLoanAmount = 0;
		        $dueId = 0; 
		        $info = $this->getAdvancePaymentService()->getSpecialLoanDueAmount($employeeId); 
		        if($info) {
		            $dueId = $info['id'];
		            //$amount = $info['dueAmount'];
		            $splLoanAmount = $info['dueAmount'];
		        }
		        
		        $tax = ($leaveAllowance - $exempted) *.15; 
		        $this->leaveAllowanceMst['Gross'] = $grossAmount;
		        $this->leaveAllowanceMst['leaveExempted'] = $exempted; 
		        $this->leaveAllowanceMst['Tax'] = $tax; 
		        $this->leaveAllowanceMst['Amount'] = $leaveAllowance; 
		        $this->leaveAllowanceMst['specialLoanDeduction'] = $splLoanAmount; 
		        $this->leaveAllowanceMst['specialLoanDeductionId'] = $dueId;
		        $this->leaveAllowanceMst['Net'] = $leaveAllowance - $tax - $splLoanAmount;
		        $this->leaveAllowanceMst['grossDescription'] =$desc;  
		        $this->leaveAllowanceMst['allowanceFrom'] = date('Y-m-d'); 
		        $this->leaveAllowanceMst['allowanceTo'] = date('Y-m-d'); 
                
		       // \Zend\Debug\Debug::dump($this->leaveAllowanceMst);  
		       // exit; 
		        
		       $mstId = $laMapper->insertLaMst($this->leaveAllowanceMst);
		        //\Zend\Debug\Debug::dump($mstId);
		        //exit; 
		        reset($allowanceList);     
		        //\Zend\Debug\Debug::dump($allowanceList);
		        //exit; 
		        foreach($allowanceList as $allowanceName => $typeName) {
		        	$dtls = array(
		        	    'leaveAllowanceMstId'  => $mstId,
		        	    'allowanceId'          => $this->getAllowanceIdByName($typeName),
		        	    'Amount'               => $this->leaveAllowanceDtls[$typeName]
		        	);
		        	$laMapper->insertLaDtls($dtls);
		        	//\Zend\Debug\Debug::dump($dtls);
		        	//exit; 
		        } 
		            
	 	    }   
	 	    
	 	    //exit;   
	 	    //$this->getCheckListService()->checkListlog($routeInfo);  
		    
		    $this->transaction->commit();  
		} catch(\Exception $e) { 
		 	$this->transaction->rollBack();  
		 	throw $e; 
		} 
		// return $this->paysheet;    
		
	 } 
	 
	 public function getBatchNo(Company $company,$fyYear)
	 {  	 	
	 	$batch = $this->getLaMapper()->getLastBatch($company,$fyYear);  
	 	
	 	if(!$batch) {
	 		$newBatch = $fyYear."-1";
	 		return $newBatch;
	 	}
	 	list($fy,$batchNo) = explode('-',$batch);
	 	$batchId = $batchNo + 1; 
	 	$newBatch = $fyYear."-".$batchId; 
	 	return $newBatch; 
	 } 
	 
	 public function isPaysheetClosed(Company $company,DateRange $dateRange) { 
	     return $this->getLaMapper()->isPaysheetClosed($company,$dateRange); 
	     // return false;    	
	 }
	 
	 public function getFunctionCode($employeeId) {
	     // @todo 
	 	//$employee = $this->getEmployeeById($employeeId);
	     return '123';  
	 } 
	 
	 public function getEmpDept($employeeId) {
	 	// @todo
	 	//$employee = $this->getEmployeeById($employeeId); 
	 	return '1';
	 }
	 
	 public function close(Company $company,DateRange $dateRange,$routeInfo) {
	 	try { 
	 		$this->transaction->beginTransaction(); 
	 		$this->removeAllFromBuffer($company); 
	 		$this->closeLeaveAllowance($company);  
	 	    $this->getCheckListService()->closeLog($routeInfo); 
	 	    $this->transaction->commit();  
	 	} catch(\Exception $e) {  
	 		$this->transaction->rollBack(); 
	 		throw $e;  
	 	} 
	 } 
	 
	 public function closeLeaveAllowance(Company $company) { 
	     $this->getLaMapper()->closeLeaveAllowance($company); 	
	 }
	 
	 public function removeAllFromBuffer(Company $company) {
	 	 $this->getLaMapper()->removeAllFromBuffer($company);
	 }
     
	 public function selectEmployeeLa() {
	 	return $this->getLaMapper()->selectEmployeeLa();  
	 }
	 
	 public function saveEmployeeLeaveAllowance($formValues) {
	 	$leaveEmployeeInfo = array (
	 			'employeeId'       => $formValues['employeeNumberLeaveAllowance'],
	 			'companyId'        => $formValues['companyId']
	 	);
	 	$this->getLaMapper()
	 	     ->saveEmployeeLeaveAllowance($leaveEmployeeInfo);
	 }
	 
	 public function removeEmployeeLeaveAllowance($id) {
	 	return $this->getLaMapper()
	 	            ->removeEmployeeLeaveAllowance($id); 
	 } 
	 
	 /*public function getLeaveAllowanceReport(array $param = array()) {
	     $mst = $this->getLaMapper()
	 	                       ->getLeaveAllowanceReport($param);
	     $output = "";
	     $total = 0;
	     $output .= "<table class='sortable'><thead><tr>";
	     $output .= "<th >Net</th>";
	     $output .= "</thead></tr><tbody class='scrollingContent'>";
	     foreach($mst as $m) {
	     	
	         $name = $m['employeeName'];   
	         $initial = $m['Initial'];
	         $output .= "<tr >";
	         
	         $output .= "<td>".$name."</td>"; 
	         $output .= "<td>".$initial."</td>";
             	
	     }
	     $output .= "</tbody></table>";
	     return $output;
	     
	 }*/
	 
	 public function getReportDtls($id) {
	 	return $this->getLaMapper()
	 	                     ->getReportDtls($id); 
	 }
	 
	 public function  getLeaveAllowanceReport(array $param = array()) 
	 {
	 	$count = 0;
	 	
	 	$result =  $this->getLaMapper()
	 	                ->getLeaveAllowanceReport($param);
	 	if (!$result) {
	 		return 0;
	 	}
	 	foreach($result as $res) {
	 			
	 		$empId = $res['employeeId']; 
	 			
	 		$amtName = "amt".$empId;
	 		$taxName = "tax".$empId;
	 		$netName = "net".$empId;
	 			
	 		$output .= "<table  cellspacing='0' bordercolor='#C0C0C0' style='border-collapse: collapse'
		             border='1' cellpadding='6px' align='center' width='400px'>
				    <thead>
				        <tr>
				            <th colspan ='2' align = 'left'>Name: ".$res['employeeName']."</th>
				            <th >SDG</th>
				        </tr>
				    </thead>"; 
	 		$initial  = $res['Initial'];
	 		$cola     = $res['Cola'];
	 		$basic    = $initial + $cola;
	 		$leaveAll = $basic * 6;
	 
	 		$output .= "<tbody>
				        <tr>
				            <td>Initial Salary</td>
				            <td>".$initial."</td>
				            <td>&nbsp;</td>
				        </tr>
				        <tr>
				            <td>Cola</td>
				            <td>".$cola."</td>
				            <td>&nbsp;</td>
				        </tr>
				        <tr>
				            <td>Non Payment days</td>
				            <td>".$res['leaveDays']."</td>
				            <td>&nbsp;</td>
				        </tr>
				        <tr>
				            <td>(Initial+Cola)*6</td>
				            <td>&nbsp;</td>
				            <td align='right'>".$leaveAll."</td>
				        </tr>";
	 		$row = $this->getReportDtls( $res['id']); 
	 		/*$select = "select Allowance_Name_En,Amount from Pmnt_Leave_All_Dtls  d
				                          inner join Lkp_Allowances a on  d.All_Id = a.id
				                          where Pmnt_Leave_All_Mst_Id = '". $res['mstId']."' ";
	 		$row = $db->fetchAll($select);*/ 
	 		if ($row) {
		 		foreach($row as $r) {
		 			$output.=" <tr>
								               <td>".$r['allowanceName']."</td>
									           <td>".$r['Amount']."</td>
									           <td>&nbsp;</td>
									       </tr>";
		 		} 
	 		}
	        
	 		$output .="<tr>
	 		         <td>Housing</td>
	 		          <td>".$res['Housing']."</td>
	 		           <td>&nbsp;</td>
	 		        </tr>
	 		 		<tr> 
				            <td>Transportation</td>
				            <td>".$res['Transportation']."</td>
				            <td>&nbsp;</td>
				        </tr>
				        <tr>
				            <td> Leave Allowance</td>
				            <td>".$res['leaveAllowance']."</td>
				            <td>&nbsp;</td>
				        </tr>
				        <tr>
				            <td> Eid</td>
				            <td>".$res['leaveEid']."</td>
				            <td>&nbsp;</td>
				        </tr>
				        <tr>
				            <td> Gross</td>
				            <td>".$res['Gross']."</td>
				            <td>&nbsp;</td>
				        </tr>
				        <tr>
				            <td>".$res['grossDescription']."</td>
				            <td>".$res['leaveExempted']."</td>
				            <td>&nbsp;</td>
				        </tr>
				        <tr>
				            <td>(Initial+Cola)*6 - ".$res['grossDescription']."</td>
				            <td>".($res['Amount'] - $res['leaveExempted'] )."</td>
				            <td>&nbsp;</td>
				        </tr>
				        <tr>
				            <td>Tax</td>
				            <td>&nbsp;</td>
				            <td>".$res['Tax']."</td>
				        </tr>
                        <tr>
				            <td>Special Loan</td>
				            <td>&nbsp;</td>
				            <td>".$res['specialLoanDeduction']."</td>
				        </tr>
				        <tr>
				            <td>Marital Status/No of Children(s)</td>
				            <td>".$res['maritalStatus']."</td>
				            <td>&nbsp;</td>
				        </tr>
				    </tbody>
				    <tfoot>
				        <tr>
				            <td colspan='2' align='right'>Net: </td>
				            <td align='right' >".$res['Net']."</td>
				        </tr>
				    </tfoot>
				</table><br><br>";
	 		$count++;
	 		$empNme[$count]   = $res['Emp_Name_En'];
	 		$func[$count]      = $res['functionCode'];
	 		$eId[$count]     =$empId; 
	 		$leavTaken[$count] = $res['issueDate'];
	 		$totalAmt[$count]  = $res['Amount'];
	 		$totalTax[$count]  = $res['Tax'];
	 		$totLoan[$count]   = $res['specialLoanDeduction'];
	 		$totalNet[$count]  = $res['Net'];
	        $doj[$count]  = $res['empJoinDate'];  
	 	}
	 
	 	$output .= "<br /><br /><table cellspacing='0' bordercolor='#C0C0C0' style='border-collapse: collapse'  border='1' cellpadding='6px' align='center' width='750px' >
	                <tr>
	                    <th>#</th>
		                <th>Name</th>
		                <th>Function</th>
		                <th>Date of Join</th>
    	                <th>Leave Taken</th>
		                <th>Amount</th>
		                <th>Tax</th>
                        <th>Special Loan</th>
		                <th>Net</th>
	               </tr>";
	 	$grandTotal=0;
	 	$i = 0;
	 	for($i=1;$i<=$count;$i++) { 	 
	 		$empName = $empNme[$i];
	 		$secCode = $func[$i];
	 		$doj =$doj[$count];
	 		$today = $leavTaken[$i];
	 		$amt = $totalAmt[$i];
	 		$tax = $totalTax[$i];
	 		$netPay = $totalNet[$i];
	 		$loan = $totLoan[$i];
	 		 
	 		$grandLoan += $loan;
	 		$grandTax += $tax;
	 		$grandTotal += $netPay;
	 		$output .= "<tr>
		            <td>".$i."</td>
			        <td>".$empName."</td>
			        <td>".$secCode."</td>
			        <td>".$doj."</td>
	    	        <td>".$today."</td>
			        <td>".$amt."</td>
			        <td>".$tax."</td>
                    <td>".$grandLoan."</td>
			        <td align='right'>".$netPay."</td>
	        	</tr>";
	 
	 	}
	 	$output .= "<tr>
		                    <td colspan='6' align='right' ><b>Total</b></td>
		                    <td align='right'><b>".$grandTax."</b></td>
                            <td align='right'><b>".$grandLoan."</b></td>
			                <td align='right'><b>".$grandTotal."</b></td>
		                </tr>
	                    </table>";
	 
	 
	 	return $output;
	 }
	 
	 
	 public function getFeLeaveAllowanceBalToEmployee(Employee $employee,$relievingDate,$dateOfJoin) {
	 	list($year,$month,$day) = explode('-', $relievingDate); 
	 	// list($jyear,$jmonth,$jday) = explode('-', $dateOfJoin); 
	 	$laMapper = $this->getLaMapper();
	 	$employeeId = $employee->getEmployeeNumber(); 
	 	$lastLeave = $laMapper->getLastLeaveAllowanceDate($employeeId); 
	 	
	 	if($lastLeave && ($lastLeave < $relievingDate)) { 
	 		$firstDay = $this->dateMethods->getFirstDayOfDate($relievingDate); 
	 	    $numberOfYears = $this->dateMethods->numberOfYearsBetween($lastLeave,$relievingDate);
	 	    $dateRange = $this->prepareDateRange($firstDay);
	 	    $company = $this->service->get('company'); 
	 	    
	 	    $basic = $this->getBasic($employee, $company, $dateRange); 
	 	    $per = ($basic * 6)/12; 
	 	    return $numberOfYears * $per;  
	 	}
	 	return 0; 
	 }
	 
	 public function getFeLeaveAllowanceBalToCompany(Employee $employee,$relievingDate,$dateOfJoin) {
	 	list($year,$month,$day) = explode('-', $relievingDate); 
	 	// list($jyear,$jmonth,$jday) = explode('-', $dateOfJoin); 
	 	$laMapper = $this->getLaMapper();
	 	$employeeId = $employee->getEmployeeNumber(); 
	 	$lastLeave = $laMapper->getLastLeaveAllowanceDate($employeeId); 
	 	//\Zend\Debug\Debug::dump($lastLeave);
	 	//exit; 
	 	if($lastLeave && ($lastLeave > $relievingDate)) { 
	 	    $numberOfYears = $this->dateMethods->numberOfYearsBetween($lastLeave,$relievingDate);
	 	    $dateRange = $this->prepareDateRange($relievingDate);
	 	    $company = $this->service->get('company'); 
	 	    $basic = $this->getBasic($employee, $company, $dateRange);
	 	    $per = ($basic * 6)/12;
	 	    return $numberOfYears * $per;
	 	}
	 	return 0;
	 }
     
} 