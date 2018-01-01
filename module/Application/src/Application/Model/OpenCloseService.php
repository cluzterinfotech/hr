<?php  
namespace Application\Model;

use User\Model\UserInfoService;
use Payment\Model\Company;
use Payment\Model\DateRange;
use Payment\Model\Payment; 
use Payment\Model\ReferenceParameter;

class OpenCloseService extends Payment {
	
	protected $userInfoService;
	protected $mailService;
	protected $checkListService;
	
	
	public function __construct(UserInfoService $userInfoService,
			MailService $mailService,CheckListService $checkListService,
			ReferenceParameter $reference) { 
		parent::__construct($reference); 
	    $this->userInfoService = $userInfoService; 
	    $this->mailService = $mailService; 
	    $this->checkListService = $checkListService; 
	}
	
	public function isPendingProcessInMonth(Company $company,DateRange $dateRange) {
		// check is any monthly process pending 
		// @todo check with pending checklist 
		return 0;   
	}  
	 
	public function closeMonth(Company $company,DateRange $dateRange) {
		try {  
			$this->transaction->beginTransaction(); 
			
			$res = $this->updateActiveMonthForCurrentCompany($company); 
				
			if($res == 0) { 
				return "To close last month,Please close the year";
			} 
			
			$employeeMapper = $this->service->get('CompanyEmployeeMapper');
			// $this->getServiceLocator()->get('CompanyEmployeeMapper');
			
			$condition = array(
					'isActive' => 1,
					'companyId' => $company->getId(),
					'isInPaysheet' => 1,
			); 
			
			$employeeList = $employeeMapper->fetchAll($condition); 
			// prepare all allowances 
			$this->prepareEmployeeAllowance($employeeList,$company,$dateRange);  
			
			$this->prepareSpecialAmount($dateRange);  
			
			// @todo prepare company allowance 
			//$this->prepareCompanyAllowance($company,$dateRange);
			
			// @todo prepare blank checklist 
			
			
			// @todo update active month 
			//echo $res;
			 
			//exit; 
			$this->transaction->commit(); 
		} catch(\Exception $e) {
			$this->transaction->rollBack(); 
			throw $e; 
		} 
	} 
	
	public function updateActiveMonthForCurrentCompany(Company $company) { 
		
		$monthyearmapper = $this->service->get('monthyearmapper'); 
		
		return $monthyearmapper->updateActiveMonthForCurrentCompany($company); 
		
		
	}
	
	public function prepareCompanyAllowance(Company $company,DateRange $dateRange) {
		// fetch allowance list for the company
		//$allowanceList = $this->companyAllowance
		                      //->getPaysheetAllowance($company,$dateRange); 
		
	}
	
	public function isPendingProcessInYear(Company $company,
			DateRange $dateRange) {
	            
	}
	
	public function prepareSpecialAmount(DateRange $dateRange) {
	    $specialAmountList = $this->allowanceEntry->getSpecialAmountList($dateRange);
	    $fromDate = $dateRange->getFromDate();
	    $nextMonth = $this->dateMethods->getNextMonth($fromDate); 
	    foreach($specialAmountList as $splList) {
	        $insArray = array(
	            //'id'              => $splList[''],
	            'employeeNumber'  => $splList['employeeNumber'],
	            'effectiveDate'   => $nextMonth,
	            'allowanceId'     => $splList['allowanceId'],
	            'amount'          => $splList['amount'],
	            'isAdded'         => $splList['isAdded'],
	        ); 
	    }
	}
	
	public function prepareEmployeeAllowance($employeeList,
			Company $company,DateRange $dateRange) {
		// fetch allowance list for the company
		$allowanceList = $this->companyAllowance
		                      ->getPaysheetAllowance($company,$dateRange);
		$normalDeduction = $this->companyDeduction
		                        ->getPaysheetNormalDeduction($company,$dateRange);
		$fromDate = $dateRange->getFromDate();
		//\Zend\Debug\Debug::dump($fromDate);
		//$dateMethods = $this->service->get('dateMethods');
		//\Zend\Debug\Debug::dump($dateRange);
		//exit; 
		$nextMonth = $this->dateMethods->getNextMonth($fromDate); 
		//\Zend\Debug\Debug::dump($nextMonth); 
        
		foreach($employeeList as $employee) {
		    
			foreach($allowanceList as $allowanceName => $typeName) { 
				// get the latest amount 
				$service = $this->service->get($typeName);
				$employeeNumber = $employee->getEmployeeNumber(); 
				$amount = $service->getLastAmount($employee,$dateRange); 
				if($amount > 0) {
					$data = array(
					    'effectiveDate'  => $nextMonth,
						'amount'         => $amount,
						'employeeId'     => $employeeNumber 
					);
					// $addAmount
					//\Zend\Debug\Debug::dump($data);  
					$service->insert($data);
				}  
			}  
			
			foreach($normalDeduction as $allowanceName => $typeName) {
				$service = $this->service->get($typeName);
				$employeeNumber = $employee->getEmployeeNumber();
				$amount = $service->getLastAmount($employee,$dateRange);
				if($amount > 0) {
					$data = array(
							'effectiveDate'  => $nextMonth,
							'amount'         => $amount,
							'employeeId'     => $employeeNumber
					);
					// $addAmount
					//echo "deduction------------<br/>";
					//\Zend\Debug\Debug::dump($data);
					$service->insert($data);
				} 
			}
			// exit;
			// @todo normal deduction 
			/*foreach ($normalDeduction as $key => $deductionName) { 
				$service = $this->service->get($typeName);
				// $service =
				$service->getLastAmount($employee,$dateRange);
			}*/ 
			
		}
		// fetch employee active employee list 
		// add allowance for new month 
		//    
	}      
	       
	public function closeYear(Company $company,DateRange $dateRange) {
	    // 	
		// 
	}
	
	public function prepareBlankChecklist() {
	    
	}
	
	public function calculateDifference() {
	    
	}  
	
	/*
	 * backsup allowance provided during that month
	 */
	
	public function backupMonthlyCompanyAllowanceList() {
		
	}
    
	public function backupMonthlyCompanyDeductionList() {
	    
	}
	// mail alerts 
	public function SendMailAlert() {
			
	} 
	
} 