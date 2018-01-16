<?php 

namespace Payment\Model;
 
use Payment\Model\Company;
use Payment\Model\DateRange;
 
class CarRent extends Payment { 
    
    protected $carRentMst = array();  
    
    protected $carRentDtls = array(); 
    
    protected $laMapper; 
    
    public function getCarRentMapper() {
    	return $this->service->get('carRentMapper'); 
    }
    
    public function getNonPayDays($employeeId,$fromDate,$toDate) {
    	$service = $this->service->get('NonPaymentDaysService'); 
    	return $service->getCarRentNonWorkingDays($employeeId,$fromDate,$toDate); 
    	// return $days;  
    } 
        
    public function removeUnclosedCarRent(Company $company) {
    	// @todo remove unclosed leave allowance for the company 
    	$this->getCarRentMapper()->removeUnclosedCarRent($company);  
    } 
	   
	public function calculate(Company $company,DateRange $dateRange,$routeInfo) {  
	 	try {  
	 	    $this->transaction->beginTransaction();   
	 	    // @todo from last taken LA to now number of days 
	 	    // @todo  
	 	    /*$workDays = 0;
              $sickLeaveDays = 0;
              $twelthMonth = 0;
              $susDays = 0;
              $suspendDays = 0;
              $levWithoutPayDays = 0;
              $annualDays = 0;
              $workingDays = 0;
              $emergencyDays = 0;
              $examDays = 0;
              $hejjDays = 0;
              $maternityDays = 0;
              $sickLeaveDaysRent = 0;
              $rentNet = 0;
              $rentWorkingDays = 0;
            */
	 	    $this->removeUnclosedCarRent($company); 
	 	    // get employee list based on company 
	 	    // $employeeList =  
	 	    $fixedAllowanceList = $this->companyAllowance
	 	                               ->getLeaveAllowanceFixed($company,$dateRange); 
	 	    $allowanceList = $this->companyAllowance
	 	                          ->getLeaveAllowanceAllowance($company,$dateRange);  
            
	 	    $employeeList = $this->getCarRentMapper()
	 	                         ->getCarRentEmployeeList($company);   
	 	        
	 	    $carRentMapper = $this->getCarRentMapper();  
	 	    // @todo fetch from DB     
	 	    $dateMethods = $this->service->get('dateMethods');  
	 	    $leaveGross = 0;   
	 	    $fromDate = $dateRange->getFromDate();   
	 	    $toDate = $dateRange->getToDate();   
	 	    $companyId = $company->getId();   
	 	    $batchNo   = 1; //@todo  //$this->getBatchNo($fyYear); 
	 	    $daysInMonth = $dateMethods->numberOfDaysBetween($fromDate,$toDate);  
            
	 	    foreach($employeeList as $emp) {  
	 	        //\Zend\Debug\Debug::dump($emp);
	 	    	//exit; 
	 	        $actAmount = 0; 
	 	    	$amount = 0; 
	 	    	$nonPayDays = 0;  
	 	    	$nonPay = array();  
	 	    	$this->carRentMst = '';   
	 	    	 
	 	    	$employeeId = $emp['employeeNumber'];  
	 	    	$employee = $this->getEmployeeById($employeeId);  
	 	    	
	 	    	$nonPay = $this->getNonPayDays($employeeId,$fromDate,$toDate);  

	 	    	$nonPayDays = $nonPay['0']; 
	 	    	
	 	    	//$dtls = $nonPay['1'];  
	 	    	
	 	    	$workDays = $daysInMonth - $nonPayDays; 
	 	    	
	 	    	$amount = $emp['amount'];  
	 	    	
	 	    	$actAmount = $amount; 
	 	    	
	 	    	$amount = $this->workingDaysPay($amount,$daysInMonth,$workDays);
                                		        
		        $this->carRentMst['rentDate'] = date('Y-m-d');
		        $this->carRentMst['isClosed'] = 0;
		        //$this->carRentMst['doneBy'] = $routeInfo->
		        $this->carRentMst['employeeId'] = $employeeId;  
		        $this->carRentMst['paidAmount'] = $amount;
		        $this->carRentMst['lkpCarRentGroupId'] = $emp['lkpCarRentGroupId'];
                
		        $this->carRentMst['referenceNumber'] = $emp['referenceNumber'];
		        $this->carRentMst['accountNumber'] = $emp['accountNumber'];
		        $this->carRentMst['empBank'] = $emp['empBank']; 
		        $this->carRentMst['empLocation'] = $emp['empLocation']; 
		        $this->carRentMst['empPosition'] = $emp['empPosition'];  
		        $this->carRentMst['companyId'] = $company->getId();   
		        $this->carRentMst['dtls'] = $nonPay['1']; 
		        $this->carRentMst['actualRent'] = $actAmount;
		        //\Zend\Debug\Debug::dump($this->carRentMst);  
		        //exit; 
		        $mstId = $carRentMapper->insertCarRent($this->carRentMst); 
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
	 
	 public function iscarrentClosed(Company $company,DateRange $dateRange) {  
	 	//return 0;
	    return $this->getCarRentMapper()->iscarrentClosed($company,$dateRange); 
	     // return false;     	
	 } 
	 
	 public function getFunctionCode($employeeId) {
	     // @todo 
	     return '123';  
	 } 
	 
	 public function getEmpDept($employeeId) {
	 	// @todo
	 	return '1';
	 }
	 
	 public function close(Company $company,DateRange $dateRange,$routeInfo) {
	 	try { 
	 		$this->transaction->beginTransaction(); 
	 		$this->getCarRentMapper()->closeThisCarrent($company,$dateRange);  
	 	    $this->getCheckListService()->closeLog($routeInfo); 
	 	    $this->transaction->commit();  
	 	} catch(\Exception $e) {  
	 		$this->transaction->rollBack(); 
	 		throw $e;  
	 	} 
	 } 
     
	 public function selectEmployeeLa() {
	 	return $this->getCarRentMapper()->selectEmployeeLa();  
	 }
	 
	 public function saveEmployeeLeaveAllowance($formValues) {
	 	$leaveEmployeeInfo = array (
	 			'employeeId'       => $formValues['employeeNumberLeaveAllowance'],
	 			'companyId'        => $formValues['companyId']
	 	);
	 	$this->getCarRentMapper()
	 	     ->saveEmployeeLeaveAllowance($leaveEmployeeInfo);
	 }
	 
	 public function removeEmployeeLeaveAllowance($id) {
	 	return $this->getCarRentMapper()
	 	            ->removeEmployeeLeaveAllowance($id); 
	 } 
	 
	 public function getReportDtls($id) {
	 	return $this->getCarRentMapper()
	 	                     ->getReportDtls($id); 
	 }
	 
	 public function  getCarRentReport(array $param = array()) 
	 {
	 	//$count = 0;
	    $from = $this->dateMethods->getFirstDayByMonthYear($param['month'],$param['year']); 
	    $to = $this->dateMethods->getLastDayOfDate($from);
	    return $this->getCarRentMapper()->getCarRentReport($from,$to);  
	 }
	 
	 public function  getCarRentReportDtls(array $param = array())
	 {
	     $from = $this->dateMethods->getFirstDayByMonthYear($param['month'],$param['year']);
	     $to = $this->dateMethods->getLastDayOfDate($from);
	     return $this->getCarRentMapper()->getCarRentReportDtls($from,$to);
	 }
	 
	 public function getCarRentByFunction(Company $company,$param) {
	 	return $this->getCarRentMapper()->getCarRentByFunction($company,$param);
	 }
	 
	 public function getCarRentByBank(Company $company,$param) {
	 	return $this->getCarRentMapper()->getCarRentByBank($company,$param);
	 }
	 
	 public function getCarRentBankSummary(Company $company,$param) {
	 	return $this->getCarRentMapper()->getCarRentBankSummary($company,$param);
	 }
	 
     
}    