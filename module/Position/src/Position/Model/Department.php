<?php

namespace Position\Model;

class Department {
	
	private $id;
	private $departmentId;
	private $departmentName;
	private $deptFunctionCode;
	private $noOfWorkDays;
	private $deptAssistantPositionId;
	private $workHoursPerDay;
	public function setId($id) {
		$this->id = $id;
	}
	public function getId() {
		return $this->id;
	}
	public function setDepartmentId($departmentId) {
		$this->departmentId = $departmentId;
	}
	public function getDepartmentId() {
		return $this->departmentId;
	}
	public function setDepartmentName($departmentName) {
		$this->departmentName = $departmentName;
	}
	public function getDepartmentName() {
		return $this->departmentName;
	}
	public function setDeptFunctionCode($deptFunctionCode) {
		$this->deptFunctionCode = $deptFunctionCode;
	}
	public function getDeptFunctionCode() {
		return $this->deptFunctionCode;
	}
	public function setNoOfWorkDays($noOfWorkDays) {
		$this->noOfWorkDays = $noOfWorkDays;
	}
	public function getNoOfWorkDays() {
		return $this->noOfWorkDays;
	}
	public function setDeptAssistantPositionId($deptAssistantPositionId) {
		$this->deptAssistantPositionId = $deptAssistantPositionId;
	}
	public function getDeptAssistantPositionId() {
		return $this->deptAssistantPositionId;
	}
	public function setWorkHoursPerDay($workHoursPerDay) {
		$this->workHoursPerDay = $workHoursPerDay;
	}
	public function getWorkHoursPerDay() {
		return $this->workHoursPerDay;
	}
}