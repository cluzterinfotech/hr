<?php

namespace Employee\Model;

use Payment\Model\EntityInterface;

class EmployeeAllowance implements EntityInterface {
	
	private $id;
	private $employeeId;
	private $amount;
	private $effectiveDate;
	private $allowanceNameText;
	
	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	
	public function getEmployeeId() {
		return $this->employeeId;
	}
	
	public function setEmployeeId($employeeId) {
		$this->employeeId = $employeeId;
		return $this;
	} 
	
	/*public function getEmployeeNumber() {
		return $this->employeeNumber;
	}
	
	public function setEmployeeNumber($employeeNumber) {
		$this->employeeNumber = $employeeNumber;
		return $this;
	}*/
    
	public function getEffectiveDate() {
		return $this->effectiveDate;
	}
	
	public function setEffectiveDate($effectiveDate) {
		$this->effectiveDate = $effectiveDate;
		return $this;
	}
	
	public function getAmount() {
		return $this->amount;
	}
	
	public function setAmount($amount) {
		$this->amount = $amount;
		return $this;
	}
	
	public function getAllowanceNameText() {
		return $this->allowanceNameText;
	}
	
	public function setAllowanceNameText($allowanceNameText) {
		$this->allowanceNameText = $allowanceNameText;
		return $this;
	}
 
} 