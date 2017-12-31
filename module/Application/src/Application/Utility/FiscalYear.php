<?php
namespace Application\Utility;

class FiscalYear {
	
	public function __construct() {
	}
	
	public function getFiscalYear(/*Company*/) {
		// return $fiscal;
		$fiscalYear = array ('startingDate' => '2014-11-01','endDate' => '2014-11-01');
		return $fiscalYear;
	}
	
	/* public function getMonthDays() {
		
	} */
	
	public function getMonthStartingDate(/*Company*/) {
		return '2014-11-01';
	}
	
	public function getMonthEndingDate(/*Company*/) {
		return '2014-11-30';
	}
	
	// public function 
	
}