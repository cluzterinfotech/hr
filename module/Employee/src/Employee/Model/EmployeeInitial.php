<?php

namespace Employee\Model;

use Payment\Model\EntityInterface;

class EmployeeInitial implements EntityInterface {
	
	private $id;
	private $employeeNumber;
	private $initial;
	private $effectiveDate;
	
	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	
	public function getEmployeeNumber() {
		return $this->employeeNumber;
	}
	
	public function setEmployeeNumber($employeeNumber) {
		$this->employeeNumber = $employeeNumber;
		return $this;
	}
	
	public function getEffectiveDate() {
		return $this->effectiveDate;
	}
	
	public function setEffectiveDate($effectiveDate) {
		$this->effectiveDate = $effectiveDate;
		return $this;
	}
	
	public function getInitial() {
		return $this->initial;
	}
	
	public function setInitial($initial) {
		$this->initial = $initial;
		return $this;
	} 
} 