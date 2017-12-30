<?php

namespace Application\Model;

use Payment\Model\EntityInterface;

class Bank implements EntityInterface {
	
	private $id;
	private $bankName;
	private $branch;
	private $accountNumber;
	
	public function setId($id) {
		$this->id = $id;
	}
	public function getId() {
		return $this->id;
	}
	public function setBankName($bankName) {
		$this->bankName = $bankName;
	}
	public function getBankName() {
		return $this->bankName;
	}
	public function setBranch($branch) {
		$this->branch = $branch;
	}
	public function getBranch() {
		return $this->branch;
	}
	public function setAccountNumber($accountNumber) {
		$this->accountNumber = $accountNumber;
	}
	public function getAccountNumber() {
		return $this->accountNumber;
	}
}
