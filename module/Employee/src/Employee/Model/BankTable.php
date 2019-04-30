<?php

namespace Employee\Model;

use Employee\Model\Bank;

/**
 * Description of BankTable
 *
 * @author Wol
 */
class BankTable {
	private $tableGateway;
	public function __construct($tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	public function saveBank(Bank $bank) {
		$data = array (
				'lkpBankId' => $bank->getLkpBankId (),
				'bankName' => $bank->getBankName (),
				'branch' => $bank->getBranch (),
				'accountNumber' => $bank->getAccountNumber () 
		);
		
		if (empty ( $data ['lkpBankId'] )) {
			$data ['lkpBankId'] = 0;
			$this->tableGateway->insert ( $data );
		} else {
			$id = $data ['lkpBankId'];
			$this->tableGateway->update ( $data, array (
					'lkpBankId' => $id 
			) );
		}
		
		return true;
	}
	public function fetchBank($id) {
		$bank = $this->tableGateway->select ( array (
				'lkpBankId' => $id 
		) );
		return $bank->current ();
	}
	public function deleteBank($id) {
		$id = ( int ) $id;
		$this->tableGateway->delete ( array (
				'lkpBankId' => $id 
		) );
	}
	public function fetchAll() {
		$data = $this->tableGateway->select ();
		return $data;
	}
	public function fetchAllArray() {
		$data = $this->tableGateway->select ();
		$banks = array ();
		foreach ( $data as $bank ) {
			$banks ['options'] [] = array (
					'id' => $bank->getLkpBankId (),
					'name' => $bank->getBankName () 
			);
		}
		return $banks;
	}
	public function fetchAllArrayNorm() {
		$data = $this->tableGateway->select ();
		$banks = array ();
		foreach ( $data as $bank ) {
			$banks [$bank->getLkpBankId ()] = $bank->getBankName ();
		}
		return $banks;
	}
}
