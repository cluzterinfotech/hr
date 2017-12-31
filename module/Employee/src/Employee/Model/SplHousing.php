<?php

namespace Employee\Model;

use Payment\Model\EntityInterface;

class SplHousing implements EntityInterface {
	
	private $id;
	private $employeeId;
	private $amount;
	
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
	
	public function getAmount() {
		return $this->amount;
	}
	
	public function setAmount($amount) {
		$this->amount = $amount;
		return $this;
	}
}
