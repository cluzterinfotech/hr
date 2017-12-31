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
use Application\Mapper\EmployeeAllowanceAmountMapper;
use Application\Model\CalculateAmount;

class EmployeeDeductionAmountService { 
	
	protected $adapter;
	protected $collection;
	protected $employeeAllowanceAmountMapper;
	protected $calculateAmount;
	protected $services;
	
	public function __construct(Adapter $adapter, EntityCollectionInterface $collection,$sm) {
		$this->adapter = $adapter;
		$this->collection = $collection;
		// $this->employeeAllowanceAmountMapper = new EmployeeAllowanceAmountMapper($adapter, $collection);
		$this->calculateAmount = new CalculateAmount(); 
		$this->services = $sm;
	}
        
	public function fetchAmountByDeduction($deductionClass,CompanyEntity $company,DateRange $dateRange) { 
		$deduction = $this->services->get($deductionClass);
		return $deduction->getAmount($company,$dateRange);
		
		
		//$mapper = $this->employeeAllowanceAmountMapper;
		//$mapper->setEntityTable($deductionClass);
		// @todo 
		$fiscalYear = $this->services->get('fiscalYear');
		//var_dump($fiscalYear);
		//exit;
		$condition = array('employeeId' => '1');
		// return "";
		return $this->calculateAmount->calculate($mapper->fetchAll($condition),$dateRange); 
		
	}
	
}
