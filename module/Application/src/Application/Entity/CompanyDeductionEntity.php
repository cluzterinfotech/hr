<?php
namespace Application\Entity;

use Application\Contract\EntityInterface;
use Payment\Model\DeductionEntity;

class CompanyDeductionEntity implements EntityInterface {
	
    protected $id;
    protected $companyId;
    protected $deductionId;
    
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
	public function getDeductionId() {
		return $this->deductionId;
	}
	public function setDeductionId(DeductionEntity $deductionId) {
		$this->deductionId = $deductionId;
		return $this;
	}
	
	
	
}