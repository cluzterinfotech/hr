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

class EmployeeAllowanceAmountService {
	
	protected $adapter;
	protected $collection;
	protected $employeeAllowanceAmountMapper;
	protected $calculateAmount;
    
	public function __construct(Adapter $adapter, EntityCollectionInterface $collection) {
		$this->adapter = $adapter;
		$this->collection = $collection;
		$this->employeeAllowanceAmountMapper = new EmployeeAllowanceAmountMapper($adapter, $collection);
		$this->calculateAmount = new CalculateAmount(); 
	}
        
	public function fetchAmountByAllowance($allowanceName,DateRange $dateRange) { 
		$mapper = $this->employeeAllowanceAmountMapper; 
		$mapper->setEntityTable($allowanceName);
		$condition = array('employeeId' => '1');
		return $this->calculateAmount->calculate($mapper->fetchAll($condition),$dateRange); 
	}
	
	public function fetchExemptionByAllowance($allowanceName,DateRange $dateRange) {
		$mapper = $this->employeeAllowanceAmountMapper;
		$mapper->setEntityTable($allowanceName);
		$condition = array('employeeId' => '1');
		return $this->calculateAmount->calculate($mapper->fetchAll($condition),$dateRange);
	}
	
    
}
