<?php

namespace Application\Model;

use Payment\Model\EntityInterface;

class Currency implements EntityInterface {
	
	private $id;
	private $currencyName;
	
	public function setId($id) {
		$this->id = $id;
	}
	public function getId() {
		return $this->id;
	}
	public function setCurrencyName($currencyName) {
		$this->currencyName = $currencyName;
	}
	public function getCurrencyName() {
		return $this->currencyName;
	} 	
}