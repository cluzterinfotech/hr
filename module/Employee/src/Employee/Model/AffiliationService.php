<?php

namespace Employee\Model;

use Employee\Model\AffiliationMapper;
use Payment\Model\Company;
use Payment\Model\Payment;
use Payment\Model\ReferenceParameter;

class AffiliationService extends Payment {
	
	private $affiliationMapper;
	
	public function __construct(ReferenceParameter $reference,
			AffiliationMapper $affiliationMapper) {
		parent::__construct($reference);
		$this->affiliationMapper = $affiliationMapper; 
	}
	
	public function selectAffiliationAmount() {
		return $this->affiliationMapper->selectAffiliationAmount();
	}
	
	public function addNewEmployeeAffiliation($employeeId,
			Company $company,$effectiveDate) { 
		
		// @todo implementation 
		// fetch all affiliated deduction and amount 
		// add it to the employee based on effective date 
		
		
	}
	
         	
}