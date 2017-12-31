<?php
namespace Payment\Model;

use Payment\Model\AbstractCalculate;
use Payment\Model\AllowanceEntryInterface;
use Application\Mapper\AllowanceEntryMapper;
use Zend\Db\Adapter\Adapter as zendAdapter;
use Application\Contract\EntityCollectionInterface;
use Application\Model\CalculateAmount;
use Application\Mapper\DeductionEntryMapper; 

class DeductionEntry implements DeductionEntryInterface { 
	
	protected $deductionEntryMapper;
    
	public function __construct(zendAdapter $adapter, 
			EntityCollectionInterface $collection,$sm, $entityTable = null) {
		$this->deductionEntryMapper = new DeductionEntryMapper($adapter, $collection, $sm); 
	}
	
	public function employeeDeductionAmount(Employee $employee,DateRange $dateRange,$allowanceName) {
		return $this->deductionEntryMapper
		            ->employeeDeductionAmount($employee,$dateRange,$allowanceName);
	}
	
	public function employeeExemptionAmount(Employee $employee,DateRange $dateRange,$allowanceName) {
		return 0;
		return $this->deductionEntryMapper
		            ->employeeExemptionAmount($employee, $dateRange, $allowanceName);
	}
	
	public function getTableName() {
		return "SalaryGradeAllowance";
	} 
} 