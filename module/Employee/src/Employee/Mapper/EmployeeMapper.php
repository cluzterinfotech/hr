<?php 

namespace Employee\Mapper;

use Application\Abstraction\AbstractDataMapper,  
    Zend\Db\Adapter\Adapter as zendAdapter,
    Employee\Model\Location;
use Employee\Model\EmployeeLocation;
use Payment\Model\Company;
use Employee\Model\NewEmployee;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Predicate\Predicate;
use Employee\Model\EmployeeSuspend;

class EmployeeMapper extends AbstractDataMapper {
	
	protected $entityTable = "EmpEmployeeInfoMain";
    	
	protected function loadEntity(array $row) {
		 $entity = new EmployeeLocation();
		 return $this->arrayToEntity($row,$entity);
	}
	
	public function employeeList($companyId) { 
		$sql = $this->getSql(); 
		$select = $sql->select(); 
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('id','employeeNumber','empLocation','employeeName'))
		       //->join(array('ep' => 'EmpPersonalInfo'),'ep.id = e.empPersonalInfoId',
		       		  //array('employeeName')) 
		       ->where(array('companyId' => $companyId))
		       ->where(array('isActive' => 1))
		; 
		$sqlString = $sql->getSqlStringForSqlObject($select); 
		//echo $sqlString;
		//exit; 
		$results = $this->adapter->query($sqlString)->execute(); 
		return $this->toArrayList($results,'employeeNumber','employeeName');  
		//return $select;         
	} 
	
	public function employeeWholeList($companyId) {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
			   ->columns(array('id','employeeNumber','empLocation','employeeName'))
			   //->join(array('ep' => 'EmpPersonalInfo'),'ep.id = e.empPersonalInfoId',
			   //array('employeeName'))
			   //->where(array('isActive' => 1))
		       ->where(array('companyId' => $companyId))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute();
		return $this->toArrayList($results,'employeeNumber','employeeName');
		//return $select;
	} 
	// Active Employee 
	public function employeeNameNumber() {
		$sql = $this->getSql();  
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('id','employeeNumber','employeeName'))
			   ->where(array('isActive' => 1))
			   ->order('employeeName asc')
	    ; 
	    // echo $sql->getSqlStringForSqlObject($select);
	    // exit;
	    $sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute(); 
		return $results; 
	} 
	 
	public function selectEmployeeNew(Company $company) { 
		$sql = $this->getSql(); 
		$select = $sql->select(); 
		$select->from(array('e' => 'EmpEmployeeInfoBuffer'))
		       ->columns(array('id','employeeNumber','employeeName')) 
		       ->join(array('p' => 'Position'),'P.id = e.empPosition',  
				      array('positionName' => new Expression("positionName + ' ' +shortDescription"))) 
			   ->join(array('se' => 'section'),'se.id = p.section', 
				      array('sectionName'),'left') 
			   ->join(array('l' => 'Location'),'l.id = p.positionLocation',
				      array('locationName'))
			   ->join(array('d' => 'Department'),'d.id = se.department',
				      array('departmentName'),'left')
		       ->join(array('s' => 'lkpSalaryGrade'),'s.id = e.empSalaryGrade',
				      array('salaryGrade'),'left')
			   //->where(array('isActive' => 1))
			   ->where(array('companyId' => $company->getId()))
			   ->order('employeeName asc') 
		;           
		//echo $sql->getSqlStringForSqlObject($select);  
		//exit; 
		return $select;   
	}   
	
	public function selectEmployee(Company $company) {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('id','employeeNumber','employeeName'))
		       
			   ->join(array('p' => 'Position'),'P.id = e.empPosition',
					  array('positionName' => 
					  		new Expression("positionName + ' ' +shortDescription"))
			   		,'left')
			   ->join(array('se' => 'section'),'se.id = p.section',
					  array('sectionName'),'left')
		       ->join(array('l' => 'Location'),'l.id = p.positionLocation',
					  array('locationName'),'left')
			   ->join(array('d' => 'Department'),'d.id = se.department',
					  array('departmentName'),'left')
			   ->join(array('s' => 'lkpSalaryGrade'),'s.id = e.empSalaryGrade',
			       	  array('salaryGrade'),'left')
			   ->where(array('isActive' => 1))
			   ->where(array('e.companyId' => $company->getId()))
			   ->order('employeeName asc')
	    ;  
	    //echo $sql->getSqlStringForSqlObject($select); 
	    //exit;  
	    return $select;  
	}  
	
	public function fetchEmployeeNew(Company $company) {
		$sql = $this->getSql(); 
		$select = $sql->select(); 
		$select->from(array('e' => 'EmpEmployeeInfoBuffer'))
		       ->columns(array('*')) 
	    ;  
	    // echo $sql->getSqlStringForSqlObject($select); 
	    // exit; 
	    $sqlString = $sql->getSqlStringForSqlObject($select); 
		$results = $this->adapter->query($sqlString)->execute(); 
		return $results;  
	}  
    
	public function fetchEmployeeExisting(Company $company) {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('*',
		           'empJoinDate' => new Expression('convert(varchar(10),empJoinDate,105)'),
		           'confirmationDate' => new Expression('convert(varchar(10),confirmationDate,105)'),
		           'empDateOfBirth' => new Expression('convert(varchar(10),empDateOfBirth,105)'),
		       ))
		       ->join(array('p' => 'Position'),'P.id = e.empPosition',
		       		  array('positionName' => 
		       		  		new Expression(" levelName+ ' ' +positionName"))
		       		,'left')
		       		
		       	->join(array('pl' => 'PositionLevel'),'pl.levelSequence = p.organisationLevel',
		       		    array('levelName'),'left')
		       ->join(array('se' => 'section'),'se.id = p.section',
		              array('sectionName'),'left')
		       ->join(array('l' => 'Location'),'l.id = p.positionLocation',
		        	  array('locationName'),'left')
		       ->join(array('g' => 'lkpGender'),'g.id = e.gender',
		           array('genderName'),'left')
		       ->join(array('ms' => 'lkpMaritalStatus'),'ms.id = e.maritalStatus',
		           array('maritalStatusName'),'left')
		       ->join(array('yn' => 'Lkp_Yes_No'),'yn.id = e.isConfirmed',
		           array('confirmed' => 'Status'),'left')
		       ->join(array('d' => 'Department'),'d.id = se.department',
		              array('departmentName'),'left')
		       ->join(array('s' => 'lkpSalaryGrade'),'s.id = e.empSalaryGrade',
		              array('salaryGrade'),'left') 
		       ->join(array('j' => 'lkpJobGrade'),'j.id = p.jobGradeId',
		           	  array('jobGrade'),'left')
		       ->join(array('c' => 'Company'),'c.id = e.companyId',
		           array('companyName'),'left')
		       ->join(array('re' => 'lkpReligions'),'re.id = e.religion',
		           array('religionName'),'left')
		       ->join(array('na' => 'lkpNationality'),'na.id = e.nationality',
		           array('nationalityName'),'left')
		       ->join(array('st' => 'lkpStates'),'st.id = e.state',
		           array('stateName'),'left')
		       ->join(array('b' => 'lkpBank'),'b.id = e.empBank',
		              array('bankName'),'left')
		       ->where(array('isActive' => 1)) 
		       ->where(array('companyId' => $company->getId()))
		       ->order(array('employeeName asc'))
		;   
		//echo $sql->getSqlStringForSqlObject($select); 
		//exit; 
		$sqlString = $sql->getSqlStringForSqlObject($select); 
		return $this->adapter->query($sqlString)->execute(); 
		// return $results; 
	} 
	
	public function fetchEmployeeTerminated(Company $company,$values) {
		$predicate = new Predicate();
		$from = $values['from'];
		$to = $values['to'];
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('*'))
		       
			   ->join(array('p' => 'Position'),'P.id = e.empPosition',
						array('positionName' =>
								new Expression("positionName + ' ' +shortDescription"))
						,'left')
			   ->join(array('se' => 'section'),'se.id = p.section',
					  array('sectionName'),'left')
					  ->join(array('l' => 'Location'),'l.id = p.positionLocation',
					  		array('locationName'),'left')
			   ->join(array('d' => 'Department'),'d.id = se.department',
										array('departmentName'),'left')
			   ->join(array('s' => 'lkpSalaryGrade'),'s.id = e.empSalaryGrade',
			       		array('salaryGrade'),'left')
			   ->join(array('j' => 'lkpJobGrade'),'j.id = p.jobGradeId',
			       	 array('jobGrade'),'left')
			   ->join(array('c' => 'Company'),'c.id = e.companyId',
			          array('companyName'))
			   ->join(array('b' => 'lkpBank'),'b.id = e.empBank',
			       	 array('bankName'),'left')
			   ->join(array('t' => 'EmpTerminationInfo'),'t.employeeId = e.employeeNumber',
			       	  array('terminationDate'))
			       	 
			   ->where(array('isActive' => 0))
			   ->where($predicate->greaterThanOrEqualTo('terminationDate',$from))
			   ->where($predicate->lessThanOrEqualTo('terminationDate',$to))
			   ->where(array('e.companyId' => $company->getId()))
			   ->order(array('employeeName asc'))
			   ; 
			   //echo $sql->getSqlStringForSqlObject($select);
			   //exit;
			   $sqlString = $sql->getSqlStringForSqlObject($select); 
			   return $this->adapter->query($sqlString)->execute(); 
			   // return $results; 
	}
	
	public function employeeNewInitialList(Company $company) {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'InitialBuffer')) 
		       ->columns(array('id','employeeId','newAmount')) 
		       ->where(array('companyId' => $company->getId())) 
		;  
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute(); 
		return $results;  
	} 
	
	public function employeeSpecialAmountBufferList(Company $company) {
	    $sql = $this->getSql();
	    $select = $sql->select();
	    $select->from(array('e' => 'AllowanceSpecialAmountBuffer'))
	    ->columns(array('id','employeeNumber','effectiveDate','allowanceId','amount','oldAmount','isAdded'))
	           ->join(array('ep' => 'EmpEmployeeInfoMain'),'ep.employeeNumber = e.employeeNumber',
	               array('employeeName'))
	           ->where(array('ep.companyId' => $company->getId()))
	    ;
	    $sqlString = $sql->getSqlStringForSqlObject($select);
	    //echo $sqlString;
	    //exit; 
	    $results = $this->adapter->query($sqlString)->execute();
	    return $results;
	} 
	
	
	
	public function getEmployeeCola($employeeNumber) {
		// Cola 
		$adapter = $this->adapter; 
		$qi = function($name) use ($adapter) { 
			return $adapter->platform->quoteIdentifier($name); 
		}; 
		$fp = function($name) use ($adapter) { 
			return $adapter->driver->formatParameterName($name); 
		}; 
		$statement = $adapter->query("select top 1 id,amount from ".$qi('Cola')."
			where employeeId  = '".$employeeNumber."'
			order by id desc
		"); 
		$results = $statement->execute()->current();
		if($results['amount']) {
			return $results['amount'];
		} 
		return 0; 
	} 
	
	public function insertNewEmployeeInfoMain($data) {
		$this->setEntityTable('EmpEmployeeInfoMain');
		$this->insert($data); 
	}   
	
	public function insertNewEmployeeInfoBuffer($data) { 
		$this->setEntityTable('EmpEmployeeInfoBuffer'); 
		$this->insert($data); 
	}  
	
	public function updateNewEmployeeInfoBuffer($data) {
		$this->setEntityTable('EmpEmployeeInfoBuffer');
		$array = $this->entityToArray($data);
		$this->update($array); 
	}  
	
	public function updatePhotoLoc($employeeNumber,$empImg) {
	    $adapter = $this->adapter;
	    $qi = function($name) use ($adapter) {
	        return $adapter->platform->quoteIdentifier($name);
	    };
	    $fp = function($name) use ($adapter) {
	        return $adapter->driver->formatParameterName($name);
	    }; 
	    $statement = $adapter->query("
                 update EmpEmployeeInfoMain set imgLoc = '".$empImg."'
                 where employeeNumber = '".$employeeNumber."'
		    ");
	    //echo $statement->getSql()."<br/>";
	    //exit;
	    $statement->execute();
	}
	
	public function updateExistingEmployeeInfoMain($data) { 
		
		$this->setEntityTable($this->entityTable); 
		$array = $this->entityToArray($data); 
		//\Zend\Debug\Debug::dump($array);
		//exit;
		$this->update($array); 
	} 
	
	public function getIdByEmployeeNumber($employeeNumber) {
	
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('id'))
			   ->where(array('employeeNumber' => $employeeNumber))
		;   
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString;
		//exit; 
		$results = $this->adapter->query($sqlString)->execute()->current();
		return $results['id'];
	}
	
	public function updateExistingEmployeeConfirmation(array $confirmationArray) {
	
		$this->setEntityTable($this->entityTable);
		//\Zend\Debug\Debug::dump($confirmationArray);
		//exit;
		$this->update($confirmationArray); 
	}
	
	public function getEmployeeInitial($employeeNumber) {
		// Initial 
		$adapter = $this->adapter; 
		$qi = function($name) use ($adapter) { 
			return $adapter->platform->quoteIdentifier($name); 
		}; 
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		}; 
		$statement = $adapter->query("select top 1 id,amount from ".$qi('Initial')." 
			where employeeId  = '".$employeeNumber."'  
			order by id desc	
		");    
		$results = $statement->execute()->current();  
		if($results['amount']) { 
			$salaryInfo = array('oldInitial' => $results['amount']);
			return $salaryInfo;
		}
		$salaryInfo = array('oldInitial' => 0); 
		return $salaryInfo; 
	}  
	
	public function getEmployeeAllowanceAmount($employeeNumber, $allowanceId) {
	    // Initial
	    $adapter = $this->adapter;
	    $qi = function($name) use ($adapter) {
	        return $adapter->platform->quoteIdentifier($name);
	    };
	    $fp = function($name) use ($adapter) {
	        return $adapter->driver->formatParameterName($name);
	    };
	    $statement = $adapter->query("select top 1 id,amount from ".$qi($allowanceId)."
			where employeeId  = '".$employeeNumber."'
			order by id desc
		");
	    $results = $statement->execute()->current();
	    if($results['amount']) {
	        $salaryInfo = array('oldAmount' => $results['amount']);
	        return $salaryInfo;
	    }
	    $salaryInfo = array('oldAmount' => 0);
	    return $salaryInfo;
	} 
	
	public function getEmployeeInitialFromBuffer($employeeNumber) { 
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name); 
		};
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};
		$statement = $adapter->query("select top 1 id,newAmount from ".$qi('InitialBuffer')."
			where employeeId  = '".$employeeNumber."'
			order by id desc
		");
		$results = $statement->execute()->current(); 
		if($results['newAmount']) { 
			return $results['newAmount']; 
		} 
		return 0; 
	} 
	
	public function notConfirmedEmployeeList(Company $company) {
		// @todo write condition 
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('id','employeeNumber','empLocation','employeeName'))
		       //->join(array('ep' => 'EmpPersonalInfo'),'ep.id = e.empPersonalInfoId',
				      //array('employeeName'))
			   ->where(array('isConfirmed' => 0))
			   ->where(array('isActive' => 1))
			   ->where(array('companyId' => $company->getId()))
		;   
		$sqlString = $sql->getSqlStringForSqlObject($select);
		// echo $sqlString; 
		// exit; 
		$results = $this->adapter->query($sqlString)->execute();
		return $this->toArrayList($results,'employeeNumber','employeeName'); 
	} 
	// Employee not took leave allowance
	public function notTakenLAEmployeeList(Company $company) {
		$lastYear = date("Y")-1;
		$dayL = date("d");
		$MonL = date("m");
		if($dayL == '29' && $MonL == '2') {
			$dayL = '28'; 
		} 
		$date  = $lastYear."-".$MonL."-".$dayL;
		
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		}; 
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		}; 
		$statement = $adapter->query("
				SELECT id,employeeNumber,employeeName,confirmationDate,
				empJoinDate,isPreviousContractor
				FROM EmpEmployeeInfoMain e
				where isActive = 1 and (empJoinDate <= '".$date."' and  isPreviousContractor = 0) 
				and e.companyId = ".$company->getId()."
				and  e.employeeNumber not in
				(
				select employeeId from leaveAllowanceMst 
				where fyYear =".date("Y")." and isClosed = 1
				)
				union	
				SELECT id,employeeNumber,employeeName,confirmationDate,
				empJoinDate,isPreviousContractor
				FROM EmpEmployeeInfoMain e
				where isActive = 1 and (confirmationDate <= '".$date."' and  isPreviousContractor = 1)  
				and e.companyId = ".$company->getId()." 
				and  e.employeeNumber not in
				(
				select employeeId from leaveAllowanceMst 
				where fyYear =".date("Y")." and isClosed = 1 
				)
		");      
		//echo $statement->getSql();
		//exit;
		$results = $statement->execute();
		//$results = $this->adapter->query($sqlString)->execute();
		return $this->toArrayList($results,'employeeNumber','employeeName');
		
		/*$predicate = new Predicate();
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array(array('id','employeeNumber',
				         'empLocation','employeeName')))
		       ->where(array('isActive' => 1))
			   ->where(array('companyId' => $company->getId()))
	           ->order('employeeName asc')
		;
		$select->where($predicate->notIn('e.employeeNumber',$ids));
		//echo $select->getSqlString();
		//exit;
		return $select;
		
		// @todo write condition
		$sql = $this->getSql(); 
		$select = $sql->select(); 
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('id','employeeNumber',
				'empLocation','employeeName'))
		//->join(array('ep' => 'EmpPersonalInfo'),'ep.id = e.empPersonalInfoId',
		//array('employeeName'))
		       //->where(array('isConfirmed' => 0))
		       ->where(array('isActive' => 1))
		       ->where(array('companyId' => $company->getId()))
		       ->order('employeeName asc') 
		; 
		$sqlString = $sql->getSqlStringForSqlObject($select);
		// echo $sqlString;
		// exit;
		$results = $this->adapter->query($sqlString)->execute();
		return $this->toArrayList($results,'employeeNumber','employeeName');*/ 
	}
	
	// employee not taken final entitlement
	public function notTakenFEEmployeeList(Company $company) {
		// @todo write condition
		$sql = $this->getSql();
		$select = $sql->select();
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
		return $this->toArrayList($results,'employeeNumber','employeeName');
	}
	
	public function notConfirmedEmployeeListBuffer(Company $company) {
		// @todo write condition
		$sql = $this->getSql();
		$select = $sql->select();
		/*employeeNumberConfirmation
		effectiveDate
		appliedDate
		oldSalary
		oldCola
		adjustedAmount
		percentage
		confirmationNotes */  
		
		$select->from(array('e' => 'EmployeeConfirmationBuffer'))
		       ->columns(array('*'))
		//->join(array('ep' => 'EmpPersonalInfo'),'ep.id = e.empPersonalInfoId',
		//array('employeeName'))
		       //->where(array('isConfirmed' => 0))
		       //->where(array('isActive' => 1))
		       ->where(array('companyId' => $company->getId()))
		;  
		$sqlString = $sql->getSqlStringForSqlObject($select); 
		// echo $sqlString;
		// exit;
		return $this->adapter->query($sqlString)->execute();
		// return $this->toArrayList($results,'employeeNumber','employeeName');
	} 
	
	public function terminatedEmployeeListBuffer(Company $company) {
		// @todo write condition
		$sql = $this->getSql();
		$select = $sql->select();
	
		$select->from(array('e' => 'EmpTerminationInfoBuff'))
		       ->columns(array('*'))
		//->join(array('ep' => 'EmpPersonalInfo'),'ep.id = e.empPersonalInfoId',
		//array('employeeName'))
		//->where(array('isConfirmed' => 0))
		//->where(array('isActive' => 1))
		      ->where(array('companyId' => $company->getId()))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		// echo $sqlString;
		// exit;
		return $this->adapter->query($sqlString)->execute();
		// return $this->toArrayList($results,'employeeNumber','employeeName');
	}
	
	public function suspendEmployeeListBuffer(Company $company) {
		// @todo write condition
		$sql = $this->getSql();
		$select = $sql->select();
	
		$select->from(array('e' => 'EmpSuspendInfoBuff'))
		       ->columns(array('*'))
		       ->where(array('companyId' => $company->getId()))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		// echo $sqlString;
		// exit;
		return $this->adapter->query($sqlString)->execute();
		// return $this->toArrayList($results,'employeeNumber','employeeName');
	}
     	
	public function employeeWithDelegatedList($employeeNumber) { 
		
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		};
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};
		$statement = $adapter->query("select employeeNumber,employeeName from EmpEmployeeInfoMain e
			where
			empPosition in(
					select delegatedEmployeeId  from EmpEmployeeInfoMain e
					inner join EmployeeDelegation pd on pd.employeeId = e.empPosition
					where employeeNumber = '".$employeeNumber."'
			)
			and isActive = 1
			and positionTerminationReferenceNumber = '0'
			or employeeNumber ='".$employeeNumber."'
			
		");
		$results = $statement->execute();
		return $this->toArrayList($results,'employeeNumber','employeeName');
		
		
		
	/* $sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('id','employeeNumber','locationId'))
		       ->join(array('ep' => 'EmpPersonalInfo'),'ep.id = e.empPersonalInfoId',
				      array('employeeName'))
				      ->join(array('ep' => 'EmpPersonalInfo'),'ep.id = e.empPersonalInfoId',
				      		array('employeeName'))
			   ->where(array('employeeNumber' => $employeeNumber))
			   ;
			   $sqlString = $sql->getSqlStringForSqlObject($select);
			   //echo $sqlString;
			   //exit; 
		$results = $this->adapter->query($sqlString)->execute();
		return $this->toArrayList($results,'employeeNumber','employeeName'); */ 
		
		/*return array(
				''     => '',
				'1075' => 'Ahmed Taha',
				//'1009' => 'Abdaelmuneim Mohammed Hassan',
				//'1083' => 'Abdalla Faroug Mohamed',
				//'1095' => 'Abdalla Ishag Ahmed',
				//'1036' => 'Abdalla Yassin Satti',	
		); */ 
	}
	
	// current list
	public function employeeInfo($employeeNumber) {
		return array(
				'position'      => 2,
				'department'    => 3,
				'location'      => 4,
				'doj'           => '2008-02-20',
		);
	}
	
	public function saveEmployeeInitialBuffer($initialInfo) { 
		$sql = $this->getSql();
		$insert = $sql->Insert('InitialBuffer');
		$insert->values($initialInfo);
		$sqlString = $sql->getSqlStringForSqlObject($insert);
		$this->adapter->query($sqlString)->execute();
	}
    public function saveEmployeeAllowancespecialAmountBuffer($initialInfo) { 
		$sql = $this->getSql();
		$insert = $sql->Insert('AllowanceSpecialAmountBuffer');
		$insert->values($initialInfo);
		$sqlString = $sql->getSqlStringForSqlObject($insert);
		$this->adapter->query($sqlString)->execute();
	}	
	public function saveEmployeeAllowancespecialAmountMain($initialInfo) {
	    $sql = $this->getSql();
	    $insert = $sql->Insert('AllowanceSpecialAmount');
	    $insert->values($initialInfo);
	    $sqlString = $sql->getSqlStringForSqlObject($insert);
	    $this->adapter->query($sqlString)->execute();
	}
	public function fetchExistingEmployeeById($id) {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('*'))
		       ->where(array('id' => $id ))
		; 
		// echo $select->getSqlString(); 
		// exit; 
		// return $select; 
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$row = $this->adapter->query($sqlString)->execute()->current();
		$entity = new NewEmployee();
		// \Zend\Debug\Debug::dump($row);
		return $this->arrayToEntity($row,$entity);
		// $this->loadEntity($results); 
	}
	
	public function fetchCompanyById($id) {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('c' => 'Company')) 
			   ->columns(array('*'))
			   ->where(array('id' => $id ))
		; 
		// echo $select->getSqlString();
		// exit;
		// return $select;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$row = $this->adapter->query($sqlString)->execute()->current();
		return $row; 
	} 
	
	
	public function updateCompanyById($array) {
		$this->setEntityTable('Company'); 
		$this->update($array); 
	} 
	
	public function deleteSuspend($entity) {
	    $this->setEntityTable('EmpSuspendInfo');
	    $this->delete($entity); 
	}
	
	public function fetchSuspendById($id) {
	    $sql = $this->getSql();
	    $select = $sql->select();
	    $select->from(array('e' => 'EmpSuspendInfo'))
	           ->columns(array('*'))
	           ->where(array('id' => $id ))
	    ;
	    // echo $select->getSqlString();
	    // exit;
	    // return $select;
	    $sqlString = $sql->getSqlStringForSqlObject($select);
	    $row = $this->adapter->query($sqlString)->execute()->current();
	    $entity = new EmployeeSuspend(); 
	    // \Zend\Debug\Debug::dump($row);
	    return $this->arrayToEntity($row,$entity);
	    // $this->loadEntity($results);
	} 
	
	public function fetchEmployeeById($id) { 
	    $sql = $this->getSql(); 
	    $select = $sql->select(); 
	    $select->from(array('e' => 'EmpEmployeeInfoBuffer'))
	           ->columns(array('*')) 
	           ->where(array('id' => $id ))
	    ;   
	    //echo $select->getSqlString(); 
	    // exit; 
	    // return $select; 
	    $sqlString = $sql->getSqlStringForSqlObject($select); 
	    $row = $this->adapter->query($sqlString)->execute()->current();
	    $entity = new NewEmployee();  
	    // \Zend\Debug\Debug::dump($row); 
	    return $this->arrayToEntity($row,$entity); 
	    // $this->loadEntity($results);
	}  
    
	public function saveEmployeeConfirmation($confirmationInfo) {
		$sql = $this->getSql();
		$insert = $sql->Insert('EmployeeConfirmationBuffer');
		$insert->values($confirmationInfo);
		$sqlString = $sql->getSqlStringForSqlObject($insert);
		$this->adapter->query($sqlString)->execute();
	}
	
	public function saveEmployeeTermination($terminationInfo) {
		$sql = $this->getSql();
		$insert = $sql->Insert('EmpTerminationInfoBuff');
		$insert->values($terminationInfo);
		$sqlString = $sql->getSqlStringForSqlObject($insert);
		$this->adapter->query($sqlString)->execute();
	}
	
	 
	
	public function saveEmployeeTerminationMain($terminationInfo) {
		$sql = $this->getSql();
		$insert = $sql->Insert('EmpTerminationInfo');
		$insert->values($terminationInfo);
		$sqlString = $sql->getSqlStringForSqlObject($insert);
		$this->adapter->query($sqlString)->execute();
	}
	
	public function saveEmployeeSuspendMain($suspendInfo) {
		$sql = $this->getSql();
		$insert = $sql->Insert('EmpSuspendInfo');
		$insert->values($suspendInfo);
		$sqlString = $sql->getSqlStringForSqlObject($insert);
		$this->adapter->query($sqlString)->execute();
	}
	
	public function saveEmployeeSuspendHist($suspendInfo) {
	    $sql = $this->getSql();
	    $insert = $sql->Insert('EmpSuspendInfoHistory');
	    $insert->values($suspendInfo);
	    $sqlString = $sql->getSqlStringForSqlObject($insert);
	    $this->adapter->query($sqlString)->execute();
	}
	
	public function removeEmployeeConfirmation($id) { 
		$sql = $this->getSql(); 
		$delete = $sql->delete('EmployeeConfirmationBuffer'); 
		$delete->where(array( 
				'id' => $id 
		)); 
		//$sqlString = $delete->getSqlString(); 
		$sqlString = $sql->getSqlStringForSqlObject($delete); 
		return $this->adapter->query($sqlString)->execute()->count(); 
	}
	
	/*public function removeEmployeeTerminationBuff($id) {
		$sql = $this->getSql();
		$delete = $sql->delete('EmpTerminationInfoBuff');
		$delete->where(array(
				'id' => $id
		));
		//$sqlString = $delete->getSqlString();
		$sqlString = $sql->getSqlStringForSqlObject($delete);
		return $this->adapter->query($sqlString)->execute()->count();
	}*/
	
	public function removeEmployeeTerminationBuff($id) { 
		$sql = $this->getSql(); 
		$delete = $sql->delete('EmpTerminationInfoBuff'); 
		$delete->where(array( 
				'id' => $id 
		)); 
		//$sqlString = $delete->getSqlString(); 
		$sqlString = $sql->getSqlStringForSqlObject($delete); 
		return $this->adapter->query($sqlString)->execute()->count(); 
	}
	
	public function removeEmployeeSuspendBuff($id) {
		$sql = $this->getSql();
		$delete = $sql->delete('EmpSuspendInfoBuff');
		$delete->where(array(
				'id' => $id
		));
		//$sqlString = $delete->getSqlString();
		$sqlString = $sql->getSqlStringForSqlObject($delete);
		return $this->adapter->query($sqlString)->execute()->count();
	}
	
	//public function removeSpecialAmountBuffer
	
	
	public function removeEmployeeInitialBuffer($id) { 
		$sql = $this->getSql();
		$delete = $sql->delete('InitialBuffer'); 
		$delete->where(array(
				'id' => $id
		)); 
		//$sqlString = $delete->getSqlString(); 
		$sqlString = $sql->getSqlStringForSqlObject($delete); 
		return $this->adapter->query($sqlString)->execute()->count();  
	} 
	public function removeEmployeeSpecialAmountBuffer($id) { 
		$sql = $this->getSql();
		$delete = $sql->delete('AllowanceSpecialAmountBuffer'); 
		$delete->where(array(
				'id' => $id
		)); 
		//$sqlString = $delete->getSqlString(); 
		$sqlString = $sql->getSqlStringForSqlObject($delete); 
		return $this->adapter->query($sqlString)->execute()->count();  
	} 	
	public function removeNewEmployeeFromBuffer($id) { 
		$sql = $this->getSql(); 
		$delete = $sql->delete('EmpEmployeeInfoBuffer');
		$delete->where(array(
				'id' => $id
		));  
		$sqlString = $sql->getSqlStringForSqlObject($delete);
		//echo $sqlString;
		//exit; 
		return $this->adapter->query($sqlString)->execute()->count();
	} 
    
	public function selectEmployeeConfirmation() { 
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'EmployeeConfirmationBuffer'))
		       ->columns(array('*'))
		       ->join(array('ep' => 'EmpEmployeeInfoMain'),'ep.employeeNumber = e.employeeNumberConfirmation',
		              array('employeeName'))
			   //->join(array('l' => 'Location'), 'e.locationId = l.id',
					  //array('locationName'))
			   ; 
	    //echo $select->getSqlString(); 
		//exit; 
		return $select;  
	} 
	
	public function selectEmployeeTermination() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'EmpTerminationInfo'))
		       ->columns(array('*'))
	           ->join(array('ep' => 'EmpEmployeeInfoMain'),'ep.employeeNumber = e.employeeId',
		              array('employeeName'))
		       ->join(array('t' => 'lkpTerminationType'), 't.id = e.lkpTerminationTypeId',
		              array('terminationType'))
		;
		//echo $select->getSqlString();
		//exit;
		return $select;
	}
	
	public function selectEmployeeSuspend() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'EmpSuspendInfoBuff'))
		       ->columns(array('id','suspendFrom','suspendTo'))
		       ->join(array('ep' => 'EmpEmployeeInfoMain'),'ep.employeeNumber = e.employeeId',
				      array('employeeName'))
			   //->join(array('t' => 'lkpTerminationType'), 't.id = e.lkpTerminationTypeId',
					  //array('terminationType'))
		;
		//echo $select->getSqlString();
		//exit;
		return $select; 
	}
	
	public function selectEmployeeSuspended() {
	    $sql = $this->getSql();
	    $select = $sql->select();
	    $select->from(array('e' => 'EmpSuspendInfo'))
	    ->columns(array('id','suspendFrom','suspendTo'))
	    ->join(array('ep' => 'EmpEmployeeInfoMain'),'ep.employeeNumber = e.employeeId',
	        array('employeeName'))
	        //->join(array('t' => 'lkpTerminationType'), 't.id = e.lkpTerminationTypeId',
	    //array('terminationType'))
	    ;
	    //echo $select->getSqlString();
	    //exit;
	    return $select;
	}
	
	public function saveEmployeeSuspendBuff($suspendInfo) {
		$sql = $this->getSql();
		$insert = $sql->Insert('EmpSuspendInfoBuff');
		$insert->values($suspendInfo);
		$sqlString = $sql->getSqlStringForSqlObject($insert);
		$this->adapter->query($sqlString)->execute();
	}   
	
	public function selectEmployeeTerminationBuff() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'EmpTerminationInfoBuff'))
		       ->columns(array('*'))
		       ->join(array('ep' => 'EmpEmployeeInfoMain'),'ep.employeeNumber = e.employeeId',
				array('employeeName'))
				->join(array('t' => 'lkpTerminationType'), 't.id = e.lkpTerminationTypeId',
		              array('terminationType'))
		;
		//echo $select->getSqlString(); 
		//exit;
		return $select; 
	}
	
	public function selectEmployeeInitialBuffer() { 
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('i' => 'InitialBuffer'))
		       ->columns(array('id','addedDate','newAmount','employeeId','oldAmount'))
		       ->join(array('e' => $this->entityTable),'e.employeeNumber = i.employeeId',
		              array('employeeName')) 
		;   
		return $select; 
	}   
	public function selectSpecialAmountBuffer() {
	    $sql = $this->getSql();
	    $select = $sql->select();
	    $select->from(array('i' => 'AllowanceSpecialAmountBuffer'))
	    ->columns(array('id','effectiveDate','amount','oldAmount','allowanceId'))	    
	    ->join(array('e' => $this->entityTable),'e.employeeNumber = i.employeeNumber',
	        array('employeeName'))
        ->join(array('l' => 'lkpAddedStatus'),'l.id = i.isAdded',
	        array('addedStatus'))
	  	   ;
	    return $select;
	}
	
	/*
	public function getMappingList() {
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		}; 
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};
		
		$statement = $adapter->query("SELECT id_in_hr, is_in_new_system
                                       FROM " . $qi('Mapping_Employee_Id') . " AS c
		");
		//echo $statement->getSql();
		$results = $statement->execute();
		return $this->convertToArray($results);
	}
	
	public function updateEmployeeIds($table,$empIdOld,$empIdNew) {
		$adapter = $this->adapter; 
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		};
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};
		
		$statement = $adapter->query("update " . $qi($table) . " 
				set employeeId = $empIdNew where employeeId = $empIdOld
		");
		//echo $statement->getSql();
		//exit;
		$statement->execute();
	}
	
	public function isHaveId($table,$empIdOld) {
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		};
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};
	
		$statement = $adapter->query("SELECT employeeId
                                       FROM " . $qi($table) . " AS c
		where employeeId = '".$empIdOld."' and effectiveDate = '2015-01-01' ");
		//echo $statement->getSql();
		//exit;
		$results = $statement->execute();
		return $this->convertToArray($results);
	}
	*/
}