<?php

namespace Employee\Model;

class EmployeeInfo {
	private $employeeId;
	private $empPersonalInfoId;
	private $lkpSalaryGradeId;
	private $lkpJobGradeId;
	private $positionId;
	private $joinDate;
	private $confirmationDate;
	private $isConfirmed;
	private $locationId;
	private $companyId;
	private $isActive;
	private $initialSalary;
	private $history;
	public function setEmployeeId($employeeId) {
		$this->employeeId = $employeeId;
	}
	public function getEmployeeId() {
		return $this->employeeId;
	}
	public function setEmpPersonalInfoId($empPersonalInfoId) {
		$this->empPersonalInfoId = $empPersonalInfoId;
	}
	public function getEmpPersonalInfoId() {
		return $this->empPersonalInfoId;
	}
	public function setLkpSalaryGradeId($lkpSalaryGradeId) {
		$this->lkpSalaryGradeId = $lkpSalaryGradeId;
	}
	public function getLkpSalaryGradeId() {
		return $this->lkpSalaryGradeId;
	}
	public function setLkpJobGradeId($lkpJobGradeId) {
		$this->lkpJobGradeId = $lkpJobGradeId;
	}
	public function getLkpJobGradeId() {
		return $this->lkpJobGradeId;
	}
	public function setPositionId($positionId) {
		$this->positionId = $positionId;
	}
	public function getPositionId() {
		return $this->positionId;
	}
	public function setJoinDate($joinDate) {
		$this->joinDate = $joinDate;
	}
	public function getJoinDate() {
		return $this->joinDate;
	}
	public function setConfirmationDate($confirmationDate) {
		$this->confirmationDate = $confirmationDate;
	}
	public function getConfirmationDate() {
		return $this->confirmationDate;
	}
	public function setIsConfirmed($isConfirmed) {
		$this->isConfirmed = $isConfirmed;
	}
	public function getIsConfirmed() {
		return $this->isConfirmed;
	}
	public function setLocationId($locationId) {
		$this->locationId = $locationId;
	}
	public function getLocationId() {
		return $this->locationId;
	}
	public function setCompanyId($companyId) {
		$this->companyId = $companyId;
	}
	public function getCompanyId() {
		return $this->companyId;
	}
	public function setIsActive($isActive) {
		$this->isActive = $isActive;
	}
	public function getIsActive() {
		return $this->isActive;
	}
	public function setInitialSalary($initialSalary) {
		$this->initialSalary = $initialSalary;
	}
	public function getInitialSalary() {
		return $this->initialSalary;
	}
	public function setHistory($history) {
		$this->history = $history;
	}
	public function getHistory() {
		return $this->history;
	}
}
