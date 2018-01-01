<?php
namespace Payment\Model;

use Payment\Model\AbstractCalculate;
use Payment\Model\AllowanceEntryInterface;
use Application\Mapper\AllowanceEntryMapper;
use Zend\Db\Adapter\Adapter as zendAdapter;
use Application\Contract\EntityCollectionInterface;
use Application\Model\CalculateAmount;

class AllowanceEntry implements AllowanceEntryInterface { 
	//extends AbstractAllowance {
	
	protected $allowanceEntryMapper;
    // protected $calculateAmount;
	public function __construct(zendAdapter $adapter, 
			EntityCollectionInterface $collection,$sm, $entityTable = null) {
		$this->allowanceEntryMapper = new AllowanceEntryMapper($adapter,$collection,$sm);
	}
	
	public function employeeAllowanceAmount(Employee $employee,
			DateRange $dateRange,$allowanceName) {
		return $this->allowanceEntryMapper
		            ->employeeAllowanceAmount($employee,$dateRange,$allowanceName);
	}
	
	public function employeeExemptionAmount(Employee $employee,
			DateRange $dateRange,$allowanceName) {
		return $this->allowanceEntryMapper
		            ->employeeExemptionAmount($employee, $dateRange, $allowanceName);
	}
	
	public function getLastAmount(Employee $employee,
			DateRange $dateRange,$allowanceName) { 
		return $this->allowanceEntryMapper
		            ->employeeAllowanceAmount($employee,$dateRange,$allowanceName);
	} 
	
	public function getSpecialAmountList(DateRange $dateRange) {
	        return $this->allowanceEntryMapper
	                    ->getSpecialAmountList($dateRange);
	}
	
	/* public function companyAllowanceAmount(Company $company,DateRange $dateRange) {
		return $this->allowanceEntryMapper
		            ->companyAllowanceAmount($company,$dateRange,$this->getTableName());
	}
	
	public function companyExemptionAmount(Company $company,DateRange $dateRange) {
		return $this->allowanceEntryMapper
		            ->companyExemptionAmount($company,$dateRange,$this->getTableName());
	} */
	
	public function getTableName() {
		return "SalaryGradeAllowance";
	} 
} 