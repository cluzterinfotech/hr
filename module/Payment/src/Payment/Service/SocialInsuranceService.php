<?php

namespace Payment\Service;

use Zend\Db\Adapter\Adapter;
use Application\Entity\CompanyEntity;
use Application\Utility\DateRange;
use Application\Contract\EntityCollectionInterface;

class SocialInsuranceService {
	
	protected $adapter;
	protected $collection;
    
	public function __construct(Adapter $adapter,EntityCollectionInterface $collection) {
		$this->adapter = $adapter; 
		$this->collection = $collection;
	}
	
	public function getAllowanceList(CompanyEntity $company,DateRange $dateRange) {
		return array('initial','cola');
	}
	
	public function getPercentage(CompanyEntity $company,DateRange $dateRange) {
		$percentage = .08;
		return $percentage;
	}
	
	public function getExemption(CompanyEntity $company,DateRange $dateRange) {
		$percentage = .08;
		return $percentage;
	}
	
}