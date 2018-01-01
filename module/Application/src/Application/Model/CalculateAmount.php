<?php

namespace Application\Model;

use Application\Utility\DateMethods;
use Application\Utility\CurrencyMethods;
use Application\Utility\DateRange;

class CalculateAmount  {
	
	private $dateMethods;
	private $currencyMethods;
    
	public function __construct() {
		// @todo inject these dependencies 
		$this->dateMethods = new DateMethods();
		$this->currencyMethods = new CurrencyMethods();
	}
	
	public function CalculateValue($results) {
		return $results;
	}
	
	public function calculate($allowanceList,DateRange $dateRange) {
		
		\Zend\Debug\Debug::dump($allowanceList);
	    
		$fromDate = $dateRange->getFromDate();
		$todate = $dateRange->getToDate();
		// $tot = 0;
		$dateArray = array();
		$amountArray = array();
		$totalDays = $this->dateMethods->numberOfDays($fromDate, $todate);
		// echo "Number of days ".$totalDays;
	    
		foreach($allowanceList as $allowance) {
			$date = date("Y-m-d",strtotime($allowance->getAllowanceDate()));
			//$date = strtotime($allowance->getallowanceDate());
			$id = $allowance->getId();
			if($dateArray[$date]) {
				if($dateArray[$date] < $id) {
					$dateArray[$date] = $id;
					$amountArray[$id] = $allowance->getAmount();
				}
			} else {
				$dateArray[$date] = $id;
				$amountArray[$id] = $allowance->getAmount();
			}
			echo $allowance->getAmount()."<br/>"; 
		}
		/* echo "<pre>";
			echo var_dump($amountArray);
			echo "</pre>";
			// revise this logic
			echo "<pre>";
			echo var_dump($dateArray);
			echo "</pre>"; */
		ksort($dateArray);
		/* echo "<pre>";
			echo var_dump($dateArray);
		echo "</pre>"; */
		$i = 1;
		$from = '';
		$to = '';
		$lastAmount = 0;
		$amount = 0;
		$daysCount = 0;
		$thisDays = 0;
		foreach($dateArray as $key => $value) {
			if($i == 1) {
				$from = $key;
				$amount += $amountArray[$value];
			}
			if($i == 2) {
				$to = $key;
				$thisDays =$this->dateMethods->numberOfDays($from, $to);
	
				$daysCount += $thisDays;
				$amount = ($amount/$totalDays) * $thisDays;
	
			}
			$i++;
			$lastAmount = $amountArray[$value];
			/* echo "<br/>amount ".$amount;
				echo "<br/>This Days ".$thisDays;
			echo "<br/>Total Days ".$totalDays; */
		}
		/* echo "<pre>";
			echo var_dump($lastAmount." - ".$amount);
			echo "</pre>"; */
		return $this->currencyMethods->roundTwoDigit(
				($amount + (($lastAmount/$totalDays) * ($totalDays - $daysCount))));
	}
}
