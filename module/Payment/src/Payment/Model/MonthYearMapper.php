<?php
namespace Payment\Model;

use Application\Abstraction\AbstractDataMapper;   
use Employee\Model\Location; 
use Zend\Db\Sql\Predicate\Predicate;
use Application\Contract\EntityCollectionInterface; 

class MonthYearMapper extends AbstractDataMapper {
	
	protected $entityTable = "MonthYear";  
	
	protected $dateMethods;
	
	public function __construct($adapter,EntityCollectionInterface $collection, 
			$sm,DateMethods $dateMethods) {
		parent::__construct($adapter,$collection,$sm); 
		$this->dateMethods = $dateMethods; 
        
	}
    	
	protected function loadEntity(array $row) { 
        $entity = new DateRange(); 
		return $this->arrayToEntity($row,$entity); 
	}  
	
	
	public function getActiveMonth(Company $company) { 
		
		$info = $this->getActiveMonthInfo($company); 
		//\Zend\Debug\Debug::dump($info); 
		$date = $info['Year']."-".$info['Month']."-01";
		$firstdate = $this->dateMethods->getFirstDayOfDate($date);
		$lastDate = $this->dateMethods->getLastDayOfDate($date); 
		//\Zend\Debug\Debug::dump($date);
		//\Zend\Debug\Debug::dump($lastDate);
		//exit; 
		/*
		"id" => string(1) "1" 
		"Month" => string(1) "1" 
		"Year" => string(4) "2014" 
		"company" => string(1) "1" 
		*/ 
		$row = array(
		    'fromDate'   => $firstdate,
		    'toDate'     => $lastDate,
		); 
		//\Zend\Debug\Debug::dump($row);
		//exit; 
		return $this->loadEntity($row);  
	}
	
