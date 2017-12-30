<?php

namespace Leave\Model;

use Payment\Model\EntityInterface;

class LeaveFormEntity implements EntityInterface {
    
	private $id;
	private $employeeId;
	private $appliedDate;
	private $joinDate;
	private $positionId;
	private $departmentId;
	private $locationId;
	private $leaveFrom;
	private $leaveTo;
	private $leaveAllowanceRequest;
	private $advanceSalaryRequest;
	private $address;
	private $daysEntitled;
	private $outstandingBalance;
	private $daysTaken;
	private $thisLeaveDays;
	private $revisedDays;
	private $publicHoilday;
	private $remainingDays;
	private $delegatedPositionId;
	private $approvedLevel;
	private $approvalLevel;
	private $isCanceled;
	private $canceledBy;
	private $canceledDate;
	private $isApproved;
	
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
	public function getAppliedDate() {
		return $this->appliedDate;
	}
	public function setAppliedDate($appliedDate) {
		$this->appliedDate = $appliedDate;
		return $this;
	}
	public function getJoinDate() {
		return $this->joinDate;
	}
	public function setJoinDate($joinDate) {
		$this->joinDate = $joinDate;
		return $this;
	}
	public function getPositionId() {
		return $this->positionId;
	}
	public function setPositionId($positionId) {
		$this->positionId = $positionId;
		return $this;
	}
	public function getDepartmentId() {
		return $this->departmentId;
	}
	public function setDepartmentId($departmentId) {
		$this->departmentId = $departmentId;
		return $this;
	}
	public function getLocationId() {
		return $this->locationId;
	}
	public function setLocationId($locationId) {
		$this->locationId = $locationId;
		return $this;
	}
	public function getLeaveFrom() {
		return $this->leaveFrom;
	}
	public function setLeaveFrom($leaveFrom) {
		$this->leaveFrom = $leaveFrom;
		return $this;
	}
	public function getLeaveTo() {
		return $this->leaveTo;
	}
	public function setLeaveTo($leaveTo) {
		$this->leaveTo = $leaveTo;
		return $this;
	}
	public function getLeaveAllowanceRequest() {
		return $this->leaveAllowanceRequest;
	}
	public function setLeaveAllowanceRequest($leaveAllowanceRequest) {
		$this->leaveAllowanceRequest = $leaveAllowanceRequest;
		return $this;
	}
	public function getAdvanceSalaryRequest() {
		return $this->advanceSalaryRequest;
	}
	public function setAdvanceSalaryRequest($advanceSalaryRequest) {
		$this->advanceSalaryRequest = $advanceSalaryRequest;
		return $this;
	}
	public function getAddress() {
		return $this->address;
	}
	public function setAddress($address) {
		$this->address = $address;
		return $this;
	}
	public function getDaysEntitled() {
		return $this->daysEntitled;
	}
	public function setDaysEntitled($daysEntitled) {
		$this->daysEntitled = $daysEntitled;
		return $this;
	}
	public function getOutstandingBalance() {
		return $this->outstandingBalance;
	}
	public function setOutstandingBalance($outstandingBalance) {
		$this->outstandingBalance = $outstandingBalance;
		return $this;
	}
	public function getDaysTaken() {
		return $this->daysTaken;
	}
	public function setDaysTaken($daysTaken) {
		$this->daysTaken = $daysTaken;
		return $this;
	}
	public function getThisLeaveDays() {
		return $this->thisLeaveDays;
	}
	public function setThisLeaveDays($thisLeaveDays) {
		$this->thisLeaveDays = $thisLeaveDays;
		return $this;
	}
	public function getRevisedDays() {
		return $this->revisedDays;
	}
	public function setRevisedDays($revisedDays) {
		$this->revisedDays = $revisedDays;
		return $this;
	}
	public function getPublicHoilday() {
		return $this->publicHoilday;
	}
	public function setPublicHoilday($publicHoilday) {
		$this->publicHoilday = $publicHoilday;
		return $this;
	}
	public function getRemainingDays() {
		return $this->remainingDays;
	}
	public function setRemainingDays($remainingDays) {
		$this->remainingDays = $remainingDays;
		return $this;
	}
	public function getDelegatedPositionId() {
		return $this->delegatedPositionId;
	}
	public function setDelegatedPositionId($delegatedPositionId) {
		$this->delegatedPositionId = $delegatedPositionId;
		return $this;
	}
	public function getApprovedLevel() {
		return $this->approvedLevel;
	}
	public function setApprovedLevel($approvedLevel) {
		$this->approvedLevel = $approvedLevel;
		return $this;
	}
	public function getApprovalLevel() {
		return $this->approvalLevel;
	}
	public function setApprovalLevel($approvalLevel) {
		$this->approvalLevel = $approvalLevel;
		return $this;
	}
	public function getIsCanceled() {
		return $this->isCanceled;
	}
	public function setIsCanceled($isCanceled) {
		$this->isCanceled = $isCanceled;
		return $this;
	}
	public function getCanceledBy() {
		return $this->canceledBy;
	}
	public function setCanceledBy($canceledBy) {
		$this->canceledBy = $canceledBy;
		return $this;
	}
	public function getCanceledDate() {
		return $this->canceledDate;
	}
	public function setCanceledDate($canceledDate) {
		$this->canceledDate = $canceledDate;
		return $this;
	}
	public function getIsApproved() {
		return $this->isApproved;
	}
	public function setIsApproved($isApproved) {
		$this->isApproved = $isApproved;
		return $this;
	}
	
	
	
} 