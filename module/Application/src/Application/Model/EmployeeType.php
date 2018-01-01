<?php

namespace Application\Model;

use Payment\Model\EntityInterface;

class EmployeeType implements EntityInterface {
	
	private $id;
	private $employeeTypeName;
	
	public function setId($id) {
		$this->id = $id;
	}
	public function getId() {
		return $this->id;
	}
	public function setEmployeeTypeName($employeeTypeName) {
		$this->employeeTypeName = $employeeTypeName;
	}
	public function getEmployeeTypeName() {
		return $this->employeeTypeName;
	}
}