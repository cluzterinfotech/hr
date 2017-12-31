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

abstract class Payment {
	
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
		$this->companyDeductionService = $sm->get('CompanyDeductionnew');
		// CompanyDeductionService($adapter, $collection);
	    $this->allowanceDeductionService = new AllowanceDeductionService($adapter, $collection);
		$this->deductionAmountService = $sm->get('EmployeeDeductionAmountService');
		$this->services = $sm;
        $this->paysheetMapper = new PaysheetMapper($adapter, $collection);
	}
	
	protected function fetchCompanyAllowance(CompanyEntity $company,DateRange $dateRange) {
		$this->companyAllowance = $this->companyAllowanceService
		     ->fetchAllowanceNameList($this->company,$this->dateRange);
	}
	
	protected function fetchCompanyDeduction(CompanyEntity $company,DateRange $dateRange) {
		$this->companyDeduction = $this->companyDeductionService
		     ->fetchCompanyDeductionNameList($this->company,$this->dateRange);
	}
     
	public function calculateAllowance() {
	
		foreach($this->companyAllowance as $allowance) {
			
			$name = $allowance->getAllowanceTypeId()
			                 ->getAllowanceId() 
			                 ->getAllowanceName();
			
			$allowance = $this->services->get($name);
			$amount = $allowance->getAmount($company,$dateRange);
			$exemption = $allowance->getExemption($company,$dateRange);
			
			/* $amount = $this->allowanceAmountService
			               ->fetchAmountByAllowance($name,$this->dateRange);
			$exemption = $this->allowanceAmountService
			                  ->fetchExemptionByAllowance($name,$this->dateRange); */
			
			$this->allowanceAmount[$name] = $amount;
			$this->allowanceAmount[$name.'Exemption'] = $exemption;
			$this->paysheetAmount += $amount;
			//\Zend\Debug\Debug::dump($amount);
			$this->paysheetAmountWithExemption += $amount - $exemption;
		}
	}
	
	protected function prepareDeduction() {
		// \Zend\Debug\Debug::dump($this->companyDeduction);
		foreach($this->companyDeduction as $deduction) {
			$category = $deduction->getDeductionId()->getDeductionCategoryId();
			$deductionClassName = $deduction->getDeductionId()->getDeductionClassName();
			if($category == 1) {
				$this->companyCompulsoryDeduction[] = $deductionClassName;
			} else {
				$this->companyNonCompulsoryDeduction[] = $deductionClassName;
			}
		} 
	}
	
	protected function calculateCompulsoryDeduction() { 
		if(in_array('SocialInsuranceEmployee', $this->companyCompulsoryDeduction)) {
			$socialInsurance = $this->allowanceDeductionService
			                        ->compulsoryDeduction($deduction);
			$amount = $socialInsurance->getAmount();
			$exemption = $socialInsurance->getExemption();
		} 
		if(in_array('IncomeTax', $this->companyCompulsoryDeduction)) {
			$amount = $this->deductionAmountService
			               ->fetchAmountByDeduction('IncomeTax',$this->company,$this->dateRange);
			if($this->paysheetAmount > $amount) { 
				$this->deductionAmount['IncomeTax'] = $amount; 
			}
		} 
	}
        
}
