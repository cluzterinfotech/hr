<?php

namespace Application\Model;

use Payment\Model\EntityInterface;

class Nationality implements EntityInterface {
	
	private $id;
	private $nationalityName;
	
	public function setId($id) {
		$this->id = $id;
	}
	public function getId() {
		return $this->id;
	}
	public function setNationalityName($nationalityName) {
		$this->nationalityName = $nationalityName;
	}
	public function getNationalityName() {
		return $this->nationalityName;
	} 	
}