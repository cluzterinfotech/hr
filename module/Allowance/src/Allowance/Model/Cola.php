<?php
namespace Allowance\Model;

class Cola {
	
	private $cola;
	
	public function __construct($cola) {
		$this->cola = $cola;
	}
    
	public function getAmount() {
		return $this->cola;
	}
	
	public function setAmount($cola) {
		$this->cola = $cola;
		return $this;
	}
    	
}