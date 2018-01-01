<?php

namespace Employee\Model;

/**
 * Description of PersonalInfo
 *
 * @author Wol
 */
class PersonalInfo {
	private $id;
	private $empPersonalInfoId;
	private $employeeName;
	private $dateOfBirth;
	private $placeOfBirth;
	private $gender;
	private $lkpMaritalStatusId;
	private $lkpReligionId;
	private $lkpNationalityId;
	private $noOfChildren;
	private $lkpStateId;
	private $address;
	private $phone;
	private $mobile;
	private $passportNumber;
	private $drivingLicence;
	private $lkpNationalService;
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
	public function setEmployeeName($employeeName) {
		$this->employeeName = $employeeName;
	}
	public function getEmployeeName() {
		return $this->employeeName;
	}
	public function setDateOfBirth($dateOfBirth) {
		$this->dateOfBirth = $dateOfBirth;
	}
	public function getDateOfBirth() {
		return $this->dateOfBirth;
	}
	public function setPlaceOfBirth($placeOfBirth) {
		$this->placeOfBirth = $placeOfBirth;
	}
	public function getPlaceOfBirth() {
		return $this->placeOfBirth;
	}
	public function setGender($gender) {
		$this->gender = ( int ) $gender;
	}
	public function getGender() {
		return $this->gender;
	}
	public function setLkpMaritalStatusId($lkpMaritalStatusId) {
		$this->lkpMaritalStatusId = $lkpMaritalStatusId;
	}
	public function getLkpMaritalStatusId() {
		return $this->lkpMaritalStatusId;
	}
	public function setLkpReligionId($lkpReligionId) {
		$this->lkpReligionId = $lkpReligionId;
	}
	public function getLkpReligionId() {
		return $this->lkpReligionId;
	}
	public function setLkpNationalityId($lkpNationalityId) {
		$this->lkpNationalityId = $lkpNationalityId;
	}
	public function getLkpNationalityId() {
		return $this->lkpNationalityId;
	}
	public function setNoOfChildren($noOfChildren) {
		$this->noOfChildren = $noOfChildren;
	}
	public function getNoOfChildren() {
		if (! isset ( $this->noOfChildren )) {
			$this->noOfChildren = 0;
		}
		return $this->noOfChildren;
	}
	public function setLkpStateId($lkpStateId) {
		$this->lkpStateId = $lkpStateId;
	}
	public function getLkpStateId() {
		return $this->lkpStateId;
	}
	public function setAddress($address) {
		$this->address = $address;
	}
	public function getAddress() {
		return $this->address;
	}
	public function setPhone($phone) {
		$this->phone = $phone;
	}
	public function getPhone() {
		return $this->phone;
	}
	public function setMobile($mobile) {
		$this->mobile = $mobile;
	}
	public function getMobile() {
		return $this->mobile;
	}
	public function setPassportNumber($passportNumber) {
		$this->passportNumber = $passportNumber;
	}
	public function getPassportNumber() {
		return $this->passportNumber;
	}
	public function setDrivingLicence($drivingLicence) {
		$this->drivingLicence = $drivingLicence;
	}
	public function getDrivingLicence() {
		return $this->drivingLicence;
	}
	public function setLkpNationalService($lkpNationalService) {
		$this->lkpNationalService = $lkpNationalService;
	}
	public function getLkpNationalService() {
		return $this->lkpNationalService;
	}
	public function setHistory($history) {
		$this->history = $history;
	}
	public function getHistory() {
		return $this->history;
	}
}
