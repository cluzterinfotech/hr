<?php

namespace Leave\Model;

use Payment\Model\EntityInterface;

class AnnualLeaveEntitlement implements EntityInterface {
    
	private $id;
	private $yearsOfService;
	private $numberOfDays;
	private $companyId;
	private $LkpLeaveType;
	
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	public function getYearsOfService() {
		return $this->yearsOfService;
	}
	public function setYearsOfService($yearsOfService) {
		$this->yearsOfService = $yearsOfService;
		return $this;
	}
	public function getNumberOfDays() {
		return $this->numberOfDays;
	}
	public function setNumberOfDays($numberOfDays) {
		$this->numberOfDays = $numberOfDays;
		return $this;
	}
	public function getCompanyId() {
		return $this->companyId;
	}
	public function setCompanyId($companyId) {
		$this->companyId = $companyId;
		return $this;
	}
	public function getLkpLeaveType() {
		return $this->LkpLeaveType;
	}
	public function setLkpLeaveType($LkpLeaveType) {
		$this->LkpLeaveType = $LkpLeaveType;
		return $this;
	}
	
	
	
	
} 