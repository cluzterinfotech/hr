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
use Payment\Model\Person;
use Zend\Db\Sql\Where;
use Payment\Model\DateRange;
use Payment\Model\Company;

/*
 * all the employee related info 
 */
class CompanyEmployeeMapper extends AbstractDataMapper {
	
	protected $entityTable = "EmpEmployeeInfoMain"; 
	protected $person; 
	protected $companyId; 
	
	public function __construct(zendAdapter $adapter, 
			EntityCollectionInterface $collection,$sm
			,PersonMapper $person 
			,$entityTable = null) {
		$this->companyId = new CompanyMapper($adapter,$collection,$sm);
		$this->person = $person;
		parent::__construct($adapter,$collection,$sm,$entityTable); 
	}
	
	protected function loadEntity(array $row) {  
	    $employee = new Employee();  
	    $employee->setId($row['id']); 
	    $employee->setEmployeeName(trim($row['employeeName']));
	    $employee->setEmployeeNumber(trim($row['employeeNumber'])); 
	    $employee->setEmpJoinDate($row['empJoinDate']);
	    $employee->setEmpSalaryGrade($row['empSalaryGrade']); 
	    $employee->setCompanyId($row['companyId']);
	    $employee->setEmpDateOfBirth($row['empDateOfBirth']); 
	    $employee->setReligion($row['religion']);
	    $employee->setEmpPosition($row['empPosition']);
	    $employee->setMaritalStatus($row['maritalStatus']);
	    $employee->setNumberOfDependents($row['numberOfDependents']); 
	    $employee->setEmpLocation($row['empLocation']);
	    //$employee->setCompanyId($row['religion']);
	    //$employee->setSalaryGradeId($row['lkpSalaryGradeId']); 
	    //$employee->setEmpPersonalInfoId( 
	    		//$this->person->fetchById($row['empPersonalInfoId']) 
	    //); 
	    return $employee;   
	}  
	// Employee latest information will be loaded  
	public function fetchEmployeeByNumber($employeeNumber) {
		// @todo load this employee to identity map for cache
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('*'))
		       //->join(array('ep' => 'EmpPersonalInfo'),'ep.id = e.empPersonalInfoId',
			          //array('employeeName','empPersonalInfoId' => 'id'))
			   ->Where(array('employeeNumber' => $employeeNumber))
			   ;  
		       
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString; 
		//exit; 
		$results = $this->adapter->query($sqlString)->execute()->current(); 
		//$row = $this->loadEntityCollection($results);
		//\Zend\Debug\Debug::dump($results->current());
		//exit; 
		if($results) {
		    return $this->loadEntity($results);
		} else { 
			return 0;  
		} 
	}   
	
	/*public function fetchPaysheetEmployee( Company $company,DateRange $dateRange) { 
		$this->setEntityTable('paysheet');
	}*/ 
	
	//  
	public function fetchEmployeeSalaryGrade($employeeNumber,DateRange $dateRange) {
		//return '22';
		// @todo load this employee to identity map for cache
		$sql = $this->getSql(); 
		$select = $sql->select(); 
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('id','employeeNumber','empSalaryGrade'))
		//->join(array('ep' => 'EmpPersonalInfo'),'ep.id = e.empPersonalInfoId',
				//array('employeeName','empPersonalInfoId' => 'id'))
				->Where(array('employeeNumber' => $employeeNumber))
		; 
		 
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute();
		//$row = $this->loadEntityCollection($results);
		//\Zend\Debug\Debug::dump($row);
		//exit;
		$row = $results->current();
		return $row['empSalaryGrade'];
	}
}   