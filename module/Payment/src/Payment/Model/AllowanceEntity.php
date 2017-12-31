<?php
namespace Payment\Model;

use Payment\Model\EntityInterface;

class AllowanceEntity implements EntityInterface {
	
	protected $id;
	
	protected $allowanceName;
	
	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	
	public function getAllowanceName() {
		return $this->allowanceName;
	}
	
	public function setAllowanceName($allowanceName) {
		$this->allowanceName = $allowanceName;
		return $this;
	}
    
}
