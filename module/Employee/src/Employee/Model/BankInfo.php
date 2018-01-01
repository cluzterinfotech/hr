<?php

namespace Employee\Model;

/**
 * Description of BankInfo
 *
 * @author Wol
 */
class BankInfo {
	private $id;
	private $empPersonalInfoId;
	private $lkpBankId;
	private $accountNumber;
	private $history;
	public function setId($id) {
		$this->id = $id;
	}
	public function getId() {
		return $this->id;
	}
	public function setEmpPersonalInfoId($empPersonalInfoId) {
		$this->empPersonalInfoId = $empPersonalInfoId;
	}
	public function getEmpPersonalInfoId() {
		return $this->empPersonalInfoId;
	}
	public function setLkpBankId($lkpBankId) {
		$this->lkpBankId = $lkpBankId;
	}
	public function getLkpBankId() {
		return $this->lkpBankId;
	}
	public function setAccountNumber($accountNumber) {
		$this->accountNumber = $accountNumber;
	}
	public function getAccountNumber() {
		return $this->accountNumber;
	}
	public function setHistory($history) {
		$this->history = $history;
	}
	public function getHistory() {
		return $this->history;
	}
}
