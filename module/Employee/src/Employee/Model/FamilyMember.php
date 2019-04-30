<?php

namespace Employee\Model;

use Payment\Model\EntityInterface;

class FamilyMember implements EntityInterface {
	
	private $id;
	private $employeeId;
	private $memberTypeId;
	private $memberName;
	
	public function setId($id) {
		$this->id = $id;
	}
	public function getId() {
		return $this->id;
	}
	public function setEmployeeId($employeeId) {
		$this->employeeId = $employeeId;
	}
	public function getEmployeeId() {
		return $this->employeeId;
	}
	public function setMemberTypeId($memberTypeId) {
		$this->memberTypeId = $memberTypeId;
	}
	public function getMemberTypeId() {
		return $this->memberTypeId;
	}
	public function setMemberName($memberName) {
		$this->memberName = $memberName;
	}
	public function getMemberName() {
		return $this->memberName;
	}
}