<?php 

namespace Payment\Model;

use Payment\Model\EntityInterface;
    
class CompanyPosition implements EntityInterface{
	
	private $id;   
	private $companyId; 
	private $positionId;
	
	public function getId() { 
		return $this->id; 
	} 
	
	public function setId($id) { 
		$this->id = $id;  
		return $this; 
	} 
	
	public function getCompanyId() { 
		return $this->companyId;  
	} 
	
	public function setCompanyId($companyId) { 
		$this->companyId = $companyId;   
		return $this;  
	} 
	
	public function getPositionId() {
		return $this->positionId;
	}
	
	public function setPositionId($positionId) {
		$this->positionId = $positionId;  
		return $this; 
	} 
}