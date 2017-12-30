<?php

namespace Employee\Model;

use Payment\Model\EntityInterface;

class CarAmortization implements EntityInterface {
	
	private $id;
	private $employeeNumber;
	private $paidDate;
	private $paidAmount;
	private $numberOfMonths;
	
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
	public function getPaidDate() {
		return $this->paidDate;
	}
	public function setPaidDate($paidDate) {
		$this->paidDate = $paidDate;
		return $this;
	}
	public function getPaidAmount() {
		return $this->paidAmount;
	}
	public function setPaidAmount($paidAmount) {
		$this->paidAmount = $paidAmount;
		return $this;
	}
	public function getNumberOfMonths() {
		return $this->numberOfMonths;
	}
	public function setNumberOfMonths($numberOfMonths) {
		$this->numberOfMonths = $numberOfMonths;
		return $this;
	} 
}