<?php 

namespace Payment\Model;

use Payment\Model\Employee; 
use Payment\Model\DateRange; 

abstract class AbstractDeduction extends Payment {
	
	public function getDeductionAmount(Employee $employee,DateRange $dateRange) {
		
		return $this->deductionEntry
		            ->employeeDeductionAmount($employee,$dateRange,$this->getTableName())
		; 
	}
	
	public function getDeductionExemption(Employee $employee,DateRange $dateRange) {
		return 0;
	} 
	
	public function insert($array) {
		$service = $this->service->get('EmployeeAllowanceAmountMapper');
		$service->setEntityTable($this->getTableName());
		$service->insert($array);
	}
	
	protected function isExemptedFromSI(Employee $employee,DateRange $dateRange) {
		// @todo get exempted age from table
		$exemptedYear = '60';
		$dob = $employee->getEmpDateOfBirth();
		$today = $dateRange->getFromDate(); 
		// $today = date('Y-m-d');
		$dateMethods = $this->service->get('dateMethods');
		$noOfYears = $dateMethods->numberOfYearsBetween($dob,$today);
		if($noOfYears >= $exemptedYear) {
			return 1;
		}
		return 0;
	}
	
	public function getLastAmount(Employee $employee,DateRange $dateRange) {
		return $this->allowanceEntry
		            ->getLastAmount($employee,$dateRange,$this->getTableName())
		;
	
	}
	
	protected function isExemptedFromTax(Employee $employee,DateRange $dateRange) {
		// @todo get exempted age from table
		$exemptedYear = '50';
		$dob = $employee->getEmpDateOfBirth();
		$today = $dateRange->getFromDate();
		// $today = date('Y-m-d');
		$dateMethods = $this->service->get('dateMethods');
		//\Zend\Debug\Debug::dump($dob);
		//\Zend\Debug\Debug::dump($today);
		$noOfYears = $dateMethods->numberOfYearsBetween($dob,$today);
		//\Zend\Debug\Debug::dump($noOfYears);
		if($noOfYears >= $exemptedYear) {
			return 1;
		}
		return 0;
	}
	
	protected function isAppointedBefore(Employee $employee,DateRange $dateRange) { 
		$doj = strtotime($employee->getEmpJoinDate());  
		$joinDate = date('Y-m-d',$doj); 
		if($joinDate <= '2001-01-01') { 
			//\Zend\Debug\Debug::dump($employee);
			//exit;
			return 1; 
		}
		return 0;
	}
	
	public function getProvidentFundShare(Employee $employee,DateRange $dateRange)
	{
		return $this->companyDeduction->getProvidentFundShare($employee,$dateRange); 
	}
	
	abstract function calculateDeductionAmount(Employee $employee,DateRange $dateRange); 
	
	abstract function calculateDeductionExemption(Employee $employee,DateRange $dateRange);  
	
}