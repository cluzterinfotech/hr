<?php  

namespace Employee\Model;

use Payment\Model\Payment;
use Payment\Model\ReferenceParameter;
use Payment\Model\DateRange;
use Payment\Model\Company;
use Symfony\Component\Console\Output\BufferedOutput;
use Employee\Mapper\IncrementMapper;
use Payment\Model\Employee;

class IncrementService extends Payment {
	
	//protected $initialService;
	protected $incrementMapper; 
    	
    public function __construct(ReferenceParameter $reference,
    		IncrementMapper $incrementMapper) { 
    	parent::__construct($reference); 
    	$this->incrementMapper = $incrementMapper;  
    }  
    
    // @todo inject all the services 
    public function applyIncrement(Company $company,$colaPercentage,$effectiveDate) {
        // @todo change depends on company
        // @todo begin transaction 
    	// change salary grade cola percentage    
    	$sgAllowance = $this->service->get('salaryGradeService'); 
    	$employeeService = $this->service->get('employeeService'); 
    	
    	/*
    	1. fetch all salary grade
    	2. add to Buffer
    	3. apply from buffer 
    	*/ 
    	// @todo pass cola as parameter
    	// @todo clear previous sg allowances buffer 
        //$sgAllowance->existingSgAllowanceList($company,'6',$colaPercentage);
    	
    	//$sgAllowance->applyAllowance($company,$effectiveDate); 
    	
    	$incrementList = $this->getIncrementList($company);
    	//\Zend\Debug\Debug::dump($incrementList);
    	foreach($incrementList as $initial) { 
    		// $employeeNumber = $initial['employeeNumber']; 
    		// $promotedInitialSalary = $initial['oldInitial']; 
    		// $Current_Initial_Salary = $initial['incrementedValue']; 
	    	$formval = array (
	    			'newInitial'            => $initial['incrementedValue'],
	    			'employeeNumberInitial' => $initial['employeeNumber'],
	    			'oldInitial'            => $initial['oldInitial'], 
	    	); 
	    	//\Zend\Debug\Debug::dump($formval);   
	    	$employeeService->saveEmployeeInitialBuffer($formval);
    	} 
    	//exit; 
    	$employeeService->applyInitialAfterTransaction($company,$effectiveDate);
    	
    	// get salary grade service
    	// change salary grade allowance
    	
    	// update initial
    	// get employee service
    	// $employeeService
    	// update employee initial
    	
    	// update cola salary grade allowance for all 
    }
    
    
    public function getIncrementList(Company $company) {
    	$sgAllowance = $this->service->get('salaryGradeService');
    	return $sgAllowance->incrementList($company); 
    }
    
	public function maxQuartileOne($employeeNumber,DateRange $dateRange) {
		
		$employee = $this->getEmployeeById($employeeNumber); 
		// $employee = new Employee(); 
		$sgId = $employee->getEmpSalaryGrade(); 
		return $this->incrementMapper->getMaxQuartileOne($sgId); 
		//return '9099';
	}
	
	public function tenPercentageNextMid($salaryGrade,$dateRange) {
		$sg = $salaryGrade + 1; 
		return ($this->incrementMapper->getMidValue($sg))*.1;
	}
	
	public function selectEmployeeRating(Company $company) { 
		return $this->incrementMapper->selectEmployeeRating($company); 
	}
	
	public function selectSalaryStructure(Company $company) {
		// return array(); 
		return $this->incrementMapper->selectSalaryStructure($company);
	}
	
	public function selectIncAnniv(Company $company) {
		return $this->incrementMapper->selectIncAnniv($company);
	}
	
	public function selectQuartileRating(Company $company) {
		// return array();
		return $this->incrementMapper->selectQuartileRating($company);
	} 
	
	public function selectIncrementCriteria(Company $company) {
		// return array();
		return $this->incrementMapper->selectIncrementCriteria($company);
	}
	
	public function fetchCriteriaById($id) {
		return $this->incrementMapper->fetchCriteriaById($id); 
	}
	
	public function insertCriteria($entity) {
		return $this->incrementMapper->insertCriteria($entity); 
	}
	
	public function updateCriteria($entity) {
		return $this->incrementMapper->updateCriteria($entity);
	}
	
	public function fetchQuartileRatingById($id) {
		return $this->incrementMapper->fetchQuartileRatingById($id);
	}
	
	public function updateQuartile($entity) {
		return $this->incrementMapper->updateQuartile($entity);
	}
	
