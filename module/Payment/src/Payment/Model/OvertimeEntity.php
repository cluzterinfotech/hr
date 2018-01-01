<?php

namespace Payment\Model;

use Payment\Model\EntityInterface;

class OvertimeEntity implements EntityInterface {
	private $id;
	private $empIdOvertime;
	private $employeeNoNOHours;
	private $employeeNoHOHours;
	private $month;
	private $year;
	//private $otStatus;
	private $endorsedDate;
	private $supervisorComments;
	private $hrComments;
	private $numberOfMeals; 
	
	public function setId($id) {
		$this->id = $id;
	}
	public function getId() {
		return $this->id;
	}
	public function setEmpIdOvertime($empIdOvertime) {
		$this->empIdOvertime = $empIdOvertime;
	}
	public function getEmpIdOvertime() {
		return $this->empIdOvertime;
	}
	public function setEmployeeNoNOHours($employeeNoNOHours) {
		$this->employeeNoNOHours = $employeeNoNOHours;
	}
	public function getEmployeeNoNOHours() {
		return $this->employeeNoNOHours;
	}
	public function setEmployeeNoHOHours($employeeNoHOHours) {
		$this->employeeNoHOHours = $employeeNoHOHours;
	}
	public function getEmployeeNoHOHours() {
		return $this->employeeNoHOHours;
	}
	public function setMonth($month) {
		$this->month = $month;
	}
	public function getMonth() {
		return $this->month;
	}
	public function setYear($year) {
		$this->year = $year;
	}
	public function getYear() {
		return $this->year;
	}
	/*public function setOtStatus($otStatus) {
		$this->otStatus = $otStatus;
	}
	public function getOtStatus() {
		return $this->otStatus;
	}*/ 
	public function setEndorsedDate($endorsedDate) {
		$this->endorsedDate = $endorsedDate;
	}
	public function getEndorsedDate() {
		return $this->endorsedDate;
	}
	public function setSupervisorComments($supervisorComments) {
		$this->supervisorComments = $supervisorComments;
	}
	public function getSupervisorComments() {
		return $this->supervisorComments;
	}
	public function setHrComments($hrComments) {
		$this->hrComments = $hrComments;
	}
	public function getHrComments() {
		return $this->hrComments;
	}
	
	public function setNumberOfMeals($numberOfMeals) {
		$this->numberOfMeals = $numberOfMeals; 
	}
	public function getNumberOfMeals() {
		return $this->numberOfMeals;
	}
}
