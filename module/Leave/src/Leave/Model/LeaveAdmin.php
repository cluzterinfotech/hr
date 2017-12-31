<?php

namespace Leave\Model;

use Payment\Model\EntityInterface;

class LeaveAdmin implements EntityInterface {
	
	private $id;
	private $employeeId;
	private $LkpLeaveTypeId;
	private $leaveFromDate;
	private $leaveToDate;
	private $isLeaveAllowanceRequired;
	private $isAdvanceSalaryRequired;
	private $address;
	private $daysApproved;
	private $holidayLieu;
	private $publicHoliday;
	private $leaveYear;
	private $leaveAddedDate;
	
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
	public function setLkpLeaveTypeId($LkpLeaveTypeId) {
		$this->LkpLeaveTypeId = $LkpLeaveTypeId;
	}
	public function getLkpLeaveTypeId() {
		return $this->LkpLeaveTypeId;
	}
	public function setLeaveFromDate($leaveFromDate) {
		$this->leaveFromDate = $leaveFromDate;
	}
	public function getLeaveFromDate() {
		return $this->leaveFromDate;
	}
	public function setLeaveToDate($leaveToDate) {
		$this->leaveToDate = $leaveToDate;
	}
	public function getLeaveToDate() {
		return $this->leaveToDate;
	}
	public function setIsLeaveAllowanceRequired($isLeaveAllowanceRequired) {
		$this->isLeaveAllowanceRequired = $isLeaveAllowanceRequired;
	}
	public function getIsLeaveAllowanceRequired() {
		return $this->isLeaveAllowanceRequired;
	}
	public function setIsAdvanceSalaryRequired($isAdvanceSalaryRequired) {
		$this->isAdvanceSalaryRequired = $isAdvanceSalaryRequired;
	}
	public function getIsAdvanceSalaryRequired() {
		return $this->isAdvanceSalaryRequired;
	}
	public function setAddress($address) {
		$this->address = $address;
	}
	public function getAddress() {
		return $this->address;
	}
	public function setDaysApproved($daysApproved) {
		$this->daysApproved = $daysApproved;
	}
	public function getDaysApproved() {
		return $this->daysApproved;
	}
	public function setHolidayLieu($holidayLieu) {
		$this->holidayLieu = $holidayLieu;
	}
	public function getHolidayLieu() {
		return $this->holidayLieu;
	}
	public function setPublicHoliday($publicHoliday) {
		$this->publicHoliday = $publicHoliday;
	}
	public function getPublicHoliday() {
		return $this->publicHoliday;
	}
	public function setLeaveYear($leaveYear) {
		$this->leaveYear = $leaveYear;
	}
	public function getLeaveYear() {
		return $this->leaveYear;
	}
	public function setLeaveAddedDate($leaveAddedDate) {
		$this->leaveAddedDate = $leaveAddedDate;
	}
	public function getLeaveAddedDate() {
		return $this->leaveAddedDate;
	}
}
