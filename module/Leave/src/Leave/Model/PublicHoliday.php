<?php

namespace Leave\Model;

use Payment\Model\EntityInterface;

class PublicHoliday implements EntityInterface {
    
	private $id;
	private $holidayReason;
	private $fromDate;
	private $toDate;
	private $Notes;
	
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	public function getHolidayReason() {
		return $this->holidayReason;
	}
	public function setHolidayReason($holidayReason) {
		$this->holidayReason = $holidayReason;
		return $this;
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
		$this->toDate = $toDate;
		return $this;
	}
	public function getNotes() {
		return $this->Notes;
	}
	public function setNotes($Notes) {
		$this->Notes = $Notes;
		return $this;
	}
	
} 