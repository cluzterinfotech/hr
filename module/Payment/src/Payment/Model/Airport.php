<?php
namespace Payment\Model; 

use Payment\Model\AbstractAllowance; 

class Airport extends AbstractAllowance {

	public function calculateAmount(Employee $employee,DateRange $dateRange) {
		$sgService = $this->service->get('salaryGradeService');
		//$sgService = $this->service->get('salaryGradeService');
		$splAmount = $sgService->getSpecialAmount($employee->getEmployeeNumber(),$dateRange,$this->getTableName());
		//\Zend\Debug\Debug::dump($splHous);
		//exit;
		if($splAmount[0] == 1) {
		    return $splAmount[1];
		}
    	$sgId = $employee->getEmpSalaryGrade(); 
    	$company = $this->service->get('company');
    	$allowanceId = $this->getAllowanceIdByName($this->getTableName()); 
    	//\Zend\Debug\Debug::dump($employee);
    	$companyId = $employee->getCompanyId();
    	$amount = $sgService->salaryGradeAmount($sgId,$allowanceId,$companyId);
    	//\Zend\Debug\Debug::dump($allowanceId);
    	//exit; 
    	//$company = $this->getAllowanceIdByName($allowanceTypeName); 
    	if($this->ishaveAirport($employee,$company,$dateRange)) {
    	    return $amount; 	
    	} 
    	//exit;
    	$isForAll = $sgService->isSalaryGradeAmountToAll($sgId,$allowanceId,$companyId);
    	if($isForAll) {
    	    $amount;
    	}
    	return 0; 
	}
	
	private function ishaveAirport(Employee $employee,Company $company,DateRange $dateRange) {
		$positionId = $employee->getEmpPosition();
		$companyId = $company->getId();
		// Nature of job only for permanent
		// @todo check condition from db
		if($companyId != 1) {
			// fetch from db entry
			return 0;
		}
		// Note:it is salary grade Id not salary grade itself
		return $this->companyAllowance
		            ->ishaveAirport($positionId,$company,$dateRange);
		//echo $isHave;
		//exit; 
	}
	
	public function calculateExemption(Employee $employee,DateRange $dateRange) {
		return 0;
	}	
	    
	public function getTableName() {
		return "Airport";
	}
}   