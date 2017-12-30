<?php

namespace Employee\Model;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;
use Employee\Model\PersonalInfo;

/**
 * Description of BankTable
 *
 * @author Wol
 */
class PersonalInfoTable {
	private $tableGateway;
	private $historyGateway;
	private $historyTableGateway;
	private $lastId;
	public function __construct($tableGateway, $historyTableGateway, $historyGateway) {
		$this->tableGateway = $tableGateway;
		$this->historyTableGateway = $historyTableGateway;
		$this->historyGateway = $historyGateway;
	}
	public function savePersonalHistoryInfo(PersonalInfo $personalInfo) {
		$history = $personalInfo->getHistory ();
		// \Zend\Debug\Debug::dump($personalInfo);
		try {
			$data = array (
					'empPersonalInfoId' => $personalInfo->getEmpPersonalInfoId (),
					'employeeName' => $personalInfo->getEmployeeName (),
					'dateOfBirth' => $personalInfo->getDateOfBirth (),
					'placeOfBirth' => $personalInfo->getPlaceOfBirth (),
					'gender' => $personalInfo->getGender (),
					'lkpMaritalStatusId' => $personalInfo->getLkpMaritalStatusId (),
					'lkpReligionId' => $personalInfo->getLkpReligionId (),
					'lkpNationalityId' => $personalInfo->getLkpNationalityId (),
					'noOfChildren' => $personalInfo->getNoOfChildren (),
					'lkpStateId' => $personalInfo->getLkpStateId (),
					'address' => $personalInfo->getAddress (),
					'phone' => $personalInfo->getPhone (),
					'mobile' => $personalInfo->getMobile (),
					'passportNumber' => $personalInfo->getPassportNumber (),
					'drivingLicence' => $personalInfo->getDrivingLicence (),
					'lkpNationalService' => $personalInfo->getLkpNationalService (),
					'addedUser' => $history->getAddedUser (),
					'addedDate' => $history->getAddedDate (),
					'updatedUser' => $history->getUpdatedUser (),
					'updatedDate' => $history->getUpdatedDate () 
			);
			
			if (empty ( $data ['empPersonalInfoId'] )) {
				// $data['id'] = 0;
				$data ['empPersonalInfoId'] = $this->getNextPersonalInfoId ();
				$data ['recordStatus'] = 2;
				$this->historyTableGateway->insert ( $data );
				$this->lastId = $this->historyTableGateway->getLastInsertValue ();
			} else {
				$update = array (
						'recordStatus' => 4,
						'updatedUser' => $history->getUpdatedUser (),
						'updatedDate' => $history->getUpdatedDate () 
				);
				$id = $personalInfo->getEmpPersonalInfoId ();
				$this->historyTableGateway->update ( $update, array (
						'empPersonalInfoId' => $id 
				) );
				
				$data ['recordStatus'] = 2;
				$this->historyTableGateway->insert ( $data );
			}
		} catch ( \Exception $e ) {
			return $e->getMessage ();
		}
		
		return true;
	}
	public function updatePersonalHistoryInfo(PersonalInfo $personalInfo) {
		$history = $personalInfo->getHistory ();
		// \Zend\Debug\Debug::dump($personalInfo);
		try {
			$data = array (
					'empPersonalInfoId' => $personalInfo->getEmpPersonalInfoId (),
					'employeeName' => $personalInfo->getEmployeeName (),
					'dateOfBirth' => $personalInfo->getDateOfBirth (),
					'placeOfBirth' => $personalInfo->getPlaceOfBirth (),
					'gender' => $personalInfo->getGender (),
					'lkpMaritalStatusId' => $personalInfo->getLkpMaritalStatusId (),
					'lkpReligionId' => $personalInfo->getLkpReligionId (),
					'lkpNationalityId' => $personalInfo->getLkpNationalityId (),
					'noOfChildren' => $personalInfo->getNoOfChildren (),
					'lkpStateId' => $personalInfo->getLkpStateId (),
					'address' => $personalInfo->getAddress (),
					'phone' => $personalInfo->getPhone (),
					'mobile' => $personalInfo->getMobile (),
					'passportNumber' => $personalInfo->getPassportNumber (),
					'drivingLicence' => $personalInfo->getDrivingLicence (),
					'lkpNationalService' => $personalInfo->getLkpNationalService (),
					'addedUser' => $history->getAddedUser (),
					'addedDate' => $history->getAddedDate (),
					'updatedUser' => $history->getUpdatedUser (),
					'updatedDate' => $history->getUpdatedDate () 
			);
			
			$data ['empPersonalInfoId'] = 0;
			$data ['recordStatus'] = 2;
			$this->historyTableGateway->insert ( $data );
			$this->lastId = $this->historyTableGateway->getLastInsertValue ();
		} catch ( \Exception $e ) {
			return $e->getMessage ();
		}
		
		return true;
	}
	public function savePersonalInfo(PersonalInfo $personalInfo) {
		try {
			$data = array (
					'empPersonalInfoId' => $personalInfo->getEmpPersonalInfoId (),
					'employeeName' => $personalInfo->getEmployeeName (),
					'dateOfBirth' => $personalInfo->getDateOfBirth (),
					'placeOfBirth' => $personalInfo->getPlaceOfBirth (),
					'gender' => $personalInfo->getGender (),
					'lkpMaritalStatusId' => $personalInfo->getLkpMaritalStatusId (),
					'lkpReligionId' => $personalInfo->getLkpReligionId (),
					'lkpNationalityId' => $personalInfo->getLkpNationalityId (),
					'noOfChildren' => $personalInfo->getNoOfChildren (),
					'lkpStateId' => $personalInfo->getLkpStateId (),
					'address' => $personalInfo->getAddress (),
					'phone' => $personalInfo->getPhone (),
					'mobile' => $personalInfo->getMobile (),
					'passportNumber' => $personalInfo->getPassportNumber (),
					'drivingLicence' => $personalInfo->getDrivingLicence (),
					'lkpNationalService' => $personalInfo->getLkpNationalService () 
			);
			
			$this->tableGateway->insert ( $data );
		} catch ( \Exception $e ) {
			return $e->getMessage ();
		}
		
		return true;
	}
	public function getNextPersonalInfoId() {
		/*
		 * $result = $this->historyTableGateway->select(function(Select $select){
		 * $select->columns(array(
		 * new Expression('max(id) as id'),
		 * ));
		 * });
		 */
		$sql = $this->historyTableGateway->getSql ();
		$select = $sql->select ();
		$select->columns ( array (
				new Expression ( 'max(id) as id' ) 
		) );
		$statement = $sql->prepareStatementForSqlObject ( $select );
		$result = $statement->execute ();
		$row = $result->current ();
		$id = $row ['id'] + 1;
		
		return $id;
	}
	public function approve($id) {
		$data = array (
				'recordStatus' => '1' 
		);
		
		$info = $this->fetchPersonalHistoryInfo ( $id );
		$this->savePersonalInfo ( $info );
		// $this->historyTableGateway->update($data,array('empPersonalInfoId' => $id));
	}
	public function reject($id) {
		$data = array (
				'recordStatus' => '0' 
		);
		$this->historyTableGateway->update ( $data, array (
				'empPersonalInfoId' => $id 
		) );
	}
	public function fetchPersonalInfo($id) {
		$info = $this->tableGateway->select ( array (
				'empPersonalInfoId' => $id 
		) );
		return $info->current ();
	}
	public function fetchPersonalHistoryInfo($id) {
		$info = $this->historyTableGateway->select ( array (
				'empPersonalInfoId' => $id 
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
