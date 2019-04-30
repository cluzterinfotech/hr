<?php

namespace Payment\Model;

use Payment\Model\EntityInterface;

class BonusCriteria implements EntityInterface {
	
	private $id;
	private $year;
	private $ratingOne;
	private $ratingTwo;
	private $ratingH3;
	private $ratingS3;
	private $ratingM3;
	private $ratingFour;
	private $joinDate;
	private $confirmationDate;
	private $declarationDate;
	private $bonusFrom;
	private $bonusTo;
	private $bonusType;
	
	public function setId($id) {
		$this->id = $id;
	}
	public function getId() {
		return $this->id;
	}
	public function setYear($year) {
		$this->year = $year;
	}
	public function getYear() {
		return $this->year;
	}
	public function setRatingOne($ratingOne) {
		$this->ratingOne = $ratingOne;
	}
	public function getRatingOne() {
		return $this->ratingOne;
	}
	public function setRatingTwo($ratingTwo) {
		$this->ratingTwo = $ratingTwo;
	}
	public function getRatingTwo() {
		return $this->ratingTwo;
	}
	public function setRatingH3($ratingH3) {
		$this->ratingH3 = $ratingH3;
	}
	public function getRatingH3() {
		return $this->ratingH3;
	}
	function setRatingS3($ratingS3) {
		$this->ratingS3 = $ratingS3;
	}
	public function getRatingS3() {
		return $this->ratingS3;
	}
	public function setRatingM3($ratingM3) {
		$this->ratingM3 = $ratingM3;
	}
	public function getRatingM3() {
		return $this->ratingM3;
	}
	public function setRatingFour($ratingFour) {
		$this->ratingFour = $ratingFour;
	}
	public function getRatingFour() {
		return $this->ratingFour;
	}
	public function setJoinDate($joinDate) {
		$this->joinDate = $joinDate;
	}
	public function getJoinDate() {
		return $this->joinDate;
	}
	public function setConfirmationDate($confirmationDate) {
		$this->confirmationDate = $confirmationDate;
	}
	public function getConfirmationDate() {
		return $this->confirmationDate;
	}
	public function setDeclarationDate($declarationDate) {
		$this->declarationDate = $declarationDate;
	}
	public function getDeclarationDate() {
		return $this->declarationDate;
	}
	public function setBonusFrom($bonusFrom) {
		$this->bonusFrom = $bonusFrom;
	}
	public function getBonusFrom() {
		return $this->bonusFrom;
	}
	public function setBonusTo($bonusTo) {
		$this->bonusTo = $bonusTo;
	}
	public function getBonusTo() {
		return $this->bonusTo;
	}
	public function setBonusType($bonusType) {
		$this->bonusType = $bonusType;
	}
	public function getBonusType() {
		return $this->bonusType;
	}
}
