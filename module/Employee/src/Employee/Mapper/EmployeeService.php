<?php

namespace Employee\Mapper; 

use Payment\Model\Company;
use Payment\Model\ReferenceParameter;
use Payment\Model\Payment;
use Application\Utility\DateMethods;

class EmployeeService extends Payment  {
    	
	protected $service; 
	protected $employeeMapper; 
	
	protected $positionService;
	protected $locationService;
	protected $salaryGradeService; 
	protected $affiliationService;
	
		
	public function __construct(ReferenceParameter $reference,
			EmployeeMapper $employeeMapper) { 
        parent::__construct($reference);  
        $this->employeeMapper = $employeeMapper; 
        $this->locationService = $this->service->get('locationService');  
        $this->positionService = $this->service->get('positionService');  
        $this->salaryGradeService = $this->service->get('salaryGradeService');   
        $this->affiliationService = $this->service->get('affiliationService'); 
	} 
	
	// Have to return   
	public function employeeWithDelegatedList() { 
		// $employeeNumber = '1100'; 
		// @todo prepare admin based list 
		$employeeNumber = $this->userInfoService->getEmployeeId(); 
        
		$isAdmin = 0; 
		if($isAdmin) { 
			return $this->employeeList();  
		} else { 
			return $this->employeeMapper->employeeWithDelegatedList($employeeNumber); 
		}  
	}  
	 
	public function employeeList($companyId) { 
        return $this->employeeMapper->employeeList($companyId);            
	} 
	
	public function employeeWholeList() {
		return $this->employeeMapper->employeeWholeList($this->companyId);
	} 
	
	public function selectEmployee(Company $company) { 
		return $this->employeeMapper->selectEmployee($company);
	}
	
	public function getEmployeeInfoReport($company,$values) {
		return $this->employeeMapper->fetchEmployeeExisting($company);
	}
	
	public function getTerminatedEmployeeInfoReport($company,$values) { 
		return $this->employeeMapper->fetchEmployeeTerminated($company,$values);
	}
	
	public function notConfirmedEmployeeList(Company $company) {
		return $this->employeeMapper->notConfirmedEmployeeList($company);
	}
	
	public function notTakenLAEmployeeList(Company $company) {
		return $this->employeeMapper->notTakenLAEmployeeList($company); 
	}
	
	public function notTakenFEEmployeeList(Company $company) {
		return $this->employeeMapper->notTakenFEEmployeeList($company);
	}
	
	// current list 
	public function employeeInfo($employeeNumber) {
		$employee = $this->getEmployeeById($employeeNumber);
		$positionId = $employee->getEmpPosition();  
		return array(
			'position'          =>$positionId,
			'department'   => 3,
			'location'          => $employee->getEmpLocation(),
			'doj'                   => date('Y-m-d',strtotime($employee->getEmpJoinDate())),
		); 
	} 
	
	public function getSalaryInfo($employeeNumber) {
		$oldInitial = $this->getEmployeeInitial($employeeNumber);
		$oldCola = $this->getEmployeeCola($employeeNumber); 
		$salaryInfo = array(
				'oldInitial'     => $this->twoDigit($oldInitial['oldInitial']),
				'oldCola'        => $this->twoDigit($oldCola),
		);
		return $salaryInfo; 
	} 
	
	public function getEmployeeInitial($employeeNumber) { 
		return $this->employeeMapper->getEmployeeInitial($employeeNumber);   
	} 
	
	public function getEmployeeAllowanceAmount($employeeNumber , $allowanceId) {
	    return $this->employeeMapper->getEmployeeAllowanceAmount($employeeNumber , $allowanceId);
	} 
    
	public function getEmployeeCola($employeeNumber) {
		return $this->employeeMapper->getEmployeeCola($employeeNumber);
	}
	
	public function getEmployeeInitialFromBuffer($employeeNumber) {
		return $this->employeeMapper->getEmployeeInitialFromBuffer($employeeNumber);
	}
	
