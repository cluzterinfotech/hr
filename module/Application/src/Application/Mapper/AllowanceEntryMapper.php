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

class AllowanceEntryMapper extends AbstractDataMapper {
	
	protected $entityTable = "AllowanceCompany";  
	
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
	
	public function getSpecialAmountList(DateRange $dateRange) { 
	    $adapter = $this->adapter;
	    $qi = function($name) use ($adapter) {
	        return $adapter->platform->quoteIdentifier($name);
	    };
	    $fp = function($name) use ($adapter) {
	        return $adapter->driver->formatParameterName($name);
	    };
	    $where = " (1=1) ";
	    // $where .= " and c.employeeId = '".$employee->getEmployeeNumber()."' ";
	    $where .= " and c.effectiveDate >= '".$dateRange->getFromDate()."' ";
	    $where .= " and c.effectiveDate <= '".$dateRange->getToDate()."' ";
	    //$order = " order by c.effectiveDate,c.id ASC";
	    $statement = $adapter->query("SELECT *
                                       FROM " . $qi('AllowanceSpecialAmount') . " AS c
	    where  $where   ");
	    //echo $statement->getSql();
	    // exit;
	    return $statement->execute();  
	}
	
	public function employeeAllowanceAmount(Employee $employee,DateRange $dateRange,$tableName) { 
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
	    // exit; 
		$results = $statement->execute(); 
		return $this->calculateValue($results,$dateRange);  
	} 	
	
	public function getLastAmount(Employee $employee,DateRange $dateRange,$tableName) {
		$adapter = $this->adapter; 
		$qi = function($name) use ($adapter) { 
			return $adapter->platform->quoteIdentifier($name); 
		}; 
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		}; 
		$employeeNumber = $employee->getEmployeeNumber(); 
		$statement = $adapter->query("select top 1 id,amount from ".$qi($tableName)." 
			where employeeId  = '".$employeeNumber."'  
			order by id desc	
		");    
		//echo $statement->getSql();
		//exit; 
		$results = $statement->execute()->current();  
		if($results['amount']) { 
			return $results['amount']; 
			//$salaryInfo = array('oldInitial' => $results['amount']);
			//return $salaryInfo;
		} 
		return 0; 
		// $salaryInfo = array('oldInitial' => 0); 
		// return $salaryInfo;
	}
	
	public function employeeExemptionAmount(Employee $employee,DateRange $dateRange,$tableName) {
		/* @note the returned value is exemption date, for name consistency 
		 * i am using allowance date
		 */ 
		
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		};
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};
		$where = " (1=1) ";
		//$where .= " and c.employeeId = '".$employee->getEmployeeNumber()."' ";
		//$where .= " and c.effectiveDate >= '".$dateRange->getFromDate()."' ";
		$where .= " and a.allowanceName = '".$tableName."' ";
		
		$statement = $adapter->query("SELECT top 1 exemptedAmount
                                       FROM " . $qi('Allowance') . " AS a
				where  $where  ");
		//echo $statement->getSql();
		//exit;
		$results = $statement->execute()->current();
		if($results) {
		    return $results['exemptedAmount'];
		} 
		return 0;
		// @todo have to work on table name 
		/*$adapter = $this->adapter; 
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
		return $this->calculateValue($results);*/ 
	} 
	
	/*
	public function companyAllowanceAmount(Company $company,DateRange $dateRange,$tableName) {
		// @todo have to work on complete query
		$results = 1800;
		$adapter = $this->adapter; 
		$qi = function($name) use ($adapter) { 
			return $adapter->platform->quoteIdentifier($name); 
		}; 
		$fp = function($name) use ($adapter) { 
			return $adapter->driver->formatParameterName($name); 
		}; 
		$where = " (1=1) ";
		$where .= " and c.companyId = '".$company->getId()."' ";
		$where .= " and c.effectiveDate >= '".$dateRange->getFromDate()."' ";
		$where .= " and c.effectiveDate <= '".$dateRange->getToDate()."' ";
		
		$statement = $adapter->query("SELECT effectiveDate, amount
                                       FROM " . $qi($tableName) . " AS c
	    where  $where  ");
		//echo $statement->getSql();
		$results = $statement->execute();
		return $this->calculateValue($results);
	}
	
	public function companyExemptionAmount(Company $company,DateRange $dateRange,$tableName) {
		// @todo have to work on query and table name
		$adapter = $this->adapter; 
		$qi = function($name) use ($adapter) { 
			return $adapter->platform->quoteIdentifier($name); 
		}; 
		$fp = function($name) use ($adapter) { 
			return $adapter->driver->formatParameterName($name); 
		}; 
		$where = " (1=1) ";
		$where .= " and c.companyId = '".$company->getId()."' ";
		$where .= " and c.effectiveDate >= '".$dateRange->getFromDate()."' ";
		$where .= " and c.effectiveDate <= '".$dateRange->getToDate()."' ";
		
		$statement = $adapter->query("SELECT effectiveDate, amount
                                       FROM " . $qi($tableName) . " AS c
	    where  $where  ");
		//echo $statement->getSql(); 
		$results = $statement->execute(); 
		return $this->calculateValue($results); 
	}
	*/
	
}