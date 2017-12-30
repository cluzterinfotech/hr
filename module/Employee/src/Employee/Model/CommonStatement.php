<?php

namespace Employee\Model;

use Payment\Model\EntityInterface;

class CommonStatement implements EntityInterface {
	
	private $id;
	private $employeeId;
	private $bankId;
	private $stmtDate;
	private $Amount;
	private $Notes;
	private $headerSerial;
	
	public function setId($id) {
		$this->id = $id;
	}
	public function getId() {
		return $this->id;
	}
	public function setEmployeeId($employeeId) {
		$this->employeeId = $employeeId;
	}
	public function getEmployeeId() {
		return $this->employeeId;
	}
	public function setBankId($bankId) {
		$this->bankId = $bankId;
	}
	public function getBankId() {
		return $this->bankId;
	}
	public function setStmtDate($stmtDate) {
		$this->stmtDate = $stmtDate;
	}
	public function getStmtDate() {
		return $this->stmtDate;
	}
	public function setAmount($Amount) {
		$this->Amount = $Amount;
	}
	public function getAmount() {
		return $this->Amount;
	}
	public function setNotes($Notes) {
		$this->Notes = $Notes;
	}
	public function getNotes() {
		return $this->Notes;
	}
	public function setHeaderSerial($headerSerial) {
		$this->headerSerial = $headerSerial;
	}
	public function getHeaderSerial() {
		return $this->headerSerial;
	}
}
