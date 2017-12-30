<?php

namespace Payment\Model;

// use Application\Contract\EntityInterface; 

class Employee implements \Application\Contract\EntityInterface {
    
	protected $id;
	protected $employeeName;
	protected $employeeNumber;
	protected $empSalaryGrade;
	protected $empJobGrade;
	protected $empJoinDate;
	protected $empDateOfBirth;
	protected $empLocation;
	protected $empInitialSalary;
	protected $empPosition;
	protected $companyId;
	protected $empBank;
	protected $accountNumber;
	protected $referenceNumber;
	protected $confirmationDate;
	protected $isConfirmed;
	protected $placeOfBirth;
	protected $Gender;
	protected $maritalStatus;
	protected $religion;
	protected $nationality;
	protected $numberOfDependents;
	protected $state;
	protected $empAddress;
	protected $empTelephone;
	protected $empMobile;
	protected $empPassport;
	protected $license;
	protected $officeExtention;
	protected $empEmail;
	protected $empType;
	protected $skillGroup;
	protected $isPreviousContractor;
	protected $isActive;
	protected $isInPayroll;
	protected $lkpNationalService;
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	public function getEmployeeName() {
		return $this->employeeName;
	}
	public function setEmployeeName($employeeName) {
		$this->employeeName = $employeeName;
		return $this;
	}
	public function getEmployeeNumber() {
		return $this->employeeNumber;
	}
	public function setEmployeeNumber($employeeNumber) {
		$this->employeeNumber = $employeeNumber;
		return $this;
	}
	public function getEmpSalaryGrade() {
		return $this->empSalaryGrade;
	}
	public function setEmpSalaryGrade($empSalaryGrade) {
		$this->empSalaryGrade = $empSalaryGrade;
		return $this;
	}
	public function getEmpJobGrade() {
		return $this->empJobGrade;
	}
	public function setEmpJobGrade($empJobGrade) {
		$this->empJobGrade = $empJobGrade;
		return $this;
	}
	public function getEmpJoinDate() {
		return $this->empJoinDate;
	}
	public function setEmpJoinDate($empJoinDate) {
		$this->empJoinDate = $empJoinDate;
		return $this;
	}
	public function getEmpDateOfBirth() {
		return $this->empDateOfBirth;
	}
	public function setEmpDateOfBirth($empDateOfBirth) {
		$this->empDateOfBirth = $empDateOfBirth;
		return $this;
	}
	public function getEmpLocation() {
		return $this->empLocation;
	}
	public function setEmpLocation($empLocation) {
		$this->empLocation = $empLocation;
		return $this;
	}
	public function getEmpInitialSalary() {
		return $this->empInitialSalary;
	}
	public function setEmpInitialSalary($empInitialSalary) {
		$this->empInitialSalary = $empInitialSalary;
		return $this;
	}
	public function getEmpPosition() {
		return $this->empPosition;
	}
	public function setEmpPosition($empPosition) {
		$this->empPosition = $empPosition;
		return $this;
	}
	public function getCompanyId() {
		return $this->companyId;
	}
	public function setCompanyId($companyId) {
		$this->companyId = $companyId;
		return $this;
	}
	public function getEmpBank() {
		return $this->empBank;
	}
	public function setEmpBank($empBank) {
		$this->empBank = $empBank;
		return $this;
	}
	public function getAccountNumber() {
		return $this->accountNumber;
	}
	public function setAccountNumber($accountNumber) {
		$this->accountNumber = $accountNumber;
		return $this;
	}
	public function getReferenceNumber() {
		return $this->referenceNumber;
	}
	public function setReferenceNumber($referenceNumber) {
		$this->referenceNumber = $referenceNumber;
		return $this;
	}
	public function getConfirmationDate() {
		return $this->confirmationDate;
	}
	public function setConfirmationDate($confirmationDate) {
		$this->confirmationDate = $confirmationDate;
		return $this;
	}
	public function getIsConfirmed() {
		return $this->isConfirmed;
	}
	public function setIsConfirmed($isConfirmed) {
		$this->isConfirmed = $isConfirmed;
		return $this;
	}
	public function getPlaceOfBirth() {
		return $this->placeOfBirth;
	}
	public function setPlaceOfBirth($placeOfBirth) {
		$this->placeOfBirth = $placeOfBirth;
		return $this;
	}
	public function getGender() {
		return $this->Gender;
	}
	public function setGender($Gender) {
		$this->Gender = $Gender;
		return $this;
	}
	public function getMaritalStatus() {
		return $this->maritalStatus;
	}
	public function setMaritalStatus($maritalStatus) {
		$this->maritalStatus = $maritalStatus;
		return $this;
	}
	public function getReligion() {
		return $this->religion;
	}
	public function setReligion($religion) {
		$this->religion = $religion;
		return $this;
	}
	public function getNationality() {
		return $this->nationality;
	}
	public function setNationality($nationality) {
		$this->nationality = $nationality;
		return $this;
	}
	public function getNumberOfDependents() {
		return $this->numberOfDependents;
	}
	public function setNumberOfDependents($numberOfDependents) {
		$this->numberOfDependents = $numberOfDependents;
		return $this;
	}
	public function getState() {
		return $this->state;
	}
	public function setState($state) {
		$this->state = $state;
		return $this;
	}
	public function getEmpAddress() {
		return $this->empAddress;
	}
	public function setEmpAddress($empAddress) {
		$this->empAddress = $empAddress;
		return $this;
	}
	public function getEmpTelephone() {
		return $this->empTelephone;
	}
	public function setEmpTelephone($empTelephone) {
		$this->empTelephone = $empTelephone;
		return $this;
	}
	public function getEmpMobile() {
		return $this->empMobile;
	}
	public function setEmpMobile($empMobile) {
		$this->empMobile = $empMobile;
		return $this;
	}
	public function getEmpPassport() {
		return $this->empPassport;
	}
	public function setEmpPassport($empPassport) {
		$this->empPassport = $empPassport;
		return $this;
	}
	public function getLicense() {
		return $this->license;
	}
	public function setLicense($license) {
		$this->license = $license;
		return $this;
	}
	public function getOfficeExtention() {
		return $this->officeExtention;
	}
	public function setOfficeExtention($officeExtention) {
		$this->officeExtention = $officeExtention;
		return $this;
	}
	public function getEmpEmail() {
		return $this->empEmail;
	}
	public function setEmpEmail($empEmail) {
		$this->empEmail = $empEmail;
		return $this;
	}
	public function getEmpType() {
		return $this->empType;
	}
	public function setEmpType($empType) {
		$this->empType = $empType;
		return $this;
	}
	public function getSkillGroup() {
		return $this->skillGroup;
	}
	public function setSkillGroup($skillGroup) {
		$this->skillGroup = $skillGroup;
		return $this;
	}
	public function getIsPreviousContractor() {
		return $this->isPreviousContractor;
	}
	public function setIsPreviousContractor($isPreviousContractor) {
		$this->isPreviousContractor = $isPreviousContractor;
		return $this;
	}
	public function getIsActive() {
		return $this->isActive;
	}
	public function setIsActive($isActive) {
		$this->isActive = $isActive;
		return $this;
	}
	public function getIsInPayroll() {
		return $this->isInPayroll;
	}
	public function setIsInPayroll($isInPayroll) {
		$this->isInPayroll = $isInPayroll;
		return $this;
	}
	public function getLkpNationalService() {
		return $this->lkpNationalService;
	}
	public function setLkpNationalService($lkpNationalService) {
		$this->lkpNationalService = $lkpNationalService;
		return $this;
	}
	
	//public function getFunctionCode() {
	
	//}
	
	
	
}