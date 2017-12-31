<?php

namespace Allowance\Model;

use Payment\Model\EntityInterface;

class SalaryStructure implements EntityInterface {
	
	private $id;
	private $salaryGradeId;
	private $minValue;
	private $midValue;
	private $maxValue;
	
	public function setId($id) {
		$this->id = $id;
		return $this; 
	}
	public function getId() {
		return $this->id;
	}
	public function setSalaryGradeId($salaryGradeId) {
		$this->salaryGradeId = $salaryGradeId;
		return $this;
	}
	public function getSalaryGradeId() {
		return $this->salaryGradeId;
	}
	public function setMinValue($minValue) {
		$this->minValue = $minValue;
		return $this;
	}
	public function getMinValue() {
		return $this->minValue;
	}
	public function setMidValue($midValue) {
		$this->midValue = $midValue;
		return $this;
	}
	public function getMidValue() {
		return $this->midValue;
	}
	public function setMaxValue($maxValue) {
		$this->maxValue = $maxValue;
		return $this;
	}
	public function getMaxValue() {
		return $this->maxValue;
	}
}   