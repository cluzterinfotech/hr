<?php

namespace Application\Entity;

use Application\Contract\EntityInterface;

class EmployeeAllowanceAmountEntity implements EntityInterface {
	
	private $id;
	private $allowanceDate;
	private $amount;
	private $employeeId;
		
	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	
	public function getAmount() {
		return $this->amount;
	}
	
	public function setAmount($amount) {
		$this->amount = $amount;
		return $this;
	}
	
	public function getEmployeeId() {
		return $this->employeeId;
	}
	
	public function setEmployeeId($employeeId) {
		$this->employeeId = $employeeId;
		return $this;
	}
	
	public function getAllowanceDate() {
		return $this->allowanceDate;
	}
	
	public function setAllowanceDate($allowanceDate) {
		$this->allowanceDate = $allowanceDate;
		return $this;
	}
}