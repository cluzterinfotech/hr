<?php 

namespace Payment\Model;

use Application\Contract\EntityInterface;

class Person implements EntityInterface {
	
	protected $id;
	protected $employeeName;
	protected $dateOfBirth;
	protected $lkpReligionId;
	
	public function getId() {
		return $this->id; 
	}
	
	public function setId($id) {
		$this->id = $id;
		return $this; 
	}
	
	public function getEmployeeName() {
		return $this->employeeName; 
	}
	public function setEmployeeName($employeeName) {
		$this->employeeName = $employeeName;
		return $this; 
	}
	public function getDateOfBirth() {
		return $this->dateOfBirth;
	}
	public function setDateOfBirth($dateOfBirth) {
		$this->dateOfBirth = $dateOfBirth;
		return $this;
	}
	public function getLkpReligionId() {
		return $this->lkpReligionId;
	}
	public function setLkpReligionId($lkpReligionId) { 
		$this->lkpReligionId = $lkpReligionId; 
		return $this; 
	}
	
	 
}  