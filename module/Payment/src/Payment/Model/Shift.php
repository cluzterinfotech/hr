<?php
namespace Payment\Model; 

use Payment\Model\AbstractAllowance; 

class Shift extends AbstractAllowance { 
    
    
    public function calculateAmount(Employee $employee,DateRange $dateRange) {
		return 0;
	}
	
	public function calculateExemption(Employee $employee,DateRange $dateRange) {
		return 0;
	}
    
	public function getTableName() {
		return "Shift"; 
	}
}   