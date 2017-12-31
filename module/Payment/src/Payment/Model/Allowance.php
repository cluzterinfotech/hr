<?php
namespace Payment\Model;

use Application\Contract\EntityInterface;

class Allowance implements EntityInterface {
	
	protected $id;
	
	protected $allowanceAmount;
	
	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	
	public function getAllowanceAmount() {
		return $this->allowanceAmount;
	}
	
	public function setAllowanceAmount($allowanceAmount) {
		$this->allowanceAmount = $allowanceAmount;
		return $this;
	}
	
}  