<?php 
namespace Payment\Mapper;

use Application\Abstraction\AbstractDataMapper,  
    Zend\Db\Adapter\Adapter as zendAdapter;
use Application\Entity\EmployeeAllowanceAmountEntity;
use Payment\Model\Company;
use Payment\Model\DateRange;
use Zend\Db\Sql\Predicate\Predicate;

class PaysheetMapper extends AbstractDataMapper {
	
	protected $entityTable = "Paysheet";
    	
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
	// by function 
	public function getPaysheetByFunction(Company $company,array $param=array()) {
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
		$where .= " and e.empBank = '".$param['bank']."' ";
		$where .= " GROUP BY c.company, c.paysheetDate, s.sectionCode";
		$where .= " order by sectionCode asc";
		$statement = $adapter->query("SELECT     s.sectionCode, SUM(c.Initial) AS Initial, 
				SUM(c.COLA) AS COLA, SUM(c.Housing) AS Housing, SUM(c.Transportation) AS Transportation, 
				SUM(c.Representative) AS Representative, 
                SUM(c.NatureofWork) AS NatureofWork, SUM(c.Hardship) AS Hardship, SUM(c.Cashier) AS Cashier, 
				SUM(c.Airport) AS Airport, SUM(c.Fitter) AS Fitter, SUM(c.Shift) AS Shift, SUM(c.OtherAllowance) 
                AS OtherAllowance, SUM(c.SpecialAllowance) AS SpecialAllowance, SUM(c.President) AS President,
				SUM(c.Overtime) AS Overtime, SUM(c.Meal) AS Meal,
				SUM(c.SocialInsurance) AS SocialInsurance,SUM(c.IncomeTax) AS IncomeTax,SUM(c.Zakat) AS Zakat,
				SUM(c.ProvidentFund) AS ProvidentFund,SUM(c.Zamala) AS Zamala,SUM(c.UnionShare) AS UnionShare,
				SUM(c.Telephone) AS Telephone,
				SUM(c.OtherDeduction) AS OtherDeduction,
				SUM(c.KhartoumUnion) AS KhartoumUnion,
				SUM(c.Cooperation) AS Cooperation,
				SUM(c.AdvanceSalary) AS AdvanceSalary,
				SUM(c.PersonalLoan) AS PersonalLoan,
				SUM(c.SocialInsuranceCompany) AS SocialInsuranceCompany,
			    SUM(c.ProvidentFundCompany) AS ProvidentFundCompany
                      FROM   Paysheet AS c INNER JOIN
                      dbo.EmpEmployeeInfoMain AS e ON e.employeeNumber = c.employeeNumber INNER JOIN
                      dbo.Position AS p ON e.empPosition = p.id INNER JOIN
                      dbo.Section AS s ON p.section = s.id
				where  $where  ");
		//echo $statement->getSql();
		//exit;
		//$results = $statement->execute();
		return $statement->execute();
	}

	// by Bank
	public function getPaysheetByBank(Company $company,array $param=array()) {
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
		$where .= " and e.empBank = '".$param['bank']."' ";
		//$where .= " GROUP BY c.company, c.paysheetDate, s.sectionCode";
		$where .= " order by employeeName asc";
		$statement = $adapter->query("SELECT  employeeName,(Initial + COLA+ Housing + Transportation + Representative
                + NatureofWork + Hardship + Cashier + Airport + Fitter + Shift + OtherAllowance + Overtime+ Meal)
				as allowance ,bankName,
				
				(SocialInsurance + IncomeTax + ProvidentFund + Zamala+ UnionShare+Telephone+OtherDeduction
				+ KhartoumUnion + Cooperation + AdvanceSalary + PersonalLoan) as deduction,
				e.accountNumber,e.referenceNumber
                      FROM   Paysheet AS c 
				INNER JOIN EmpEmployeeInfoMain AS e ON e.employeeNumber = c.employeeNumber 
				INNER JOIN lkpBank AS b ON e.empBank = b.id 
				where  $where  ");
		//echo $statement->getSql();
		//exit;
		//$results = $statement->execute();
		return $statement->execute();
	}
	
	public function getPaysheetBankSummary(Company $company,array $param=array()) { 
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
		//$where .= " and e.empBank = '".$param['bank']."' ";
		$where .= " GROUP BY bankName";
		$where .= " order by bankName asc";
		$statement = $adapter->query("SELECT  bankName,sum(Initial + COLA+ Housing + Transportation + Representative
                + NatureofWork + Hardship + Cashier + Airport + Fitter + Shift + OtherAllowance + Overtime+ Meal)
				as allowance,
				
				sum(SocialInsurance + IncomeTax + ProvidentFund + Zamala+ UnionShare+Telephone+OtherDeduction
				+ KhartoumUnion + Cooperation + AdvanceSalary + PersonalLoan) as deduction
                      FROM   Paysheet AS c 
				INNER JOIN EmpEmployeeInfoMain AS e ON e.employeeNumber = c.employeeNumber 
				INNER JOIN lkpBank AS b ON e.empBank = b.id 
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
                    and employeeNumber in ('1100','1032','1025','1172','1058','1276','1294')
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
		//echo $statement->getSql(); 
		//exit; 
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
		//echo $statement->getSql(); 
		//exit; 
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
	
	public function getPayslipReport(Company $company,array $param=array()) {
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
		$employeeId = $param['empId'];
		$where .= " and c.company = '".$company->getId()."' ";
		$where .= " and c.paysheetDate >= '".$fromDate."' ";
		$where .= " and c.paysheetDate <= '".$toDate."' ";
		$where .= " and c.employeeNumber = '".$employeeId."' ";
		$statement = $adapter->query("SELECT c.*,employeeName
                FROM " . $qi($this->entityTable) . " AS c
				inner join EmpEmployeeInfoMain e on e.employeeNumber = c.employeeNumber
				where  $where  ");
		//echo $statement->getSql();
		//exit;
		//$results = $statement->execute();
		return $statement->execute()->current();
	} 
	
	public function getPfList(Company $company,DateRange $dateRange) { 
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		};
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};
		$where = " (1=1) ";
        
		$where .= " and c.company = '".$company->getId()."' ";
		$where .= " and c.paysheetDate >= '".$dateRange->getFromDate()."' ";
		$where .= " and c.paysheetDate <= '".$dateRange->getToDate()."' "; 
		$where .= " and ProvidentFund > 0 "; 
		$statement = $adapter->query("SELECT employeeNumber,c.ProvidentFundCompany,
				c.ProvidentFund,paysheetDate
                FROM " . $qi($this->entityTable) . " AS c
				
				where  $where  "); 
		//echo $statement->getSql();
		//exit;
		//$results = $statement->execute();
		return $statement->execute();
	} 
	
	public function insertPfDed($data) { 
		$this->setEntityTable('pfDeduction');   
		$this->insert($data); 
	}    
	
	/*public function closePaysheetPFDeduction(Company $company,DateRange $dateRange) { 
	    	
	} 
	
	public function closeAdvancePaymentDeduction(Company $company,DateRange $dateRange) { 
	    	
	}*/ 
	
} 