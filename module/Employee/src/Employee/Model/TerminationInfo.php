<?php

namespace Employee\Model;

/**
 * Description of TerminationInfo
 *
 * @author Wol
 */
class TerminationInfo {
	private $id;
	private $employeeId;
	private $lkpTerminationTypeId;
	private $notes;
	private $terminationDate;
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
	public function setLkpTerminationTypeId($lkpTerminationTypeId) {
		$this->lkpTerminationTypeId = $lkpTerminationTypeId;
	}
	public function getLkpTerminationTypeId() {
		$this->lkpTerminationTypeId = $lkpTerminationTypeId;
	}
	public function setNotes($notes) {
		$this->notes = $notes;
	}
	public function getNotes() {
		return $this->notes;
	}
	public function setTerminationDate($terminationDate) {
		$this->terminationDate = $terminationDate;
	}
	public function getTerminationDate() {
		return $this->terminationDate;
	}
}
