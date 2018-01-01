<?php

namespace Application\Entity;

class SectionEntity {
	public $sectionId;
	public $sectionName;
	public $sectionCode;
	public $departmentId;
	public function getSectionId() {
		return $this->sectionId;
	}
	public function getSectionName() {
		return $this->sectionName;
	}
	public function getSectionCode() {
		return $this->sectionCode;
	}
	public function getDepartmentId() {
		return $this->departmentId;
	}
	public function setSectionId($sectionId) {
		$this->sectionId = $sectionId;
	}
	public function setSectionName($sectionName) {
		$this->sectionName = $sectionName;
	}
	public function setSectionCode($sectionCode) {
		$this->sectionCode = $sectionCode;
	}
	public function setDepartmentId($departmentId) {
		$this->departmentId = $departmentId;
	}
}
