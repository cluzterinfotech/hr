<?php
namespace Allowance\Model;

class Initial {
	
	private $initial;
	
	public function __construct($initial) {
		$this->initial = $initial;
	}
    
	public function getAmount() {
		return $this->initial;
	}
	
	public function setAmount($initial) {
		$this->initial = $initial;
		return $this;
	}
    	
}