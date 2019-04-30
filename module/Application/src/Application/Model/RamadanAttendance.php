<?php

namespace Application\Model;

use Payment\Model\EntityInterface;

class RamadanAttendance implements EntityInterface {
	
	private $id;
	private $Reason;
	private $startingDate;
	private $endingDate;
	private $noOfMinutes;
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	public function getReason() {
		return $this->Reason;
	}
	public function setReason($Reason) {
		$this->Reason = $Reason;
		return $this;
	}
	public function getStartingDate() {
		return $this->startingDate;
	}
	public function setStartingDate($startingDate) {
		$this->startingDate = $startingDate;
		return $this;
	}
	public function getEndingDate() {
		return $this->endingDate;
	}
	public function setEndingDate($endingDate) {
		$this->endingDate = $endingDate;
		return $this;
	}
	public function getNoOfMinutes() {
		return $this->noOfMinutes;
	}
	public function setNoOfMinutes($noOfMinutes) {
		$this->noOfMinutes = $noOfMinutes;
		return $this;
	} 
}