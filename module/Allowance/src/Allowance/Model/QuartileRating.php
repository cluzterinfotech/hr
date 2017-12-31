<?php

namespace Allowance\Model;

use Payment\Model\EntityInterface;

class QuartileRating implements EntityInterface {
	
	private $id;
	private $Rating;
	private $quartileOne;
	private $quartileTwo;
	private $quartileThree;
	private $quartileFour;
	
	public function setId($id) {
		$this->id = $id;
	}
	public function getId() {
		return $this->id;
	}
	public function setRating($Rating) {
		$this->Rating = $Rating;
		return $this; 
	}
	public function getRating() {
		return $this->Rating;
	}
	public function setQuartileOne($quartileOne) {
		$this->quartileOne = $quartileOne;
		return $this;
	}
	public function getQuartileOne() {
		return $this->quartileOne;
	}
	public function setQuartileTwo($quartileTwo) {
		$this->quartileTwo = $quartileTwo;
		return $this;
	}
	public function getQuartileTwo() {
		return $this->quartileTwo;
	}
	public function setQuartileThree($quartileThree) {
		$this->quartileThree = $quartileThree;
		return $this;
	}
	public function getQuartileThree() {
		return $this->quartileThree;
	}
	public function setQuartileFour($quartileFour) {
		$this->quartileFour = $quartileFour;
		return $this;
	}
	public function getQuartileFour() {
		return $this->quartileFour;
	}
}   