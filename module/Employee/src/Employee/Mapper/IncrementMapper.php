<?php

namespace Employee\Mapper;

use Application\Abstraction\AbstractDataMapper,  
    Zend\Db\Adapter\Adapter as zendAdapter,
    Employee\Model\Location;
use Payment\Model\Company;
use Zend\Db\Sql\Expression;
use Allowance\Model\IncrementCriteria;
use Allowance\Model\QuartileRating;
use Allowance\Model\SalaryStructure;
use Employee\Model\AnnivInc;
use Zend\Db\Sql\Predicate\Predicate;
use Payment\Model\DateRange;
use Zend\Db\Sql\Where;

class IncrementMapper extends AbstractDataMapper {
	
	protected $entityTable = "EmployeeIncrement"; 
	
	protected $employeeRatingBuff = 'EmployeeRatingBuffer';  
	
	protected $salaryStructure = 'SalaryStructureValue';  
	
	protected $quartileRating = 'IncrementRatingQuartile'; 
    
	protected $incrementCriteria = 'IncrementCriteria'; 
	
	protected $annivIncBuff = 'IncrementAnniversaryBuffer'; 
    	
	protected function loadEntity(array $row) {
		 $entity = new IncrementCriteria(); 
		 return $this->arrayToEntity($row,$entity);
	}
	
