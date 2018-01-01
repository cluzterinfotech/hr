<?php  
namespace Employee\Model;

use Application\Contract\EntityInterface;

class IncrementColaPercentage implements EntityInterface {
	
	private $id;
	private $applyeEfectiveDate; 
	private $incColaPercentage;
	
	public function getId() {
		return $this->id; 
	}
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	public function getIncColaPercentage() {
		return $this->incColaPercentage;
	}
	public function setIncColaPercentage($incColaPercentage) {
		$this->incColaPercentage = $incColaPercentage;
		return $this; 
	}
	public function getApplyeEfectiveDate() {
		return $this->applyeEfectiveDate;
	}
	public function setApplyeEfectiveDate($applyeEfectiveDate) {
		$this->applyeEfectiveDate = $applyeEfectiveDate;
		return $this; 
	} 
} 