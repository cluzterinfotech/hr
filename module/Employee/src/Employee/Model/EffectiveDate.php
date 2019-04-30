<?php 
namespace Employee\Model;

use Application\Contract\EntityInterface;

class EffectiveDate implements EntityInterface {
	
	private $id;
	
	private $effectiveDate;
	
	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	
	public function getEffectiveDate() {
		return $this->effectiveDate;
	}
	
	public function setEffectiveDate($effectiveDate) {
		$this->effectiveDate = $effectiveDate;
		return $this;
	}
} 