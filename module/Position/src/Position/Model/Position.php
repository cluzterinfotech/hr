<?php

namespace Position\Model;

use Payment\Model\EntityInterface;

class Position implements EntityInterface {
		
	private $id;
	private $positionName;
	private $organisationLevel;
	private $positionLocation; 
	private $jobGradeId; 
	private $shortDescription;
	private $section;
	private $reportingPosition;
	private $status; 
	
	/**
     * @return mixed
     */
    public function getJobGradeId()
    {
        return $this->jobGradeId;
    }

    /**
     * @param mixed $jobGradeId
     */
    public function setJobGradeId($jobGradeId)
    {
        $this->jobGradeId = $jobGradeId;
    }

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
	
	public function setPositionLocation($positionLocation) {
	    $this->positionLocation = $positionLocation;  
	    return $this; 
	}
	
	public function getPositionLocation() {  
		return $this->positionLocation;  
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