	public function insertNewEmployeeInfoBuffer($data) { 
		return $this->employeeMapper->insertNewEmployeeInfoBuffer($data);  
	} 
	
	public function updateNewEmployeeInfoBuffer($data) {
		return $this->employeeMapper->updateNewEmployeeInfoBuffer($data);
	} 
	
	public function updatePhotoLoc($employeeNumber,$empImg) {
	    return $this->employeeMapper->updatePhotoLoc($employeeNumber,$empImg);
	}
	
	public function updateExistingEmployeeInfoMain($data) {
		return $this->employeeMapper->updateExistingEmployeeInfoMain($data);
	}
	
	public function removeEmployeeInitialBuffer($id) {
		return $this->employeeMapper->removeEmployeeInitialBuffer($id);
	} 
	public function removeEmployeeSpecialAmountBuffer($id) {
	    return $this->employeeMapper->removeEmployeeSpecialAmountBuffer($id);
	} 	
	public function selectEmployeeInitialBuffer() {
		return $this->employeeMapper->selectEmployeeInitialBuffer(); 
	} 
	
	public function selectSpecialAmountBuffer() {
	    return $this->employeeMapper->selectSpecialAmountBuffer();
	} 
	
	public function saveEmployeeConfirmation($formValues) {
		$confirmationInfo = array (
			'employeeNumberConfirmation' => $formValues['employeeNumberConfirmation'],
			'effectiveDate' => $formValues['effectiveDate'],
			'appliedDate' => $formValues['appliedDate'],
			'confirmationNotes' => $formValues['confirmationNotes'],
			'oldSalary' => $formValues['oldSalary'],
			'oldCola' => $formValues['oldCola'],
			'adjustedAmount' => $formValues['adjustedAmount'],
			'percentage' => $formValues['percentage'], 		
			'companyId' => $formValues['companyId']
		); 
		$this->employeeMapper->saveEmployeeConfirmation($confirmationInfo); 
	} 
	
	public function saveEmployeeInitialBuffer($formValues) {  
		$company = $this->service->get('company'); 
		$initialInfo = array (  
			'addedDate'      => date('Y-m-d'),  
			'newAmount'      => $formValues['newInitial'], 
			'employeeId'     => $formValues['employeeNumberInitial'], 
			'oldAmount'      => $formValues['oldInitial'], 
			'companyId'      => $company->getId(), 
		);  
		$this->employeeMapper->saveEmployeeInitialBuffer($initialInfo);  
	} 
	public function saveEmployeeAllowanceSpecialAmount($formValues) {
	    $company = $this->service->get('company');
	    $initialInfo = array (
	        'employeeNumber'     => $formValues['employeeNumberAllowance'],
	        'effectiveDate'      => $formValues['effectiveDate'],
	        'allowanceId'     => $formValues['allowanceId'],
	        'amount'      => $formValues['newAmount'],
	        'oldAmount'      => $formValues['oldAmount'],
	        'isAdded'      => $formValues['isAdded'],
	    );
	    $this->employeeMapper->saveEmployeeAllowancespecialAmountBuffer($initialInfo);
	}
	
	
	
	public function fetchEmployeeById($id) {
		return $this->employeeMapper->fetchEmployeeById($id);
	}
	
	public function fetchSuspendById($id) {
	    return $this->employeeMapper->fetchSuspendById($id);
	}
	
	public function deleteSuspend($entity) {
	    return $this->employeeMapper->deleteSuspend($entity);
	}
	
	public function fetchExistingEmployeeById($id) {
		return $this->employeeMapper->fetchExistingEmployeeById($id);
	}
	
	public function selectEmployeeNew(Company $company) { 
		return $this->employeeMapper->selectEmployeeNew($company); 
	} 
	
	public function employeeNameNumber() { 
		return $this->employeeMapper->employeeNameNumber();
	}
	
	/*public function selectEmployee() {
		return $this->employeeMapper->selectEmployeeNew();
	}*/
	
