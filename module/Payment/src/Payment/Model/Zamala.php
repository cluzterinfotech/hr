<?php

namespace Payment\Model;

use Zend\Db\Adapter\Adapter, 
    Application\Contract\EntityCollectionInterface, 
    Payment\Model\Employee,
    Payment\Model\Company,
    Payment\Model\DateRange,
    Payment\Model\AbstractDeduction;

class Zamala extends AbstractDeduction {
	
	protected $amount; 
    
    public function calculateDeductionAmount(Employee $employee,DateRange $dateRange) {   
        return 0;
	}
    
	public function calculateDeductionExemption(Employee $employee,DateRange $dateRange) { 
		return 0;
	}
	
	public function getTableName() {
		return "Zamala"; 
	}
    	
	
}