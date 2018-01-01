<?php

namespace Employee\Model;

use Payment\Model\EntityInterface;

class CarRentLkpGroup implements EntityInterface {
	
	private $id; 
	private $groupName;
	private $amount;
	private $Notes;
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	public function getGroupName() {
		return $this->groupName;
	}
	public function setGroupName($groupName) {
		$this->groupName = $groupName;
		return $this;
	}
	public function getAmount() {
		return $this->amount;
	}
	public function setAmount($amount) {
		$this->amount = $amount;
		return $this;
	}
	public function getNotes() {
		return $this->Notes;
	}
	public function setNotes($Notes) {
		$this->Notes = $Notes;
		return $this;
	}
	
	
	
}
