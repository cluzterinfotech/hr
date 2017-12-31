<?php

namespace Application\Mapper;

use Application\Abstraction\AbstractDataMapper;
use Application\Contract\EntityCollectionInterface;
use Application\Entity\CompanyDeductionEntity;
use Payment\Model\Company;
use Payment\Model\DateRange;
use Payment\Model\Employee;
use Zend\Db\Adapter\Adapter as zendAdapter;

class CompanyDeductionMapper extends AbstractDataMapper {
	
	protected $entityTable = "CompanyDeduction";
	protected $companyId;
	protected $deductionId;
	
	public function __construct(zendAdapter $adapter, 
			EntityCollectionInterface $collection,$sm
			,$entityTable = null) {
		$this->companyId = new CompanyMapper($adapter,$collection);
		$this->deductionId = new DeductionMapper($adapter, $collection);
		parent::__construct($adapter,$collection,$sm,$entityTable);
	}
	
	protected function loadEntity(array $row) {
	    $companyDeduction = new CompanyDeductionEntity();
	    $companyDeduction->setId($row['id']);
	    $companyDeduction->setCompanyId($this->companyId->fetchById($row['id']));
	    $companyDeduction->setDeductionId($this->deductionId->fetchById($row['deductionId']));
	    return $companyDeduction; 
	}
    
	public function getPaysheetCompulsoryDeduction(Company $company,DateRange $dateRange) {
		return array(
				'SocialInsurance' => 'SocialInsurance', 
				'ProvidentFund'   => 'ProvidentFund', 
				 
				'Zakat'           => 'Zakat', 
		);  
	} 
	
	public function getIncometaxExemptedDeduction(Company $company,DateRange $dateRange) {
		return array('SocialInsurance' => 'SocialInsurance',
				     'ProvidentFund' => 'ProvidentFund');
	}
	
	public function getPaysheetNormalDeduction(Company $company,DateRange $dateRange) {
		return array(
				     'Cooperation'      => 'Cooperation',
		        	 'Zamala'           => 'Zamala',
		        	 'UnionShare'       => 'UnionShare',
		        	 'KhartoumUnion'    => 'KhartoumUnion',
				     'OtherDeduction'   => 'OtherDeduction',
				     'Absenteeism'      => 'Absenteeism',
				     'Punishment'       => 'Punishment',
		            ); 
	}
	
	public function getCompanyContributionDeduction(Company $company,DateRange $dateRange) {
		return array(
				'SocialInsuranceCompany' => 'SocialInsuranceCompany',
				'ProvidentFundCompany'   => 'ProvidentFundCompany'
		);
	}
	
	public function getAdvancePaymentDeduction(Company $company,DateRange $dateRange) {
		return array(
				//'AdvanceHousing' => 'AdvanceHousing',
				'AdvanceSalary'  => 'AdvanceSalary',
				'PersonalLoan'   => 'PersonalLoan',
				'OverPayment'    => 'OverPayment',
				'PhoneDeduction' => 'PhoneDeduction',
		); 
	} 
	
	public function getTax($taxableIncome) {
		if($taxableIncome <= 0) { 
			return 0; 
		} 
		$amount = 0; 
		$sum = 0;
		$per = 0;
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('i' => 'IncomeTaxMst'))
		       ->columns(array('isActive'))
		       ->join(array('d' => 'IncomeTaxDtls'),'i.id = d.incomeTaxMstId',
				      array('lower'=>'taxLowLimit','upper'=>'taxUpperLimit',
					        'per'=>'taxPercentage'))
			   ->where(array('i.isActive' => 1))
			   ->order('d.taxGrade'); 
		;
		$sqlString = $sql->getSqlStringForSqlObject($select); 
		//echo $sqlString;
		$results = $this->adapter->query($sqlString)->execute();  
		foreach ($results as $r) {  
			/*if ($taxableIncome >= $r['upper']) { 
				$x = ($r['upper'] - $r['lower'] + 0.01) * $r['per']; 
				$sum += $x; 
			} else { 
				$x = ($taxableIncome - $r['lower'] + 0.01) * $r['per']; 
				$sum += $x; 
				break; 
			}*/ 
		    if ($taxableIncome >= $r['lower'] && $taxableIncome <= $r['upper']) { 
			    $per = $r['per']; 
			   
			} 
		} 
		$val = 0; 
		if($per > 0) {
		    $val = 2.5; 
		}
		$amount = ($taxableIncome * $per) + $val; 
		return $amount;
		//return $sum; 
	} 
	
	/*public function getOverPaymentDeduction(Employee $employee,DateRange $dateRange) {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('o' => 'OverPayment'))
		       ->columns(array('id','amount','employeeNumber','deductionDate','isDeducted')) 
		       ->where(array('employeeId' => $employee->getEmployeeNumber() )) 
		       ->where(array('isDeducted' => $employee->getEmployeeNumber() ))
		; 
		$sqlString = $sql->getSqlStringForSqlObject($select); 
		$results = $this->adapter->query($sqlString)->execute()->current(); 
		if($results) {
			return $results['amount']; 
		}
	}*/  
	
	public function getProvidentFundShare(Employee $employee,DateRange $dateRange) {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('p' => 'ProvidentFundShare'))
		       ->columns(array('id','employeeId','employeeShare','companyShare')) 
		       ->where(array('employeeId' => $employee->getEmployeeNumber() )) 
		; 
		$sqlString = $sql->getSqlStringForSqlObject($select); 
		$results = $this->adapter->query($sqlString)->execute()->current(); 
		return $results;  
	} 
} 