<?php 

namespace Payment\Mapper; 

use Application\Abstraction\AbstractDataMapper,  
    Zend\Db\Adapter\Adapter as zendAdapter,
    Employee\Model\Location;
use Employee\Model\EmployeeLocation;
use Payment\Model\Company;
use Employee\Model\NewEmployee;
use Payment\Model\DateRange; 
use Zend\Db\Sql\Predicate\Predicate;

class CarRentMapper extends AbstractDataMapper {
	
	protected $entityTable = "CarRent";
	
	//protected $laMstTable = "leaveAllowanceMst"; 
	
	//protected $laDtlsTable = "leaveAllowanceDtls"; 
    	
	protected function loadEntity(array $row) {
		 $entity = new EmployeeLocation();
		 return $this->arrayToEntity($row,$entity);
	}
	
	public function saveEmployeeLeaveAllowance($leaveEmployeeInfo) {
		$sql = $this->getSql();
		$insert = $sql->Insert($this->entityTable);
		$insert->values($leaveEmployeeInfo);
		$sqlString = $sql->getSqlStringForSqlObject($insert);
		$this->adapter->query($sqlString)->execute(); 
	}
	
	public function insertCarRent($mstArray) { 
		$this->setEntityTable($this->entityTable); 
		return $this->insert($mstArray);  
	} 
	
	/*public function insertLaDtls($dtlsArray) { 
		$this->setEntityTable($this->laDtlsTable);  
		return $this->insert($dtlsArray); 
	}*/   
	
	public function removeUnclosedLeaveAllowance(Company $company) { 
		$sql = $this->getSql();
		$delete = $sql->delete($this->laMstTable);
		$delete->where(array(
				'companyId'  => $company->getId(),
				'isClosed'   => 0 
		));  
		$sqlString = $sql->getSqlStringForSqlObject($delete);
		//echo $sqlString; 
		//exit; 
		return $this->adapter->query($sqlString)->execute()->count();  
	} 
	
	public function removeUnclosedCarRent(Company $company) { 
		$sql = $this->getSql();
		$delete = $sql->delete($this->entityTable);
		$delete->where(array(
				'companyId'  => $company->getId(),
				'isClosed'   => 0
		));
		$sqlString = $sql->getSqlStringForSqlObject($delete);
		//echo $sqlString;
		//exit;
		return $this->adapter->query($sqlString)->execute()->count();
	} 
	
