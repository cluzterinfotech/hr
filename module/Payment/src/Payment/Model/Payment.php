<?php 

namespace Payment\Model;

use Application\Persistence\TransactionDatabase;
use Payment\Model\ReferenceParameter;

abstract class Payment {
	
	protected $companyAllowance;  
	protected $transaction;  
	protected $service;  
	protected $allowanceEntry; 
	protected $deductionEntry; 
	protected $companyDeduction; 
	protected $allowanceServiceName; 
	protected $dateMethods; 
	protected $userInfoService; 
	protected $companyId;
	//protected $company;
	
	public function __construct(ReferenceParameter $reference) {  
		$this->companyAllowance = $reference->getCompanyAllowance();  
		$this->companyDeduction = $reference->getCompanyDeduction(); 
		$this->allowanceEntry = $reference->getAllowanceEntry(); 
		$this->service = $reference->getService(); 
		$this->transaction = new TransactionDatabase($reference->getAdapter()); 
		$this->deductionEntry = $reference->getDeductionEntry(); 
		$this->dateMethods = $this->service->get('dateMethods');
		$this->userInfoService = $this->service->get('userInfoService');   
		$this->companyId = $this->userInfoService->getCompany();
		//$this->company = $this->service->get('company'); 
	} 
	
    public function getCheckListService() {  
		return $this->service->get('checkListService'); 
	}  
	
	public function getBasic(Employee $employee,Company $company,DateRange $dateRange) {
		$tot = 0; 
	    //$service = $this->service->get('initial');  
	    //$initial = $service->getAmount($employee,$dateRange);  
	    //$tot += $initial;  
	    //\Zend\Debug\Debug::dump($dateRange);  
	    $basicAllowance = $this->companyAllowance->getBasicAllowance($company,$dateRange); 
	    foreach($basicAllowance as $allowanceName => $serviceName) {
	    	//\Zend\Debug\Debug::dump($allowanceName);
	    	$service = $this->service->get($serviceName);
	    	$amount = $service->getAmount($employee,$dateRange);
	    	//\Zend\Debug\Debug::dump($amount); 
	    	$tot += $amount;
	    } 
	    /*if($employee->getEmployeeNumber() == '1076') {
	        echo $tot;
	        exit;
	    }*/  
	    return $tot; 
	} 
	
	public function getGross(Employee $employee,Company $company,DateRange $dateRange) {
		$tot = 0;
		//$service = $this->service->get('initial');
		//$initial = $service->getAmount($employee,$dateRange);
		//$tot += $initial;
		//\Zend\Debug\Debug::dump($dateRange);
		$basicAllowance = $this->companyAllowance->getPaysheetAllowance($company,$dateRange);
		foreach($basicAllowance as $allowanceName => $serviceName) {
			//\Zend\Debug\Debug::dump($allowanceName);
			$service = $this->service->get($serviceName);
			$amount = $service->getAmount($employee,$dateRange);
			//\Zend\Debug\Debug::dump($amount); 
			$tot += $amount;
		}
		/*if($employee->getEmployeeNumber() == '1076') {
		 echo $tot;
		 exit;
		 }*/
		return $tot;
	}
	
	public function isThisAllowanceHaveMorePriority
	    ($allowance,$notToHaveAllowance,$priority,Company $company) { 
		$notToHavePriority = $this->companyAllowance
		                          ->getAllowancePriority($allowance,$notToHaveAllowance,$company); 
		if($notToHavePriority > $priority) {
			return false;
		}
		return true;
	}
	
	public function addAllowanceToEmployee($employeeNumber,$allowanceId,
			Company $company,$effectiveDate) { 
		$dateRange = $this->service->get('dateRange'); 
		$allowanceList = $this->companyAllowance
		                      ->getNotToHaveAllowance($allowanceId,$company,$dateRange); 
		$addAllowanceFlag = 1; 
		foreach($allowanceList as $a) { 
			$allowance = $a['allowanceId']; 
			$notToHaveAllowance = $a['notToHaveAllowance']; 
			$priority = $a['priority']; 
			
			//\Zend\Debug\Debug::dump($a);
			//exit; 
			
			$isHave = $this->isHaveThisAllowance($employeeNumber,$notToHaveAllowance
					,$company,$effectiveDate);  
			if($isHave) {
				if($this->isThisAllowanceHaveMorePriority 
						($allowance,$notToHaveAllowance,$priority,$company)) { 
					$this->applyAffectedAmount($employeeNumber,$notToHaveAllowance,
							$company,$effectiveDate,'0');   
				} else { 
					$addAllowanceFlag++; 
				} 
			}
		}  
		if($addAllowanceFlag == 1) {  
			$this->addEmployeeAllowance($employeeNumber,$allowanceId,$company,$effectiveDate);
		} 
		//exit; 
	}   
	
	public function isHaveThisAllowance($employeeNumber,$allowanceId,$company,$effectiveDate) {
		$allowanceName = $this->companyAllowance
		                      ->getAllowanceTypeName($allowanceId,$company); 
		$allowance = $this->service->get($allowanceName);
		$dateRange = $this->prepareDateRange($effectiveDate);
		$employee = $this->getEmployeeById($employeeNumber);
	    $amount = $allowance->calculateAmount($employee,$dateRange);
		if($amount > 0) {
			return true;
		}
		return false; 
	}
	