	public function fetchSalStructureById($id) {
		return $this->incrementMapper->fetchSalStructureById($id);
	}
	
	public function updateSalStructure($entity) {
		return $this->incrementMapper->updateSalStructure($entity);
	}
	
	public function isHaveIncrement(Company $company,DateRange $dateRange) {
		return 1; 
		return $this->incrementMapper->isHaveAnnivIncrement($company,$dateRange);
	}
    
	public function isHaveAnnivIncrement(Company $company,DateRange $dateRange) {
	    return $this->incrementMapper->isHaveAnnivIncrement($company,$dateRange);      	
	}
	
	public function blankCloseAnniversary(Company $company,DateRange $dateRange) {
	    
	} 
	
	public function calculateIncrement(Company $company) {
		// select all employee
	    // $empInitial = $model->getEmpInitialSalary($db,$empId);
	    // $compRatio = $model->getQuartileValue($db,$empId);
	    // $incPercentage = $model->getIncrementPercentage($db,$empId);
	    // $quartileRating = $model->getEmpQuartileRating($db,$empId);
	    // $incMidValue = $model->getIncMidValue($db,$empId);
	    // $salGrade = $model->getEmpSalaryGrade($db,$empId);
	    // $quartileRange = $model->getEmpQuartileRange($db,$empId);
	    // $splCompensation = $model->getSplCompensationNew($diff);
	    /*if($acttualSickLeave > $allowedSickLeave) {
	     $empIncrement = 0;
	     $meritLumpsum = 0;
	     }*/
	    // $empIncrement = $model->twoDigit($empIncrement);
	}
	
	public function calculateAnniversaryIncrement(Company $company,DateRange $dateRange) {
		// get list 
		$this->incrementMapper->clearPreviousAnnivInc($company,$dateRange); 
	    $list = $this->incrementMapper->getAnnivIncrementEmployeeList($company,$dateRange);  
	    $incPercentage = $this->incrementMapper
	                          ->getAnnivIncPercentage($company,$dateRange);   
	    foreach($list as $lst) {  
	    	$employeeNumber = $lst['employeeNumber'];   
	    	$service = $this->service->get('initial'); 
	    	$employee = $this->getEmployeeById($employeeNumber); 
	    	$initial = $service->getAmount($employee,$dateRange);   
	    	$newInitial = ($initial * ($incPercentage/100)) + $initial;  
	    	$data = array( 
	    		'addedDate'   => date('Y-m-d'), 
	    		'oldAmount'   => $this->twoDigit($initial),
	    		'employeeId'  => $employeeNumber,
	    		'newAmount'   => $this->twoDigit($newInitial), 
	    		'companyId'   => $company->getId()
	    			
	    	); 
	    	$this->incrementMapper->insertAnnivInc($data); 
	        // \Zend\Debug\Debug::dump($lst);  
	    }   
	}   
	
	public function applyAnnivInc(Company $company,DateRange $dateRange) {
		try {
			$c = 0;
			$this->transaction->beginTransaction(); 
			$list = $this->incrementMapper->getAnnivIncrementBufferList($company,$dateRange);
			$employeeService = $this->service->get('employeeService');
			foreach ($list as $lst) {
				//\Zend\Debug\Debug::dump($lst); 
				$id = $lst['id']; 
				$emp = $lst['employeeId'];  
				$employee = $this->getEmployeeById($emp);  
				// $employe = new Employee();
				$effectiveDate = $employee->getEmpJoinDate(); 
				$values = array(
						'addedDate'             => date('Y-m-d'),
						'oldInitial'            => $lst['oldAmount'],
						'newInitial'            => $lst['newAmount'],
						'employeeNumberInitial' => $emp,
						'companyId'             => $company->getId(),
				);
				$employeeService->saveEmployeeInitialBuffer($values);  
				$employeeService->applyInitialAfterTransaction($company,$effectiveDate); 
				$this->incrementMapper->removeAnnivIncBuff($id);  
			} 
			//exit; 
			$this->transaction->commit();
		} catch(\Exception $e) {
			$this->transaction->rollBack();
			throw $e;
		} 
	}
	
	public function fetchAnnivIncById($id) {
		return $this->incrementMapper->fetchAnnivIncById($id);
	}
	
	public function insertAnnivInc($entity) {
		return $this->incrementMapper->insertCriteria($entity);
	}
	
	public function updateAnnivInc($entity) {
		return $this->incrementMapper->updateAnnivInc($entity);
	} 
	
	
}