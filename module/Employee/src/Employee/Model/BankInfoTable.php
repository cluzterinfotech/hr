<?php

namespace Employee\Model;

use Employee\Model\BankInfo;

/**
 * Description of BankTable
 *
 * @author Wol
 */
class BankInfoTable {
	private $tableGateway;
	private $historyGateway;
	private $historyTableGateway;
	public function __construct($tableGateway, $historyTableGateway, $historyGateway) {
		$this->tableGateway = $tableGateway;
		$this->historyTableGateway = $historyTableGateway;
		$this->historyGateway = $historyGateway;
	}
	public function saveBankHistoryInfo(BankInfo $bankInfo) {
		$history = $bankInfo->getHistory ();
		
		try {
			$data = array (
					'id' => $bankInfo->getId (),
					'empPersonalInfoId' => $bankInfo->getEmpPersonalInfoId (),
					'lkpBankId' => $bankInfo->getLkpBankId (),
					'accountNumber' => $bankInfo->getAccountNumber (),
					'addedUser' => $history->getAddedUser (),
					'addedDate' => $history->getAddedDate (),
					'updatedUser' => $history->getUpdatedUser (),
					'updatedDate' => $history->getUpdatedDate () 
			);
			
			if (empty ( $data ['id'] )) {
				$data ['id'] = 0;
				$data ['recordStatus'] = 2;
				$this->historyTableGateway->insert ( $data );
			}
		} catch ( \Exception $e ) {
			return $e->getMessage ();
		}
		
		return true;
	}
	public function updateBankInfo(BankInfo $bankInfo) {
		$history = $bankInfo->getHistory ();
		
		try {
			$data = array (
					'id' => $bankInfo->getId (),
					'empPersonalInfoId' => $bankInfo->getEmpPersonalInfoId (),
					'lkpBankId' => $bankInfo->getLkpBankId (),
					'accountNumber' => $bankInfo->getAccountNumber (),
					'recordStatus' => '3',
					'updatedUser' => $history->getUpdatedUser (),
					'updatedDate' => $history->getUpdatedDate () 
			);
		} catch ( \Exception $e ) {
			return $e->getMessage ();
		}
		
		return true;
	}
	public function saveBankInfo(BankInfo $bankInfo) {
		try {
			$data = array (
					'id' => $bankInfo->getId (),
					'empPersonalInfoId' => $bankInfo->getEmpPersonalInfoId (),
					'lkpBankId' => $bankInfo->getLkpBankId (),
					'accountNumber' => $bankInfo->getAccountNumber () 
			);
			
			$this->tableGateway->insert ( $data );
		} catch ( \Exception $e ) {
			return $e->getMessage ();
		}
		
		return true;
	}
	public function approve($id) {
		$data = array (
				'recordStatus' => '1' 
		);
		
		$bankInfo = $this->fetchBankHistoryInfo ( $id );
		$this->SaveBankInfo ( $bankInfo );
		$this->historyTableGateway->update ( $data, array (
				'id' => $id 
		) );
	}
	public function reject($id) {
		$data = array (
				'recordStatus' => '0' 
		);
		$this->historyTableGateway->update ( $data, array (
				'id' => $id 
		) );
	}
	public function fetchBankInfo($id) {
		$bank = $this->tableGateway->select ( array (
				'id' => $id 
		) );
		return $bank->current ();
	}
	public function fetchBankHistoryInfo($id) {
		$bank = $this->historyTableGateway->select ( array (
				'id' => $id 
		) );
		return $bank->current ();
	}
	public function fetchAll() {
		$data = $this->tableGateway->select ();
		return $data;
	}
	public function fetchAllPending() {
		$data = $this->historyTableGateway->select ( array (
				'recordStatus' => 2 
		) );
		return $data;
	}
}
