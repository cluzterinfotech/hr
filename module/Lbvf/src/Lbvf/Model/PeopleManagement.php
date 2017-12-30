<?php

namespace Lbvf\Model;

use Payment\Model\EntityInterface;

class PeopleManagement implements EntityInterface {
	
	private $id;
	private $employeeNumber;
	private $Role01;
	private $duration01;
	private $lOI01;
	private $content01;
	private $Role02;
	private $duration02;
	private $lOI02;
	private $content02;
	private $Role03;
	private $duration03;
	private $lOI03;
	private $content03;
	private $Role04;
	private $duration04;
	private $lOI04;
	private $content04;
	private $Role05;
	private $duration05;
	private $lOI05;
	private $content05;
	private $LbvfId;
	
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
	public function getRole01() {
		return $this->Role01;
	}
	public function setRole01($Role01) {
		$this->Role01 = $Role01;
		return $this;
	}
	public function getDuration01() {
		return $this->duration01;
	}
	public function setDuration01($duration01) {
		$this->duration01 = $duration01;
		return $this;
	}
	public function getLOI01() {
		return $this->lOI01;
	}
	public function setLOI01($lOI01) {
		$this->lOI01 = $lOI01;
		return $this;
	}
	public function getContent01() {
		return $this->content01;
	}
	public function setContent01($content01) {
		$this->content01 = $content01;
		return $this;
	}
	public function getRole02() {
		return $this->Role02;
	}
	public function setRole02($Role02) {
		$this->Role02 = $Role02;
		return $this;
	}
	public function getDuration02() {
		return $this->duration02;
	}
	public function setDuration02($duration02) {
		$this->duration02 = $duration02;
		return $this;
	}
	public function getLOI02() {
		return $this->lOI02;
	}
	public function setLOI02($lOI02) {
		$this->lOI02 = $lOI02;
		return $this;
	}
	public function getContent02() {
		return $this->content02;
	}
	public function setContent02($content02) {
		$this->content02 = $content02;
		return $this;
	}
	public function getRole03() {
		return $this->Role03;
	}
	public function setRole03($Role03) {
		$this->Role03 = $Role03;
		return $this;
	}
	public function getDuration03() {
		return $this->duration03;
	}
	public function setDuration03($duration03) {
		$this->duration03 = $duration03;
		return $this;
	}
	public function getLOI03() {
		return $this->lOI03;
	}
	public function setLOI03($lOI03) {
		$this->lOI03 = $lOI03;
		return $this;
	}
	public function getContent03() {
		return $this->content03;
	}
	public function setContent03($content03) {
		$this->content03 = $content03;
		return $this;
	}
	public function getRole04() {
		return $this->Role04;
	}
	public function setRole04($Role04) {
		$this->Role04 = $Role04;
		return $this;
	}
	public function getDuration04() {
		return $this->duration04;
	}
	public function setDuration04($duration04) {
		$this->duration04 = $duration04;
		return $this;
	}
	public function getLOI04() {
		return $this->lOI04;
	}
	public function setLOI04($lOI04) {
		$this->lOI04 = $lOI04;
		return $this;
	}
	public function getContent04() {
		return $this->content04;
	}
	public function setContent04($content04) {
		$this->content04 = $content04;
		return $this;
	}
	public function getRole05() {
		return $this->Role05;
	}
	public function setRole05($Role05) {
		$this->Role05 = $Role05;
		return $this;
	}
	public function getDuration05() {
		return $this->duration05;
	}
	public function setDuration05($duration05) {
		$this->duration05 = $duration05;
		return $this;
	}
	public function getLOI05() {
		return $this->lOI05;
	}
	public function setLOI05($lOI05) {
		$this->lOI05 = $lOI05;
		return $this;
	}
	public function getContent05() {
		return $this->content05;
	}
	public function setContent05($content05) {
		$this->content05 = $content05;
		return $this;
	}
	public function getLbvfId() {
		return $this->LbvfId;
	}
	public function setLbvfId($LbvfId) {
		$this->LbvfId = $LbvfId;
		return $this;
	} 
} 