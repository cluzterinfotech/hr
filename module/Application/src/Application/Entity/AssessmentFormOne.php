<?php

namespace Application\Entity;

use Application\Contract\EntityInterface;

class AssessmentFormOne implements EntityInterface {
	
	private $id;
	private $employeeNumber;
	private $AssessorId;
	private $SubmissionDate;
	private $LbvfId;
	private $Strength;
	private $DevelopmentAreas;
	private $Question01a;
	private $Question02a;
	private $Question03a;
	private $Question03b;
	private $Question04a;
	private $Question04b;
	private $Question05a;
	private $Question05b;
	private $Question06a;
	private $Question06b;
	private $Question07a;
	private $Question07b;
	private $Question08a;
	private $Question08b;
	private $Question08c;
	private $Question09a;
	private $Question09b;
	private $Question17;
	private $Question18;
	private $Question19;
	private $Question20;
	private $Question21;
	private $Question22;
	private $Question23;
	private $Question24;
	private $Question25;
	private $Question26;
	private $Question27;
	private $Question28;
	private $Question29;
	private $Question30;
	private $Question31;
	private $Question32;
	private $Question33;
	private $Question34;
	private $Question35;
	private $Question36;
	
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	public function getEmployeeNumber() {
		return $this->employeeNumber;
	}
	public function setEmployeeNumber($employeeNumber) {
		$this->employeeNumber = $employeeNumber;
		return $this;
	}
	public function getAssessorId() {
		return $this->AssessorId;
	}
	public function setAssessorId($AssessorId) {
		$this->AssessorId = $AssessorId;
		return $this;
	}
	public function getSubmissionDate() {
		return $this->SubmissionDate;
	}
	public function setSubmissionDate($SubmissionDate) {
		$this->SubmissionDate = $SubmissionDate;
		return $this;
	}
	public function getLbvfId() {
		return $this->LbvfId;
	}
	public function setLbvfId($LbvfId) {
		$this->LbvfId = $LbvfId;
		return $this;
	}
	public function getStrength() {
		return $this->Strength;
	}
	public function setStrength($Strength) {
		$this->Strength = $Strength;
		return $this;
	}
	public function getDevelopmentAreas() {
		return $this->DevelopmentAreas;
	}
	public function setDevelopmentAreas($DevelopmentAreas) {
		$this->DevelopmentAreas = $DevelopmentAreas;
		return $this;
	}
	public function getQuestion01a() {
		return $this->Question01a;
	}
	public function setQuestion01a($Question01a) {
		$this->Question01a = $Question01a;
		return $this;
	}
	public function getQuestion02a() {
		return $this->Question02a;
	}
	public function setQuestion02a($Question02a) {
		$this->Question02a = $Question02a;
		return $this;
	}
	public function getQuestion03a() {
		return $this->Question03a;
	}
	public function setQuestion03a($Question03a) {
		$this->Question03a = $Question03a;
		return $this;
	}
	public function getQuestion03b() {
		return $this->Question03b;
	}
	public function setQuestion03b($Question03b) {
		$this->Question03b = $Question03b;
		return $this;
	}
	public function getQuestion04a() {
		return $this->Question04a;
	}
	public function setQuestion04a($Question04a) {
		$this->Question04a = $Question04a;
		return $this;
	}
	public function getQuestion04b() {
		return $this->Question04b;
	}
	public function setQuestion04b($Question04b) {
		$this->Question04b = $Question04b;
		return $this;
	}
	public function getQuestion05a() {
		return $this->Question05a;
	}
	public function setQuestion05a($Question05a) {
		$this->Question05a = $Question05a;
		return $this;
	}
	public function getQuestion05b() {
		return $this->Question05b;
	}
	public function setQuestion05b($Question05b) {
		$this->Question05b = $Question05b;
		return $this;
	}
	public function getQuestion06a() {
		return $this->Question06a;
	}
	public function setQuestion06a($Question06a) {
		$this->Question06a = $Question06a;
		return $this;
	}
	public function getQuestion06b() {
		return $this->Question06b;
	}
	public function setQuestion06b($Question06b) {
		$this->Question06b = $Question06b;
		return $this;
	}
	public function getQuestion07a() {
		return $this->Question07a;
	}
	public function setQuestion07a($Question07a) {
		$this->Question07a = $Question07a;
		return $this;
	}
	public function getQuestion07b() {
		return $this->Question07b;
	}
	public function setQuestion07b($Question07b) {
		$this->Question07b = $Question07b;
		return $this;
	}
	public function getQuestion08a() {
		return $this->Question08a;
	}
	public function setQuestion08a($Question08a) {
		$this->Question08a = $Question08a;
		return $this;
	}
	public function getQuestion08b() {
		return $this->Question08b;
	}
	public function setQuestion08b($Question08b) {
		$this->Question08b = $Question08b;
		return $this;
	}
	public function getQuestion08c() {
		return $this->Question08c;
	}
	public function setQuestion08c($Question08c) {
		$this->Question08c = $Question08c;
		return $this;
	}
	public function getQuestion09a() {
		return $this->Question09a;
	}
	public function setQuestion09a($Question09a) {
		$this->Question09a = $Question09a;
		return $this;
	}
	public function getQuestion09b() {
		return $this->Question09b;
	}
	public function setQuestion09b($Question09b) {
		$this->Question09b = $Question09b;
		return $this;
	}
	public function getQuestion17() {
		return $this->Question17;
	}
	public function setQuestion17($Question17) {
		$this->Question17 = $Question17;
		return $this;
	}
	public function getQuestion18() {
		return $this->Question18;
	}
	public function setQuestion18($Question18) {
		$this->Question18 = $Question18;
		return $this;
	}
	public function getQuestion19() {
		return $this->Question19;
	}
	public function setQuestion19($Question19) {
		$this->Question19 = $Question19;
		return $this;
	}
	public function getQuestion20() {
		return $this->Question20;
	}
	public function setQuestion20($Question20) {
		$this->Question20 = $Question20;
		return $this;
	}
	public function getQuestion21() {
		return $this->Question21;
	}
	public function setQuestion21($Question21) {
		$this->Question21 = $Question21;
		return $this;
	}
	public function getQuestion22() {
		return $this->Question22;
	}
	public function setQuestion22($Question22) {
		$this->Question22 = $Question22;
		return $this;
	}
	public function getQuestion23() {
		return $this->Question23;
	}
	public function setQuestion23($Question23) {
		$this->Question23 = $Question23;
		return $this;
	}
	public function getQuestion24() {
		return $this->Question24;
	}
	public function setQuestion24($Question24) {
		$this->Question24 = $Question24;
		return $this;
	}
	public function getQuestion25() {
		return $this->Question25;
	}
	public function setQuestion25($Question25) {
		$this->Question25 = $Question25;
		return $this;
	}
	public function getQuestion26() {
		return $this->Question26;
	}
	public function setQuestion26($Question26) {
		$this->Question26 = $Question26;
		return $this;
	}
	public function getQuestion27() {
		return $this->Question27;
	}
	public function setQuestion27($Question27) {
		$this->Question27 = $Question27;
		return $this;
	}
	public function getQuestion28() {
		return $this->Question28;
	}
	public function setQuestion28($Question28) {
		$this->Question28 = $Question28;
		return $this;
	}
	public function getQuestion29() {
		return $this->Question29;
	}
	public function setQuestion29($Question29) {
		$this->Question29 = $Question29;
		return $this;
	}
	public function getQuestion30() {
		return $this->Question30;
	}
	public function setQuestion30($Question30) {
		$this->Question30 = $Question30;
		return $this;
	}
	public function getQuestion31() {
		return $this->Question31;
	}
	public function setQuestion31($Question31) {
		$this->Question31 = $Question31;
		return $this;
	}
	public function getQuestion32() {
		return $this->Question32;
	}
	public function setQuestion32($Question32) {
		$this->Question32 = $Question32;
		return $this;
	}
	public function getQuestion33() {
		return $this->Question33;
	}
	public function setQuestion33($Question33) {
		$this->Question33 = $Question33;
		return $this;
	}
	public function getQuestion34() {
		return $this->Question34;
	}
	public function setQuestion34($Question34) {
		$this->Question34 = $Question34;
		return $this;
	}
	public function getQuestion35() {
		return $this->Question35;
	}
	public function setQuestion35($Question35) {
		$this->Question35 = $Question35;
		return $this;
	}
	public function getQuestion36() {
		return $this->Question36;
	}
	public function setQuestion36($Question36) {
		$this->Question36 = $Question36;
		return $this;
	}
	
	public function getArrayCopy(){
		
	}
	
} 