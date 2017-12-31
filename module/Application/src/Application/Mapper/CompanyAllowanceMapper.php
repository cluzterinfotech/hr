<?php

namespace Application\Mapper; 

use Application\Abstraction\AbstractDataMapper;
use Application\Contract\EntityCollectionInterface;
use Application\Entity\CompanyAllowanceEntity;
use Payment\Model\Company;
use Payment\Model\DateRange;
use Payment\Model\Employee;
use Zend\Db\Adapter\Adapter as zendAdapter;

class CompanyAllowanceMapper extends AbstractDataMapper { 
	
	protected $entityTable = "CompanyAllowance";
	
	protected $allowanceType; 
	                        
	protected $companyId; 
	
	/* NOTE : all the below method should have history
	 */ 
	
	public function __construct(zendAdapter $adapter, 
			EntityCollectionInterface $collection,$sm
			,AllowanceTypeMapper $allowanceType 
			,$entityTable = null) {
		$this->companyId = new CompanyMapper($adapter,$collection,$sm);  
		$this->allowanceType = $allowanceType; 
		parent::__construct($adapter,$collection,$sm,$entityTable); 
	}   
	
	protected function loadEntity(array $row) { 
	    $companyAllowance = new CompanyAllowanceEntity(); 
	    $companyAllowance->setId($row['id']); 
	    $companyAllowance->setCompanyId($this->companyId->fetchById($row['companyId']));      
	    $companyAllowance->setAllowanceTypeId(
	    		$this->allowanceType->fetchById($row['allowanceTypeId'])
	    );  
	    return $companyAllowance;  
	} 
	
	public function getPaysheetEmployeeList($condition) {
	    //'isActive' => 1,
	    //'companyId' => $company->getId(),
	    //'isInPaysheet' => 1,
	    $sql = $this->getSql();
	    $select = $sql->select();
	    $select->from(array('e' => 'EmpEmployeeInfoMain'))
	           ->columns(array('employeeName','employeeNumber',
                'empJoinDate','empSalaryGrade','companyId','empDateOfBirth',
    	        'religion','empPosition',
                'maritalStatus','numberOfDependents','empLocation'))
	           //->join(array('l' => 'Location'),'e.empLocation = l.id',
	            //array('overtimeHour'))
	          ->where(array('isActive' => $condition['isActive']))
	          ->where(array('companyId' => $condition['companyId']))
	          ->where(array('isActive' => $condition['isInPaysheet']))
	          //->where(array('employeeNumber' => '1270'))
	        ;  
	        $sqlString = $sql->getSqlStringForSqlObject($select);
	        //echo $sqlString;
	        //exit;
	        $results = $this->adapter->query($sqlString)->execute();
	        if($results) {
	            return $results;
	        }
	        return 0;
	}
	
	public function getIndividualEmployee($condition) {
	    //'isActive' => 1,
	    //'companyId' => $company->getId(),
	    //'isInPaysheet' => 1,
	    $sql = $this->getSql();
	    $select = $sql->select();
	    $select->from(array('e' => 'EmpEmployeeInfoMain'))
	    ->columns(array('employeeName','employeeNumber',
	        'empJoinDate','empSalaryGrade','companyId','empDateOfBirth',
	        'religion','empPosition',
	        'maritalStatus','numberOfDependents','empLocation'))
	        //->join(array('l' => 'Location'),'e.empLocation = l.id',
	    //array('overtimeHour'))
	    ->where(array('isActive' => $condition['isActive']))
	    ->where(array('companyId' => $condition['companyId']))
	    ->where(array('isActive' => $condition['isInPaysheet']))
	    ->where(array('employeeNumber' => $condition['employeeNumber']))
	    ;
	    $sqlString = $sql->getSqlStringForSqlObject($select);
	    //echo $sqlString;
	    //exit;
	    $results = $this->adapter->query($sqlString)->execute();
	    if($results) {
	        return $results;
	    }
	    return 0;
	}
	
