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
use Application\Mapper\CompanyDeductionMapper;

class CompanyDeductionService {
	
	protected $adapter;
	protected $collection;
	protected $companyDeductionMapper;
    
	public function __construct(Adapter $adapter, EntityCollectionInterface $collection) {
		$this->adapter = $adapter;
		$this->collection = $collection;
		$this->companyDeductionMapper = new CompanyDeductionMapper($adapter, $collection);
	}
        
	public function fetchCompanyDeductionNameList(CompanyEntity $company,DateRange $dateRange) { 
		// @todo fetch with date range
		$array = array(
				'companyId' => $company->getId()
		);
		return $this->companyDeductionMapper->fetchAll($array);
	}
	
	
}
