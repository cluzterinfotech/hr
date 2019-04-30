<?php

namespace Pms\Model;

use Payment\Model\EntityInterface;

class Manage implements EntityInterface {
		
	private $id;
	private $Year;
	private $Curr_Activity;
	private $IPC_Notes; 
	private $Reports_Status; 
	
	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id = $id;
		return $this;
	} 
	
	public function getYear() {
		return $this->Year;
	} 
	
	public function setYear($Year) {
		$this->Year = $Year;
		return $this;
	} 
	
	public function getCurr_Activity() {
		return $this->Curr_Activity;
	}
	
	public function setCurr_Activity($Curr_Activity) {
		$this->Curr_Activity = $Curr_Activity;
		return $this;
	}
	
	public function setIPC_Notes($IPC_Notes) {
	    $this->IPC_Notes = $IPC_Notes; 
	    return $this;
	}
	
	public function getIPC_Notes() { 
		return $this->IPC_Notes; 
	}
	
	public function setReports_Status($Reports_Status) {
		$this->Reports_Status = $Reports_Status;
		return $this;
	}
	
	public function getReports_Status() {
		return $this->Reports_Status;
	}
	/*
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
	}*/
}
?>