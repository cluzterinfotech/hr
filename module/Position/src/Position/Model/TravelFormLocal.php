<?php

namespace Position\Model;

use Payment\Model\EntityInterface;

class TravelFormLocal implements EntityInterface {
		
	private $id;
	private $positionName;
	private $organisationLevel;
	private $empType; 
	private $shortDescription;
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
	
	public function getPositionName() {
		return $this->positionName;
	} 
	
	public function setPositionName($positionName) {
		$this->positionName = $positionName;
		return $this;
	} 
	
	public function getOrganisationLevel() {
		return $this->organisationLevel;
	}
	
	public function setOrganisationLevel($organisationLevel) {
		$this->organisationLevel = $organisationLevel;
		return $this;
	}
	
	public function setEmpType($empType) {
	    $this->empType = $empType; 
	    return $this;
	}
	
	public function getEmpType() { 
		return $this->empType; 
	}
	
	public function setShortDescription($shortDescription) {
		$this->shortDescription = $shortDescription;
		return $this;
	}
	
	public function getShortDescription() {
		return $this->shortDescription;
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
?>