<?php
namespace Application\Utility;

class DateRange {
	
    private $fromDate;
	private $toDate;
	
	public function __construct($fromDate = null,$toDate = null) {
		$this->setFromDate($fromDate);
		$this->setToDate($toDate);
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
			throw new \Exception('Sorry! from date is less than to date'); 
		}
		$this->toDate = $toDate;
		return $this;
	}
	
}