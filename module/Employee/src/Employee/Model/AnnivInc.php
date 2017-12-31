<?php

namespace Employee\Model;

use Payment\Model\EntityInterface;

class AnnivInc implements EntityInterface {
	
	private $id;
	private $addedDate;
	private $oldAmount;
	private $employeeId;
	private $newAmount;
	private $companyId;
	
	public function setId($id) {
		$this->id = $id; 
		return $this;
	}
	public function getId() {
		return $this->id;
	}
	public function setAddedDate($addedDate) {
		$this->addedDate = $addedDate;
		return $this;
	}
	public function getAddedDate() {
		return $this->addedDate;
	}
	public function setOldAmount($oldAmount) {
		$this->oldAmount = $oldAmount;
		return $this;
	}
	public function getOldAmount() {
		return $this->oldAmount;
	}
	public function setEmployeeId($employeeId) {
		$this->employeeId = $employeeId;
		return $this;
	}
	public function getEmployeeId() {
		return $this->employeeId;
	}
	public function setNewAmount($newAmount) {
		$this->newAmount = $newAmount;
		return $this;
	}
	public function getNewAmount() {
		return $this->newAmount;
	}
	public function setCompanyId($companyId) {
		$this->companyId = $companyId;
		return $this;
	}
	public function getCompanyId() {
		return $this->companyId;
	}
} 