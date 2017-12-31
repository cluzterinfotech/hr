<?php

namespace Employee\Model;

use Employee\Model\EmployeeInfo;

/**
 * Description of BankTable
 *
 * @author Wol
 */
class EmployeeInfoTable {
	private $tableGateway;
	private $historyGateway;
	private $historyTableGateway;
	private $lastId;
	public function __construct($tableGateway, $historyTableGateway, $historyGateway) {
		$this->tableGateway = $tableGateway;
		$this->historyTableGateway = $historyTableGateway;
		$this->historyGateway = $historyGateway;
	}
	public function saveEmployeeHistoryInfo(EmployeeInfo $employeeInfo) {
		$history = $employeeInfo->getHistory ();
		
		try {
			$data = array (
					'employeeId' => $employeeInfo->getEmployeeId (),
					'empPersonalInfoId' => $employeeInfo->getEmpPersonalInfoId (),
					'lkpSalaryGradeId' => $employeeInfo->getLkpSalaryGradeId (),
					'lkpJobGradeId' => $employeeInfo->getLkpJobGradeId (),
					'positionId' => $employeeInfo->getPositionId (),
					'joinDate' => $employeeInfo->getJoinDate (),
					'confirmationDate' => $employeeInfo->getConfirmationDate (),
					'isConfirmed' => $employeeInfo->getIsConfirmed (),
					'locationId' => $employeeInfo->getLocationId (),
					'companyId' => $employeeInfo->getCompanyId (),
					'isActive' => $employeeInfo->getIsActive (),
					'initialSalary' => $employeeInfo->getInitialSalary (),
					'addedUser' => $history->getAddedUser (),
					'addedDate' => $history->getAddedDate (),
					'updatedUser' => $history->getUpdatedUser (),
					'updatedDate' => $history->getUpdatedDate () 
			);
			
			$data ['recordStatus'] = 2;
			$this->historyTableGateway->insert ( $data );
			$this->lastId = $this->historyTableGateway->getLastInsertValue ();
		} catch ( \Exception $e ) {
			return $e->getMessage ();
		}
		
		return true;
	}
	public function saveEmployeeInfo(EmployeeInfo $employeeInfo) {
		try {
			$data = array (
					'employeeId' => $employeeInfo->getEmployeeId (),
					'empPersonalInfoId' => $employeeInfo->getEmpPersonalInfoId (),
					'lkpSalaryGradeId' => $employeeInfo->getLkpSalaryGradeId (),
					'lkpJobGradeId' => $employeeInfo->getLkpJobGradeId (),
					'positionId' => $employeeInfo->getPositionId (),
					'joinDate' => $employeeInfo->getJoinDate (),
					'confirmationDate' => $employeeInfo->getConfirmationDate (),
					'isConfirmed' => $employeeInfo->getIsConfirmed (),
					'locationId' => $employeeInfo->getLocationId (),
					'companyId' => $employeeInfo->getCompanyId (),
					'isActive' => $employeeInfo->getIsActive (),
					'initialSalary' => $employeeInfo->getInitialSalary () 
			);
			
			$this->tableGateway->insert ( $data );
		} catch ( \Exception $e ) {
			echo $e->getMessage ();
		}
		
		return true;
	}
	public function approve($id) {
		$data = array (
				'recordStatus' => '1' 
		);
		
		$info = $this->fetchEmployeeHistoryInfo ( $id );
		$this->saveEmployeeInfo ( $info );
		$this->historyTableGateway->update ( $data, array (
				'employeeId' => $id 
		) );
	}
	public function reject($id) {
		$data = array (
				'recordStatus' => '0' 
		);
		$this->historyTableGateway->update ( $data, array (
				'employeeId' => $id 
		) );
	}
	public function fetchEmployeeInfo($id) {
		$info = $this->tableGateway->select ( array (
				'employeeId' => $id 
		) );
		return $info->current ();
	}
	public function fetchEmployeeHistoryInfo($id) {
		$info = $this->historyTableGateway->select ( array (
				'employeeId' => $id 
		) );
		return $info->current ();
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
	public function getLastId() {
		return $this->lastId;
	}
}
