<?php   

namespace Leave\Model;

use Leave\Mapper\LeaveFormMapper;
use Leave\Mapper\ApprovalLevelMapper;
use Position\Model\PositionService;

class ApprovalService { 
    
	private $positionService;
	
	private $approvalLevelMapper;
	
	public function __construct(PositionService $positionService,
			ApprovalLevelMapper $approvalLevelMapper) {   
		$this->positionService  = $positionService;
		$this->approvalLevelMapper = $approvalLevelMapper; 
	}
	
    public function isApprover($formType,$applicant,$approver,$approvedLevel) {  
    	//\Zend\Debug\Debug::dump($approvedLevel);  
    	//exit; 
    	$approvedLevel += 1; 
        $isApprover = 0;  
		switch ($formType) {  
		    case "Leave":  
		    	$levelRow = $this->approvalLevelMapper->getLeaveLevelRow($approvedLevel);  
		        $isApprover = $this->leaveForm($applicant,$approver,$levelRow); 
		        break; 
		    case "TravelLocal":  
		    	//$isApprover = 1; 
		    	$level = $this->approvalLevelMapper->getTravelLocalLevelRow($approvedLevel); 
		        $isApprover = $this->travelLocalForm($applicant,$approver,$level); 
		        //$isGm = $this->isGeneralManager($applicant, $approver); 
		        //if()
		        
		        break;  
		    case "TravelAbroad":  
		    	//$isApprover = 1;
		    	$level = $this->approvalLevelMapper->getLeaveApprovalLevel($approvedLevel); 
		        $isApprover = $this->travelAbroadForm($applicant,$approver,$level);  
		        break;  
		    case "OverTime": 
		    	//$isApprover = 1; 
		        $level = $this->approvalLevelMapper->getOvertimeLevelRow($approvedLevel); 
		        $isApprover = $this->OvertimeForm($applicant,$approver,$level); 
		        break; 
		    default:  
		        $isApprover = 0;  
		}   
    	return $isApprover;  
    } 
    
    public function OvertimeForm($applicant,$approver,$levelRow) {
    	$level = $levelRow['ApprovalLevelName'];
    	$approvalBy = $levelRow['ApprovalSequence']; 
    	$isApprover = 0;
    	switch ($level) {
    		case "ImmediateSupervisor":
    			$isApprover = $this->isImmediateSupervisor($applicant,$approver);
    			break;
    		case "Hod":
    			$isApprover = $this->isHod($applicant,$approver);
    			break;
    		case "HrService":
    		    //echo "Is hr ser";
    		    //exit; 
    		    $isApprover = $this->isHrService($applicant,$approver); 
    			break;
    		default:
    			$isApprover = 0; 
    	}
    	return $isApprover; 
    }  
        
    public function leaveForm($applicant,$approver,$levelRow) {   
    	//return 1;  
    	//\Zend\Debug\Debug::dump($levelRow);
    	$level = $levelRow['ApprovalLevelName'];
    	$approvalBy = $levelRow['ApprovalBy']; 
    	$isApprover = 0; 
    	// $approvalBy == byLevel 
    	if($approvalBy == 'byLevel') { 	
    		
    	} 
    	if($approvalBy == 'byPosition') {
    		
    	} 
    	//\Zend\Debug\Debug::dump($approvalBy);
    	// approvalBy can be 
    	// either by supervisor 
    	// other supervisor 
    	// hod 
    	// or any other based on position 
    	switch ($level) { 
    		case "ImmediateSupervisor": 
    			$isApprover = $this->isImmediateSupervisor($applicant,$approver); 
    			break;
    		case "Hod":
    			$isApprover = $this->isHod($applicant,$approver); 
    			break;
    		default:
    			$isApprover = 0; 
    	} 	
    	return $isApprover;     	
    }
    
    public function travelLocalForm($applicant,$approver,$levelRow) {
    	$level = $levelRow['ApprovalLevelName'];
    	$approvalBy = $levelRow['ApprovalBy'];
    	//echo $level; 
    	//exit;  
    	$isApprover = 0; 
    	switch ($level) {
    		case "ImmediateSupervisor":
    			$isApprover = $this->isImmediateSupervisor($applicant,$approver);
    			//\Zend\Debug\Debug::dump($isApprover);
    			//exit;
    			break;
    		case "Hod":
    			$isApprover = $this->isHod($applicant,$approver);
    			$isGm = $this->isGeneralManager($applicant,$approver); 
    			// in case the approver is GM, HOD approval will be skipped
    			if($isGm == $approver) {
    				$isApprover = 1; 
    			} 
    			break; 
    		case "HrService":
    			$isApprover = $this->isHrService($applicant,$approver);
    			//$isApprover = $this->isHrManager($applicant,$approver); 
    			break;
    		default:
    			$isApprover = 0; 
    	}
    	return $isApprover; 
    }
    
    public function travelAbroadForm($applicant,$approver,$levelRow) {
    	$level = $levelRow['ApprovalLevelName'];
    	$approvalBy = $levelRow['ApprovalBy'];
    	//echo $level;
    	//exit;
    	$isApprover = 0;
    	switch ($level) {
    		case "ImmediateSupervisor":
    			$isApprover = $this->isImmediateSupervisor($applicant,$approver);
    			break;
    		case "Hod":
    			$isApprover = $this->isHod($applicant,$approver);
    			break;
    		case "HrManager":
    			$isApprover = $this->isHrManager($applicant,$approver);
    			break;
    		case "GeneralManager":
    			$isApprover = $this->isGeneralManager($applicant,$approver);
    			break;
    		default:
    			$isApprover = 0;
    	}
    	return $isApprover; 
    }
    
    // is conditions 
    public function isImmediateSupervisor($applicant,$approver) { 
    	return $this->positionService->isImmediateSupervisor($applicant,$approver);
    } 
    
    public function isHod($applicant,$approver) {
    	return $this->positionService->isHod($applicant,$approver);
    }
    
    public function isHrManager($applicant,$approver) {
    	return $this->positionService->isHrManager($applicant,$approver);
    } 
    
    public function isHrService($applicant,$approver) {
    	return $this->positionService->isHrService($applicant,$approver);
    }
    
    public function isGeneralManager($applicant,$approver) {
    	return $this->positionService->isGeneralManager($applicant,$approver);
    } 
    
}