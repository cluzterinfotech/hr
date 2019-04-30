<?php

namespace Application\Model;

use Payment\Model\EntityInterface;

class GlassAmountDuration implements EntityInterface {
	
	private $id;
	private $amount;
	private $durationInYears;
	
	public function setId($id) {
		$this->id = $id;
	}
	public function getId() {
		return $this->id;
	}
	public function setAmount($amount) {
		$this->amount = $amount;
	}
	public function getAmount() {
		return $this->amount;
	}
	public function setDurationInYears($durationInYears) {
		$this->durationInYears = $durationInYears;
	}
	public function getDurationInYears() {
		return $this->durationInYears;
	}
}