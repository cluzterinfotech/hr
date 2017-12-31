<?php

namespace Payment\Service;

use Zend\Db\Adapter\Adapter, 
    Application\Contract\EntityCollectionInterface, 
    Payment\Service\Payment,
    Application\Entity\CompanyEntity,
    Application\Utility\DateRange;

class SalaryDifferenceService extends Payment {
	
	protected $differenceMapper;
	protected $differenceAmount;
	
    public function __construct(Adapter $adapter, 
			EntityCollectionInterface $collection
			,$sm
			) {
		parent::__construct($adapter,$collection,$sm);
	}
	
	public function calculate(CompanyEntity $company,DateRange $dateRange) {
		// return array();
		$this->company = $company;
		$this->dateRange = $dateRange;
		// Fetch all allownce used for that daterange
		$this->fetchCompanyAllowance($company,$dateRange);
		// Fetch all compulsory deduction for that daterange
		$this->fetchCompanyDeduction($company,$dateRange);
		$this->calculateAllowanceDifference();
		$this->calculateDeductionDifference();
		$this->prepareDifference();
		// $this->differenceMapper->insert($this->differenceAmount);
		// save difference
		$this->differenceAmount['differenceDate'] = $this->dateRange->getFromDate();
		return $this->differenceAmount; 
	}
	
	protected function calculateAllowanceDifference() { 
		$this->calculateAllowance(); 
		// Fetch allowance amount for each allowance for date range
		// Fetch difference paid for that daterange
		// Fetch salary paid for that daterange
		// Difference = allowanceamount - paid in salary - paid in difference
	}   
	
	protected function calculateDeductionDifference() { 
		$this->prepareDeduction();
		//$this->calculateCompulsoryDeduction();
		$this->calculateCompulsoryDeduction();
		// Check is this deduction available for this difference 
		// Calculate deduction amount for that daterange
		// Fetch difference paid for that date range
		// Fetch salary paid for that daterange
		// Difference =  deductionamount - paid in salary - paid in difference 
	}   
	
	protected function fetchAllowanceDifferencePaid() {
		
	}
	
    protected function prepareDifference() {
		// Allowance for paysheet 
		foreach ($this->companyAllowance as $allowance) {
		    $name = $allowance->getAllowanceTypeId()
							  ->getAllowanceId()
							  ->getAllowanceName();
			$this->differenceAmount[$name] = $this->allowanceAmount[$name]; 
		} 
		// Deduction for paysheet 
		foreach($this->companyDeduction as $deduction) {
			$deductionName = $deduction->getDeductionId()
			                           ->getDeductionClassName(); 
			$this->differenceAmount[$deductionName] = $this->deductionAmount[$deductionName];
		}  
	}
    
}