	public function getPaysheetAllowance(Company $company,DateRange $dateRange) {
		
		$adapter = $this->adapter; 
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		}; 
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};
		$where = " (1=1) ";
		$where .= " and p.companyId = '".$company->getId()."' ";
		//$where .= " and p.effectiveDate >= '".$dateRange->getFromDate()."' ";
		//$where .= " and p.effectiveDate <= '".$dateRange->getToDate()."' ";
		// $order = " order by c.effectiveDate,c.id ASC"; 
		$statement = $adapter->query("
		    SELECT ca.allowanceTypeName AS allowanceTypeName, 
            a.allowanceName AS allowanceName 
            FROM PaysheetAllowance AS p 
            INNER JOIN CompanyAllowance AS ca ON p.companyAllowanceId = ca.id 
            INNER JOIN Allowance AS a ON ca.allowanceId = a.id
			where  $where  
		");  
		 //echo $statement->getSql();  
	    // exit;  
		$results = $statement->execute();  
		
		if($results) {
			return $this->toArrayListWithoutBlank($results,'allowanceName','allowanceTypeName'); 
		}
		return array(); 
		
	}
	
	public function getRuntimeAllowance(Company $company,DateRange $dateRange) {
		return array(
				'Overtime'  => 'Overtime', 
				'Meal'      => 'Meal', 
		); 
	} 
	
	public function getIncometaxAllowance(Company $company,DateRange $dateRange) {
		return array(
				'Initial' => 'Initial','Cola' => 'ColaSalaryGrade','Hardship'=>'Hardship',
				'Cashier' => 'Cashier','Fitter' => 'Fitter',
				'Housing' => 'Housing','Transportation' => 'Transportation',
				'NatureofWork'=> 'NatureofWork','Representative'=>'Representative',
				'Shift'=>'Shift','Airport'=>'Airport','SpecialAllowance'=>'SpecialAllowance',
				'Overtime'  => 'Overtime','Meal' => 'Meal',
		); 
	} 
	
	public function getSocialInsuranceAllowance(Company $company,DateRange $dateRange) {
		return array(
				'Initial' => 'Initial','Cola' => 'ColaSalaryGrade','Hardship'=>'Hardship',
				'Cashier' => 'Cashier','Fitter' => 'Fitter',
				'Housing' => 'Housing','Transportation' => 'Transportation',
				'NatureofWork'=> 'NatureofWork','Representative'=>'Representative',
				'Shift'=>'Shift','Airport'=>'Airport','SpecialAllowance'=>'SpecialAllowance',
		);
	} 
	
	public function getZakatExemAllowance(Company $company,DateRange $dateRange) {
		return array( 'Transportation' => 'Transportation' ); 
	} 
	
	public function getLeaveAllowanceFixed(Company $company,DateRange $dateRange) {
		return array(
				'Initial' => 'Initial','Cola' => 'ColaSalaryGrade',
				'Housing' => 'Housing','Transportation' => 'Transportation' 
		); 
	} 
	
	public function getLeaveAllowanceAllowance(Company $company,DateRange $dateRange) {
		return array(
				'Hardship'=>'Hardship',
				'Cashier' => 'Cashier','Fitter' => 'Fitter','President'=>'President',
				'Representative'=>'Representative','NatureofWork'=> 'NatureofWork',
				'Shift'=>'Shift','Airport'=>'Airport','SpecialAllowance'=>'SpecialAllowance',
		);
	}
	
	
	
	public function getPFAllowance(Company $company,DateRange $dateRange) {
		return array(
				'Initial' => 'Initial','Cola' => 'ColaSalaryGrade'
		);
	}
	
	public function getBasicAllowance(Company $company,DateRange $dateRange) {
		return array('Initial' => 'Initial','cola' => 'ColaSalaryGrade'); 
	}
	
    public function selectFixedAmountAllowance(/*Company $company*/) {
		return array(
				'' => '',
				'Cashier'=>'Cashier',
				'Fitter'=>'Fitter',
				'President'=>'President',
				'Cooperation'=>'Cooperation',
				'Zamala'=>'Zamala',
				'UnionShare'=>'Union',
				'KhartoumUnion'=>'Khartoum Union',
		);
	} 
	
	public function selectSocialInsuranceAllowance() {
		$sql = $this->getSql(); 
        $select = $sql->select(); 
        $select->from(array('s' => 'SocialInsuranceAllowance'))
               ->columns(array('id')) 
               ->join(array('c' => 'Company'),'s.companyId = c.id', 
                      array('companyName'))
               ->join(array('a' => 'Allowance'), 's.allowanceId = a.id',  
                      array('allowanceName'))
        ; 
        //echo $select->getSqlString();  
        //exit; 
        return $select;   
	} 
	
	public function selectAllowanceNotToHaveAllowance() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('na' => 'AllowanceNotToHaveAllowance'))
		       ->columns(array('id','priority'))
		       ->join(array('c' => 'Company'),'na.companyId = c.id',
			          array('companyName'))
		       ->join(array('a' => 'Allowance'), 'na.allowanceId = a.id',
			          array('allowanceName'))
	           ->join(array('aa' => 'Allowance'), 'na.notToHaveAllowance = aa.id',
			          array('notToHave' => 'allowanceName'))
			   ->order(array('a.allowanceName asc'))
		; 
		//echo $select->getSqlString(); 
		//exit; 
		return $select;
	}
	
	public function selectAllowanceAffectedAllowance() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('na' => 'AllowanceAffectedAllowance'))
		       ->columns(array('id'))
		       ->join(array('c' => 'Company'),'na.companyId = c.id',
				      array('companyName'))
			   ->join(array('a' => 'Allowance'), 'na.allowanceId = a.id',
					  array('allowanceName'))
			   ->join(array('aa' => 'Allowance'), 'na.affectedAllowanceId = aa.id',
					  array('affected' => 'allowanceName'))
			   ->order(array('a.allowanceName asc'))
		;
		//echo $select->getSqlString();
		//exit;
		return $select;
	}
	
	public function selectPaysheetAllowance() { 
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('pa' => 'PaysheetAllowance'))
		       ->columns(array('id'))
		       ->join(array('c' => 'Company'),'pa.companyId = c.id',
				      array('companyName'))
			   ->join(array('ca' => 'CompanyAllowance'),'pa.companyAllowanceId = ca.id',
				      array()) 
			   ->join(array('a' => 'Allowance'), 'ca.allowanceId = a.id',
					  array('allowanceName'))
			   //->join(array('aa' => 'Allowance'), 'pa.affectedAllowanceId = aa.id',
					 // array())
			   ->order(array('a.allowanceName asc'))
		;
		//echo $select->getSqlString();
		//exit;
		return $select;
	}
    	
	public function getOtAllowances(Company $company,DateRange $dateRange) {
		return array('Initial' => 'Initial','Cola' => 'ColaSalaryGrade');
	}
	
	public function getTopOtAttendanceDate(Employee $employee) { 
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		};
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		}; 
		$statement = $adapter->query("
				SELECT top 1 cardId,attendanceDate
				FROM OtAttendancePaysheet AS o
				where  cardId = '".$employee->getEmployeeNumber()."'  
				order by attendanceDate asc 
				"); 
		// echo $statement->getSql();
		// exit;
		$row = $statement->execute()->current(); 
	
		if($row) {
			return $row['attendanceDate'];
		}
		return 0; 
	}
	/*
	 SELECT convert(varchar(5),cast(DATEADD(ms, SUM(DATEDIFF(ms, '00:00', normalHour)), '00:00') as time),108) as normalHour,
				convert(varchar(5),cast(DATEADD(ms, SUM(DATEDIFF(ms, '00:00', holidayHour)), '00:00') as time),108) as holidayHour,
				sum(noOfMeals) as noOfMeals FROM OtAttendancePaysheet AS o
				where
	 */
	// @todo move the below methods to employee allowance
	public function getEmployeeOTHour(Employee $employee,DateRange $dateRange) { 
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		};
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};
		$where = " (1=1) ";
		$where .= " and o.cardId = '".$employee->getEmployeeNumber()."' ";
		$where .= " and o.attendanceDate >= '".$dateRange->getFromDate()."' ";
		$where .= " and o.attendanceDate <= '".$dateRange->getToDate()."' ";
		$statement = $adapter->query("
				SELECT sum(normalHour) as normalHour,sum(holidayHour) as holidayHour
				 FROM OtAttendancePaysheet AS o
				where  $where
				"); 
		//echo $statement->getSql(); 
		// exit; 
		$results = $statement->execute()->current(); 
		
		if($results) {
			//$normalArr = explode(':', $results['normalHour']);
			//$holidayArr = explode(':', $results['holidayHour']);
		    //'meal'   => $results['noOfMeals']
			return array(
			    'normal' => $results['normalHour'],
			    'holiday' => $results['holidayHour'],

			); 
		}
		return 0;  
	}
	
	public function getEmployeeOTValue(Employee $employee,DateRange $dateRange) {
		$sql = $this->getSql(); 
		$select = $sql->select(); 
		$select->from(array('e' => 'EmpEmployeeInfoMain'))
		       ->columns(array('empLocation')) 
		       ->join(array('l' => 'Location'),'e.empLocation = l.id', 
			          array('overtimeHour'))
		       ->where(array('employeeNumber' => $employee->getEmployeeNumber())) 
		;   
		$sqlString = $sql->getSqlStringForSqlObject($select); 
		//echo $sqlString;
		//exit;
		$results = $this->adapter->query($sqlString)->execute()->current(); 
		if($results['overtimeHour']) {
			return $results['overtimeHour'];
		} 
		return 0; 
	} 
	
	public function getEmployeeMealAmount($companyId) {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'MealAmount'))
		       ->columns(array('amount')) 
			   ->where(array('companyId' => $companyId))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString; 
		//exit; 
		$results = $this->adapter->query($sqlString)->execute()->current();
		if($results['amount']) {
		    return $results['amount']; 
		}
		return 0;
	}
	
	public function getEmployeeTotalMeal(Employee $employee,DateRange $dateRange) { 
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		};
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};
		$where = " (1=1) ";
		$where .= " and o.employeeId = '".$employee->getEmployeeNumber()."' ";
		$where .= " and o.mealDate >= '".$dateRange->getFromDate()."' ";
		$where .= " and o.mealDate <= '".$dateRange->getToDate()."' ";
		$statement = $adapter->query("
				SELECT sum(numberOfMeals) as numberOfMeals
				FROM mealDtls AS o
				where   $where
                 
				");
		// echo $statement->getSql();
		// exit;
		$row = $statement->execute()->current(); 
		if($row['numberOfMeals']) {
			return $row['numberOfMeals'];
		}
		return 0; 
	}
	
	// @note date range is not used now 
	public function getRelatedAllowance($allowanceId,Company $company) {
		// AllowanceAffectedAllowance
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('aa' => 'AllowanceAffectedAllowance'))
		       ->columns(array('id','allowanceId','affectedAllowanceId')) 
			   ->where(array('companyId' => $company->getId()))
			   ->where(array('allowanceId' => $allowanceId))
		; 
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString; 
		//exit; 
		return $this->adapter->query($sqlString)->execute();
		// return $results; 
	} 
	
	public function getNotToHaveAllowance($allowanceId,Company $company,DateRange $dateRange) {
		// AllowanceAffectedAllowance
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('aa' => 'AllowanceNotToHaveAllowance'))
		       ->columns(array('id','allowanceId','notToHaveAllowance','priority'))
		       ->where(array('companyId' => $company->getId()))
		       ->where(array('allowanceId' => $allowanceId))
		;       
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString;
		//exit;
		return $this->adapter->query($sqlString)->execute();
		// return $results;
	}
	
	public function getAllowancePriority($allowance,$notToHaveAllowance,Company $company) {
		// AllowanceAffectedAllowance
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('aa' => 'AllowanceNotToHaveAllowance'))
		       ->columns(array('id','allowanceId','notToHaveAllowance','priority'))
		       ->where(array('companyId' => $company->getId()))
		       ->where(array('allowanceId' => $notToHaveAllowance))
		       ->where(array('notToHaveAllowance' => $allowance))
		; 
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString; 
		//exit; 
		$row = $this->adapter->query($sqlString)->execute()->current();
		// echo "After ".$allowance." - ".$notToHaveAllowance." - ".$row['priority']."<br/>";  
		if($row['priority']) {
			return $row['priority'];
		}
		return 0; 
		// return $results; 
	}
	
	public function getAllowanceTypeName($allowanceId,Company $company) {
		// AllowanceAffectedAllowance
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('ca' => 'CompanyAllowance')) 
		       ->columns(array('allowanceTypeName'))
		       //->join(array('l' => 'Location'),'e.locationId = l.id', 
		       		  //array('overtimeHour')) 
		       ->where(array('companyId' => $company->getId()))
		       ->where(array('allowanceId' => $allowanceId)) 
		;  
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString;
		//exit;
		$row = $this->adapter->query($sqlString)->execute()->current();
		// echo "After ".$allowance." - ".$notToHaveAllowance." - ".$row['priority']."<br/>";
		if($row['allowanceTypeName']) {
			return $row['allowanceTypeName']; 
		} 
		return 0;  
		// return $results;  
	}   
	
	public function getAllowanceIdByName($allowanceTypeName) {
		// AllowanceAffectedAllowance
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('ca' => 'Allowance'))
		       ->columns(array('id','allowanceName')) 
		       //->where(array('companyId' => $company->getId()))
		       ->where(array('allowanceName' => $allowanceTypeName))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString;
		//exit;
		$row = $this->adapter->query($sqlString)->execute()->current();
		// echo "After ".$allowance." - ".$notToHaveAllowance." - ".$row['priority']."<br/>";
		if($row['id']) { 
			return $row['id']; 
		} 
		return 0; 
		// return $results; 
	} 
	
	public function getSplHousing($employeeId) {
		// AllowanceAffectedAllowance
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('s' => 'SpecialHousing'))
		       ->columns(array('amount'))
	         //->where(array('companyId' => $company->getId()))
		       ->where(array('employeeId' => $employeeId))
		;  
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString;
		//exit;
		$row = $this->adapter->query($sqlString)->execute()->current();
		// echo "After ".$allowance." - ".$notToHaveAllowance." - ".$row['priority']."<br/>";
		if($row['amount']) {
			return $row['amount'];
		}
		return 0; 
	}
	/*
	public function getAllowanceIdByName($allowanceTypeName) {
		// AllowanceAffectedAllowance
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('ca' => 'CompanyAllowance'))
		       ->columns(array('allowanceId','allowanceTypeName'))
		//->where(array('companyId' => $company->getId()))
		       ->where(array('allowanceTypeName' => $allowanceTypeName))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString;
		//exit;
		$row = $this->adapter->query($sqlString)->execute()->current();
		// echo "After ".$allowance." - ".$notToHaveAllowance." - ".$row['priority']."<br/>";
		if($row['allowanceId']) {
			return $row['allowanceId'];
		}
		return 0;
		// return $results;
	}*/
	
	public function isHaveHardship($positionId,Company $company) {
		// @todo fetch from history 
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('p' => 'Position'))
		       ->columns(array('positionLocation'))
		       ->join(array('l' => 'Location'),'p.positionLocation = l.id',
		              array('isHaveHardship'))
		       ->where(array('p.id' => $positionId))
		    ;
		$sqlString = $sql->getSqlStringForSqlObject($select); 
		//echo $sqlString; 
		//exit; 
		$row = $this->adapter->query($sqlString)->execute()->current(); 
		// echo "After ".$allowance." - ".$notToHaveAllowance." - ".$row['priority']."<br/>";
		//if($row['empLocation']) { 
		return $row['isHaveHardship'];  
		//} 
		//return 0; 
	} 
	
	public function isHaveNatureOfJob($positionId,Company $company,DateRange $dateRange) {
		// @todo fetch from history
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'PositionAllowance'))
		       ->columns(array('id'))
		//->join(array('l' => 'Location'),'e.empLocation = l.id',
				//array('isHaveHardship'))
			   ->where(array('positionId' => $positionId))
			   // @todo get from DB by name
			   ->where(array('allowanceId' => '14'))
			   //->where(array('companyId' => $company->getId()))
	    ;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//if($positionId == 63) {
		//echo $sqlString;
		//exit;
		//}
		$row = $this->adapter->query($sqlString)->execute()->current();
		//\Zend\Debug\Debug::dump($row);
		// echo "After ".$allowance." - ".$notToHaveAllowance." - ".$row['priority']."<br/>";
		if($row['id']) {
			//echo "have noj";
			//exit; 
			return 1;
		}
		//echo "have noj";
		//exit;
		return 0;
	}
	
	public function ishaveAirport($positionId,Company $company,DateRange $dateRange) {
		// @todo fetch from history
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'PositionAllowance'))
		       ->columns(array('id'))
		//->join(array('l' => 'Location'),'e.empLocation = l.id',
		//array('isHaveHardship'))
		       ->where(array('positionId' => $positionId))
		// @todo get from DB by name
		       ->where(array('allowanceId' => '1'))
		       ->where(array('companyId' => $company->getId()))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//if($positionId == 63) {
		//echo $sqlString;
		//exit;
		//}
		$row = $this->adapter->query($sqlString)->execute()->current();
		//\Zend\Debug\Debug::dump($row);
		// echo "After ".$allowance." - ".$notToHaveAllowance." - ".$row['priority']."<br/>";
		if($row['id']) {
			//echo "have noj";
			//exit;
			return 1;
		}
		//echo "have noj";
		//exit;
		return 0;
	}
	
} 