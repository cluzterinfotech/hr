<?php

namespace Leave\Model;

class LeaveEntitlementAdmin {
	private $id;
	private $yearsOfService;
	private $numberOfDays;
	private $companyId;
	private $addedUser;
	private $addedDate;
	private $updatedUser;
	private $updatedDate;
	private $recordStatus;
	public function setId($id) {
		$this->id = ( int ) $id;
	}
	public function getId() {
		return $this->id;
	}
	public function setYearsOfService($yearsOfService) {
		$this->yearsOfService = $yearsOfService;
	}
	public function getYearsOfService() {
		return $this->yearsOfService;
	}
	public function setNumberOfDays($numberOfDays) {
		$this->numberOfDays = $numberOfDays;
	}
	public function getNumberOfDays() {
		return $this->numberOfDays;
	}
	public function setCompanyId($companyId) {
		$this->companyId = $companyId;
	}
	public function getCompanyId() {
		return $this->companyId;
	}
	public function setAddedUser($addedUser) {
		$this->addedUser = $addedUser;
	}
	public function getAddedUser() {
		return $this->addedUser;
	}
	public function setAddedDate($addedDate) {
		$this->addedDate = $addedDate;
	}
	public function getAddedDate() {
		return $this->addedDate;
	}
	public function setUpdatedUser($updatedUser) {
		$this->updatedUser = $updatedUser;
	}
	public function getUpdatedUser() {
		return $this->updatedUser;
	}
	public function setUpdatedDate($updatedDate) {
		$this->updatedDate = $updatedDate;
	}
	public function getUpdatedDate() {
		return $this->updatedDate;
	}
	public function setRecordStatus($recordStatus) {
		$this->recordStatus = $recordStatus;
	}
	public function getRecordStatus() {
		return $this->recordStatus;
	}
}
