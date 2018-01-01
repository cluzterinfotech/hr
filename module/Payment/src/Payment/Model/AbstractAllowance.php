<?php 

namespace Payment\Model; 

use Payment\Model\Employee; 
use Payment\Model\Company; 


abstract class AbstractAllowance extends Payment {
    	
	public function getAmount(Employee $employee,DateRange $dateRange) {
		return $this->allowanceEntry
		            ->employeeAllowanceAmount($employee,$dateRange,$this->getTableName())
		; 
	}
	
	public function getExemption(Employee $employee,DateRange $dateRange) {
		// @todo temporarily fetching from allowance 
		// return 0;
		return $this->allowanceEntry
		            ->employeeExemptionAmount($employee,$dateRange,$this->getTableName())
		; 
	} 
	
	public function getLastAmount(Employee $employee,DateRange $dateRange) { 
		//echo "testtttttttt";
		//exit;
		return $this->allowanceEntry
		            ->getLastAmount($employee,$dateRange,$this->getTableName())
		;
		
	}
	
	public function insert($array) {
		$service = $this->service->get('EmployeeAllowanceAmountMapper');
		$service->setEntityTable($this->getTableName());
		$service->insert($array);
	}
	
	abstract function getTableName();
	
	abstract function calculateAmount(Employee $employee,DateRange $dateRange); 
	
	abstract function calculateExemption(Employee $employee,DateRange $dateRange); 
	
	//abstract function getElegibleAmount(Employee $employee,DateRange $dateRange);  
	
	// is have cola
	// is have hardship
    
}