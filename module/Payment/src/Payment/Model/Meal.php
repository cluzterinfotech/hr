<?php 
namespace Payment\Model; 

use Payment\Model\AbstractAllowance; 

class Meal extends AbstractAllowance { 
    
    public function calculateAmount(Employee $employee,DateRange $dateRange) { 
        // @todo
        //return 0; 
    	$numberOfMeals = $this->companyAllowance
    	                      ->getEmployeeTotalMeal($employee,$dateRange);  
	    $amount = $this->companyAllowance
			           ->getEmployeeMealAmount($employee->getCompanyId());  
		return ($numberOfMeals * $amount); 
	} 
	 
	public function calculateExemption(Employee $employee,DateRange $dateRange) { 
		return 0;  
	}
    
	public function getTableName() {
		return "Meal"; 
	}
}   