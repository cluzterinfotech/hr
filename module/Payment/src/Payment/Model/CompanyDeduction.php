<?php 

namespace Payment\Model;

use Zend\Db\Adapter\Adapter,
Application\Contract\EntityInterface,
Application\Contract\EntityCollectionInterface;
use Payment\Model\Company;
use Payment\Model\DateRange;
use Application\Entity\CompanyAllowanceEntity;
use Application\Mapper\CompanyAllowanceMapper;
use Application\Mapper\AllowanceTypeMapper;
use Application\Mapper\CompanyDeductionMapper;

class CompanyDeduction {
    
	protected $adapter;
	protected $collection;
	protected $companyDeductionMapper;
    
	public function __construct(Adapter $adapter, EntityCollectionInterface $collection,$sm) {
	    $this->adapter = $adapter; 
		$this->collection = $collection;
		$this->companyDeductionMapper = new CompanyDeductionMapper($adapter, $collection,$sm);
	}
    
	public function getPaysheetCompulsoryDeduction(Company $company,DateRange $dateRange) { 
		return $this->companyDeductionMapper->getPaysheetCompulsoryDeduction($company, $dateRange);
	}
	
	public function getPaysheetNormalDeduction(Company $company,DateRange $dateRange) {
		return $this->companyDeductionMapper->getPaysheetNormalDeduction($company, $dateRange);
	} 
	
	public function getIncometaxExemptedDeduction(Company $company,DateRange $dateRange) {
		return $this->companyDeductionMapper->getIncometaxExemptedDeduction($company, $dateRange);
	}
	
	public function getAdvancePaymentDeduction(Company $company,DateRange $dateRange) {
		return $this->companyDeductionMapper->getAdvancePaymentDeduction($company, $dateRange);
	}
	
	public function getCompanyContributionDeduction(Company $company,DateRange $dateRange) {
		return $this->companyDeductionMapper->getCompanyContributionDeduction($company, $dateRange);
	}
	
	/*public function getOverPaymentDeduction(Employee $employee,DateRange $dateRange) {
		return $this->companyDeductionMapper->getOverPaymentDeduction($employee,$dateRange);
	}*/
	
	public function getTax($taxableIncome) {
		return $this->companyDeductionMapper->getTax($taxableIncome); 
	}
	
	public function getProvidentFundShare(Employee $employee,DateRange $dateRange) {
		return $this->companyDeductionMapper->getProvidentFundShare($employee,$dateRange); 
	}
}