<?php 

namespace Application\Model;

use Payment\Model\EntityInterface;
    
class Jg implements EntityInterface{
	
	private $id;
	private $jobGrade;
	
	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	
	public function getJobGrade() {
		return $this->jobGrade; 
	}
	
	public function setJobGrade($jobGrade) {
		$this->jobGrade = $jobGrade; 
		return $this; 
	}
}