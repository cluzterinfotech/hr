<?php 
namespace Payment\Model;

use Payment\Model\Company;
use Payment\Model\DateRange;

class PfRefundService extends Payment { 
    
    protected $finalEntitlement = array();  
    
    protected $leaveAllowanceDtls = array(); 
    
    protected $feMapper; 
    
    public function getPfMapper() {
    	return $this->service->get('pfRefundMapper'); 
    }
    
    public function getNonPayDays($employeeId,$fromDate,$toDate) {
    	$service = $this->service->get('NonPaymentDaysService'); 
    	return $service->getEmployeeFinalEntitlementNonWorkingDays($employeeId,$fromDate,$toDate); 
    	// return $days;  
    } 
    
    public function getLastPFRefDate($employeeId) {
        $res = $this->getPfMapper()->getLastPFRefDate($employeeId); 
        if($res) {
        	return array('refundFrom' => $res); 
        }	
        $employee = $this->getEmployeeById($employeeId); 
        return array('refundFrom' => $employee->getEmpJoinDate());
    }
    
   /* public function getPFDtls($employeeId,$refundFrom,$refundTo) {
    	$res = 1;//$this->getPfMapper()->getLastPFRefDate($employeeId);
    	if($res) {
    		$output = "<table border='1' align='center'  width='100%' bordercolorlight='#C0C0C0' bordercolordark='#C0C0C0' style='border-collapse: collapse'>
	        <tr>
		        <th bgcolor='#F0F0F0'>Month & Year</th>
		        <th bgcolor='#F0F0F0'>Company</th>
		        <th bgcolor='#F0F0F0'>Employee</th>
		        <th bgcolor='#F0F0F0'>5%</th>
		        <th bgcolor='#F0F0F0'>Optional Amount</th>
	        </tr>"; 
    		
    		$amount = 0; 
    		return array(
    				'refundAmount' => $amount, 
    				'dtls'         => $output, 
    		);
    	} 
    	return array(
    				'refundAmount' => '0',
    				'dtls'         => 'n/a',
    		); 
    }  */ 
    
