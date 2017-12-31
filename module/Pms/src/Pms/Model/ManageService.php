<?php

namespace Position\Model;

use Position\Mapper\PositionMapper;
use Position\Mapper\PositionAllowanceMapper;
use Payment\Model\Payment;
use Payment\Model\Company;
use Payment\Model\DateRange;
use Payment\Model\ReferenceParameter;

class ManageService {
    
    private $positionMapper; 
    	
	public function __construct(PositionMapper $positionMapper) {
		$this->positionMapper = $positionMapper; 
	} 
	
	public function select() {
		return $this->positionMapper->select();
	} 
	
	public function insert($entity) {
		return $this->positionMapper->insert($entity);
	}
	
	public function selectList() { 
		return $this->positionMapper->selectList();
	}
	
	public function fetchById($id) {
		return $this->positionMapper->fetchById($id);
	}
	
	public function update($entity) {
	    return $this->positionMapper->update($entity);	
	}	
	
	public function getEmployeeDelegation($employeeId) {
		// @todo get all delegated chain and return last delegation 
		return false;  
	} 
    
	public function addEmployeeDelegation($employeeId,$delegatedEmployee) {
		// @todo  
		return false;  
	} 
	
	public function getHigherPosition($id) {
		return $this->positionMapper->getHigherPosition($id); 
	} 
	
	public function getPositionMovementList() {
		return $this->positionMapper->getPositionMovementList();
	}
	
	public function savePositionMovement($data) { 
		// $employeeId = $data['']; 
		$employeeId   = $data['employeeId'];  
		$positionId   = $data['positionId'];  
		if(!$this->isEmployeeAlreadyInCurrentPosition($employeeId,$positionId)) { 
		    return $this->positionMapper->savePositionMovement($data); 
		}    
		return 0;   
	}    
	
	public function isEmployeeAlreadyInCurrentPosition($employeeId,$positionId) {
		return $this->positionMapper->isEmployeeAlreadyInCurrentPosition($employeeId,$positionId); 
	}    
	
	public function removePositionMovement($id) {
		return $this->positionMapper->removePositionMovement($id);
	}
	
	public function applyPositionMovement() {  
		// @todo 
		// check is any position clash with employee
		// any position shared by two employee
	} 
	
	public function getLevelByEmployee($employeeId) {
		return $this->positionMapper->getLevelByEmployee($employeeId);
		// return $level; 
	}
	
	public function getPositionNameById($positionId) {
		return $this->positionMapper->getPositionNameById($positionId); 
	}
	
	public function isImmediateSupervisor($applicant,$approver) {
		$immSup = $this->getImmediateSupervisorByEmployee($applicant);
		$delegatedEmp = $this->getEmployeeDelegation($immSup);
		if($delegatedEmp && ($delegatedEmp == $approver) ) {
			return true;
		} 
		if($immSup == $approver) {
			return true;
		}
		return false;
	}
	
	public function isHod($applicant,$approver) {
		$hod = $this->getHodByEmployee($applicant);
		$delegatedEmp = $this->getEmployeeDelegation($immSup);
		if($delegatedEmp && ($delegatedEmp == $approver) ) {
			return true;
		}
		if($hod == $approver) {
			return true;
		}
		return false;
	}
	
	public function isHrManager($applicant,$approver) {
		$hrManagerId = $this->getHrManagerId();
		$delegatedEmp = $this->getEmployeeDelegation($hrManagerId);
		if($delegatedEmp && ($delegatedEmp == $approver) ) {
			return true;
		}
		if($hrManagerId == $approver) {
			return true;
		}
		return false;
	} 
	
	public function isGeneralManager($applicant,$approver) {
		$hrManagerId = $this->getHrManagerId();
		$delegatedEmp = $this->getEmployeeDelegation($hrManagerId);
		if($delegatedEmp && ($delegatedEmp == $approver) ) {
			return true;
		}
		if($hrManagerId == $approver) {
			return true;
		}
		return false;
	}
	
	public function getImmediateSupervisorByEmployee($employeeId) { 
		return $this->positionMapper->getImmediateSupervisorByEmployee($employeeId);
	}
	
	public function getHodByEmployee($employeeId) { 
        return $this->positionMapper->getHodByEmployee($employeeId); 
	}
	
	public function getHrManagerId() { 
	    return $this->positionMapper->getHrManagerId($employeeId);
	}
	
	public function getPositionList() {
		return $this->positionMapper->getPositionList();
	}
	
	public function selectPositionAllowance() {
		return $this->positionAllowanceMapper->selectPositionAllowance(); 
	}
	
	public function selectPositionAllowanceHist() {
		return $this->positionAllowanceMapper->selectPositionAllowanceHist();
	}
	
