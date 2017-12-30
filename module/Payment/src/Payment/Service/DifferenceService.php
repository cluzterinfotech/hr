<?php

namespace Payment\Service;

use Zend\Db\Adapter\Adapter, 
    Application\Contract\EntityInterface, 
    Application\Contract\EntityCollectionInterface, 
    Application\Entity\CompanyEntity;
use Application\Utility\DateRange;
use Application\Service\CompanyAllowanceService;
use Application\Service\EmployeeAllowanceAmountService;
use Application\Service\CompanyDeductionService;
use Application\Service\EmployeeDeductionAmountService;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Payment\Mapper\PaysheetMapper;
use Application\Service\AllowanceDeductionService;

class DifferenceService {
	
	protected $adapter;
	protected $collection;
	protected $companyAllowanceService;
	protected $companyDeductionService;
	protected $employeeService;
	protected $allowanceAmountService;
	
	protected $allowanceExemptionService;
	protected $deductionExemptionService;
	
	protected $paysheetAmount;
	protected $paysheetAmountWithExemption;
	
	protected $paysheetFlag = array();
	
	protected $allowanceDeductionService;
	
	protected $deductionAmountService; 
	
	protected $allowanceAmount = array();
	protected $deductionAmount = array();
	protected $taxAmount; 
	protected $paysheetMapper;
	protected $paysheet = array();
	protected $companyAllowance = array();
	protected $companyDeduction = array();
	protected $companyCompulsoryDeduction = array();
	protected $companyNonCompulsoryDeduction = array();
	// protected $companyCompulsoryDeduction;
	// protected 
	protected $company;
	protected $dateRange;
	protected $incomeTax;
	protected $services; 
    
	public function __construct(Adapter $adapter, 
			EntityCollectionInterface $collection
			,$sm
			) {
		$this->adapter = $adapter;
		$this->collection = $collection; 
		$this->companyAllowanceService = new CompanyAllowanceService($adapter,$collection);
		$this->allowanceAmountService = new EmployeeAllowanceAmountService($adapter,$collection);
		$this->companyDeductionService = new CompanyDeductionService($adapter, $collection);
	    $this->allowanceDeductionService = new AllowanceDeductionService($adapter, $collection);
		$this->deductionAmountService = $sm->get('EmployeeDeductionAmountService');
		$this->services = $sm;
        $this->paysheetMapper = new PaysheetMapper($adapter, $collection, $sm);
	}
	
	public function calculate(CompanyEntity $company,DateRange $dateRange) {
	    echo "test";
	    exit; 
		$this->company = $company;
		$this->dateRange = $dateRange;
		$this->companyAllowance = $this->companyAllowanceService
		     ->fetchAllowanceNameList($this->company,$this->dateRange);
		     \Zend\Debug\Debug::dump($this->companyAllowance);
		     exit; 
		// Always remove paysheet before  
		$this->removePaysheet($company,$dateRange);
		$this->calculateAllowance();
		$this->calculateDeduction(); 
		// $this->calculateTax();
		$this->preparePaysheet();
		$this->paysheet['paysheetDate'] = $this->dateRange->getFromDate();
		$this->paysheetMapper->insert($this->paysheet);
		return $this->paysheet;
		//return $this->paysheetFlag;
	}
	
	// is paysheet already closed? 
	public function isPaysheetClosed($company,$dateRange) {
		return 1;
	}
    
	// ok 
	public function calculateAllowance() {
        
		foreach($this->companyAllowance as $allowance) {
		    echo "Allowance ";
		    exit; 
		    $name = $allowance->getAllowanceTypeId()
							  ->getAllowanceId()
							  ->getAllowanceName(); 
			$amount = $this->allowanceAmountService
			               ->fetchAmountByAllowance($name,$this->dateRange);
		    $exemption = $this->allowanceAmountService
			                  ->fetchExemptionByAllowance($name,$this->dateRange);
			$this->allowanceAmount[$name] = $amount;
			$this->allowanceAmount[$name.'Exemption'] = $exemption; 
			$this->paysheetAmount += $amount;
			\Zend\Debug\Debug::dump($name); 
			\Zend\Debug\Debug::dump($amount); 
			$this->paysheetAmountWithExemption += $amount - $exemption;
		} 
		exit; 
	}
	
	public function calculateDeduction() { 
		$this->companyDeduction = $this->companyDeductionService
		                               ->fetchCompanyDeductionNameList($this->company,$this->dateRange);
		//\Zend\Debug\Debug::dump($this->companyDeduction);
		foreach($this->companyDeduction as $deduction) { 
            $category = $deduction->getDeductionId()->getDeductionCategoryId();
            $deductionClassName = $deduction->getDeductionId()->getDeductionClassName(); 
            if($category == 1) { 
            	$this->companyCompulsoryDeduction[] = $deductionClassName;
            } else {
                $this->companyNonCompulsoryDeduction[] = $deductionClassName; 
		    }
		}
		$this->prepareCompulsoryDeduction();
		$this->prepareNonCompulsoryDeduction();      
	}
	
	/*  
	 *  This deduction includes 
	 *  which have exemption or it is compulsory or included in tax
	 *  so this have to be treated separately 
	 */    
	
	protected function prepareCompulsoryDeduction() { 
		foreach ($this->companyCompulsoryDeduction as $k=>$deduction) {
			if(in_array('SocialInsuranceEmployee', $deduction)) {
			    $this->allowanceDeductionService
			         ->compulsoryDeduction($this->paysheetAmount,$deduction);
			}
		}
	}
	
	protected function  prepareNonCompulsoryDeduction() { 
		foreach($this->companyNonCompulsoryDeduction as $k => $deductionClassName) {
			$amount = $this->deductionAmountService
		                   ->fetchAmountByDeduction($deductionClassName,$this->dateRange);
			if($this->paysheetAmount > $amount) {
		        $this->deductionAmount[$deductionClassName] = $amount;
		        $this->paysheetFlag[$deductionClassName] = true;
			}
		}
	}
    
	protected function preparePaysheet() {
		// Allowance for paysheet
		foreach ($this->companyAllowance as $allowance) {
		    $name = $allowance->getAllowanceTypeId()
							  ->getAllowanceId()
							  ->getAllowanceName();
			$this->paysheet[$name] = $this->allowanceAmount[$name]; 
		} 
		// Deduction for paysheet
		foreach($this->companyDeduction as $deduction) {
			$deductionName = $deduction->getDeductionId()
			                           ->getDeductionClassName(); 
			$this->paysheet[$deductionName] = $this->deductionAmount[$deductionName];
		}  
	}
	
	public function removePaysheet(CompanyEntity $company,DateRange $dateRange) {
		// removes given paysheet
		//@todo implement remove method
		//return true;
		if($this->isPaysheetClosed($company, $dateRange)) {
		    //$this->paysheetMapper->remove($dateRange);
			//throw new \Exception('unable to remove paysheet');
		} else {
			throw new \Exception('unable to remove paysheet');
		}
	}
	
	protected function verifyPaysheetCalculate(CompanyEntity $company,DateRange $dateRange) {
		// is already closed?
		// if closed then removes or throws exception
		if($this->isPaysheetClosed($company, $dateRange)) {
		    return 1;
		}
	}
	
	public function close() {
		
	}
    
}