    public function getPFDtls($empId,$from,$to)
    {
    	$paysheetService = $this->getPaysheetService();
    	$company = $this->service->get('company'); 
    	$firstDay = $this->dateMethods->getFirstDayOfDate($to);
    	$dateRange = $this->prepareDateRange($firstDay); 
    	
    	$isSalClosed = $paysheetService->isPaysheetClosed($company,$dateRange);
    
    	if(!$isSalClosed) {
    		return array(
    				'refundAmount' => '0',
    				'dtls'         => 'Sorry! Salary not closed for',
    		);
    		// return "0,'Sorry! Salary not closed for ".$to."'";
    	}
    
    	$output = "<table border='1' align='center'  width='100%' bordercolorlight='#C0C0C0' bordercolordark='#C0C0C0' style='border-collapse: collapse'>
	        <tr>
		        <th bgcolor='#F0F0F0'>Month & Year</th>
		        <th bgcolor='#F0F0F0'>Company</th>
		        <th bgcolor='#F0F0F0'>Employee</th>
		        <th bgcolor='#F0F0F0'>5%</th>
		        <th bgcolor='#F0F0F0'>Optional Amount</th>
	        </tr>";
    
    
    	//$lastRefDate = $this->getLastPFRefDate($db,$empId);
    	$date = explode("-",$from);
    	// $date =time();
    	$month = $date[1] ;
    	$year = $date[0] ;
    	$j = 1;
    
    	$mon = date("m");
    	$yr = date("Y");
    	if($mon == 1) {
    		$mon = 12;
    		$yr = $yr - 1;
    	} else {
    		$mon = $mon - 1;
    	} 
    	$today    = $yr."-".$mon."-01";
    	$pfElegibleDays = $this->dateMethods->numberOfMonthsBetween($from,$to); 
        
    	$totOptamt = 0;
    	$totComShare = 0;
    	$totEmpShare = 0;
    	$totFivePer = 0;
    	
    	// $pfElegibleDays = $this->getTotalMonths($from,$to);
    	// if($pfElegibleDays){
    	$output .= "<tr>
		                    <td >&nbsp;</td>
		                    <td >&nbsp;</td>
		                    <td >&nbsp;</td>
		                    <td >&nbsp;</td>
		                    <td >&nbsp;</td>
	                    </tr>";
    	// this is disabled only for elmansore ali elmansore
    	//for($i=0;$i<$pfElegibleDays;$i++){
    	for($i=0;$i<$pfElegibleDays;$i++){
    		$day = 1 ;
    		$month++;
    		if($month == 13) {
    			$year = $date[0] + $j++ ;
    			$month = 01;
    		}
    		$ded_date = $year."-".$month."-".$day;
    		
    		$ro = $this->getPfMapper()->getPfDed($empId,$ded_date); 
    		//\Zend\Debug\Debug::dump($ro);
    		//exit;
    		// $db
    		/*$q = "SELECT Deduction_Date,Emp_Share,Comp_Share,Five_Per,Opt_Amt FROM Pmnt_Emp_Pf_Ded WHERE
			          Deduction_Date ='".$ded_date."' and Pmnt_Emp_Mst_Id = '".$empId."'  "; 
    		$ro = $db->fetchRow($q);*/ 
    		$totComShare += $ro['companyShare'];
    		$totEmpShare += $ro['empShare'];
    		$totFivePer += $ro['fivePercentage'];
    		$totOptamt += $ro['optionalAmount'];
    		
    		$ded_date = strtotime($ded_date);
    
    		$output .="<tr>
							<td align='right'> ".date('F',$ded_date).' '.date('Y',$ded_date)." </td>
							<td align='right'>".$ro['companyShare']."</td>
							<td align='right'>".$ro['empShare']."</td>
							<td align='right'>".$ro['fivePercentage']."</td>
							<td align='right'>".$ro['optionalAmount']."</td>
				    	   </tr>";
    	}
    	$output .= "<tr>
		                    <td >&nbsp;</td>
		                    <td >&nbsp;</td>
		                    <td >&nbsp;</td>
		                    <td >&nbsp;</td>
		                    <td >&nbsp;</td>
	                    </tr>";
    
    
    	$totOptamt = $this->twoDigit($totOptamt);
    	$output .="<tr>
		               <td align='right'>&nbsp;Total </td>
		               <td align='right'>".$this->twoDigit($totComShare)."</td>
		               <td align='right'>".$this->twoDigit($totEmpShare)."</td>
		               <td align='right'>".$this->twoDigit($totFivePer)."</td>
		               <td align='right'>".$totOptamt."</td>
	               </tr>
                </table>";
    
    	//$plusTweleve = date("Y-m-d",mktime(0, 0, 0, date("m",strtotime($lastRefDate)) + 12, date("d",strtotime($lastRefDate)), date("Y",strtotime($lastRefDate))));
    
    	//$arr = array($output,$lastRefDate,$totOptamt,$plusTweleve);
    
    	// return $totOptamt.",".$output;
    	
    	if($totOptamt > 0) {
	    	return array(
	    			'refundAmount' => $totOptamt,
	    			'dtls'         => $output,
	    	);
    	}
    	
    	return array(
    			'refundAmount' => '0',
    			'dtls'         => 'n/a',
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
	 	return $this->getPfMapper()->selectEmployeeLa();  
	 }
	 
	 public function saveEmployeeLeaveAllowance($formValues) {
	 	$leaveEmployeeInfo = array (
	 			'employeeId'       => $formValues['employeeNumberLeaveAllowance'],
	 			'companyId'        => $formValues['companyId']
	 	);
	 	$this->getPfMapper()
	 	     ->saveEmployeeLeaveAllowance($leaveEmployeeInfo);
	 }
	 
	 public function removeEmployeeLeaveAllowance($id) {
	 	return $this->getPfMapper()
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