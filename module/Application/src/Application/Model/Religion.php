<?php

namespace Application\Model;

use Payment\Model\EntityInterface;

class Religion implements EntityInterface {
	
	private $id;
	private $religionName;
	
	public function setId($id) {
		$this->id = $id;
	}
	public function getId() {
		return $this->id;
	}
	public function setReligionName($religionName) {
		$this->religionName = $religionName;
	}
	public function getReligionName() {
		return $this->religionName;
	} 	
}