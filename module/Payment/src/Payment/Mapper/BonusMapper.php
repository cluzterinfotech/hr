<?php 
namespace Payment\Mapper;

use Application\Abstraction\AbstractDataMapper,  
    Zend\Db\Adapter\Adapter as zendAdapter;
use Application\Entity\EmployeeAllowanceAmountEntity;
use Payment\Model\Company;
use Payment\Model\DateRange;
use Zend\Db\Sql\Predicate\Predicate;

class BonusMapper extends AbstractDataMapper {
	
	protected $entityTable = "Bonus";
    	
	protected function loadEntity(array $row) {
		 $entity = new EmployeeAllowanceAmountEntity();
		 return $this->arrayToEntity($row,$entity);
	}
    
	public function getPaysheetReport(Company $company,array $param=array()) {
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) { 
			return $adapter->platform->quoteIdentifier($name); 
		}; 
		$fp = function($name) use ($adapter) { 
			return $adapter->driver->formatParameterName($name);
		};
		$where = " (1=1) ";
		$fromto = $this->getFromTo($param['month'],$param['year']); 
		//\Zend\Debug\Debug::dump($fromto);
		//exit;
		$fromDate = $fromto['fromDate'];
		$toDate = $fromto['toDate'];
		$where .= " and c.company = '".$company->getId()."' ";
		$where .= " and c.paysheetDate >= '".$fromDate."' ";
		$where .= " and c.paysheetDate <= '".$toDate."' "; 
		$where .= " order by employeeName asc";
		$statement = $adapter->query("SELECT c.*,employeeName
                FROM " . $qi($this->entityTable) . " AS c
				inner join EmpEmployeeInfoMain e on e.employeeNumber = c.employeeNumber
				where  $where  "); 
		//echo $statement->getSql(); 
		//exit; 
		//$results = $statement->execute();
		return $statement->execute();  
	}
	
	public function fetchPaysheetEmployee(Company $company,DateRange $dateRange) {
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		}; 
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};   
		$statement = $adapter->query("select * from ".$qi('Paysheet')." where
					paysheetDate  >= '".$dateRange->getFromDate()."' and 
					paysheetDate  <= '".$dateRange->getToDate()."' and 
					company   = '".$company->getId()."' and 
				    PsheetClosed = 1  
		");   
		//echo $statement->getSql(); 
		//exit; 
		$results = $statement->execute(); 
		if($results) { 
			return $results; 
		}  
		return 0; 
	}
	
	public function isTakenThisMonthSal($employeeNumber,DateRange $dateRange) {
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		};
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};
		$statement = $adapter->query("select top 1 id from ".$qi('Paysheet')." where
					paysheetDate  >= '".$dateRange->getFromDate()."' and
					paysheetDate  <= '".$dateRange->getToDate()."' and
					employeeNumber   = '".$employeeNumber."' and
				    PsheetClosed = 1 
		");
		//echo $statement->getSql();
		//exit;
		$results = $statement->execute()->current();
		if($results['id']) {
			return 1;
		}
		return 0;
	}
	
	public function isPaysheetClosed(Company $company,DateRange $dateRange) {  
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		}; 
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};   
		$statement = $adapter->query("select top 1 id from ".$qi('Paysheet')." where
					paysheetDate  >= '".$dateRange->getFromDate()."' and 
					paysheetDate  <= '".$dateRange->getToDate()."' and 
					company   = '".$company->getId()."' and 
				    PsheetClosed = 1  
		");   
		// echo $statement->getSql(); 
		// exit; 
		$results = $statement->execute()->current(); 
		if($results['id']) { 
			return 1; 
		}  
		return 0;  
	}   
	
	public function removepaysheet(Company $company,DateRange $dateRange) {
		$adapter = $this->adapter; 
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name); 
		}; 
		$fp = function($name) use ($adapter) { 
			return $adapter->driver->formatParameterName($name); 
		}; 
		$statement = $adapter->query("delete from ".$qi('Paysheet')." where
					paysheetDate  >= '".$dateRange->getFromDate()."' and
					paysheetDate  <= '".$dateRange->getToDate()."' and
					company   = '".$company->getId()."' and
				    PsheetClosed = 0
		"); 
		// echo $statement->getSql(); 
		// exit; 
		$statement->execute();  
	} 
	
	public function closeThisPaysheet(Company $company,DateRange $dateRange) {
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		};
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};
		$statement = $adapter->query("update  ".$qi('Paysheet')." set
				    PsheetClosed = 1 where
				    paysheetDate  >= '".$dateRange->getFromDate()."' and
					paysheetDate  <= '".$dateRange->getToDate()."' and
					company   = '".$company->getId()."' 
				   
		"); 
		// echo $statement->getSql(); 
		// exit; 
		$statement->execute(); 
	}   
	
	public function fetchPaysheetView(Company $company,array $param=array()) {
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		};
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};
		$fromto = $this->getFromTo($param['month'],$param['year']);
		//\Zend\Debug\Debug::dump($fromto);
		//exit;
		$fromDate = $fromto['fromDate'];
		$toDate = $fromto['toDate'];
		$statement = $adapter->query("select * from ".$qi('paysheetView')." where
					Paysheet.paysheetDate  >= '".$fromDate."' and
					Paysheet.paysheetDate  <= '".$toDate."' and
					Paysheet.company   = '".$company->getId()."' and
				    Paysheet.PsheetClosed = 1
		");
		//echo $statement->getSql();
		//exit;
		$results = $statement->execute();
		if($results) {
			return $results;
		}
		return 0;
	}
	
	/*public function closePaysheetPFDeduction(Company $company,DateRange $dateRange) { 
	    	
	} 
	
	public function closeAdvancePaymentDeduction(Company $company,DateRange $dateRange) { 
	    	
	}*/ 
	
} 