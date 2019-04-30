<?php

namespace Employee\Model;

use Payment\Model\EntityInterface;

class IdCard implements EntityInterface {
	
	private $id;
	private $employeeIdIdCard;
	private $idCard;
	
	public function setId($id) {
		$this->id = $id;
	}
	public function getId() {
		return $this->id;
	}
	public function setEmployeeIdIdCard($employeeIdIdCard) {
		$this->employeeIdIdCard = $employeeIdIdCard; 
	}
	public function getEmployeeIdIdCard() {
		return $this->employeeIdIdCard;
	}
	public function setIdCard($idCard) {
		$this->idCard = $idCard;
	}
	public function getIdCard() {
		return $this->idCard;
	}
}
