<?php 

namespace Payment\Mapper;

use Application\Abstraction\AbstractDataMapper,  
    Zend\Db\Adapter\Adapter as zendAdapter,
    Employee\Model\Location;
use Employee\Model\EmployeeLocation;
use Payment\Model\Company;
use Payment\Model\DateRange;
use Employee\Model\NewEmployee;

class DifferenceMapper extends AbstractDataMapper {
	
	protected $entityTable = "DifferenceArrears"; 
	
	protected $mainTable = "FinalEntitlement"; 
        	
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
	
	public function insertLaMst($mstArray) { 
		$this->setEntityTable($this->laMstTable); 
		return $this->insert($mstArray);  
	} 
	
	public function removedifference(Company $company) { 
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
		       ->join(array('m' => 'EmpEmployeeInfoMain'),
		    		'm.employeeNumber = e.employeeId',
				   array('employeeName'))  
			//->where(array('isActive' => 1))
			   ->order('employeeName asc')
	    ; 
	    // echo $sql->getSqlStringForSqlObject($select);
	    // exit;
	    return $select; 
	} 
	
	public function getLeaveAllowanceEmployeeList(Company $company) { 
		$sql = $this->getSql(); 
		$select = $sql->select(); 
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('employeeId')) 
		       ->where(array('companyId' => $company->getId())) 
	    ;     
	    // echo $sql->getSqlStringForSqlObject($select); 
	    // exit; 
	    $sqlString = $sql->getSqlStringForSqlObject($select); 
		$results = $this->adapter->query($sqlString)->execute(); 
		return $results; 
	} 
	
	public function isDifferenceClosed(Company $company,DateRange $dateRange) {
		return 0; 
		/*$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		};
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};
		$statement = $adapter->query("select top 1 id from ".$qi('DifferenceArrears')." where
					differenceDate  >= '".$dateRange->getFromDate()."' and
					differenceDate  <= '".$dateRange->getToDate()."' and
					company   = '".$company->getId()."' and
				    differenceClosed = 1
		");
		// echo $statement->getSql();
		// exit;
		$results = $statement->execute()->current();
		if($results['id']) {
			return 1;
		}
		return 0;*/ 
	} 
	 
	public function differenceDescription(Company $company) {
		// $sql = $this->getSql(); 
		// $select = $sql->select(); 
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		};
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};
		$statement = $adapter->query("select shortDescription from ".$qi('DifferenceArrears')." where
				isClosed = 0  and 
				companyId   = '".$company->getId()."'    
				group by shortDescription   
		"); 
		/*differenceDate  >= '".$dateRange->getFromDate()."' and
					differenceDate  <= '".$dateRange->getToDate()."' and
					company   = '".$company->getId()."' and
					*/
		// echo $statement->getSql(); 
		// exit; 
		$results = $statement->execute(); 
		return $this->toArrayList($results,'shortDescription','shortDescription');
		/*if($results['id']) {
			return 1;
		}
		return 0;
		
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('id','employeeNumber',
				               'empLocation','employeeName'))
				//->join(array('ep' => 'EmpPersonalInfo'),'ep.id = e.empPersonalInfoId',
		        //array('employeeName'))
		        //->where(array('isConfirmed' => 0))
		        // @todo istakenfinalentitlement 0
		        //->where(array('isActive' => 1))
		        ->where(array('companyId' => $company->getId()))
		        ->order('employeeName asc')
		; 
		$sqlString = $sql->getSqlStringForSqlObject($select);
		// echo $sqlString;
		// exit;
		$results = $this->adapter->query($sqlString)->execute();
		return $this->toArrayList($results,'employeeNumber','employeeName');*/ 
	}
	
	public function closeThisDifference(Company $company,$description) { 
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		};
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};
		$statement = $adapter->query("update  ".$qi('DifferenceArrears')." set
				    isClosed = 1 where
				    shortDescription  = '".$description."' and
					companyId   = '".$company->getId()."'
		"); 
		// echo $statement->getSql(); 
		// exit; 
		$statement->execute();  
	} 
	
	public function getPaidDifferenceAmount($employeeId,DateRange $dateRange,$name,$type) { 
		//return 0;
		// @todo convert to array and return 
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		};
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};
		$statement = $adapter->query("select sum($name) as amount from ".$qi('DifferenceArrears')." 
				    where employeeNumber   = '".$employeeId."'
				    and differenceDate  >= '".$dateRange->getFromDate()."' 
				    and differenceDate  <= '".$dateRange->getToDate()."'
		");  
		//echo $statement->getSql(); 
		//exit; 
		$row = $statement->execute()->current(); 
		if($row['amount']) {
			return $row['amount'];   
		}   
		return 0;     
	}  
	
	public function getDifferenceReport(Company $company,array $param=array()) {
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		};
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};
		$where = " (1=1) ";
		//$fromto = $this->getFromTo($param['month'],$param['diffShortDescription']);
		//\Zend\Debug\Debug::dump($fromto);
		//exit;
		//$fromDate = $fromto['fromDate'];
		//$toDate = $fromto['toDate'];
		$where .= " and c.shortDescription = '".$param['diffShortDescription']."' ";
		//$where .= " and c.paysheetDate >= '".$fromDate."' ";
		//$where .= " and c.paysheetDate <= '".$toDate."' ";
		$where .= " group by employeeName  ";
		$where .= " order by employeeName asc";
		
		//id
		//differenceDate
		//companyId
		//isClosed
		//shortDescription
		
		$statement = $adapter->query("SELECT sum(Initial) as Initial,sum(COLA) as COLA,
			sum(Housing) as Housing,sum(Transportation) as Transportation,
		    sum(Representative) as Representative,sum(NatureofWork) as NatureofWork,
			sum(Hardship) as Hardship,sum(Cashier) as Cashier,
			sum(Airport) as Airport,sum(Fitter) as Fitter,sum(OtherAllowance) as OtherAllowance,
		    sum(SpecialAllowance) as SpecialAllowance,sum(President) as President,
			sum(Overtime) as Overtime,sum(OtMeal) as OtMeal,
		    sum(Meal) as Meal,sum(Shift) as Shift,sum(Breakfast) as Breakfast,
			sum(LeaveAllowance) as LeaveAllowance,sum(SocialInsurance) as SocialInsurance,
			sum(ProvidentFund) as ProvidentFund,sum(Zakat) as Zakat,sum(Cooperation) as Cooperation,
		    sum(Zamala) as Zamala,sum(UnionShare) as UnionShare,sum(KhartoumUnion) as KhartoumUnion,
			sum(Telephone) as Telephone,sum(OtherDeduction) as OtherDeduction,
			sum(Absenteeism) as Absenteeism,sum(IncomeTax) as IncomeTax,
			sum(SocialInsuranceCompany) as SocialInsuranceCompany,sum(ProvidentFundCompany) as ProvidentFundCompany,
			sum(Punishment) as Punishment,sum(Eid) as Eid,employeeName
            FROM " . $qi($this->entityTable) . " AS c
		    inner join EmpEmployeeInfoMain e on e.employeeNumber = c.employeeNumber
			where  $where  "); 
		//echo $statement->getSql(); 
		//exit;
		//$results = $statement->execute();
		return $statement->execute();
	}
	
	
}