	// remove related allowance 
	public function addEmployeeAllowance($employeeNumber,$allowanceId,$company,$effectiveDate) { 
		$amount = 0;  
		//\Zend\Debug\Debug::dump($employeeNumber);
		//\Zend\Debug\Debug::dump($allowanceId);
		//\Zend\Debug\Debug::dump($company);
		//\Zend\Debug\Debug::dump($effectiveDate);
		//exit;
		$this->applyAffectedAmount($employeeNumber,$allowanceId,
				$company,$effectiveDate,'1'); 
		// This will fetch all the allowance affected by given allowance name 
		$affectedAllowanceList = $this->companyAllowance
		                              ->getRelatedAllowance($allowanceId,$company);  
		foreach ($affectedAllowanceList as $a) { 
			// as of now the chain cannot go more than one level
			$this->applyAffectedAmount($employeeNumber,$a['affectedAllowanceId'],
					$company,$effectiveDate,'1'); 
		} 
		
	}
    
	public function applyAffectedAmount($employeeNumber,$allowanceId,
		$company,$effectiveDate,$addRemoveFlag = 0) {   
		//\Zend\Debug\Debug::dump($allowanceId); 
		try {  
			if($employeeNumber) {
				$allowanceName = $this->companyAllowance 
				                      ->getAllowanceTypeName($allowanceId,$company);  
				$dateMethods = $this->service->get('dateMethods'); 
				$beginningMonth = $dateMethods->getFirstDayOfDate($effectiveDate); 
				$today = $dateMethods->getToday();  
				$noOfMonths = $dateMethods->numberOfMonthsBetween($beginningMonth,$today); 
				$employee = $this->getEmployeeById($employeeNumber); 
				$dateRange = $this->prepareDateRange($effectiveDate);  
				$dateRange->setFromDate($beginningMonth);  
	            $this->applyAmount($employee,$allowanceName,
	                		$effectiveDate,$dateRange,$addRemoveFlag);  
				for($i=1;$i<=$noOfMonths;$i++) {  
					$mydate = date("Y-m-d",mktime(0, 0, 0,date("m",strtotime($beginningMonth)) + $i, 
							  date("d",strtotime($beginningMonth)),date("Y",strtotime($beginningMonth)) 
					));  
					$dateRange = $this->prepareDateRange($mydate);  
					$this->applyAmount($employee,$allowanceName, 
							$mydate,$dateRange,$addRemoveFlag); 
				}   
					
			}   
		} catch(\Exception $e) {    
			throw $e;      
		}     
	}          
	
	private function applyAmount(Employee $employee,$allowanceName,
			$effectiveDate,DateRange $dateRange,$flag) { 
		/*if($allowanceName == 0) {
			echo "zero";
			exit;
		}*/
			    
		//\Zend\Debug\Debug::dump($allowanceName);
		//\Zend\Debug\Debug::dump($allowanceName);
		//\Zend\Debug\Debug::dump($employee);
		//\Zend\Debug\Debug::dump($dateRange); 
		//exit; 
		$allowance = $this->service->get($allowanceName);
		if($flag == 1) {
			$amount = $allowance->calculateAmount($employee,$dateRange);
		} else {
			$amount = 0;
		} 
		$arr = array( 
				'effectiveDate'  => $effectiveDate, 
				'amount'         => $amount,  
				'employeeId'     => $employee->getEmployeeNumber() 
		);  
		//\Zend\ 
		//\Zend\Debug\Debug::dump($allowance);
		//\Zend\Debug\Debug::dump($arr);
		//exit;
		$allowance->insert($arr);
	}   
	
	public function twoDigit($amount) {
		return number_format($amount,2,'.','');
	}
	
	
    
	protected function getEmployeeById($employeeNumber) {
		$employeeMapper = $this->service->get('CompanyEmployeeMapper');
		return $employeeMapper->fetchEmployeeByNumber($employeeNumber); 
	} 
	
	protected function prepareDateRange($effectiveDate) {
		$dateRange = $this->service->get('dateRange'); 
		$dateMethods = $this->service->get('dateMethods');  
		$lastDayOfMonth = $dateMethods->getLastDayOfDate($effectiveDate); 
		$dateRange->setFromDate($effectiveDate); 
	    $dateRange->setToDate($lastDayOfMonth);   
		return $dateRange; 
	} 
	
	protected function prepareCompleteDateRange($effectiveDate) {
		$dateRange = $this->service->get('dateRange');
		$dateMethods = $this->service->get('dateMethods');
		$lastDayOfMonth = $dateMethods->getLastDayOfDate($effectiveDate);
		$firstDate = $dateMethods->getFirstDayOfDate($effectiveDate);
		$dateRange->setFromDate($firstDate);
		$dateRange->setToDate($lastDayOfMonth);
		return $dateRange;
	}
	 
	protected function getAllowanceIdByName($allowanceTypeName) {
		return $this->companyAllowance->getAllowanceIdByName($allowanceTypeName);
	} 
	
	protected function workingDaysPay($amount,$daysInMonth,$workDays) {
		return ($amount/$daysInMonth) * $workDays;
	}
	
	/*protected function getCompanyById($companyId) { 
		return $this->companyAllowance->getCompanyById($companyId); 
	}*/ 
	
}