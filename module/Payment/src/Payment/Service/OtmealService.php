<?php

namespace Payment\Service;

use Payment\Mapper\OtmealMapper;

class OtmealService  {

    private $otmealMapper;
	
	public function __construct(OtmealMapper $otmealMapper) {
		$this->otmealMapper = $otmealMapper;
	}
	
	public function select() {
		return $this->otmealMapper->select();
	}
	
	public function insert($entity) {
		return $this->otmealMapper->insert($entity);
	}
	
	public function fetchById($id) {
		return $this->otmealMapper->fetchById($id);
	}
	
	public function update($entity) {
	    return $this->otmealMapper->update($entity);	
	}	
	
	
	
	public function getEmployeeDelegation($employeeId) {
		// @todo get all delegated chain and return last delegation 
		return false;
		/*
		 * return false;
		 * or
		 * return delegated employee 
		 */ 
	} 
    
	public function addEmployeeDelegation($employeeId,$delegatedEmployee) {
		// @todo  
		return false; 
	}
	
	public function getHigherPosition($id) {
		return array(
				''  => '',
				//'1' => 'Admin Assistant',
				'1' => 'Section Head ICT'.$id,
				'2' => 'Manager, HR Planning & Development sdfsd'
		); 
	}
	
	public function getOvertimeList() {
		return $this->otmealMapper->getOvertimeList();
	}
        public function getOvertimeBatchList() {
		return $this->otmealMapper->getOvertimeBatchList();
	}
	public function getCurrentOvertimeBatch() {
		return $this->otmealMapper->getCurrentOvertimeBatch();
	}
	public function saveOverTime($data) {
		//$employeeId = $data['']; 
		//if(!$this->isEmployeeAlreadyInCurrentBatch($employeeId)) {
		return $this->otmealMapper->saveOverTime($data);
                    
		//} 
		return 0;
	}
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
public function saveOverTimeBatch($data) {
		$employeeId = $data[''];//************* to retrun list from OvertimeMst to check if employee is on list
                //echo '------------------------'.$employeeId;exit;
		if(!$this->isEmployeeAlreadyInCurrentBatch($employeeId)) {
		    return $this->otmealMapper->saveOverTimeBatch($data);
                    
		} 
		return 0;
	}
	
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@	
        //**************************Apply overtime********************************************************
 //  2- to send request to the mapper to add data        
public function applyOverTime($dataMst ,$dataDtls) {
		$employeeId = $dataMst[''];//************* to reterun list from OvertimeMst
               $employeeId1 = $dataDtls[''];
              
                //echo '------------------------'.$employeeId;
		if(!$this->isEmployeeAlreadyInCurrentBatch($employeeId)) {
		    return $this->otmealMapper->applyOverTime($dataMst ,$dataDtls);
                    
		} 
		return 0;
	}         
//**********************************************************************************************
 //**************************Approve overtime********************************************************
 /*
public function approveOverTime($dataMst,$dataDtls) {
		$employeeId = $dataMst[''];//************* to reterun list from OvertimeMst
                $employeeId2 = $dataDtls[''];
		//--if(!$this->isEmployeeAlreadyInCurrentBatch($employeeId)) {
		    return $this->otmealMapper->approveOverTime($dataMst,$dataDtls);
                    
		//--} 
		//--return 0;
	}       */  
//**********************************************************************************************       
        
	public function isEmployeeAlreadyInCurrentBatch($employeeId) {
		$this->otmealMapper->isEmployeeAlreadyInCurrentBatch($employeeId); 
	}
	
	public function removeOverTime($id) {
		return $this->otmealMapper->removeOverTime($id);
	}
        
        public function removeOvertimeBatch($id) {
                return $this->otmealMapper->removeOvertimeBatch($id);
        }
//	
//	public function applyOvertime() {
//		// @todo 
//		// check is any position clash with employee
//		// any position shared by two employee
//	} (
        /*()((((((((((((((((((((((((((((((((((((((((((((((((((* 
        public function checkEmployee() {
                        return $this->otmealMapper->checkEmployee();
                        // return $level; 
                }
	public function  getEmployeeList() {
                        return $this->otmealMapper-> getEmployeeList();
                        // return $level; 
                }
               
        /*))))))))))))))))))))))))))))))))))))))))))))))))))*/
	public function getLevelByEmployee($employeeId) {
		return $this->otmealMapper->getLevelByEmployee($employeeId);
		// return $level; 
	}
	
	public function getPositionNameById($positionId) {
		return $this->otmealMapper->getPositionNameById($positionId); 
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
		return $this->otmealMapper->getImmediateSupervisorByEmployee($employeeId);
	}
	
	public function getHodByEmployee($employeeId) { 
        return $this->otmealMapper->getHodByEmployee($employeeId);
	}
	
	public function getHrManagerId() { 
	    return $this->otmealMapper->getHrManagerId($employeeId);
	}
}   
?>