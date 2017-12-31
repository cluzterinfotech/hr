<?php 

namespace Payment\Model;

// use Application\Persistence\TransactionDatabase;

class DateRange {
    
	private $fromDate; 
	private $toDate; 
	//private $transaction; 
    
	public function __construct() {
        // $this->setFromDate($fromDate);
        // $this->setToDate($toDate);
	} 
    
	public function getFromDate() {
		return $this->fromDate;
	}
     
	public function setFromDate($fromDate) {
		$this->fromDate = $fromDate;
		return $this;
	}
    
	public function getToDate() {
		return $this->toDate;
	}
    
	public function setToDate($toDate) { 
		if(!isset($this->fromDate)) {
			throw new \Exception('Sorry! from date not available');
		}
		if($this->fromDate && ($toDate < $this->fromDate)) {
			throw new \Exception('Sorry! to date is less than from date');
		}
		$this->toDate = $toDate; 
		return $this; 
	} 
    
}