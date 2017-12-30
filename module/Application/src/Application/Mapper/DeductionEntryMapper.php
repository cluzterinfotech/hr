<?php
namespace Application\Mapper;

use Application\Model\PositionTest,
    Application\Mapper\PersonMapper, 
    Application\Contract\EntityCollectionInterface, 
    Application\Contract\DataMapperInterface, 
    Zend\Db\Adapter\Adapter as zendAdapter;
use Application\Entity\CompanyAllowanceEntity;
use Application\Abstraction\AbstractDataMapper;
use Payment\Model\Employee;
use Payment\Model\DateRange;
use Zend\Db\Sql\Where;
use Payment\Model\Company; 

class DeductionEntryMapper extends AbstractDataMapper {
	
	protected $entityTable = "DeductionCompany";  
	
	protected $companyId; 
	
	public function __construct(zendAdapter $adapter, 
			EntityCollectionInterface $collection,$sm,$entityTable = null) { 
		parent::__construct($adapter,$collection,$sm,$entityTable); 
    } 
	
	protected function loadEntity(array $row) { 
	    $employee = new Employee(); 
	    $employee->setId($row['id']); 
	    $employee->setEmployeeNumber($row['employeeNumber']); 
	    $employee->setSalaryGradeId($row['lkpSalaryGradeId']);  
	    $employee->setEmpPersonalInfoId( 
	    		$this->person->fetchById($row['empPersonalInfoId'])  
	    );  
	    return $employee;  
	} 
	
	public function employeeDeductionAmount(Employee $employee,DateRange $dateRange,$tableName) { 
		$adapter = $this->adapter; 
		$qi = function($name) use ($adapter) { 
			return $adapter->platform->quoteIdentifier($name); 
		}; 
		$fp = function($name) use ($adapter) { 
			return $adapter->driver->formatParameterName($name); 
		}; 
		$where = " (1=1) "; 
		$where .= " and c.employeeId = '".$employee->getEmployeeNumber()."' ";
		$where .= " and c.effectiveDate >= '".$dateRange->getFromDate()."' ";
		$where .= " and c.effectiveDate <= '".$dateRange->getToDate()."' ";
		$order = " order by c.effectiveDate,c.id ASC";
		$statement = $adapter->query("SELECT effectiveDate, amount
                                       FROM " . $qi($tableName) . " AS c
	    where  $where   $order"); 
		//echo $statement->getSql(); 
		//exit;
		$results = $statement->execute(); 
		return $this->calculateValue($results,$dateRange);  
	} 	
	
	public function employeeExemptionAmount(Employee $employee,DateRange $dateRange,$tableName) {
		return 0; 
		/* @note the returned value is exemption date, for name consistency 
		 * i am using allowance date
		 */ 
		// @todo have to work on table name 
		$adapter = $this->adapter; 
		$qi = function($name) use ($adapter) { 
			return $adapter->platform->quoteIdentifier($name); 
		}; 
		$fp = function($name) use ($adapter) { 
			return $adapter->driver->formatParameterName($name); 
		}; 
		$where = " (1=1) ";
		$where .= " and c.employeeId = '".$employee->getEmployeeNumber()."' ";
		$where .= " and c.effectiveDate >= '".$dateRange->getFromDate()."' ";
		$where .= " and c.effectiveDate <= '".$dateRange->getToDate()."' ";
		
		$statement = $adapter->query("SELECT effectiveDate, amount
                                       FROM " . $qi($tableName) . " AS c
	    where  $where  "); 
		//echo $statement->getSql(); 
		//exit; 
		$results = $statement->execute(); 
		return $this->calculateValue($results); 
	} 
	
	public function employeePfContribution(Employee $employee,DateRange $dateRange) {
		return 25; 
	}
	
	public function companyPfContribution(Employee $employee,DateRange $dateRange) {
		return 25;
	}
	
}