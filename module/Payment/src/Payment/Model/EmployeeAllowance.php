<?php

namespace Payment\Model;

//use Application\Contract\EntityInterface;

class EmployeeAllowance extends AbstractAllowance {
    
	
	
	/*
	 * @todo
	 * To check is have this allowance
	 * Add this allowance to corresponding employee
	 * Calculate allowance value
	 * Remove one allowance from employee
	 *
	 */
	
	public function isHaveAllowance(Employee $employee,Company $company,$effectiveDate) {
	    
	}
	
	public function addAllowance() {
	    
	}
	
	public function calculateAllowanceValue() {
	    
	}
	
	public function removeEmloyeeAllowance() {
	    
	}
    public function getTableName()
    {}

    public function calculateAmount(Employee $employee, DateRange $dateRange)
    {}

    public function calculateExemption(Employee $employee, DateRange $dateRange)
    {}

	
	// public function 
	
}