	public function getActiveMonthInfo(Company $company) { 
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('id','Month','Year','company'))
		       ->where(array('company' => $company->getId()))
		;
		//echo $select->getSqlString();
		//exit;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		return $this->adapter->query($sqlString)->execute()->current();
	} 
	
	public function appendActiveMonth(Company $company) { 
		
		$activeMonth = $this->getActiveMonth($company);
		$currentMonth = $activeMonth->getFromDate(); 
		
	} 
	
	public function updateActiveMonthForCurrentCompany(Company $company) { 
	    
	    // get active month
	    $activeMonthInfo = $this->getActiveMonthInfo($company); 
	    $id = $activeMonthInfo['id'];
	    $month = $activeMonthInfo['Month']; 
	    $year = $activeMonthInfo['Year']; 
	    
	    if($month == 12) {
	    	return 0; 
	    } else {
	    	$month += 1;
	    }
	    
	    $data = array(
	    	'id'  => $id,
	    	'Month'  => $month	
	    ); 
	    //\Zend\Debug\Debug::dump($data);
	    //exit; 
	    $this->update($data);
	    // ammend active month 
	    // you cant ammend active 12th month
	    // its closing year 
		return 1;
	}
	
	/*
    // Advance housing 
    public function selectAdvanceHousing() {
    	$sql = $this->getSql(); 
    	$select = $sql->select(); 
    	$select->from(array('e' => $this->entityTable))
    	       ->columns(array('id','employeeId','paidDate','advanceFromDate',
                               'advanceToDate','totalMonths','advanceAmount',
                               'taxAmount','netAmount','groupId','isClosed'
    	       )) 
    	       ->join(array('ep' => 'EmpEmployeeInfo'),'ep.employeeNumber = e.employeeId',
    	              array('employeeName' => 'employeeNamex')) 
    	       ->where(array('isClosed' => 0)) 
    	; 
    	//echo $select->getSqlString(); 
    	//exit; 
    	return $select; 
    } 
    
    public function getAdvanceHousingList() {
    	$sql = $this->getSql();
    	$select = $sql->select();
    	$select->from(array('e' => $this->entityTable))
    	       ->columns(array('id','employeeId','paidDate','advanceFromDate',
    			               'advanceToDate','totalMonths','advanceAmount',
    			               'taxAmount','netAmount','groupId','isClosed'
    	       ))
    	       ->join(array('ep' => 'EmpEmployeeInfo'),'ep.employeeNumber = e.employeeId',
    			      array('employeeName' => 'employeeNamex'))
    		   ->where(array('isClosed' => 0))
    	; 
    	//echo $select->getSqlString();
        //exit;
    	$sqlString = $sql->getSqlStringForSqlObject($select); 
    	return $this->adapter->query($sqlString)->execute();  
    } 
    
    public function getThisMonthEmpAdvPaymentDue($advancePayment,$employeeId,
    		DateRange $dateRange) {  
    	$adapter = $this->adapter;  
    	$qi = function($name) use ($adapter) {
    		return $adapter->platform->quoteIdentifier($name);
    	};
    	$fp = function($name) use ($adapter) { 
    		return $adapter->driver->formatParameterName($name); 
    	};   
    	$mst = $advancePayment."Mst"; 
    	$statement = $adapter->query("select top 1 d.id,d.dueAmount AS dueAmount
    			from ".$qi($mst)." as m 
    			INNER JOIN ".$qi($advancePayment)." AS d ON m.id = d.mstId 
    			where 
				deuStartingDate  < '".$dateRange->getFromDate()."' and
			    paidStatus = 0
		");  
    	// echo $statement->getSql();  
    	// exit;  
    	$results = $statement->execute()->current(); 
    	if($results) { 
    		return $results; 
    	} 
    	return 0; 
    } 
     
    public function isHaveAdvanceHousingRecords() {
    	$sql = $this->getSql();
    	$select = $sql->select();
    	$select->from(array('e' => $this->entityTable))
    	       ->columns(array('id')) 
    		   ->where(array('isClosed' => 0))
    	; 
    	//echo $select->getSqlString();
    	//exit; 
    	$sqlString = $sql->getSqlStringForSqlObject($select);
    	$results = $this->adapter->query($sqlString)->execute()->current(); 
    	//var_dump($results);
    	//exit; 
        return $results; 
    } 
	
	public function insertAdvanceHousing($data) {
		$sql = $this->getSql(); 
		$insert = $sql->Insert($this->entityTable);  
		$insert->values($data);
		$sqlString = $sql->getSqlStringForSqlObject($insert); 
		$this->adapter->query($sqlString)->execute();	
	}
	
	public function insertAdvanceHousingMst($data,$tableName = "") {
		$sql = $this->getSql();
		$insert = $sql->Insert('AdvanceHousingMst'); 
		$insert->values($data);
		$sqlString = $sql->getSqlStringForSqlObject($insert);
		$res = $this->adapter->query($sqlString)->execute(); 
		return  $res->getGeneratedValue();
	}
	
	public function insertAdvanceHousingDtls($data,$tableName = "") {
		$sql = $this->getSql(); 
		$insert = $sql->Insert('AdvanceHousingDtls'); 
		$insert->values($data);
		$sqlString = $sql->getSqlStringForSqlObject($insert);
		$this->adapter->query($sqlString)->execute();
	}
	
	public function removeAdvanceHousing($id) { 
		$sql = $this->getSql();
		$delete = $sql->delete($this->entityTable);
		$delete->where(array(
				'id' => $id
		));
		//$sqlString = $delete->getSqlString();
		$sqlString = $sql->getSqlStringForSqlObject($delete);
		return $this->adapter->query($sqlString)->execute()->count();
	}
	
	public function addThisMonthDue($due) { 
		$sql = $this->getSql(); 
		$insert = $sql->Insert('AdvancePaymentBuffer'); 
		$insert->values($due); 
		$sqlString = $sql->getSqlStringForSqlObject($insert); 
		$this->adapter->query($sqlString)->execute(); 
	} 
	
	public function removeThisMonthDue(Company $company) { 
		$sql = $this->getSql();
		$delete = $sql->delete($this->paymentBuffer); 
		$delete->where(array(
				'companyId' => $company->getId() 
		)); 
		//$sqlString = $delete->getSqlString(); 
		$sqlString = $sql->getSqlStringForSqlObject($delete); 
		return $this->adapter->query($sqlString)->execute()->count(); 
	} 
	
	public function getThisMonthDueList(Company $company) { 
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->paymentBuffer))
		       ->columns(array('id','dtlsId','advancePaymentTable'))
		       ->where(array('companyId' => $company->getId()))
		;
		//echo $select->getSqlString();
		//exit;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute();
		//var_dump($results);
		//exit;
		return $results;
	}
	
	public function closeAdvancePaymentDeduction($dtlsId,$advTable) {
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		};
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};
		$statement = $adapter->query("update  ".$qi($advTable)." set
				    paidStatus = 1 where 
					id   = '".$dtlsId."'    
		");  
		// echo $statement->getSql();  
		// exit;  
		$statement->execute();   
	}  
	
	public function removeFromBuffer($bufferId) {
		$sql = $this->getSql();
		$delete = $sql->delete($this->paymentBuffer);
		$delete->where(array(
				'id' => $bufferId
		)); 
		//$sqlString = $delete->getSqlString();
		$sqlString = $sql->getSqlStringForSqlObject($delete);
		return $this->adapter->query($sqlString)->execute()->count();
	}
	*/ 
}