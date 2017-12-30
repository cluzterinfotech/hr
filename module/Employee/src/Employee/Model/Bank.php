<?php

namespace Employee\Model;

/**
 * Description of Bank
 *
 * @author Wol
 */
class Bank {
	private $lkpBankId;
	private $bankName;
	private $branch;
	private $accountNumber;
	public function setLkpBankId($lkpBankId) {
		$this->lkpBankId = $lkpBankId;
	}
	public function getLkpBankId() {
		return $this->lkpBankId;
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
