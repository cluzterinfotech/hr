<?php

namespace Application\Service;

use Zend\Db\Adapter\Adapter, 
    Application\Contract\EntityInterface, 
    Application\Contract\EntityCollectionInterface, 
    Application\Entity\CompanyEntity;
use Application\Utility\DateRange;
use Application\Entity\CompanyAllowanceEntity;
use Application\Mapper\CompanyAllowanceMapper;
use Application\Mapper\AllowanceTypeMapper;
 
class AllowanceDeductionService {
	
	protected $adapter;
	protected $collection;
	protected $companyAllowanceMapper;
    
	public function __construct(Adapter $adapter, EntityCollectionInterface $collection) {
		$this->adapter = $adapter;
		$this->collection = $collection;
		$allowanceType = new AllowanceTypeMapper($adapter, $collection);
		$this->companyAllowanceMapper = new CompanyAllowanceMapper($adapter,$collection,$allowanceType);
	}
        
	public function compulsoryDeduction($paysheetAmount,array $deductionName) {
		
		if(in_array('SocialInsuranceEmployee', $deductionName)) {
			
		}
		 
	}
	
	/*
	public function  prepareCompulsoryDeduction($paysheetAmount,array $deductionName) { 
        
		if(in_array('SocialInsuranceEmployee', $deductionName)) {
			// @todo
			//$socialInsuranceService = $this->services->get('SocialInsurance');
			// temp
			$socialInsuranceService = new SocialInsuranceService($this->adapter,$this->collection);
			// get allowance for social insurance
			$allowanceList = $socialInsuranceService->getAllowanceList($this->company, $this->dateRange);
			foreach($allowanceList as $allowance) {
				$siAmount += $this->allowanceAmount[$allowance];
			}
			// get exemption for social insurance
			$exemption = $socialInsuranceService->getExemption($this->company, $this->dateRange);
			// get percentage
			$percentage = $socialInsuranceService->getPercentage($this->company, $this->dateRange);
			$amount = $siAmount * $percentage;
			 
			if($this->paysheetAmount > $amount) {
				$this->deductionAmount['SocialInsuranceEmployee'] = $amount;
				$this->paysheetAmount -= $amount;
			}
			// $this->paysheetAmountWithExemption += $amount - $exemption;
		} else {
			$this->deductionAmount['SocialInsuranceEmployee'] = 0;
		}
	
		if(in_array('SocialInsuranceCompany', $this->companyCompulsoryDeduction)) { 
			$this->deductionAmount['SocialInsuranceCompany'] = $amount;
				
		} else {
			$this->deductionAmount['SocialInsuranceCompany'] = 0;
		}
         
		if(in_array('IncomeTax', $this->companyCompulsoryDeduction)) {
			$amount = 500;
			if($this->paysheetAmount > $amount) {
				$this->deductionAmount['IncomeTax'] = $amount;
				//$this->paysheetAmount -= $amount;
			}
		}
		return $this;
	}
	*/
}
