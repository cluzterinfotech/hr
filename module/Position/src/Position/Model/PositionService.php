<?php

namespace Position\Model;

use Position\Mapper\PositionMapper;
use Position\Mapper\PositionAllowanceMapper;
use Payment\Model\Payment;
use Payment\Model\Company;
use Payment\Model\DateRange;
use Payment\Model\ReferenceParameter;
use Payment\Model\Employee;
//use Payment\Model\Payment\Model;

class PositionService extends Payment {
    
    public $output; 
    
    private $positionMapper; 
    
    private $positionAllowanceMapper;
	
	public function __construct(PositionMapper $positionMapper,
			PositionAllowanceMapper $positionAllowanceMapper,
			ReferenceParameter $reference 
		    ) {
		parent::__construct($reference);
		$this->positionMapper = $positionMapper;
		$this->positionAllowanceMapper = $positionAllowanceMapper;
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
		
		//return false;  
	} 
	
	public function getHigherPosition($id) {
		return $this->positionMapper->getHigherPosition($id); 
	} 
	
	public function getPositionMovementList() {
		return $this->positionMapper->getPositionMovementList();
	}
	
	
	
	public function getDelegationList() {
		return $this->positionMapper->getDelegationList();
	}
	
	public function savePositionMovement($data) { 
		// $employeeId = $data['']; 
		$employeeId       = $data['employeeId'];  
		$positionId       = $data['positionId'];
		$currpositionId   = $data['currentPositionId']; 
		if($positionId == $currpositionId) {
		    return 0; 
		}
		//if(!$this->isEmployeeAlreadyInCurrentPosition($employeeId,$positionId)) { 
		return $this->positionMapper->savePositionMovement($data); 
		//}    
		//return 0;    
	}   
    
	public function saveDelegation($data) {
		//$employeeId            = $data['employeeId'];
		//$delegatedEmployeeId   = $data['delegatedEmployeeId'];
		//$delegatedFrom         = $data['delegatedFrom'];
		//$delegatedTo           = $data['delegatedTo'];
		return $this->positionMapper->saveDelegation($data);
		// return 0;
	}

	
	
	public function isEmployeeAlreadyInCurrentPosition($employeeId,$positionId) {
		return $this->positionMapper->isEmployeeAlreadyInCurrentPosition($employeeId,$positionId); 
	}    
	/*public function CheckEmployeeAtTheMovmentBufferList($positionBufferList) {
	    return $this->positionMapper->CheckEmployeeAtTheMovmentBufferList($positionBufferList);
	}*/
	
	/*public function CheckEmployeeAtMovmentEnableSwap($positionBufferList) {
	    return $this->positionMapper->CheckEmployeeAtMovmentEnableSwap($positionBufferList);
	}*/
	
	public function removePositionMovement($id) {
		return $this->positionMapper->removePositionMovement($id);
	}
	
