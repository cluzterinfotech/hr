<?php

namespace Payment\Model;

use Payment\Model\EntityInterface;

class DeductionEntityX implements EntityInterface {
	
	protected $id;
	protected $deductionName;
	protected $deductionCategoryId;
	protected $deductionClassName;
	public function getId() {
		return $this->id; 
	}
	public function setId($id) {
		$this->id = $id; 
		return $this; 
	} 
	public function getDeductionName() {
		return $this->deductionName;
	}
	public function setDeductionName($deductionName) {
		$this->deductionName = $deductionName;
		return $this;
	}
	public function getDeductionCategoryId() {
		return $this->deductionCategoryId;
	}
	public function setDeductionCategoryId($deductionCategoryId) {
		$this->deductionCategoryId = $deductionCategoryId;
		return $this; 
	} 
	public function getDeductionClassName() { 
		return $this->deductionClassName; 
	} 
	public function setDeductionClassName($deductionClassName) { 
		$this->deductionClassName = $deductionClassName; 
		return $this; 
	} 
    
}
