<?php 

namespace Application\Model;

use Payment\Model\EntityInterface;

class LeaveAppForm implements EntityInterface {
	
	private $id;
	//private $expenseApproved;
	private $approvalType;
	
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	public function getId() {
		return $this->id;
	}
	
	/*public function setExpenseApproved($expenseApproved) {
		$this->expenseApproved = $expenseApproved;
		return $this;
	}
	public function getExpenseApproved() {
		return $this->expenseApproved;
	}*/
	public function getApprovalType() {
		return $this->approvalType;
	}
	public function setApprovalType($approvalType) {
		$this->approvalType = $approvalType;
		return $this;
	}
	  
	
}