	public function applyEmployeeTermination(Company $company) {
		try {
			// $c = 0;
			$this->transaction->beginTransaction();
			$terminatedBufferList =  $this->employeeMapper
			                              ->terminatedEmployeeListBuffer($company);
			if($terminatedBufferList) {
				foreach($terminatedBufferList as $lst) {
					// \Zend\Debug\Debug::dump($lst);
					$id = $lst['id'];
					$employeeNumber = $lst['employeeId'];
					$terminationDate = $lst['terminationDate'];
					// $companyId = $lst['companyId'];
					$companyId = $lst['companyId'];
					$empId = $this->employeeMapper
					              ->getIdByEmployeeNumber($employeeNumber); 
					$termination = array(
						'isActive'     => 0,
				        'positionTerminationReferenceNumber' 
							=> $empId,
						'id'           => $empId,
					);   
					// update main info
					$this->employeeMapper
					     ->update($termination);
					$terminationMain = array(
							'employeeId'              => $employeeNumber,
							'lkpTerminationTypeId'    => $lst['lkpTerminationTypeId'], 
							'notes'                   => $lst['notes'], 
							'terminationDate'         => $terminationDate,
							'companyId'               => $lst['companyId'],
								
					); 
					// add to termination info
					$this->saveEmployeeTerminationMain($terminationMain); 
					
					// remove from buffer
					$this->removeEmployeeTerminationBuff($id); 
					//\Zend\Debug\Debug::dump($confirmationArray);
					//exit;
				} 
				$this->transaction->commit();
			} else {
				return "No Employees added to terminate"; 
			}
			
			} catch(\Exception $e) { 
				$this->transaction->rollBack(); 
				throw $e; 
			}  
		return $company->getCompanyName()." Employee Terminated Successfully";
	}
	
	public function applyEmployeeConfirmation(Company $company) { 
		try {
			// $c = 0; 
			$this->transaction->beginTransaction();
		    $notConfirmedBufferList =  $this->employeeMapper
		                                    ->notConfirmedEmployeeListBuffer($company); 
		    if($notConfirmedBufferList) { 
			    foreach($notConfirmedBufferList as $lst) {
			        // \Zend\Debug\Debug::dump($lst); 
			    	$id = $lst['id']; 
			        $employeeNumber = $lst['employeeNumberConfirmation'];
			        $effectiveDate = $lst['effectiveDate']; 
			        $newAmount = $lst['adjustedAmount']; 
			        //$companyId = $lst['companyId']; 
			        $oldAmount = $lst['oldSalary'];   
			        $initialArray = array(
			            'newInitial'             => $newAmount, 
			            'employeeNumberInitial'  => $employeeNumber,
			            'oldInitial'             => $oldAmount, 
			        );  
			        $this->saveEmployeeInitialBuffer($initialArray); 
			        $this->applyInitialAfterTransaction($company,$effectiveDate); 
			        $this->removeEmployeeConfirmation($id); 
			        // update confirmation status
			        $empId = $this->employeeMapper
			                      ->getIdByEmployeeNumber($employeeNumber);
			        $confirmationArray = array(
			            'isConfirmed'      => 1,
			        	'confirmationDate' => $effectiveDate,
			        	'id'               => $empId		
			        ); 
			        $this->employeeMapper
			             ->updateExistingEmployeeConfirmation($confirmationArray);
			        //\Zend\Debug\Debug::dump($confirmationArray);
			        //exit;
			    } 
            } else { 
			    return "No Employees added to confirm";  
		    }  
			$this->transaction->commit();
		} catch(\Exception $e) {
		    $this->transaction->rollBack();
			throw $e;
		}
		return $company->getCompanyName()." Employee Confirmed Successfully";  
	} 
	
	public function getIdByEmployeeNumber($employeeNumber) { 
		return $this->employeeMapper
			        ->getIdByEmployeeNumber($employeeNumber);
	}
	
