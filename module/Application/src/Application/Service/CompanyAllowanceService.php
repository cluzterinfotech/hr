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

class CompanyAllowanceService {
	
	protected $adapter;
	protected $collection;
	protected $companyAllowanceMapper;
    
	public function __construct(Adapter $adapter, EntityCollectionInterface $collection) {
		$this->adapter = $adapter;
		$this->collection = $collection;
		$allowanceType = new AllowanceTypeMapper($adapter, $collection);
		$this->companyAllowanceMapper = new CompanyAllowanceMapper($adapter,$collection,$allowanceType);
	}
           
	public function fetchAllowanceNameList(CompanyEntity $company,DateRange $dateRange) {
        // Allowances inside paysheet
		$array = array(
				'companyId' => $company->getId()
		); 
		return $this->companyAllowanceMapper->fetchAll($array);
	}
}