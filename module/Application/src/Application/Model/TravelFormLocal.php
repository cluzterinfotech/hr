<?php

namespace Application\Model;

use Payment\Model\EntityInterface;

class TravelFormLocal implements EntityInterface {
	
	private $id;
	private $employeeNumberTravelingLocal;
	private $travelingFormEmpPosition;
	private $travelingTo;
	private $purposeOfTrip;
	private $effectiveFrom;
	private $effectiveTo;
	private $expensesRequired;
	private $delegatedEmployee;
	private $meansOfTransport;
	private $fuelLiters;
	private $classOfAirTicket;
	private $classOfHotel;
	private $expenseApproved;
	private $amount;
	private $travelingComments;
	private $approvalLevel;
	private $isCanceled;
	private $approvedLevel;
	private $isApproved;
	
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	public function getId() {
		return $this->id;
	}
	public function setEmployeeNumberTravelingLocal($employeeNumberTravelingLocal) {
		$this->employeeNumberTravelingLocal = $employeeNumberTravelingLocal;
		return $this;
	}
	public function getEmployeeNumberTravelingLocal() {
		return $this->employeeNumberTravelingLocal;
	}
	public function setTravelingFormEmpPosition($travelingFormEmpPosition) {
		$this->travelingFormEmpPosition = $travelingFormEmpPosition;
		return $this;
	}
	public function getTravelingFormEmpPosition() {
		return $this->travelingFormEmpPosition;
	}
	public function setTravelingTo($travelingTo) {
		$this->travelingTo = $travelingTo;
		return $this;
	}
	public function getTravelingTo() {
		return $this->travelingTo;
	}
	public function setPurposeOfTrip($purposeOfTrip) {
		$this->purposeOfTrip = $purposeOfTrip;
		return $this;
	}
	public function getPurposeOfTrip() {
		return $this->purposeOfTrip;
	}
	public function setEffectiveFrom($effectiveFrom) {
		$this->effectiveFrom = $effectiveFrom;
		return $this;
	}
	public function getEffectiveFrom() {
		return $this->effectiveFrom;
	}
	public function setEffectiveTo($effectiveTo) {
		$this->effectiveTo = $effectiveTo;
		return $this;
	}
	public function getEffectiveTo() {
		return $this->effectiveTo;
	}
	public function setExpensesRequired($expensesRequired) {
		$this->expensesRequired = $expensesRequired;
		return $this;
	}
	public function getExpensesRequired() {
		return $this->expensesRequired;
	}
	public function setDelegatedEmployee($delegatedEmployee) {
		$this->delegatedEmployee = $delegatedEmployee;
		return $this;
	}
	public function getDelegatedEmployee() {
		return $this->delegatedEmployee;
	}
	public function setMeansOfTransport($meansOfTransport) {
		$this->meansOfTransport = $meansOfTransport;
		return $this;
	}
	public function getMeansOfTransport() {
		return $this->meansOfTransport;
	}
	public function setFuelLiters($fuelLiters) {
		$this->fuelLiters = $fuelLiters;
		return $this;
	}
	public function getFuelLiters() {
		return $this->fuelLiters;
	}
	public function setClassOfAirTicket($classOfAirTicket) {
		$this->classOfAirTicket = $classOfAirTicket;
		return $this;
	}
	public function getClassOfAirTicket() {
		return $this->classOfAirTicket;
	}
	public function setClassOfHotel($classOfHotel) {
		$this->classOfHotel = $classOfHotel;
		return $this;
	}
	public function getClassOfHotel() {
		return $this->classOfHotel;
	}
	public function setExpenseApproved($expenseApproved) {
		$this->expenseApproved = $expenseApproved;
		return $this;
	}
	public function getExpenseApproved() {
		return $this->expenseApproved;
	} 
	public function setAmount($amount) {
		$this->amount = $amount;
		return $this;
	}
	public function getAmount() {
		return $this->amount;
	}
	public function setTravelingComments($travelingComments) {
		$this->travelingComments = $travelingComments;
		return $this;
	}
	public function getTravelingComments() {
		return $this->travelingComments;
	}
	
	public function setApprovalLevel($approvalLevel) {
		$this->approvalLevel = $approvalLevel; 
		return $this; 
	}
	
	public function getApprovalLevel() { 
		return $this->approvalLevel;  
	} 
	
	public function setIsCanceled($isCanceled) {
		$this->isCanceled = $isCanceled;
		return $this;
	}
	
	public function getIsCanceled() {
		return $this->isCanceled;
	}
	
	public function setApprovedLevel($approvedLevel) {
		$this->approvedLevel = $approvedLevel;
		return $this;
	}
	
	public function getApprovedLevel() {
		return $this->approvedLevel;
	} 
	
	public function setIsApproved($isApproved) {
		$this->isApproved = $isApproved;
		return $this;
	}
	
	public function getIsApproved() {
		return $this->isApproved;
	}
	
}