	public function approveNewEmployee($data,Company $company) { 
		try { 
			$c = 0; 
			$this->transaction->beginTransaction();   
			// $effectiveDate = date('Y-m-d',strtotime($data->getEffectiveDate())); 
			$employeeList = $this->employeeMapper 
			                     ->fetchEmployeeNew($company);   
			foreach ($employeeList as $emp) { 
				$c++;  
				//\Zend\Debug\Debug::dump($emp);  
				//exit;   
				$bufferId = $emp['id'];    
				unset($emp['id']);   
				$emp['isActive'] = 1;
				$emp['isInPaysheet'] = 1;
				// $emp[' companyId'] = $company->getId();
				//$emp['isActive'] = 1;
				// insert the record 
				//\Zend\Debug\Debug::dump($emp); 
				//exit; 
				$this->insertNewEmployeeInfoMain($emp);  
				$employeeNumber = $emp['employeeNumber']; 
				$effectiveDate = $emp['empJoinDate']; 
				$salGradeId = $emp['empSalaryGrade']; 
				$positionId = $emp['empPosition'];  
				$locationId = $emp['empLocation']; 
				$values = array(  
					'addedDate'             => date('Y-m-d'),  
				    'oldInitial'            => 0,   
					'newInitial'            => $emp['empInitialSalary'],      
					'employeeNumberInitial' => $employeeNumber,   
					'companyId'             => $company->getId(),      
				);    
				
				// insert initial buffer    
				$this->saveEmployeeInitialBuffer($values);  
				//\Zend\Debug\Debug::dump($company);
				//exit; 
				// insert initial main   
				$this->applyInitialAfterTransaction($company,$effectiveDate);   
				// insert location allowance  
				//$this->locationService 
				     //->addEmployeeLocationAllowance($locationId, 
				         //$employeeNumber,$company,$effectiveDate);  
				// add employee salary grade related allowance    
				$this->salaryGradeService 
				     ->addEmployeeSalaryGradeAllowance($salGradeId, 
				         $employeeNumber,$company,$effectiveDate);   
				// add employee position related allowance   
				$this->positionService 
				     ->addEmployeePositionAllowance($positionId, 
			             $employeeNumber,$company,$effectiveDate);  
				
				$this->affiliationService
				     ->addNewEmployeeAffiliation($employeeNumber,
			                            $company,$effectiveDate);
				$this->removeNewEmployeeFromBuffer($bufferId);     
				
			}   
			if($c == 0) {  
				return "Sorry! no records found";  
			}  
			//exit; 
			$this->transaction->commit();     
		} catch(\Exception $e) {   
			//$this->transaction->rollBack();
			throw $e;     
		}   
		return "Employees approved successfully"; 
	}  
	
	public function insertNewEmployeeInfoMain($data) {
		$this->employeeMapper->insertNewEmployeeInfoMain($data);  
	}
	
	/*public function updateExistingEmployeeInfoMain($data) {
		$this->employeeMapper->updateExistingEmployeeInfoMain($data); 
	}*/ 
	
	public function removeNewEmployeeFromBuffer($id) {
		$this->employeeMapper->removeNewEmployeeFromBuffer($id);
	}
	
	public function fetchEmployeeNew() { 
		return $this->employeeMapper->fetchEmployeeNew(); 
	}  
	
	public function saveEmployeeAllowanceSpecialAmountMain($formValues) {
	    $company = $this->service->get('company');
	    $initialInfo = array (
	        'employeeNumber'  => $formValues['employeeNumber'],
	        'effectiveDate'   => $formValues['effectiveDate'],
	        'allowanceId'     => $formValues['allowanceId'],
	        'amount'          => $formValues['amount'],
	        'isAdded'         => $formValues['isAdded'],
	    );
	    $this->employeeMapper->saveEmployeeAllowancespecialAmountMain($initialInfo);
	}
	 
