<?php

namespace Application\Entity;

use Application\Contract\EntityInterface;

class SalaryGradeAllowanceEntity implements EntityInterface {
	
	private $id;
	private $allowanceId;
	private $companyId;
	private $lkpSalaryGradeId;
	private $amount;
	private $isApplicableToAll;
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	public function getAllowanceId() {
		return $this->allowanceId;
	}
	public function setAllowanceId($allowanceId) {
		$this->allowanceId = $allowanceId;
		return $this;
	}
	public function getCompanyId() {
		return $this->companyId;
	}
	public function setCompanyId($companyId) {
		$this->companyId = $companyId;
		return $this;
	}
	public function getLkpSalaryGradeId() {
		return $this->lkpSalaryGradeId;
	}
	public function setLkpSalaryGradeId($lkpSalaryGradeId) {
		$this->lkpSalaryGradeId = $lkpSalaryGradeId;
		return $this;
	}
	public function getAmount() {
		return $this->amount;
	}
	public function setAmount($amount) {
		$this->amount = $amount;
		return $this;
	}
	public function getIsApplicableToAll() {
		return $this->isApplicableToAll;
	}
	public function setIsApplicableToAll($isApplicableToAll) {
		$this->isApplicableToAll = $isApplicableToAll;
		return $this;
	}
	
} 