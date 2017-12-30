<?php
namespace Application\Entity;

use Application\Contract\EntityInterface;
class CompanyAllowanceEntity implements EntityInterface {
	
    protected $id;
    protected $companyId;
    protected $allowanceTypeId;
    
    protected $effectiveDate;
    protected $status;
    protected $isInSocialInsurance;
    protected $isInHealthInsurance;
    protected $isTaxable;
    protected $isInsidePaysheet;
    protected $exemptionTypeId;
    
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
	public function setCompanyId(CompanyEntity $companyId) {
		$this->companyId = $companyId;
		return $this; 
	}
	public function getAllowanceTypeId() {
		return $this->allowanceTypeId;
	}
	public function setAllowanceTypeId(AllowanceTypeEntity $allowanceTypeId) {
		$this->allowanceTypeId = $allowanceTypeId;
		return $this;
	}
	public function getEffectiveDate() {
		return $this->effectiveDate;
	}
	public function setEffectiveDate($effectiveDate) {
		$this->effectiveDate = $effectiveDate;
		return $this;
	}
	public function getStatus() {
		return $this->status;
	}
	public function setStatus($status) {
		$this->status = $status;
		return $this;
	}
	public function getIsInSocialInsurance() {
		return $this->isInSocialInsurance;
	}
	public function setIsInSocialInsurance($isInSocialInsurance) {
		$this->isInSocialInsurance = $isInSocialInsurance;
		return $this;
	}
	public function getIsInHealthInsurance() {
		return $this->isInHealthInsurance;
	}
	public function setIsInHealthInsurance($isInHealthInsurance) {
		$this->isInHealthInsurance = $isInHealthInsurance;
		return $this;
	}
	public function getIsTaxable() {
		return $this->isTaxable;
	}
	public function setIsTaxable($isTaxable) {
		$this->isTaxable = $isTaxable;
		return $this;
	}
	public function getIsInsidePaysheet() {
		return $this->isInsidePaysheet;
	}
	public function setIsInsidePaysheet($isInsidePaysheet) {
		$this->isInsidePaysheet = $isInsidePaysheet;
		return $this;
	}
	public function getExemptionTypeId() {
		return $this->exemptionTypeId;
	}
	public function setExemptionTypeId($exemptionTypeId) {
		$this->exemptionTypeId = $exemptionTypeId;
		return $this;
	}
	
	
}