	public function applyInitial(Company $company,$effectiveDate) { 
		try { 
			$c = 0; 
			$this->transaction->beginTransaction(); 
			$this->applyInitialAfterTransaction($company,$effectiveDate);  
			$this->transaction->commit(); 
		} catch(\Exception $e) { 
			$this->transaction->rollBack(); 
			throw $e; 
		}  
		return "Employee New Initial Amount Applied successfully Effective from - ".$effectiveDate; 
	} 
	
	public function applySpecialAmount(Company $company) {
	    try {
	        $c = 0;
	        $this->transaction->beginTransaction();
	        $this->prepareSpecialAmount($company); 
	        $this->applySpecialAmountAfterTransaction($company);
	        $this->transaction->commit();
	    } catch(\Exception $e) {
	        $this->transaction->rollBack();
	        throw $e;
	    }
	    return "Employee New Special Amount Applied successfully Effective from - ".$effectiveDate;
	}
	
	public function prepareSpecialAmount(Company $company) {
	   $results = $this->employeeMapper
	                   ->employeeSpecialAmountBufferList($company);
	   foreach($results as $r) {
	       $effectiveDate = $r['effectiveDate']; 
	       $months = $this->dateMethods->numberOfMonthsBetween($effectiveDate,date('Y-m-d')); 
	       //echo "Number of months ".$months."<br/>"; 
    	   for($i =0;$i<$months;$i++) {
    	       //echo "Eff Date ".$effectiveDate."<br/>"; 
    	       $myDate = date("Y-m-d",mktime(0, 0, 0,date("m",strtotime($effectiveDate)) + $i,
    	           date("d",strtotime($effectiveDate)),date("Y",strtotime($effectiveDate))
    	           )); 
    	       $r['effectiveDate'] = $myDate; 
    	       //echo "My Date ".$myDate."<br/>"; 
    	       //\Zend\Debug\Debug::dump($r); 
    	       $this->saveEmployeeAllowanceSpecialAmountMain($r,'1');
    	    }
    	    //exit; 
	    }
	}
	
	public function applySpecialAmountAfterTransaction(Company $company) {
	    $c = 0;
	    $employeeList = $this->employeeMapper
	                         ->employeeSpecialAmountBufferList($company);
	    foreach ($employeeList as $emp) { 
	        $c++;
	        $id = $emp['id'];
	        $employeeId = $emp['employeeNumber'];
	        $allowanceTable = $emp['allowanceId'];
	        $effectiveDate = $emp['effectiveDate'];
	        $allowanceId = $this->getAllowanceIdByName($allowanceTable);
	        $this->addAllowanceToEmployee($employeeId,$allowanceId,$company,$effectiveDate);
	        $this->employeeMapper->removeEmployeeSpecialAmountBuffer($id);
	        
	    }
	    if($c == 0) {
	        return "Sorry! no records found";
	    }
	} 
	
	public function applyInitialAfterTransaction(Company $company,$effectiveDate) {  
		$employeeList = $this->employeeMapper
		                     ->employeeNewInitialList($company); 
		foreach ($employeeList as $emp) { 
			$c++; 
			$id = $emp['id']; 
			$employeeId = $emp['employeeId'];
			$allowanceId = $this->getAllowanceIdByName('Initial');
			$this->addAllowanceToEmployee($employeeId,$allowanceId,$company,$effectiveDate);
			$this->removeEmployeeInitialBuffer($id);
			
		} 
		if($c == 0) { 
			return "Sorry! no records found"; 
		} 
	}
	
	public function selectEmployeeConfirmation() {
		return $this->employeeMapper->selectEmployeeConfirmation();
	}
	
	public function removeEmployeeConfirmation($id) {
		return $this->employeeMapper->removeEmployeeConfirmation($id);
	}
	
	public function removeEmployeeTerminationBuff($id) {
		return $this->employeeMapper->removeEmployeeTerminationBuff($id);
	}
	
	public function removeEmployeeSuspendBuff($id) {
		return $this->employeeMapper->removeEmployeeSuspendBuff($id);
	}
	
	public function selectEmployeeTermination() {
		return $this->employeeMapper->selectEmployeeTermination();
	}
	