	public function selectPositionAllowanceNew() {
		return $this->positionAllowanceMapper->selectPositionAllowanceNew();
	}
	
	public function removePositionAllowanceBuffer($id) {
		return $this->positionAllowanceMapper->removePositionAllowanceBuffer($id);
	}
	
	public function savePositionAllowanceBuffer($formValues,$company) {
		// @todo check is already existing 
		$companyId = $company->getId(); 
		$isUpdate = 0;
		if($formValues['id']) {
			$isUpdate = 1;
		}
		// 'isUpdate'          => $isUpdate 
		$sgAllowanceInfo = array (
			'positionId'    => $formValues['positionName'],
			'allowanceId'   => $formValues['positionAllowanceName'],
			'companyId'     => $companyId,
			'isUpdate'      => $isUpdate 
		); 
		return $this->positionAllowanceMapper->savePositionAllowanceBuffer($sgAllowanceInfo);
	} 
	 
	public function applyCompanyPositionAllowance(Company $company,$effectiveDate) { 
		try { 
			$this->transaction->beginTransaction();
			$res = $this->applyAllowance($company,$effectiveDate);  
			$this->transaction->commit(); 
			return $res; 
		} catch(\Exception $e) { 
			$this->transaction->rollBack(); 
			throw $e; 
		}  
		return "Position Allowances Applied successfully"; 
		//exit;     
	}   
	
	public function applyAllowance(Company $company,$effectiveDate) {
		$c = 0; 
		$newPositionList = $this->positionAllowanceMapper
		                        ->getNewPositionAllowanceBufferList($company);
		foreach ($newPositionList as $position) {
			$c++; 
			if(!$this->isHavePositionAllowance($position)) {
				//\Zend\Debug\Debug::dump($position);
				//exit;
				// return "Position already exists"; 
				//} else { 
				$isUpdate = $position['isUpdate'];
				$positionId = $position['positionId']; 
				$allowanceId = $position['allowanceId']; 
				//$companyId = $position['companyId']; 
				$company = $this->service->get('company');  
				// Remove position from buffer 
				$this->positionAllowanceMapper 
				     ->removePositionAllowanceBuffer($position['id']);  
				if($isUpdate) {
					$this->positionAllowanceMapper
					    ->removePositionAllowanceMain($position);
					// \Zend\Debug\Debug::dump($sgAllowance);
				}  else {
					unset($position['id']);
					unset($position['isUpdate']);
					$this->positionAllowanceMapper 
				         ->savePositionAllowanceMain($position); 
				}
                
				// get employee who belongs to the position 
				$employeeId = $this->positionMapper
				                   ->getEmployeeByPosition($positionId);
				if($isUpdate) {
					// to remove this allowance from employee
					$this->applyAffectedAmount($employeeId,$allowanceId,$company,$effectiveDate,'0'); 
				    // $this->addAllowanceToEmployee($employeeNumber, $allowanceId, $company, $effectiveDate)	
				} else {
				    $this->addAllowanceToEmployee($employeeId,$allowanceId,$company,$effectiveDate);
				}
			}
		}
		if($c == 0) {
			return "Sorry! no records found"; 
		} 
	} 
	
	public function isHavePositionAllowance(array $position) {
		// @todo
		return false; 
	} 
	
	public function addEmployeePositionAllowance($positionId,
			$employeeNumber,$company,$effectiveDate) {
		    // @todo add employee position allowance 
	    try {
			// $this->transaction->beginTransaction();
			
		    $allowanceList = $this->positionAllowanceMapper
		                          ->getPositionAllowanceList($positionId,$company); 
		    
			foreach($allowanceList as $allowance) { 
				$allowanceId = $allowance['allowanceId'];  
			    $this->addAllowanceToEmployee($employeeNumber,
			    		$allowanceId,$company,$effectiveDate); 
			} 
			// $this->transaction->commit();   
			// return $res;  
		} catch(\Exception $e) {  
			// $this->transaction->rollBack();   
			throw $e;   
		}   
	}  
	
	public function selectPositionAllowanceById($id) {
	    return $this->positionAllowanceMapper->selectPositionAllowanceById($id);
	}
	
