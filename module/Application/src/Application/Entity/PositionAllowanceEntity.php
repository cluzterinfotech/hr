<?php

namespace Application\Entity;

use Application\Contract\EntityInterface;

class PositionAllowanceEntity implements EntityInterface {
	
	private $id;
	private $positionName;
	private $positionAllowanceName;
	//private $companyId; 
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id; 
		return $this; 
	} 
	public function getPositionName() {
		return $this->positionName;
	}
	public function setPositionName($positionName) {
		$this->positionName = $positionName;
		return $this;
	}
	public function getPositionAllowanceName() {
		return $this->positionAllowanceName;
	}
	public function setPositionAllowanceName($positionAllowanceName) {
		$this->positionAllowanceName = $positionAllowanceName;
		return $this; 
	}
	/*public function getCompanyId() {
		return $this->companyId;
	}
	public function setCompanyId($companyId) {
		$this->companyId = $companyId; 
		return $this; 
	}*/ 
		
} 