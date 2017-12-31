<?php

namespace Employee\Model;

use Payment\Model\EntityInterface;

class EmployeeLocation implements EntityInterface {
	
	private $id;
	private $employeeNumber;
	private $empLocation; 
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
	
	public function getEmpLocation() {
		return $this->empLocation;
	}
	
	public function setEmpLocation($empLocation) {
		$this->empLocation = $empLocation;
		return $this;
	}
	
	
} 