	public function checkForMismatchPosition($effectiveDate) {
		// return 'success'; 
		// @todo 
		$positionBufferList = $this->positionMapper->fetchPositionMovementBuffList();   
		$vacantPosition = '159'; 
		$company = $this->service->get('company'); 
		$x = array(); 
		foreach ($positionBufferList as $lst) {   
			$id = $lst['id']; 
            if(!array_search($id,$x)) {  			
			    $positionId = $lst['positionId'];  
			    $employeeId = $lst['employeeId'];	 
			    if($this->isEmployeeAlreadyInCurrentPosition($employeeId,$positionId)) { 
			    	return $employeeId." Employee already in same position";   
			    }   
			    if($empNumber = $this->isPositionOccupiedByEmployee($positionId)) {  
			    	// make sure the occupied employee have other position
			    	if($this->isEmployeeInCurrentMovementList($empNumber)) {
			    		$swapEmp = $this->positionMapper->fetchRowByEmployee($empNumber); 
			    		$swapId = $swapEmp['id']; 
			    		$swapEmpId = $swapEmp['employeeId']; 
			    		$swapPosition = $swapEmp['positionId']; 
			    		$x[] = $swapId; 
			    		// remove existing 
			    		$this->updateCurrentEmpPosition($empNumber,$vacantPosition); 
			    		 
			    		// @todo add position allowance  
			    		// @todo remove old position allowance    
			    		$this->updateCurrentEmpPosition($employeeId,$employeeId); 
			    		$this->addEmployeePositionAllowance($positionId,$employeeId,$company,$effectiveDate);
			    		// @todo add position allowance  
			    		// @todo remove old position allowance
			    		$this->updateCurrentEmpPosition($swapEmpId,$swapPosition);
			    		$this->addEmployeePositionAllowance($swapPosition,$swapEmpId,$company,$effectiveDate);
			    		
			    		$empOne = array (
			    				'positionId'    => $employeeId,
			    				'employeeId'    => $employeeId,
			    				'effectiveDate' => $effectiveDate
			    		);
			    		$empTwo = array (
			    				'positionId'    => $swapPosition,
			    				'employeeId'    => $swapEmpId,
			    				'effectiveDate' => $effectiveDate
			    		); 
			    		$this->positionMapper->savePositionMovementHist($empOne); 
			    		$this->positionMapper->savePositionMovementHist($empTwo);
			    		$this->removePositionMovement($id);
			    		$this->removePositionMovement($swapId);
			    	} else { 
			    	    return $empNumber." Employee have no replacement position, but his position is moved"; 
			    	}                            	    	
			    } else { 
			    	$empOne = array (
			    		'positionId'    => $employeeId,
			    		'employeeId'    => $employeeId,
			    		'effectiveDate' => $effectiveDate
			    	);
			    	$this->positionMapper->savePositionMovementHist($empOne);
			    	// @todo add position allowance 
			    	// @todo remove old position allowance 
			    	$this->updateCurrentEmpPosition($employeeId,$positionId);  
			    	$this->addEmployeePositionAllowance($positionId,$employeeId,$company,$effectiveDate); 
			    	$this->removePositionMovement($id);   
			    } 
            }    
		}       
	    return "success";      
	}   
	
	protected function updateCurrentEmpPosition($empNumber,$positionId) {
		
	}
	
	public function isEmployeeInCurrentMovementList($employeeId) {
		return $this->positionMapper->isEmployeeInCurrentMovementList($employeeId); 
	}
	
	public function getPositionCountFromBuff($positionId) {
		// @todo implementation  
		return 1; 
	} 
	
	public function isPositionOccupiedByEmployee($positionId) { 
		$empNumber = $this->positionMapper->getEmployeeByPosition($positionId); 
		if($empNumber) {
			return $empNumber; 
		}
		return 0;  
	} 
	
	public function applyMovement() {
		
	}
	
	/*public function swapTest() { 
		$positionBufferList = $this->positionMapper->fetchPositionMovementBuffList();
		$vacantPosition = '159';
		foreach ($positionBufferList as $lst) {
			\Zend\Debug\Debug::dump($lst); 
			$id = $lst['id'];
			$positionId = $lst['positionId'];
			$employeeId = $lst['employeeId'];
			$empNumber = $this->isPositionOccupiedByEmployee($positionId);  
			\Zend\Debug\Debug::dump($empNumber); 
			$swapEmp = $this->positionMapper->fetchRowByEmployee($empNumber);  
			//\Zend\Debug\Debug::dump($swapEmp);  
			$swapId = $swapEmp['id']; 
			$swapEmpId = $swapEmp['employeeId'];
			$swapPosition = $swapEmp['positionId'];
			\Zend\Debug\Debug::dump($swapEmpId); 
			//exit; 
			$this->removePositionMovement($id);  
			$this->removePositionMovement($swapId); 
			//exit; 
		} 
		exit; 
    }*/  
    
	//ChangeEmployeePosition
	//$this-> 
	//ApproveEmployeePosition
	//ChangePositionAllowance
	//ApprovePositionAllowance
		
}   
?>