	public function selectEmployeeSuspend() {
		return $this->employeeMapper->selectEmployeeSuspend();
	}
	
	public function selectEmployeeSuspended() {
	    return $this->employeeMapper->selectEmployeeSuspended();
	}
	
	public function selectEmployeeTerminationBuff() {
		return $this->employeeMapper->selectEmployeeTerminationBuff(); 
	}
	
	public function saveEmployeeTermination($formValues) {
		$terminationInfo = array (
		       'employeeId'       => $formValues['employeeNumberTermination'],
		       'terminationDate'  => $formValues['terminationDate'],
		       'lkpTerminationTypeId'  => $formValues['terminationType'],
		       'notes'                 => $formValues['terminationNotes'],
		       'companyId'        => $formValues['companyId']
		);   
		$this->employeeMapper->saveEmployeeTermination($terminationInfo); 
	} 
	
	public function saveEmployeeSuspendBuff($formValues) {
		$suspendInfo = array (
				'employeeId'       => $formValues['employeeNumberSuspend'],
				'suspendFrom'      => $formValues['suspendFromDate'],
				'suspendTo'        => $formValues['suspendToDate'],
				'reason'           => $formValues['suspendReason'],
				'companyId'        => $formValues['companyId']
		);
		$this->employeeMapper->saveEmployeeSuspendBuff($suspendInfo);
	}
	
	public function saveEmployeeTerminationMain($terminationInfo) {
		/*$terminationInfo = array (
				'employeeId'       => $formValues['employeeNumberTermination'],
				'terminationDate'  => $formValues['terminationDate'],
				'lkpTerminationTypeId'  => $formValues['terminationType'],
				'notes'                 => $formValues['terminationNotes'],
				'companyId'        => $formValues['companyId']
		);*/
		$this->employeeMapper->saveEmployeeTerminationMain($terminationInfo);
	}
	
	public function saveEmployeeSuspendMain($suspendInfo) { 
		$this->employeeMapper->saveEmployeeSuspendMain($suspendInfo);
	}
	
	public function saveEmployeeSuspendHist($suspendInfo) {
	    $this->employeeMapper->saveEmployeeSuspendHist($suspendInfo);
	}
	
	public function applyEmployeeSuspend(Company $company) {
		try {
			// $c = 0;
			$this->transaction->beginTransaction();
			$suspendBufferList =  $this->employeeMapper
			                              ->suspendEmployeeListBuffer($company);
			if($suspendBufferList) {
				foreach($suspendBufferList as $lst) {
					// \Zend\Debug\Debug::dump($lst);
					$id = $lst['id'];
					
					$suspendMain = array(
							'employeeId'     => $lst['employeeId'],
							'suspendFrom'    => $lst['suspendFrom'],
							'suspendTo'      => $lst['suspendTo'],
							'reason'         => $lst['reason'],
							'companyId'      => $lst['companyId'], 
					);
					// add to suspend info
					$this->saveEmployeeSuspendMain($suspendMain); 
					$this->saveEmployeeSuspendHist($suspendMain);
					// remove from buffer
					$this->removeEmployeeSuspendBuff($id);
				}
				
			} else {
				return "No Employees added to suspend";
			}
			$this->transaction->commit(); 
		} catch(\Exception $e) {
			$this->transaction->rollBack();
			throw $e;
		}
		return $company->getCompanyName()." Employee(s) Suspended Successfully";
	}
	
	public function getUniqueEmployeeNumber(Company $company) {
		try { 
			$id = $company->getId(); 
			$compRow = $this->employeeMapper->fetchCompanyById($id); 
			$prefix = $compRow['employeeIdPrefix']; 
			$value = $compRow['value']; 
			$newVal = $value + 1; 
			$array = array(
			    'id'    => $id,
				'value' => $newVal  		
			); 
			$this->employeeMapper->updateCompanyById($array);
			return $prefix."".$newVal;  			 
		} catch(\Exception $e) { 
			throw $e;
		}  	
	}
	
}