	public function removeDelegation($id) {
		return $this->positionMapper->removeDelegation($id); 
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
	
	public function isHrService($applicant,$approver) {
		$hrServiceId = $this->getHrServiceId(); 
		$delegatedEmp = $this->getEmployeeDelegation($hrServiceId);
		if($delegatedEmp && ($delegatedEmp == $approver) ) {
			return true;
		}
		if($hrServiceId == $approver) {
			return true;
		}
		return false;
	}
	
	
	
	public function isGeneralManager($applicant,$approver) {
		$gmId = $this->getGmId();
		$delegatedEmp = $this->getEmployeeDelegation($gmId);
		if($delegatedEmp && ($delegatedEmp == $approver) ) {
			return true;
		}
		if($gmId == $approver) {
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
	    return $this->positionMapper->getHrManagerId();
	}
	
	public function getGmId() {
		return $this->positionMapper->getGmId();
	}
	
	public function getHrServiceId() {
		return $this->positionMapper->getHrServiceId();
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
	
	public function getVacantPositionList() {
		return $this->positionMapper->getVacantPositionList();
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
			//return $res; 
		} catch(\Exception $e) { 
			$this->transaction->rollBack(); 
			throw $e; 
		}  
		if(!$res) { 
		    return "Position Allowances Applied successfully"; 
		}
		//exit;     
	}   
	
	public function applyAllowance(Company $company,$effectiveDate) {
		$c = 0; 
		$newPositionList = $this->positionAllowanceMapper
		                        ->getNewPositionAllowanceBufferList($company);
		foreach ($newPositionList as $position) {
			$c++; 
			if(!$this->isHavePositionAllowance($position)) { 
				// return "Position already exists"; 
				//} else { 
				$isUpdate = $position['isUpdate'];
				$positionId = $position['positionId']; 
				$isHaveHardship = $this->companyAllowance
				                       ->isHaveHardship($positionId,$company);
				$allowanceId = $position['allowanceId']; 
				//$companyId = $position['companyId']; 
				//$company = $this->service->get('company');  
				// Remove position from buffer 
				//\Zend\Debug\Debug::dump($allowanceId);
				//exit;
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
				if($employeeId) {
    				if($isUpdate) {
    					// to remove this allowance from employee 
    				    if(!$isHaveHardship) {
    				        $this->applyAffectedAmount($employeeId,'9',$company,$effectiveDate,'0'); 
    				    }
    					$this->applyAffectedAmount($employeeId,$allowanceId,$company,$effectiveDate,'0'); 
    				    // $this->addAllowanceToEmployee($employeeNumber, $allowanceId, $company, $effectiveDate)	
    				} else {
    				    if($isHaveHardship) {
    				        $this->addAllowanceToEmployee($employeeId,'9',$company,$effectiveDate);
    				    }
    				    $this->addAllowanceToEmployee($employeeId,$allowanceId,$company,$effectiveDate);
    				}
				}
			}
		}
		if($c == 0) {
			return "Sorry! no records found"; 
		} 
		return 0; 
	} 
	
	public function isHavePositionAllowance(array $position) {
		// @todo
	    /*positionId
	    allowanceId
	    companyId
	    isUpdate
	    [PositionAllowanceBufferNew]*/
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
	
	public function applyCurrentPositionMovement($effectiveDate,Company $company) {
	    //$company = $this->service->get('')
	    try {
	        $this->transaction->beginTransaction(); 
    	    $positionBufferList = $this->positionMapper->fetchPositionMovementBuffList();
    	    $isValidMovement = $this->checkIsMovementValid();  
    	    if($isValidMovement == '1') { 
        	    foreach ($positionBufferList as $lst) {
        	        $tempNumber = '121'; 
        	        $id = $lst['id'];
        	        $positionId = $lst['positionId']; 
        	        $employeeId = $lst['employeeId']; 
        	        $currentPosition = $lst['currentPositionId']; 
        	        $movementHistory = array (
        	            'positionId'        => $positionId,
        	            'employeeId'        => $employeeId,
        	            'effectiveDate'     => $effectiveDate,
        	            'currentPositionId' => $currentPosition,
        	        );         	        
        	        $isHaveHardship = $this->companyAllowance
        	                               ->isHaveHardship($positionId,$company);
        	        $prevAllowanceList = $this->positionAllowanceMapper
        	                                  ->getPositionAllowanceList($currentPosition,$company);
        	        $prevIsHaveHardship = $this->companyAllowance
        	                                   ->isHaveHardship($currentPosition,$company);
        	        //\Zend\Debug\Debug::dump($employeeId);                         
        	        //\Zend\Debug\Debug::dump($isHaveHardship);
        	        //\Zend\Debug\Debug::dump($prevIsHaveHardship);
        	        $this->positionMapper->updatePositionForMovement($employeeId,$positionId,$tempNumber);
        	        foreach($prevAllowanceList as $prevAllowance) {
        	            $prevAllowanceId = $prevAllowance['allowanceId'];
        	            $this->applyAffectedAmount($employeeId,$prevAllowanceId,$company,$effectiveDate,'0');
        	        }
        	        // remove hardship if not having 
        	        if($prevIsHaveHardship) { 
        	            $this->applyAffectedAmount($employeeId,'9',$company,$effectiveDate,'0');
        	        }
        	        $allowanceList = $this->positionAllowanceMapper
        	                              ->getPositionAllowanceList($positionId,$company); 
        	        foreach($allowanceList as $allowance) {
        	            $allowanceId = $allowance['allowanceId'];
        	            $this->addAllowanceToEmployee($employeeId,
        	                $allowanceId,$company,$effectiveDate);
        	        } 
        	        // apply hardhsip if 
        	        if($isHaveHardship) {
        	            $this->addAllowanceToEmployee($employeeId,'9',$company,$effectiveDate);
        	        } 
        	        $this->positionMapper->savePositionMovementHist($movementHistory);
        	        $this->removePositionMovement($id); 
        	    }
        	    $this->positionMapper->revertPositionMovementTemp($tempNumber); 
        	    //exit; 
        	    $this->transaction->commit(); 
    	    } else {
    	        return $isValidMovement." Invalid Movement list, please check the positions"; 
    	    }
	    } catch(\Exception $e) {
	        $this->transaction->rollBack();  
	        throw $e; 
	    }
	    return "success"; 
	}   
	
	protected function checkIsMovementValid($positionBufferList) {
	    $positionBufferList = $this->positionMapper->fetchPositionMovementBuffList();
	    foreach ($positionBufferList as $lst) { 
	        $positionId = $lst['positionId'];
	        $employeeId = $lst['employeeId'];
	        $currentPositionId = $lst['currentPositionId']; 
	        $isVacant = $this->positionMapper->isPositionVacant($positionId);
	        if(!$isVacant) {
	            $checkIsInList = $this->positionMapper->isPositionInCurrentMovement($positionId);
	            if(!$checkIsInList) {
	                return $positionId." is already occupied and the occupant is not in current movement";
	            }
	        } 
	        //echo "Position Id ".$positionId."<br/>"; 
	    }
	    //echo "Valid Movement"; 
	    //exit; 
	    return 1; 
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
	
	public function getPositionIdByEmpId($employeeId) {
		$employee = $this->getEmployeeById($employeeId);
		// $employee = new Employee();
		return $employee->getEmpPosition();
	}
	
	public function isHaveSubordinatesByEmployee($employeeId) {
	    $positionId = $this->getPositionIdByEmpId($employeeId); 
	    return $this->isHaveSubordinatesByPosition($positionId); 
	}
	
	public function isHaveSubordinatesByPosition($positionId) {
		return $this->positionMapper
		            ->isHaveSubordinatesByPosition($positionId);
	}
	
	public function isNonExecutive($employeeId) {
		$positionId = $this->getPositionIdByEmpId($employeeId); 
		return $this->positionMapper
		            ->isNonExecutive($positionId);
	}
	
	public function applyMovement() {
		
	}
	
	public function getChartDetailsByPositionId($positionId) {
		$employeeId = $this->positionMapper->getEmployeeByPosition($positionId);
		$position = $this->getPositionNameById($positionId);
		if($employeeId) {
			$employee = $this->getEmployeeById($employeeId); 
			$empName = $employee->getEmployeeName();  
			return $empName." - ".$position; 
		}
		return $position." - ___VACANT___"; 
	}
	
	public function getSubOrdinatesByPosition($positionId) {
		return $this->positionMapper->getSubOrdinatesByPosition($positionId);  
	}
	
	
	
	public function orgnChart() { 
		$output = ""; 
		$gm = $this->getFirstLevelPositionId(); 
		if ($gm) {
			$output .=  '<ul id="org" style="display: none;" >';
			$output .=  "<li>" . $this->getChartDetailsByPositionId($gm);
			$output .=  "<ul>";
			$result = $this->getSubOrdinatesByPosition($gm);
			//\Zend\Debug\Debug::dump($result);
			//exit; 
			foreach($result as $r) { 
				//\Zend\Debug\Debug::dump($r); 
				//exit; 
				$output .=  "<li>" . $this->getChartDetailsByPositionId($r['id']);
				$result1 = $this->getSubOrdinatesByPosition($r['id']);
				if ($result1) { 
					$output .=  '<ul>';
					foreach($result1 as $r1) { 
						//\Zend\Debug\Debug::dump($r1);
						//exit;
						$output .=  "<li>" . $this->getChartDetailsByPositionId($r1['id']);
						$result2 = $this->getSubOrdinatesByPosition($r1['id']);
						if ($result2) {
							$output .=  '<ul>';
							foreach ( $result2 as $r2 ) {
								$output .=  "<li>" . $this->getChartDetailsByPositionId($r2['id']);
								$result3 = $this->getSubOrdinatesByPosition($r2['id']);
								if ($result3) {
									$output .=  '<ul>';
									foreach ( $result3 as $r3 ) {
										$output .=  "<li>" . $this->getChartDetailsByPositionId($r3['id']);
										$result4 = $this->getSubOrdinatesByPosition($r3 ['id']);
										$output .=  '</li>';
									}
									$output .=  '</ul>';
								}
								$output .=  '</li>';
							}
							$output .=  '</ul>';
						}
						$output .=  '</li>';
					}
					$output .=  '</ul>';
				}
				$output .=  '</li>';
			}
			$output .=  "<ul>";
			$output .=  '</li>';
			$output .=  '</ul>';
			return $output; 
		}
		return $output; 
	} 
	
	public function getChairmanPositionId() {
	    return $this->positionMapper->getChairmanLevelPositionId(); 
	}
	
	public function getFirstLevelPositionId() {
	    return $this->positionMapper->getFirstLevelPositionId();
	} 
	
	public function orgnChartAllLevel() {
	    //$this->output = "";
	    $gm = $this->getFirstLevelPositionId(); 
	    if ($gm) {
	        $this->output .= '<ul id="org" style="display: none;" >';
	        $this->output .= "<li>"; 
	        $this->output .= $this->getChartDetailsByPositionId($gm);
	        $this->output .= "<ul>";
	        $result = $this->getSubOrdinatesByPosition($gm);
	        $this->orgnChartRecursive($result);
	        //
	    }
	    $this->output .= '</ul></li></ul>'; 
	    //$this->output .='</li></ul>'; 
	    return $this->output;  
	}
	
	public function orgnChartChairLevel() {
	    //$this->output = "";
	    $chairman = $this->getChairmanPositionId();
	    if ($chairman) {
	        $this->output .= '<ul id="org" style="display: none;" >';
	        $this->output .= "<li>";
	        $this->output .= $this->getChartDetailsByPositionId($chairman);
	        $this->output .= "<ul>";
	        $result = $this->getSubOrdinatesByPosition($chairman);
	        $this->orgnChartRecursive($result);
	        //
	    }
	    $this->output .= '</ul></li></ul>';
	    //$this->output .='</li></ul>';
	    return $this->output;
	} 
	
	public function orgnChartRecursive($result) { 
	    foreach ($result as $r) {
	        $this->output .=  "<li>".$this->getChartDetailsByPositionId($r['id']);
	        $result4 = $this->getSubOrdinatesByPosition($r['id']); 
	        if($result4) {
	            $this->output .=  "<ul>";
	            $this->orgnChartRecursive($result4); 
	        } else {
	            $this->output .=  "</li>";
	        }
	        $this->output .=  "</ul>";
	    }     	
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