	public function selectEmployeeLa() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('id'))
		       ->join(array('c' => 'Company'),'c.id = e.companyId',
		              array('companyName'))
		       ->join(array('m' => 'EmpEmployeeInfoMain'),'m.employeeNumber = e.employeeId',
				   array('employeeName'))
			 			
			//->where(array('isActive' => 1))
			   ->order('employeeName asc')
	    ; 
	    // echo $sql->getSqlStringForSqlObject($select);
	    // exit;
	    return $select;  
	}
	
	public function getCarRentEmployeeList(Company $company) { 
		$sql = $this->getSql(); 
		$select = $sql->select(); 
		
		$select->from(array('g' =>'CarRentPositionGroup'))
		            ->columns(array('positionId','lkpCarRentGroupId')) 
		            ->join(array('lg' => 'lkpCarRentGroup'),'g.lkpCarRentGroupId = lg.id', 
		            		    array('amount'))
		            ->join(array('e' => 'EmpEmployeeInfoMain'),'g.positionId = e.empPosition',
		            			array('employeeNumber','empLocation','empBank','empPosition',
		            			'referenceNumber','accountNumber')) 
		            ->where(array('e.isActive' => 1))  
		            ->where(array('e.companyId' => $company->getId())) 
	    ;          
	    // echo $sql->getSqlStringForSqlObject($select);     
	    // exit;    
	    $sqlString = $sql->getSqlStringForSqlObject($select);    
		$results = $this->adapter->query($sqlString)->execute();    
		return $results;    
	}    
	 
	public function removeEmployeeLeaveAllowance($id) {
		$sql = $this->getSql();
		$delete = $sql->delete($this->entityTable);
		$delete->where(array(
				'id' => $id
		)); 
		//$sqlString = $delete->getSqlString();
		$sqlString = $sql->getSqlStringForSqlObject($delete);
		return $this->adapter->query($sqlString)->execute()->count();
	} 
	
	public function getCarRentReport($from,$to) {
	    $predicate = new Predicate(); 
	    $sql = $this->getSql(); 
		$select = $sql->select(); 
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('*')) 
		       ->join(array('m' => 'EmpEmployeeInfoMain'),'m.employeeNumber = e.employeeId',
		           array('employeeName','employeeNumber')) 
		       ->join(array('p' => 'Position'),'p.id = m.empPosition',
		              array('positionName'))
		       ->join(array('l' => 'Location'),'l.id = m.empLocation',
		              array('locationName'))
		       ->join(array('b' => 'lkpBank'),'b.id = m.empBank',  
		              array('bankName'))
		       ->join(array('g' => 'lkpCarRentGroup'),'g.id = e.lkpCarRentGroupId',
		              array('groupName'))
		     //->where(array('month' =>$param['year'])) 
		->where($predicate->greaterThanOrEqualTo('rentDate',$from))
		->where($predicate->lessThanOrEqualTo('rentDate',$to))
		       //->where(array('isClosed' =>0)) 
	    ;         
		      
	    //echo $sql->getSqlStringForSqlObject($select);   
	    //exit;    
	       
	    $sqlString = $sql->getSqlStringForSqlObject($select);    
		$results = $this->adapter->query($sqlString)->execute();    
		return $results;  
		      
	} 
	
	public function getCarRentReportDtls($from,$to) {
	    $predicate = new Predicate(); 
	    $sql = $this->getSql();
	    $select = $sql->select();
	    $select->from(array('e' => $this->entityTable))
	           ->columns(array('*'))
	           ->join(array('m' => 'EmpEmployeeInfoMain'),'m.employeeNumber = e.employeeId',
	                  array('employeeName','employeeNumber'))
	           ->join(array('p' => 'Position'),'p.id = m.empPosition',
	                  array('positionName'))
	           ->join(array('l' => 'Location'),'l.id = m.empLocation',
	                  array('locationName'))
	           ->join(array('b' => 'lkpBank'),'b.id = m.empBank',
	                  array('bankName'))
	           ->join(array('g' => 'lkpCarRentGroup'),'g.id = e.lkpCarRentGroupId',
	                  array('groupName'))
	                  ->where($predicate->greaterThanOrEqualTo('rentDate',$from))
	                  ->where($predicate->lessThanOrEqualTo('rentDate',$to))
	                        //->where(array('fyYear' =>$param['year']))
	    //->where(array('isClosed' =>0))
	    ;
	    
	    // echo $sql->getSqlStringForSqlObject($select);
	    // exit;
	    
	    $sqlString = $sql->getSqlStringForSqlObject($select);
	    $results = $this->adapter->query($sqlString)->execute();
	    return $results;
	    
	}
	
	public function closeThisCarrent(Company $company,DateRange $dateRange) {
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		};
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};
		$statement = $adapter->query("update  ".$qi($this->entityTable)." set
				    isClosed = 1 where
				    rentDate  >= '".$dateRange->getFromDate()."' and
					rentDate  <= '".$dateRange->getToDate()."' and
					companyId   = '".$company->getId()."'
				
		"); 
		//echo $statement->getSql(); 
		//exit;
		$statement->execute();
	}
	
	public function iscarrentClosed(Company $company,DateRange $dateRange) {
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		};
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};
		$statement = $adapter->query("select top 1 id from ".$qi($this->entityTable)." where
					rentDate  >= '".$dateRange->getFromDate()."' and
					rentDate  <= '".$dateRange->getToDate()."' and
					companyId   = '".$company->getId()."' and
				    isClosed = 1 
		"); 
		// echo $statement->getSql(); 
		// exit;
		$results = $statement->execute()->current();
		if($results['id']) {
			return 1;
		}
		return 0; 
	}
	
	public function getCarRentByFunction(Company $company,array $param=array()) {
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
		$where .= " and c.companyId = '".$company->getId()."' ";
		$where .= " and c.rentDate >= '".$fromDate."' ";
		$where .= " and c.rentDate <= '".$toDate."' ";
		$where .= " and e.empBank = '".$param['bank']."' "; 
		//$where .= " and isClosed = 1 ";
		$where .= " GROUP BY c.companyId, c.rentDate, s.sectionCode";
		$where .= " order by sectionCode asc";
		$statement = $adapter->query("SELECT  s.sectionCode, 
				SUM(c.paidAmount) AS paidAmount
				FROM   CarRent AS c INNER JOIN
				dbo.EmpEmployeeInfoMain AS e ON e.employeeNumber = c.employeeId 
				INNER JOIN Position AS p ON e.empPosition = p.id 
				INNER JOIN Section AS s ON p.section = s.id
				where  $where  ");
				//echo $statement->getSql();
				//exit;
				//$results = $statement->execute();
				return $statement->execute();
	    }
	    
		// by Bank
		public function getCarRentByBank(Company $company,array $param=array()) {
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
					$where .= " and c.companyId = '".$company->getId()."' ";
			$where .= " and c.rentDate >= '".$fromDate."' ";
			$where .= " and c.rentDate <= '".$toDate."' ";
			$where .= " and e.empBank = '".$param['bank']."' ";
		//$where .= " GROUP BY c.company, c.paysheetDate, s.sectionCode";
			$where .= " order by employeeName asc";
					$statement = $adapter->query("SELECT  employeeName,paidAmount
	                as allowance ,bankName,
	                 e.accountNumber,e.referenceNumber
	                FROM   CarRent AS c
	                INNER JOIN EmpEmployeeInfoMain AS e ON e.employeeNumber = c.employeeId
	                INNER JOIN lkpBank AS b ON e.empBank = b.id
	                where  $where  ");
	                //echo $statement->getSql();
	                //exit;
	                //$results = $statement->execute();
	                return $statement->execute();
		}
	
		public function getCarRentBankSummary(Company $company,array $param=array()) {
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
			$where .= " and c.companyId = '".$company->getId()."' ";
			$where .= " and c.rentDate >= '".$fromDate."' ";
			$where .= " and c.rentDate <= '".$toDate."' ";
			//$where .= " and e.empBank = '".$param['bank']."' ";
			$where .= " GROUP BY bankName";
			$where .= " order by bankName asc";
		    $statement = $adapter->query("SELECT sum(paidAmount)
	                as allowance ,bankName 
	                FROM   CarRent AS c
	                INNER JOIN EmpEmployeeInfoMain AS e ON e.employeeNumber = c.employeeId
	                INNER JOIN lkpBank AS b ON e.empBank = b.id
				where  $where  ");
				//echo $statement->getSql();
				//exit;
				//$results = $statement->execute();
		return $statement->execute();
		}
	
}