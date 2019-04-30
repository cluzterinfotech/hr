<?php 

namespace Payment\Model;

use Payment\Model\ReferenceParameter;

class TaxService { 
    
	// @todo get percentage based on allowance
	public function getTaxPercentage($allowanceName,DateRange $dateRange) {
		return .15;
	}
	
	public function getIncomeTaxPercentage(/*DateRange*/) {
		return .15;
	}
	
}