<?php
namespace Application\Entity;

class CompanyEntity {
	
    private $id;
    
	private $companyName;

	private $status;
	
	private $employeeIdPrefix;
	
	private $value;
	
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
	
	public function getStatus() {
		return $this->status;
	}
	
	public function setStatus($status) {
		$this->status = $status;
		return $this;
	}
	
	public function getEmployeeIdPrefix() {
		return $this->employeeIdPrefix;
	}
	
	public function setEmployeeIdPrefix($employeeIdPrefix) {
		$this->employeeIdPrefix = $employeeIdPrefix;
		return $this;
	}
	
	public function getValue() {
		return $this->value;
	}
	
	public function setValue($value) {
		$this->value = $value;
		return $this;
	}
	 
	
}