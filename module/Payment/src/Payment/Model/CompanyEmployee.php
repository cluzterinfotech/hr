<?php
namespace Payment\Model;

use Payment\Model\CompanyEmployeeInterface;
use Application\Contract\EntityCollectionInterface,
    Zend\Db\Adapter\Adapter;
use Application\Entity\CompanyAllowanceEntity;
use Application\Mapper\CompanyEmployeeMapper;
use Application\Mapper\PersonMapper;

class CompanyEmployee implements CompanyEmployeeInterface {
	
	protected $adapter;
	protected $collection;
	protected $employeeMapper;
	protected $person;
	
	public function __construct(Adapter $adapter, EntityCollectionInterface $collection) {
		$personMapper = new PersonMapper($adapter, $collection);
		$this->employeeMapper = new CompanyEmployeeMapper($adapter, $collection, $personMapper);
	}
    	
	public function getPaysheetEmployee(Company $company,DateRange $dateRange) {
		// @todo it have to return entity not array
		//$employeeArray = array(); 
		//$x = 'aaaaaaaaaa'; 
		//$emp = $this->employeeMapper->fetchAll(array('lkpSalaryGradeId' =>  12));
		
		$emp = $this->employeeMapper->fetchAll();
		return $emp;
		/* foreach ($emp as $employee) {
			//\Zend\Debug\Debug::dump($employee);
			$employeeArray[] = $employee;
		} */
		
		//\Zend\Debug\Debug::dump($emp);
		/* for($i=0;$i<10;$i++) {
			$person = new Person();
			$person->setId($i);
			$person->setEmployeeName($x++);
			
			$employee = new Employee();
			$employee->setEmpPersonalInfoId($person);
			$employee->setEmployeeNumber($eNo++);
			$employee->setCompanyId('1');
			$employeeArray[] = $employee; 
		} */
		
		//return $employeeArray;
		
	}
	
}