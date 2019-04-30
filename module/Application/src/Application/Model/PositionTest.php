<?php

namespace Application\Model;

use Application\Abstraction\AbstractEntity;
use Application\Contract\EntityInterface;

class PositionTest implements EntityInterface {

	private $id;
	private $name;
	private $level;
	private $sequence;
	private $section;
	private $reportingPosition;
	private $status;
	
	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function setName($name) {
		$this->name = $name;
		return $this;
	}
	
	public function getLevel() {
		return $this->level;
	}
	
	public function setLevel($level) {
		$this->level = $level;
		return $this;
	}
	
	public function getSequence() {
		return $this->sequence;
	}
	
	public function setSequence($sequence) {
		$this->sequence = $sequence;
		return $this;
	}
	
	public function getSection() {
		return $this->section;
	}
	
	public function setSection($section) {
		$this->section = $section;
		return $this;
	}
	
	public function getReportingPosition() {
		return $this->reportingPosition;
	}
	
	public function setReportingPosition($reportingPosition) {
		$this->reportingPosition = $reportingPosition;
		return $this;
	}
	
	public function getStatus() {
		return $this->status;
	}
	
	public function setStatus($status) {
		$this->status = $status;
		return $this;
	}
	
}