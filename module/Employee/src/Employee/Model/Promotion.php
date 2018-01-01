<?php

namespace Employee\Model;

use Application\Contract\EntityInterface;

class Promotion implements EntityInterface {
	
	private $id;
	private $locationName;
	private $overtimeHour;
	
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
}
