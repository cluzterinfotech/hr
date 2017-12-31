<?php 

namespace Application\Model;

use Payment\Model\EntityInterface;

class OtAppForm implements EntityInterface {
	
	private $id;
	private $approvalType;
	
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	public function getId() {
		return $this->id;
	}
    
	public function getApprovalType() {
		return $this->approvalType;
	}
	public function setApprovalType($approvalType) {
		$this->approvalType = $approvalType;
		return $this;
	}
	  
	
}