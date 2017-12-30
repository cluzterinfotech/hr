<?php

namespace Employee\Model;

use Payment\Model\Payment;
use Payment\Model\ReferenceParameter;
use Payment\Model\DateRange;


class SalaryGradeValueService extends Payment {
	
	//protected $initialService; 
	
    public function __construct(ReferenceParameter $reference) {
    	parent::__construct($reference); 
    	//$this->initialService = $this->service->get('initial'); 
    } 
    
	public function salaryGradeMinValue($salaryGrade,DateRange $dateRange) {
		
	} 
	
	// max of quartile one
	
	
	
	public function salaryGradeMidValue($salaryGrade,DateRange $dateRange) {
	    //@todo
		return '12345';
	}
	
	public function salaryGradeMaxValue($salaryGrade,DateRange $dateRange) {
	    
	}
	
	public function tenPercentageNextMid($salaryGrade,DateRange $dateRange) {
		$nextSalaryGrade = $salaryGrade + 1; 
		$midValue = $this->salaryGradeMidValue($nextSalaryGrade, $dateRange);
		return $midValue * 0.1;
	}
    
}