<?php

namespace Payment\Service;

use Zend\Db\Adapter\Adapter, 
    Application\Contract\EntityCollectionInterface, 
    Payment\Service\Payment,
    Application\Entity\CompanyEntity,
    Application\Utility\DateRange;

class PaysheetService extends Payment {
    	
	public function __construct(Adapter $adapter, 
			EntityCollectionInterface $collection
			,$sm
			) {
		parent::__construct($adapter, $collection, $sm);
	}
	
	public function calculate(CompanyEntity $company,DateRange $dateRange) {
		$this->company = $company;
		$this->dateRange = $dateRange;
		$this->fetchCompanyAllowance($company, $dateRange); 
		$this->fetchCompanyDeduction($company, $dateRange); 
		// Always remove paysheet before  
		$this->removePaysheet($company,$dateRange);
		$this->calculateAllowance(); 
		$this->prepareDeduction();  
		$this->calculateCompulsoryDeduction();
		$this->calculateNonCompulsoryDeduction();
		$this->preparePaysheet();
		$this->paysheet['paysheetDate'] = $this->dateRange->getFromDate();
		$this->paysheetMapper->insert($this->paysheet);
		return $this->paysheet; 
	} 
	
	// is paysheet already closed? 
	public function isPaysheetClosed($company,$dateRange) {
		return 1;
	}
    
	/*  
	 *  This deduction includes 
	 *  which have exemption or it is compulsory or included in tax
	 *  so this have to be treated separately 
	 */    
	
	protected function calculateNonCompulsoryDeduction() { 
		foreach($this->companyNonCompulsoryDeduction as $k => $deductionClassName) {
			$amount = 0;
			$amount = $this->deductionAmountService
		                   ->fetchAmountByDeduction($deductionClassName,$this->company,$this->dateRange);
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