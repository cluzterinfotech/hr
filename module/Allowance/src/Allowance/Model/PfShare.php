<?php

namespace Allowance\Model;

use Payment\Model\EntityInterface;

class PfShare implements EntityInterface {
	
	private $id;
	private $employeeId;
	private $employeeShare;
	private $companyShare;
	private $effectiveDate;
	
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
	public function setEmployeeShare($employeeShare) {
		$this->employeeShare = $employeeShare;
	}
	public function getEmployeeShare() {
		return $this->employeeShare;
	}
	public function setCompanyShare($companyShare) {
		$this->companyShare = $companyShare;
	}
	public function getCompanyShare() {
		return $this->companyShare;
	}
	public function setEffectiveDate($effectiveDate) {
		$this->effectiveDate = $effectiveDate;
	}
	public function getEffectiveDate() {
		return $this->effectiveDate;
	}
}   