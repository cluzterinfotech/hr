<?php

/**
 * Description of ContractInfo
 *
 * @author Wol
 */
class ContractInfo {
	private $id;
	private $employeeId;
	private $contractFrom;
	private $contractTo;
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
	public function setContractFrom($suspendFrom) {
		$this->suspendFrom = $suspendFrom;
	}
	public function getContractFrom() {
		return $this->suspendFrom;
	}
	public function setContractTo($suspendTo) {
		$this->suspendTo = $suspendTo;
	}
	public function getContractTo() {
		return $this->suspendTo;
	}
}
