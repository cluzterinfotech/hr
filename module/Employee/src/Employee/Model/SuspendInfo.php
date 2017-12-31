<?php

class SuspendInfo {
	private $id;
	private $employeeId;
	private $suspendFrom;
	private $suspendTo;
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
	public function setSuspendFrom($suspendFrom) {
		$this->suspendFrom = $suspendFrom;
	}
	public function getSuspendFrom() {
		return $this->suspendFrom;
	}
	public function setSuspendTo($suspendTo) {
		$this->suspendTo = $suspendTo;
	}
	public function getSuspendTo() {
		return $this->suspendTo;
	}
}
