<?php
namespace Payment\Model;

use Payment\Model\EntityInterface;

class AllowanceTypeEntity implements EntityInterface {
		
	protected $id;
	
	protected $allowanceId;
	
	protected $allowanceType;
	
	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	
	public function getAllowanceId() {
		return $this->allowanceId;
	}
	
	public function setAllowanceId(AllowanceEntity $allowanceId) {
		$this->allowanceId = $allowanceId;
		return $this;
	}
	
	public function getAllowanceType() {
		return $this->allowanceType;
	}
	
	public function setAllowanceType($allowanceType) {
		$this->allowanceType = $allowanceType;
		return $this;
	}
		

}
