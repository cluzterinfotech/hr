<?php

namespace Application\Model;

use Payment\Model\EntityInterface;

class Section implements EntityInterface {
	
	private $id;
	private $sectionName;
	private $sectionCode;
	private $department;
	
	public function setId($id) {
		$this->id = $id;
	}
	public function getId() {
		return $this->id;
	}
	public function setSectionName($sectionName) {
		$this->sectionName = $sectionName;
	}
	public function getSectionName() {
		return $this->sectionName;
	}
	public function setSectionCode($sectionCode) {
		$this->sectionCode = $sectionCode;
	}
	public function getSectionCode() {
		return $this->sectionCode;
	}
	public function setDepartment($department) {
		$this->department = $department;
	}
	public function getDepartment() {
		return $this->department;
	}
}