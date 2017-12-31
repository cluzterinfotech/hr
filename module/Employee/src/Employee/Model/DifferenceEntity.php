<?php

namespace Employee\Model;

use Payment\Model\EntityInterface;

class DifferenceEntity implements EntityInterface {
	
	private $id;
	private $differenceFromDate; 
	private $differenceToDate;
	private $employeeNumberDifference;
	private $diffShortDescription;
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	public function getDifferenceFromDate() {
		return $this->differenceFromDate;
	}
	public function setDifferenceFromDate($differenceFromDate) {
		$this->differenceFromDate = $differenceFromDate;
		return $this;
	}
	public function getDifferenceToDate() {
		return $this->differenceToDate;
	}
	public function setDifferenceToDate($differenceToDate) {
		$this->differenceToDate = $differenceToDate;
		return $this;
	}
	public function getEmployeeNumberDifference() {
		return $this->employeeNumberDifference;
	}
	public function setEmployeeNumberDifference($employeeNumberDifference) {
		$this->employeeNumberDifference = $employeeNumberDifference;
		return $this;
	}
	public function getDiffShortDescription() {
		return $this->diffShortDescription;
	}
	public function setDiffShortDescription($diffShortDescription) {
		$this->diffShortDescription = $diffShortDescription;
		return $this;
	}
	
	
	
	
} 