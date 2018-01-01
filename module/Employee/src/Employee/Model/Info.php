<?php

namespace Employee\Model;

/**
 * Description of Info
 *
 * @author Wol
 */
class Info {
	private $bankInfo;
	private $personalInfo;
	private $employeeInfo;
	public function setBankInfo($bankInfo) {
		$this->bankInfo = $bankInfo;
	}
	public function getBankInfo() {
		return $this->bankInfo;
	}
	public function setPersonalInfo($personalInfo) {
		$this->personalInfo = $personalInfo;
	}
	public function getPersonalInfo() {
		return $this->personalInfo;
	}
	public function setEmployeeInfo($employeeInfo) {
		$this->employeeInfo = $employeeInfo;
	}
	public function getEmployeeInfo() {
		return $this->employeeInfo;
	}
}