	public function locationList() { 
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('id','locationName'))
		; 
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute();
		return $this->toArrayList($results,'id','locationName');
		//return $select;
	}
	
	public function getLocationAllowanceList($locationId,$company) {
	    
		$sql = $this->getSql(); 
		$select = $sql->select(); 
		$select->from(array('e' => 'LocationAllowance'))
		       ->columns(array('id','allowanceId',
				               'companyId','locationId'))
			   ->where(array('companyId' => $company->getId()))
			   ->where(array('locationId' => $locationId))
		; 
		$sqlString = $sql->getSqlStringForSqlObject($select);
		// echo $sqlString;
		// exit;
		return $this->adapter->query($sqlString)->execute(); 
		
	} 
	
	public function removePreviousCalculation() {
	    $sql = $this->getSql();
	    $delete = $sql->delete($this->entityTable); 
	    //$array = $this->entityToArray($entity);
	    //$id = $array['id'];
	    //unset($array['id']);
	    $delete->where(array(
	        'applied' => 0
	    ));
	    //$sqlString = $delete->getSqlString();
	    $sqlString = $sql->getSqlStringForSqlObject($delete);
	    //echo $sqlString; 
	    //exit; 
	    return $this->adapter->query($sqlString)->execute()->count(); 
	    
	}
	
	public function incReport($year,$companyId) {
	    $sql = $this->getSql();
	    $select = $sql->select();
	    $select->from(array('e' => $this->entityTable))
    	       ->columns(array('*'))
    	       ->join(array('ep' => 'EmpEmployeeInfoMain'),'ep.employeeNumber = e.employeeNumber',
    	           array('employeeName')) 
    	       ->join(array('s' => 'lkpSalaryGrade'),'e.salaryGradeId = s.id',
    	              array('salaryGrade'),'left') 
    	       ->where(array('e.companyId' => $companyId))
    	       ->where(array('Year' => $year))
	     ;  
	     $sqlString = $sql->getSqlStringForSqlObject($select); 
	        // echo $sqlString;
	        // exit;
	     return $this->adapter->query($sqlString)->execute();   
	}  
	
	public function getIncrementElegibleList($companyId) {
	    $adapter = $this->adapter;
	    $qi = function($name) use ($adapter) {
	        return $adapter->platform->quoteIdentifier($name);
	    };
	    $fp = function($name) use ($adapter) {
	        return $adapter->driver->formatParameterName($name);
	    };
	    $statement = $adapter->query("
	        select employeeNumber,empSalaryGrade from ".$qi('EmpEmployeeInfoMain')." m 
            where isActive = 1 and companyId = '".$companyId."'	        
		"); 
	    $results = $statement->execute(); 
	    if($results) {
	        return $results;
	    }
	    return array();   
	} 
	
	public function getMaxQuartileOne($sgId) {
		 
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->salaryStructure))
		       ->columns(array('id','maxValue'))
			   //->where(array('companyId' => $company->getId()))
			   ->where(array('salaryGradeId' => $sgId))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		// echo $sqlString;
		// exit;
		$row = $this->adapter->query($sqlString)->execute()->current(); 
		
		if($row['maxValue']) {
			return $row['maxValue']; 
		}
		return 0; 
	}
	
	public function isHaveIncrement(Company $company,DateRange $dateRange) {  
	    $companyId = $company->getId(); 
	    $year = date('Y'); 
	    $sql = $this->getSql();
	    $select = $sql->select();
	    $select->from(array('e' => $this->entityTable))
	           ->columns(array('id'))
	         //->where(array('companyId' => $company->getId()))
	           ->where(array('applied' => 1))
	           ->where(array('year' => $year))
	           ->where(array('companyId' => $companyId))
	    ; 
	    $sqlString = $sql->getSqlStringForSqlObject($select); 
	    // echo $sqlString; 
	    // exit; 
	    $row = $this->adapter->query($sqlString)->execute()->current(); 
	    if($row['id']) { 
	        return 1;  
	    } 
	    return 0;   
	}  
	
	public function isHaveAnnivIncrement(Company $company,DateRange $dateRange) { 
		$res = $this->getAnnivIncrementEmployeeList($company,$dateRange); 
		if($res) { 
			return 1; 
		} 
		return 0; 
	}
	
	public function getAnnivIncrementEmployeeList(Company $company,DateRange $dateRange) {
		$from = strtotime($dateRange->getFromDate());
		$to = strtotime($dateRange->getToDate()); 
		$time = strtotime("-1 year", $from);
		$fromOne = date("Y-m-d", $time);
		$toTime = strtotime("-1 year", $to);
		$toOne = date("Y-m-d", $toTime);
		$predicate = new Predicate();
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'EmpEmployeeInfoMain'))
		       ->columns(array('id','employeeNumber'))
		       ->where($predicate->greaterThanOrEqualTo('empJoinDate',$fromOne))
		       ->where($predicate->lessThanOrEqualTo('empJoinDate',$toOne))
		       ->where(array('isActive' => 1))
		//->where(array('isApproved' => 0))
		//->where($predicate->lessThanOrEqualTo('approvedLevel','approvalLevel'))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString;
		//exit;
		return $this->adapter->query($sqlString)->execute();
	}
	
	public function getAnnivIncrementBufferList(Company $company,DateRange $dateRange) {
		$from = strtotime($dateRange->getFromDate());
		$to = strtotime($dateRange->getToDate());
		//$time = strtotime("-1 year", $from);
		$fromOne = date("Y-m-d", $from);
		//$toTime = strtotime("-1 year", $to);
		$toOne = date("Y-m-d", $to);
		$predicate = new Predicate();
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->annivIncBuff))
		       ->columns(array('id','employeeId','newAmount','oldAmount'))
		       //->where($predicate->greaterThanOrEqualTo('addedDate',$fromOne))
		       //->where($predicate->lessThanOrEqualTo('addedDate',$toOne))
		       //->where(array('isActive' => 1))
		//->where(array('isApproved' => 0))
		//->where($predicate->lessThanOrEqualTo('approvedLevel','approvalLevel'))
		; 
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString;
		//exit;
		return $this->adapter->query($sqlString)->execute();
	}
	
	public function getAnnivIncPercentage(Company $company,DateRange $dateRange) { 
		$year = date("Y");  
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->incrementCriteria))
		       ->columns(array('id','incrementAveragePercentage'))
		     //->where(array('companyId' => $company->getId()))
		       ->where(array('Year' => $year))
		; 
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString;
		//exit;
		$row = $this->adapter->query($sqlString)->execute()->current();
		
		if($row['incrementAveragePercentage']) {
			return $row['incrementAveragePercentage'];
		}
		return 0; 
	}
	
	public function getMidValue($sgId) { 
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->salaryStructure))
		       ->columns(array('id','midValue'))
		     //->where(array('companyId' => $company->getId()))
		       ->where(array('salaryGradeId' => $sgId))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		// echo $sqlString;
		// exit;
		$row = $this->adapter->query($sqlString)->execute()->current();
	
		if($row['midValue']) {
			return $row['midValue'];
		}
		return 0; 
	}
	
	public function selectEmployeeRating(Company $company) { 
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->employeeRatingBuff))
		       ->columns(array('id','empRating','year'))
		       ->join(array('ep' => 'EmpEmployeeInfoMain'),'ep.employeeNumber = e.employeeId',
		       		array('employeeName')) 
				//->where(array('companyId' => $company->getId()))
		;
		return $select; 
	}
	
	public function getEmployeeRating($year,$employeeId) {
	    $sql = $this->getSql();
	    $select = $sql->select();
	    $select->from(array('e' => $this->employeeRatingBuff))
        	    ->columns(array('id','empRating'))
        	    //->where(array('companyId' => $company->getId()))
	            ->where(array('employeeId' => $employeeId))
	    ; 
	    $sqlString = $sql->getSqlStringForSqlObject($select);
	    // echo $sqlString;
	    // exit;
	    $row = $this->adapter->query($sqlString)->execute()->current();
	    
	    if($row['empRating']) {
	        return $row['empRating']; 
	    }
	    return 0; 
	}
	
	public function selectSalaryStructure(Company $company) {
			
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->salaryStructure))
		       ->columns(array('id','minValue','midValue','maxValue'))
		       ->join(array('s' => 'lkpSalaryGrade'),'s.id = e.salaryGradeId',
				      array('salaryGrade'))
		       ->order('salaryGrade asc')
		;
		//echo $select;
		//exit;
		return $select;
	}
	
	public function selectIncAnniv(Company $company) {
			
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('i' => $this->annivIncBuff))
		       ->columns(array('id','addedDate','newAmount','employeeId','oldAmount'))
		       ->join(array('e' => 'EmpEmployeeInfoMain'),'e.employeeNumber = i.employeeId',
		              array('employeeName')) 
			   ->order('employeeName asc')
	    ;
		//echo $select; 
		//exit; 
		return $select; 
	}  
	
	public function selectQuartileRating(Company $company) { 
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->quartileRating)) 
		       ->columns(array('id','Rating','quartileOne',
		       		'quartileTwo','quartileThree','quartileFour'))
		       //->join(array('s' => 'lkpSalaryGrade'),'s.id = e.salaryGradeId',
				      //array('salaryGrade'))
			   ->order('Rating asc')
		;
		//echo $select;  
		//exit;  
		return $select;    
	}   
	
	public function selectIncrementCriteria(Company $company) {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->incrementCriteria))
		       ->columns(array('id','Year'
		       	   ,'joinDate' => new Expression('convert(varchar(12),joinDate,107)')
		       	   ,'confirmationDate' => new Expression('convert(varchar(12),confirmationDate,107)')
		       	   ,'incrementFrom' => new Expression('convert(varchar(12),incrementFrom,107)')
		       	   ,'incrementTo' => new Expression('convert(varchar(12),incrementTo,107)')
                   ,'sickLeaveDays','maximumScale','colaPercentage','incrementAveragePercentage')) 
		       ->order('Year DESC')
		; 
		//echo $select; 
		//exit; 
		return $select; 
	}   
	
	public function fetchCriteriaById($id) {
	    $this->setEntityTable($this->incrementCriteria); 
	    return $this->fetchById($id); 	
	}
	
	public function fetchQuartileRatingById($id) {
		$this->setEntityTable($this->quartileRating); 
		$statement = $this->fetch(array(
				'id' => $id
		) );
		if (!$results = $statement->execute()->current()) {
			return null;
		}
		return $this->loadQuartile($results);
		// return $this->fetchById($id);
	}
	
	public function fetchSalStructureById($id) {
		$this->setEntityTable($this->salaryStructure);
		$statement = $this->fetch(array(
				'id' => $id
		) );
		if (!$results = $statement->execute()->current()) {
			return null;
		}
		return $this->loadSalStructure($results);
		// return $this->fetchById($id);
	}
	
	protected function loadSalStructure(array $row) {
		$entity = new SalaryStructure(); 
		return $this->arrayToEntity($row,$entity);
	}
	
	protected function loadQuartile(array $row) {
		$entity = new QuartileRating(); 
		return $this->arrayToEntity($row,$entity);
	}
	
	public function insertCriteria($entity) {
		$this->setEntityTable($this->incrementCriteria);
		return $this->insert($entity); 
	}
	
	public function updateCriteria($entity) {
		$this->setEntityTable($this->incrementCriteria);
		return $this->update($entity);
	}
	
	public function insertAnnivInc($entity) {
		$this->setEntityTable($this->annivIncBuff); 
		return $this->insert($entity);
	}
	
	public function updateAnnivInc($entity) { 
		//\Zend\Debug\Debug::dump($entity);
		//exit; 
		$this->setEntityTable($this->annivIncBuff); 
		$sql = $this->getSql();
		$update = $sql->Update($this->entityTable);
		$array = $this->entityToArray($entity);
		$id = $array['id'];
		unset($array['id']);
		$update->set($array);
		$update->where(array(
				'id' => $id
		));
		$sqlString = $update->getSqlString();
		//echo $sqlString;
		//exit;
		$sqlString = $sql->getSqlStringForSqlObject($update);
		return $this->adapter->query($sqlString)->execute()->count();
		//return $this->update($entity);
		return $this->update($entity); 
	} 
	
	// removeAnnivIncBuff($id)
	
	public function removeAnnivIncBuff($id) {
		$sql = $this->getSql();
		$delete = $sql->delete($this->annivIncBuff);
		$delete->where(array(
				'id' => $id
		));
		//$sqlString = $delete->getSqlString();
		$sqlString = $sql->getSqlStringForSqlObject($delete);
		return $this->adapter->query($sqlString)->execute()->count();
	}
	
	public function clearPreviousAnnivInc(Company $company,DateRange $dateRange) {
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		};
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};
		$statement = $adapter->query("delete from ".$qi($this->annivIncBuff)."
			where companyId  = '".$company->getId()."' 
			
		");
		$results = $statement->execute();
		if($results) {
			return 1; 
		} 
		return 0; 
	}
	
	public function updateQuartile($entity) {
		$this->setEntityTable($this->quartileRating);
		$sql = $this->getSql();
		$update = $sql->Update($this->entityTable);
		$array = $this->entityToArray($entity);
		$id = $array['id'];
		unset($array['id']);
		$update->set($array);
		$update->where(array(
				'id' => $id
		));
		$sqlString = $update->getSqlString();
		// echo $sqlString;
		// exit;
		$sqlString = $sql->getSqlStringForSqlObject($update);
		return $this->adapter->query($sqlString)->execute()->count();
		//return $this->update($entity);
	}
	
	public function updateSalStructure($entity) {
		$this->setEntityTable($this->salaryStructure); 
		$sql = $this->getSql();
		$update = $sql->Update($this->entityTable);
		$array = $this->entityToArray($entity);
		$id = $array['id'];
		unset($array['id']);
		$update->set($array);
		$update->where(array(
				'id' => $id
		));
		$sqlString = $update->getSqlString();
		// echo $sqlString;
		// exit;
		$sqlString = $sql->getSqlStringForSqlObject($update);
		return $this->adapter->query($sqlString)->execute()->count();
		//return $this->update($entity);
	}
	
	public function fetchAnnivIncById($id) {
		$this->setEntityTable($this->annivIncBuff); 
		$statement = $this->fetch(array(
				'id' => $id
		) );
		if (!$results = $statement->execute()->current()) {
			return null;
		}
		return $this->loadAnnivInc($results);
	}
	
	protected function loadAnnivInc(array $row) {
		$entity = new AnnivInc(); 
		return $this->arrayToEntity($row,$entity);
	} 
	
    	
}