<?php

namespace Employee\Model;

use Payment\Model\EntityInterface;

class CarRentPositionGroup implements EntityInterface {
	
	private $id;
	private $positionId;
	private $lkpCarRentGroupId;
	
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	public function getPositionId() {
		return $this->positionId;
	}
	public function setPositionId($positionId) {
		$this->positionId = $positionId;
		return $this;
	}
	public function getLkpCarRentGroupId() {
		return $this->lkpCarRentGroupId;
	}
	public function setLkpCarRentGroupId($lkpCarRentGroupId) {
		$this->lkpCarRentGroupId = $lkpCarRentGroupId;
		return $this;
	}
	
	
	
	
}
