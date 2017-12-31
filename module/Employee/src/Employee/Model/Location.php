<?php

namespace Employee\Model;

use Payment\Model\EntityInterface;

class Location implements EntityInterface {
	
	private $id;
	private $locationName;
	private $overtimeHour;
	private $isHaveHardship; 
	
	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	
	public function getLocationName() {
		return $this->locationName;
	}
	
	public function setLocationName($locationName) {
		$this->locationName = $locationName;
		return $this;
	}
	
	public function getOvertimeHour() {
		return $this->overtimeHour;
	}
	
	public function setOvertimeHour($overtimeHour) {
		$this->overtimeHour = $overtimeHour;
		return $this;
	}
	public function getIsHaveHardship() {
		return $this->isHaveHardship;
	}
	public function setIsHaveHardship($isHaveHardship) {
		$this->isHaveHardship = $isHaveHardship;
		return $this;
	}
	
}
