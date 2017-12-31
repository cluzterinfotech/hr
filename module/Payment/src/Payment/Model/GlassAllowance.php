<?php

namespace Payment\Model;

use Payment\Model\EntityInterface;

class GlassAllowance implements EntityInterface {
	
	private $id;
	private $familyMemberId;
	private $amount;
	private $paidDate;
	private $fromDate;
	
	public function setId($id) {
		$this->id = $id;
	}
	public function getId() {
		return $this->id;
	}
	public function setFamilyMemberId($familyMemberId) {
		$this->familyMemberId = $familyMemberId;
	}
	public function getFamilyMemberId() {
		return $this->familyMemberId;
	}
	public function setAmount($amount) {
		$this->amount = $amount;
	}
	public function getAmount() {
		return $this->amount;
	}
	public function setPaidDate($paidDate) {
		$this->paidDate = $paidDate;
	}
	public function getPaidDate() {
		return $this->paidDate;
	}
	public function setFromDate($fromDate) {
		$this->fromDate = $fromDate;
	}
	public function getFromDate() {
		return $this->fromDate;
	}
}
