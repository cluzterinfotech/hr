<?php

namespace Payment\Model;

use Zend\Db\Adapter\Adapter;
use Application\Contract\EntityCollectionInterface;
use Payment\Model\AllowanceSalaryGradeInterface;
use Payment\Model\AllowanceEntryInterface;
use Payment\Model\AllowancePercentageInterface;
use Payment\Model\CompanyAllowanceInterface;
use Application\Persistence\TransactionDatabase;

class ReferenceParameter {
	
	protected $allowanceEntry;
	protected $deductionEntry;
	protected $allowanceSalaryGrade;
	protected $allowancePercentage;
	protected $companyAllowance;
	protected $service;
	protected $adapter;
	protected $collection;
	protected $companyDeduction;
	protected $transactionDatabase; 
	
	
	public function __construct(AllowanceEntryInterface $entry
			,AllowanceSalaryGradeInterface $salaryGrade
			,AllowancePercentageInterface $percentage
			,CompanyAllowanceInterface $companyAllowance
			,$sm
			,Adapter $adapter
			,EntityCollectionInterface $collection
			,CompanyDeduction $companyDeduction 
			,TransactionDatabase $transactionDatabase
			,DeductionEntryInterface $deductionEntry) {
		$this->allowanceEntry = $entry;
		$this->allowanceSalaryGrade = $salaryGrade;
		$this->allowancePercentage = $percentage;
		$this->companyAllowance = $companyAllowance;
		$this->service = $sm;
		$this->adapter = $adapter;
		$this->collection = $collection;
		$this->companyDeduction = $companyDeduction;
		$this->deductionEntry = $deductionEntry;
		
	}
    
	public function getAllowanceEntry() {
		return $this->allowanceEntry;
	}
    
	public function setAllowanceEntry($allowanceEntry) {
		$this->allowanceEntry = $allowanceEntry;
		return $this;
	}
    
	public function getAllowanceSalaryGrade() {
		return $this->allowanceSalaryGrade;
	}
    
	public function setAllowanceSalaryGrade($allowanceSalaryGrade) {
		$this->allowanceSalaryGrade = $allowanceSalaryGrade;
		return $this;
	}
    
	public function getAllowancePercentage() {
		return $this->allowancePercentage;
	}
    
	public function setAllowancePercentage($allowancePercentage) {
		$this->allowancePercentage = $allowancePercentage;
		return $this;
	}
	public function getCompanyAllowance() {
		return $this->companyAllowance;
	}
	public function setCompanyAllowance($companyAllowance) {
		$this->companyAllowance = $companyAllowance;
		return $this;
	}
	public function getService() {
		return $this->service;
	}
	public function setService($service) {
		$this->service = $service;
		return $this;
	}
	public function getAdapter() {
		return $this->adapter; 
	}
	public function setAdapter($adapter) {
		$this->adapter = $adapter;
		return $this;
	}
	public function getCollection() {
		return $this->collection;
	}
	public function setCollection($collection) {
		$this->collection = $collection;
		return $this;
	}
	public function getCompanyDeduction() {
		return $this->companyDeduction;
	}
	public function setCompanyDeduction($companyDeduction) {
		$this->companyDeduction = $companyDeduction;
		return $this;
	}
	public function getDeductionEntry() {
		return $this->deductionEntry;
	}
	public function setDeductionEntry($deductionEntry) {
		$this->deductionEntry = $deductionEntry;
		return $this;
	}
	
}