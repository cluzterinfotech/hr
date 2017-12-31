<?php 

namespace Payment\Model;

use Payment\Model\EntityInterface;
    
class Company implements EntityInterface{
	
	private $id;
	private $companyName;
	
	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	
	public function getCompanyName() {
		return $this->companyName; 
	}
	
	public function setCompanyName($companyName) {
		$this->companyName = $companyName; 
		return $this; 
	}
}