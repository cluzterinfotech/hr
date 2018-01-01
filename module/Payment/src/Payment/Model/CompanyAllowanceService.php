<?php

namespace Payment\Model; 

use Application\Contract\EntityCollectionInterface;
use Application\Mapper\AllowanceTypeMapper;
use Application\Mapper\CompanyAllowanceMapper;
use Zend\Db\Adapter\Adapter;
    
class CompanyAllowanceService implements CompanyAllowanceInterface { 
      
	protected $adapter; 
	protected $collection; 
	protected $companyAllowanceMapper; 
	//protected $dateMethods;
	
	public function __construct(Adapter $adapter,EntityCollectionInterface $collection,$sm) {
		$this->adapter = $adapter; 
		$this->collection = $collection; 
		//$this->dateMethods = $sm->get('dateMethods'); 
		$allowanceType = new AllowanceTypeMapper($adapter, $collection,$sm); 
		$this->companyAllowanceMapper = new CompanyAllowanceMapper($adapter,$collection,$sm,$allowanceType);
		// @todo create separate mapper for 
		/*SALARY GRADE ALLOWANCE
		LOCATION ALLOWANCE
		POSITION ALLOWANCE
		FIXED AMOUNT ALLOWANCE
		ALLOWANCE CRITERIA
		    -- Related Allowance
		    -- Allowance Anti-Allowance
		PAYSHEET ALLOWANCE
		LEAVE ALLOWANCE ALLOWANCE*/ 
	} 
	
	public function insert($data,$tableName) {
		$this->companyAllowanceMapper->setEntityTable($tableName);
		$this->companyAllowanceMapper->insert($data);
	}
	
	public function getPaysheetEmployeeList($condition) {
	    return $this->companyAllowanceMapper->getPaysheetEmployeeList($condition); 
	}
	
	public function getIndividualEmployee($condition) {
	    return $this->companyAllowanceMapper->getIndividualEmployee($condition);
	}
    
	public function getPaysheetAllowance(Company $company,DateRange $dateRange) { 
		return $this->companyAllowanceMapper->getPaysheetAllowance($company,$dateRange); 
	}
	
	public function getLeaveAllowanceFixed(Company $company,DateRange $dateRange) {
		return $this->companyAllowanceMapper->getLeaveAllowanceFixed($company,$dateRange);
	}
	
	public function getLeaveAllowanceAllowance(Company $company,DateRange $dateRange) {
		return $this->companyAllowanceMapper->getLeaveAllowanceAllowance($company,$dateRange); 
	}  
	
	public function getZakatExemAllowance(Company $company,DateRange $dateRange) {
		return $this->companyAllowanceMapper->getZakatExemAllowance($company,$dateRange); 
	}
	
	public function getPFAllowance(Company $company,DateRange $dateRange) {
		return $this->companyAllowanceMapper->getPFAllowance($company,$dateRange);
	}
	
	public function getTopOtAttendanceDate(Employee $employee) {
		return $this->companyAllowanceMapper->getTopOtAttendanceDate($employee); 
	}
	
	public function getRuntimeAllowance(Company $company,DateRange $dateRange) {
		return $this->companyAllowanceMapper->getRuntimeAllowance($company,$dateRange);
	}
	
	public function getIncometaxAllowance(Company $company,DateRange $dateRange) { 
		return $this->companyAllowanceMapper->getIncometaxAllowance($company,$dateRange);
	}
	 
	public function getBasicAllowance(Company $company,DateRange $dateRange) {
		return $this->companyAllowanceMapper->getBasicAllowance($company,$dateRange);
	}
	
	public function selectSocialInsuranceAllowance() { 
		return $this->companyAllowanceMapper->selectSocialInsuranceAllowance();
	}
    
	public function selectAllowanceNotToHaveAllowance() {
		return $this->companyAllowanceMapper->selectAllowanceNotToHaveAllowance();
	}
	
	public function selectAllowanceAffectedAllowance() {
		return $this->companyAllowanceMapper->selectAllowanceAffectedAllowance(); 
	}
	
	public function selectPaysheetAllowance() {
		return $this->companyAllowanceMapper->selectPaysheetAllowance();
	} 
		
	public function selectFixedAmountAllowance(/*Company $company*/) {
		return $this->companyAllowanceMapper->selectFixedAmountAllowance(/*$company*/); 
	}
	
	public function getSocialInsuranceAllowance(Company $company,DateRange $dateRange) {
		return $this->companyAllowanceMapper->getSocialInsuranceAllowance($company,$dateRange);
	}
	
	/*public function getSocialInsuranceAllowance(Company $company,DateRange $dateRange) { 
		return $this->companyAllowanceMapper->getSocialInsuranceAllowance($company,$dateRange); 
	}*/ 
	
	public function getOtAllowances(Company $company,DateRange $dateRange) {
		return $this->companyAllowanceMapper->getOtAllowances($company,$dateRange);
	}
    	
	public function getEmployeeOTHour(Employee $employee,DateRange $dateRange) { 
		return $this->companyAllowanceMapper->getEmployeeOTHour($employee,$dateRange);
	}
	
	// public function 
	
	public function getEmployeeOTValue(Employee $employee,DateRange $dateRange) {
		return $this->companyAllowanceMapper->getEmployeeOTValue($employee,$dateRange);
	}
	
	public function getEmployeeMealAmount($companyId) {
		return $this->companyAllowanceMapper->getEmployeeMealAmount($companyId); 
	}
	
	public function getEmployeeTotalMeal(Employee $employee,DateRange $dateRange) {
		return $this->companyAllowanceMapper->getEmployeeTotalMeal($employee,$dateRange); 
	}
	
	public function getRelatedAllowance($allowanceId,Company $company) {
		return $this->companyAllowanceMapper
		            ->getRelatedAllowance($allowanceId,$company); 
	} 
	
	public function getNotToHaveAllowance($allowanceId,Company $company,DateRange $dateRange) {
		return $this->companyAllowanceMapper
		            ->getNotToHaveAllowance($allowanceId,$company,$dateRange); 
	}
	
	public function getAllowancePriority($allowance,$notToHaveAllowance,Company $company) {
		return $this->companyAllowanceMapper
		            ->getAllowancePriority($allowance,$notToHaveAllowance,$company); 
	} 
	
	public function getAllowanceTypeName($allowanceId,Company $company) {
		return $this->companyAllowanceMapper
		            ->getAllowanceTypeName($allowanceId,$company);
		
	}
	
	public function getAllowanceIdByName($allowanceTypeName) {
		return $this->companyAllowanceMapper
		            ->getAllowanceIdByName($allowanceTypeName);
		            //->getAllowanceTypeName($allowanceId,$company); 
	}
	
	public function getSplHousing($employeeId) {
		return $this->companyAllowanceMapper
		            ->getSplHousing($employeeId); 
	}
	
	public function isHaveHardship($positionId,Company $company) {
		return $this->companyAllowanceMapper
		            ->isHaveHardship($positionId,$company);  
	}
	
	public function isHaveNatureOfJob($positionId,Company $company,DateRange $dateRange) {
		return $this->companyAllowanceMapper
		            ->isHaveNatureOfJob($positionId,$company,$dateRange);
	}
	
	public function ishaveAirport($positionId,Company $company,DateRange $dateRange) {
		return $this->companyAllowanceMapper
		            ->ishaveAirport($positionId,$company,$dateRange);
	}
	
	/*public function getallowanceListByLocation() {
		
	}*/ 
	
} 