<?php

namespace Lbvf\Model;

use Payment\Model\EntityInterface;

class Instruction implements EntityInterface {
	
	private $id;
	private $LbvfName;
	private $DeadLine;
	private $DeadLineAssessment;
	private $Notes;
	private $Status;
	private $NominationEndorsement;
	private $AllowAssess;
	private $AllowReport;
	
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	public function getLbvfName() {
		return $this->LbvfName;
	}
	public function setLbvfName($LbvfName) {
		$this->LbvfName = $LbvfName;
		return $this;
	}
	public function getDeadLine() {
		return $this->DeadLine;
	}
	public function setDeadLine($DeadLine) {
		$this->DeadLine = $DeadLine;
		return $this;
	}
	public function getDeadLineAssessment() {
		return $this->DeadLineAssessment;
	}
	public function setDeadLineAssessment($DeadLineAssessment) {
		$this->DeadLineAssessment = $DeadLineAssessment;
		return $this;
	}
	public function getNotes() {
		return $this->Notes;
	}
	public function setNotes($Notes) {
		$this->Notes = $Notes;
		return $this;
	}
	public function getStatus() {
		return $this->Status;
	}
	public function setStatus($Status) {
		$this->Status = $Status;
		return $this;
	}
	public function getNominationEndorsement() {
		return $this->NominationEndorsement;
	}
	public function setNominationEndorsement($NominationEndorsement) {
		$this->NominationEndorsement = $NominationEndorsement;
		return $this;
	}
	public function getAllowAssess() {
		return $this->AllowAssess;
	}
	public function setAllowAssess($AllowAssess) {
		$this->AllowAssess = $AllowAssess;
		return $this;
	}
	public function getAllowReport() {
		return $this->AllowReport;
	}
	public function setAllowReport($AllowReport) {
		$this->AllowReport = $AllowReport;
		return $this;
	}
	
}