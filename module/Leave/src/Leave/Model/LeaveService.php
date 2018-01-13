<?php  

namespace Leave\Model;
      
use Payment\Model\Company;
use Payment\Model\DateRange;
use Payment\Model\Employee;

class LeaveService extends Approvals { 
    
	protected $formType = "Leave"; 
	

    public function isHaveLeave($employeeNumber,$fromDate,$toDate) {
    	//echo $employeeNumber; 
    	//exit; 
    	return $this->nonWorkingDays->isHaveLeave($employeeNumber,$fromDate,$toDate);
    	// return false; 
    } 
    
    public function isWaitingForApproval($id) {
    	// check is waiting for approval
    	return $this->leaveFormMapper->isWaitingForApproval($id);
    	// return 1; 
    }
    
    public function selectAdminLeave() {
    	return $this->leaveFormMapper->selectAdminLeave($id);
    }
    
    public function insertAdminLeave($entity) {
    	return $this->leaveFormMapper->insertAdminLeave($entity);
    }
    
    public function isHaveHajjLeave($employeeId) {
        return $this->leaveFormMapper->isHaveHajjLeave($employeeId);
    }
    
    public function isHaveHajjLeaveId($employeeId,$id) {
        return $this->leaveFormMapper->isHaveHajjLeaveId($employeeId,$id);
    }
    
    public function updateAdminLeave($entity) {
    	return $this->leaveFormMapper->updateAdminLeave($entity);
    }
    
    public function fetchAdminLeaveById($id) {
    	return $this->leaveFormMapper->fetchAdminLeaveById($id);
    }
    
    public function isHaveLeaveForApproval($employeeNumber,$from,$to) {
    	return false;
    } 
    
    public function fetchLeaveById($id) {
    	return $this->leaveFormMapper->fetchLeaveById($id); 
    }
    
    public function getLeaveFormApprovalList() {   
    	$employeeNumber = $this->userInfoService->getEmployeeId(); 
    	$leaveList = $this->leaveFormMapper->getLeaveFormList(); 
    	if($leaveList) { 
    		$totId = array(); 
    		$i = 1; 
	    	foreach($leaveList as $lst) { 
	    		//\Zend\Debug\Debug::dump($lst); 
	    		$applicant = $lst['employeeId'];   
	    		$approvedLevel = $lst['approvedLevel']; 
	    		$approver = $employeeNumber;  
	    		// @todo check is the current user approver for current level 
	    		$isApprover = $this->checkIsApprover($applicant,$approver,$approvedLevel);  
	    		if($isApprover) { 
	    		    $totId[] = $lst['id'];  
	    		}  
	    		$i++; 
	    	}  
	    	if(!$totId) { 
	    		$totId[] = 0;   
	    	}  
    	}   
    	return $this->leaveFormMapper->getLeaveFormApprovalList($totId);     	
    }   
    
    public function outstandingBalanceList() { 
    	return $this->leaveFormMapper->outstandingBalanceList(); 
    }
    
    public function checkIsApprover($applicant,$approver,$approvedLevel) {
    	/*
    	 * @param formType,applicant,approvalLevel,approver
    	 */
    	//return true;
    	return $this->approvalService->isApprover($this->formType,$applicant,$approver,$approvedLevel); 
    } 
    
    public function insert($leaveData) { 
    	try { 
    	    $employeeId = $leaveData->getEmployeeId(); 
    	    // $employeeId = $leaveData['employeeNameAnnualLeave']; 
    	    $lastInsertId = $this->leaveFormMapper->insert($leaveData); 
    	    $openingValue = array(
    	    	// @todo get approval level
    	    	'id'            => $lastInsertId,
    	        'approvalLevel' => 	2,
    	    	'isCanceled'    =>  0,
    	    	'approvedLevel' =>  1,
    	    	'isApproved'    =>  0,          
    	    );
    	    $this->leaveFormMapper->update($openingValue);
    	} catch(\Exception $e) {
    		throw $e; 
    	} 
    	$supervisor = $this->positionService->getImmediateSupervisorByEmployee($employeeId);
    	$this->mailService->leaveFormSubmitAlert($employeeId,$supervisor); 
    } 
    
    
    
    public function employeeLeaveInfo($employeeNumber) { 
    	$leaveType = 'annualleave'; 
    	// @todo 
    	$from = Date('Y').'-01-01';
    	$to = date('Y').'-12-31'; 
    	return array ( 
    			'daysEntitled'       => 
    			    $this->getEmployeeEntitlement($employeeNumber,$leaveType,$from,$to),
    			'outstandingBalance' => 
    			    $this->getEmployeeOutstandingBalance($employeeNumber,$leaveType,$from,$to),
    			'daysTaken'          => 
    			    $this->getEmployeeLeaveDaysTaken($employeeNumber,$leaveType,$from,$to), 
    			//'thisLeaveDays'      => '3',
    			'revisedDays'        => '0',
    			//'remainingDays'      => '19', 
    	); 
    } 
    
    // @todo clean later 
    public function approveLeave($data,$leaveType = 1) { 
    	// $employeeNumber is an approver 
        $approvalType = $data->getApprovalType(); 
    	$approver = $this->userInfoService->getEmployeeId(); 
    	$approval = $approvalType;  
    	$id = $data->getId();  
    	//echo "Approver ".$approver."<br/>";
    	//echo "Approval ".$approval."<br/>";
    	//echo "id ".$id."<br/>";
    	//exit; 
    	
    	if(!$this->isWaitingForApproval($id)) {
    		return "This form is not valid!";
    	} 
    	$leaveRow = $this->fetchLeaveById($id); 
    	//\Zend\Debug\Debug::dump($leaveRow);
    	$leaveLevel = $this->leaveFormMapper->getLeaveLevel(); 
    	//\Zend\Debug\Debug::dump($leaveLevel);
    	$applicant =  $leaveRow->getEmployeeId();  
    	//\Zend\Debug\Debug::dump($applicant);
    	$hod = $this->positionService->getHodByEmployee($applicant); 
    	//\Zend\Debug\Debug::dump($applicant);
    	//exit; 
    	$c = 1; 
    	$waitingApprovalLevel = $leaveRow->getApprovedLevel(); 
    	//\Zend\Debug\Debug::dump($waitingApprovalLevel);
    	$totalLevel = $leaveRow->getApprovalLevel(); 
    	//\Zend\Debug\Debug::dump($totalLevel);
    	//exit; 
    	if($totalLevel < $waitingApprovalLevel) {
    		return "Sorry! Error in form"; 
    	}
    	$c = 1; 
    	$w = $totalLevel - $waitingApprovalLevel; 
    	while($w) { 
    		//echo "<br/> ";
    		//echo "Waitinig approval level before ".$waitingApprovalLevel;
    		//echo "<br/> ";
    		
    		$isApprover = $this->approvalService
    		                   ->isApprover($this->formType,$applicant,$approver,$waitingApprovalLevel);
    		// echo "Is Approver ".$isApprover."<br/>";
    		//exit; 
    		if($isApprover) {
    			$levelToApprove = $waitingApprovalLevel; 
    			$c++;
    			$waitingApprovalLevel++;
    			$w--;
    		} else {
    			$w = 0;
    		}   
    		// echo "Level To Approve ".$levelToApprove."before<br/>"; 
    		// echo "Waiting approval level after ".$waitingApprovalLevel; 
    	} 
    	// exit; 
    	$levelToApprove += 1;
    	//echo "Level To Approve ".$levelToApprove; 
    	//exit; 
    	// exit; 
    	// checks if he is not approver
    	if($c == 1) { 
            return "Unable to approve the form";   
    	} 
    	//$levelToApprove = 3; 
    	if($approval) { 
    		try { 
    		    //\Zend\Debug\Debug::dump($approval);
    		    //exit; 
	    		$this->databaseTransaction->beginTransaction(); 
	    		
	    		$leaveArray = array(
	    				'employeeId'                => $applicant, 
	    				'LkpLeaveTypeId'            => $leaveType, 
	    				'leaveFromDate'             => $leaveRow->getLeaveFrom(),
	    				'leaveToDate'               => $leaveRow->getLeaveTo(),
	    				'isLeaveAllowanceRequired'  => $leaveRow->getLeaveAllowanceRequest(),
	    				'isAdvanceSalaryRequired'   => $leaveRow->getAdvanceSalaryRequest(),
	    				'address'                   => $leaveRow->getAddress(),
	    				'daysApproved'              => $leaveRow->getThisLeaveDays(),
	    				'holidayLieu'               => $leaveRow->getRevisedDays(),
	    				'publicHoliday'             => $leaveRow->getPublicHoilday(),
	    				'leaveYear'                 => date('Y',strtotime($leaveRow->getLeaveFrom())),
	    				'leaveAddedDate'            => date('Y-m-d'), 
	    		);  
	    		
	    		//\Zend\Debug\Debug::dump($leaveArray);
	    		//exit; 
	    		
	    		$delegatedEmployee = $leaveRow->getDelegatedPositionId();  
	    		$isApproved = 0; 
	    		
	    		if($levelToApprove == $totalLevel) {
	    			$isApproved = 1;
	    		}
	    		
	    		$update = array(
	    			'id'             => $id,
	    		    'approvedLevel'  => $levelToApprove,
	    			'isApproved'     => $isApproved		
	    		); 
	    		$this->leaveFormMapper->update($update);
	    		
	    		//@todo 
	    		$approverInfo = array(
	    			'approvalLevel'  => $levelToApprove,
	    			'approver'       => $approver,
	    			'addedDate'      => date('Y-m-d')	
	    		); 
	    		$this->leaveFormMapper->addApproverInfo($approverInfo);
	    		
	    		if($isApproved) {
	    			$this->positionService->addEmployeeDelegation($applicant,$delegatedEmployee); 
	    			$this->addToLeave($leaveArray); 
	    		} 
	    		// @todo
	    		// identify the level getLevel / get level 
	    		// update approval level 
	    		// add approver information 
	    		
	    		/* 
	    		 * if final approval  
	    		 * add delegation 
	    		 * update approved status to 1  
	    		 */  
	    		$this->databaseTransaction->commit();
	    		
    		} catch(\Exception $e) {   
    			//echo $e->getMessage();
    			$this->databaseTransaction->rollBack(); 
    			throw new \Exception('Sorry! Unable to approve leave form '.$e->getMessage());
    		}
    		// $levelToApprove
    		$hod = $this->positionService->getHodByEmployee($applicant); 
    		$this->mailService->leaveFormApprovalAlert($applicant,$approver,$hod); 
    		return "Form approved successfully";
    	} else { 
    		// cancel leave form 
    		$update = array(
    				'isCanceled'   => 1,
    				'canceledBy'   => $approver,
    				'canceledDate' => date('Y-m-d'),
    				'id'           => $id,
    		); 
    		$hod = $this->positionService->getHodByEmployee($applicant); 
    		$this->leaveFormMapper->update($update); 
    		$hod = $this->positionService->getHodByEmployee($applicant);
    		$this->mailService->leaveFormRejectedAlert($applicant,$approver,$hod); 
    		return "Form rejected Successfully";
    	} 
    } 
     
    public function testService() {
    	// @todo to be removed
    	return $this->positionService->getLevelByEmployee('1075');
    } 
     
    public function getNonPayDays($employeeId,$fromDate,$toDate) {
    	
    	// get leave without pay
    	
    	// get sick leave 
    	
    	// get 
    	
    	/*if($employeeId == '1075') {
    	    return 10;
    	}*/
    	return 0; 
    } 
    
    public function addToLeave(array $leaveArray) {
        $this->leaveFormMapper->addToLeave($leaveArray);  
    }
    
    public function paysheetSickLeaveDays() { 
    	return 180; 
    }
    
    public function leaveInfoById($id) { 
    	//$leaveInfo = $this->fetchEmployeeLeave($id);
    	$leaveInfoArray = $this->leaveFormMapper->fetchEmployeeLeave($id);  
    	//\Zend\Debug\Debug::dump($leaveInfoArray);  
    	//exit; 
    	$output = " 
            <table cellpadding='10px' cellspacing='10px'>
                <tr><td>Name :</td><td><b>".$leaveInfoArray['employeeName']."</b></td>
                <td>&nbsp;</td><td>&nbsp;</td><td>Date Of Join :</td>
                <td>".$leaveInfoArray['joinDate']."</td></tr><tr><td>Position :</td>
                <td>".$leaveInfoArray['positionName']."</td>
    			<td>&nbsp;</td><td>&nbsp;</td><td>Location :</td>
    			<td>".$leaveInfoArray['locationName']."</td></tr><tr><td>Department :</td>
    			<td>".$leaveInfoArray['departmentName']."</td><td>&nbsp;</td>
    			<td>&nbsp;</td><td></td><td></td></tr>
                
    			<tr><td>Leave From Date :</td><td><b>".$leaveInfoArray['leaveFrom']."</b>
    		    </td><td>&nbsp;</td><td>&nbsp;</td><td>Advance Salary Required :</td>
    		    <td>".$leaveInfoArray['advanceSalaryRequest']."</td></tr><tr><td>Leave To Date</td>
    		    <td><b>".$leaveInfoArray['leaveTo']."</b></td><td>&nbsp;</td>
    		    <td>&nbsp;</td><td>Address On Leave :</td><td>".$leaveInfoArray['address']."
    		    </td></tr><tr><td>Delegated Employee :</td><td>".$leaveInfoArray['delegatedEmployee']."
    		    </td><td>&nbsp;</td><td>&nbsp;</td><td></td><td></td></tr>
                 
    			<tr><td>Leave Days Entitled(+) :</td><td>".$leaveInfoArray['daysEntitled']."
    			</td><td>&nbsp;</td><td>&nbsp;</td><td>Days (This Leave)(-):</td>
    			<td><b>".$leaveInfoArray['thisLeaveDays']."</b></td></tr><tr>
    		    <td>Outstanding Balance:</td><td>".$leaveInfoArray['outstandingBalance']."</td>
    			<td>&nbsp;</td><td>&nbsp;</td><td>Revise Holidays(+) :</td>
    			<td>".$leaveInfoArray['revisedDays']."</td></tr><tr><td>Days Already Taken(-):
    			</td><td>".$leaveInfoArray['daysTaken']."</td><td>&nbsp;</td>
    			<td>&nbsp;</td><td>Remaining Balance:</td><td>".$leaveInfoArray['remainingDays']."
    		    </td></tr> 
    	    </table>
    	";
    	return $output;
    } 
    
    public function employeeLeaveCompleteDtls($employeeNumber,DateRange $dateRange = null) {
        $leaveArray = $this->leaveFormMapper
                           ->employeeLeaveCompleteDtls($employeeNumber,$dateRange);
        return $leaveArray; 
    } 
    
    // report methods 
    
    public function getEmployeeAllRecentLeave(Company $company,$values,$from,$to) {
        $leaveArray = $this->leaveFormMapper
        ->getEmployeeAllRecentLeave($company,$values,$from,$to);
        return $leaveArray; 
    }
    
    public function employeeAllRecentLeave(Company $company,$values,$from,$to) {
        
        $leaveInfo = $this->getEmployeeAllRecentLeave($company,$values,$from,$to); 
        $i = 1; 
        $totLeave = 0;
        $totRev = 0;
        $totRemaining = 0;
        $output = "<table  border='1' class='sortable' font-size='6px' align='center' id='table1'
             width='100%' bordercolorlight='#C0C0C0' bordercolordark='#C0C0C0' style='border-collapse: collapse'>
                    <thead >
                        <tr>
                            <th bgcolor='#F0F0F0'>#</th>
                            <th bgcolor='#F0F0F0'>Employee Name</th>
                            <th bgcolor='#F0F0F0'><b>Leave Type</b></th>
                            <th bgcolor='#F0F0F0'>From</th>
                            <th bgcolor='#F0F0F0'>To</th>
                            <th bgcolor='#F0F0F0'>Days Taken</th>
                            <th bgcolor='#F0F0F0'>Revise Holidays</th>
                            <th bgcolor='#F0F0F0'>Actual Leave Days</th>
                            <th><p align='center'>&nbsp;</th> 
                        </tr>
                    </thead><tbody class='scrollingContent'>";   
        foreach ($leaveInfo as $dtls) {
            $from = $dtls['leaveFromDate'];   
            $to = $dtls['leaveToDate']; 
            $totalDays = (int)$this->dateMethods->numberOfDaysBetween($from,$to); 
            $fromFormat = $this->dateMethods->customFormatDate($from);
            $toFormat = $this->dateMethods->customFormatDate($to);
            $reviseDays = (int)$dtls['holidayLieu']; 
            $remaining = $totalDays - $reviseDays;
            $totLeave += $totalDays;
            $totRev += $reviseDays;
            $totRemaining += $remaining;
            $output .= "
                        <tr>
        		       		<td><p align='center'>&nbsp;".$i++."</td>
                            <td><p align='left'>&nbsp;".$dtls['employeeName']."</td>  
                            <td><p align='center'>&nbsp;".$dtls['leaveName']."</td>
                            <td><p align='center'>&nbsp;".$fromFormat."</td>
                            <td><p align='center'>&nbsp;".$toFormat."</td> 
                            <td><p align='center'>&nbsp;".$totalDays."</td>
                            <!--<td><p align='center'>&nbsp;</td>-->
                            <td><p align='center'>&nbsp;".$reviseDays."</td>
                            <td><p align='center'>&nbsp;".$remaining."</td>
                            <td><p align='center'>&nbsp;</td>
                        </tr>";
        }
        $output .= "</tbody><tfoot><tr>
                    <td align='right' colspan = '5'>&nbsp;<b>Total</b></td>
                    <td><p align='center'>&nbsp;<b>".$totLeave."</b></td>
                    <td><p align='center'>&nbsp;<b>".$totRev."</b></td>
                    <td><p align='center'>&nbsp;<b>".$totRemaining."</b></td>
                   </tr></tfoot>
        		";
        return $output;
    }
    
    public function getAnnualLeaveReport($company,$values) {
    	
      /*Employee name
    	Entitlement
    	Is In First Year
    	Leave taken From- To
    	Days Taken
    	Revise Holiday
    	Public holiday
    	Total Balance*/
        
        
    	
    	$leaveInfo = $this->employeeLeaveCompleteDtls('1075'); 
    	
        $output = "<table  border='1' class='sortable' font-size='6px' align='center' id='table1' 
             width='100%' bordercolorlight='#C0C0C0' bordercolordark='#C0C0C0' style='border-collapse: collapse'>
                    <thead >
                        <tr>
                            <th width='2%' bgcolor='#F0F0F0'>#</th>
                            <th width='20%' bgcolor='#F0F0F0'>Employee Name</th>
                            <th width='10%' bgcolor='#F0F0F0'>
                               <table>
                                   <tr>
                                       <td></td></tr>
                                   <tr>
                                       <td ><b>Entitlements</b></td>
                                   </tr>
                               </table>
                           </th>
                           <th width='10%' bgcolor='#F0F0F0'>
                               <table>
                                   <tr><td></td></tr>
                                   <tr><td ><b>UN Leave Entitlements</b></td></tr> 
                               </table>
                           </th>
                           <th width='10%' bgcolor='#F0F0F0'>Is in first year  </th>	
                           <th width='28%' bgcolor='#F0F0F0'>
                           <table align='center' width='100%' border='0' cellpadding='0'>
                               <tr><td></td></tr>
                               <tr><td><b>From - To</b></td></tr>
                           </table></th>        
                           <th width='10%' bgcolor='#F0F0F0'>Days Taken</th>
                           <th width='5%' bgcolor='#F0F0F0'>Revise Holidays</th>
                           <th width='10%' bgcolor='#F0F0F0'>Total Remaining Balance</th>
                        </tr>	
                    </thead>";
                   foreach ($leaveInfo as $dtls) { 
        		       $output .= "<tbody class='scrollingContent'>
                        <tr>
        		       		<td><p align='center'>&nbsp;</td>
                            <td><p align='center'>&nbsp;".$dtls['employeeName']."</td>
                            
                            <td><p align='center'>&nbsp;".$dtls['employeeId']."</td>
                            <td><p align='center'>&nbsp;".$dtls['employeeId']."</td>
                            <td><p align='center'>&nbsp;".$dtls['employeeId']."</td>
                            
                            <td><p align='center'>&nbsp;".$dtls['leaveFromDate'] ."-". $dtls['leaveToDate']."</td>
                            <td><p align='center'>&nbsp;".$dtls['employeeId']."</td>
                            <!--<td><p align='center'>&nbsp;</td>-->			
                            <td><p align='center'>&nbsp;".$dtls['employeeId']."</td>
                            <td><p align='center'>&nbsp;".$dtls['employeeId']."</td>
                            <td><p align='center'>&nbsp;</td>
                        </tr>
                    <!--<td colspan='7' align='center'><br><br><b>Sorry! no records found</b><br><br></td>-->
                        </tr>";
                   } 	
                    $output .= "</tbody> 
        		";	
        return $output;  
    } 
    
    public function getAnnualLeave($employeeId,$leaveType,$fromDate,$toDate) { 
    	
    	/*$dtls = $this->leaveFormMapper->getLeaveDtls($employeeId,$leaveType,$fromDate,$toDate); 
    	
	    foreach ($dtls as $l) {
	    		 
	    	$i++;
	    	$startingDate = $l['Leav_Strt_Date'];
	    	$endingDate = $l['Leav_End_Date'];
	    	$reviseHoliday += $l['Leav_Hd_Lieu'];
	    		 
	    	if ($startingDate <= $from)
	    		$startingDate = $from;
	    	if ($endingDate >= $to) {
	    		$endingDate = $to;
	    	}
	    		 
	    	$date .= "<div class='leaveDate'><ul><li>($startingDate) - ($endingDate)</li></ul></div>";
	    	$reviseHoliDtl .= "<div class='leaveDate'><ul><li>" . $l['Leav_Hd_Lieu'] . "</li></ul></div>";
	    	$startingDate_mk = strtotime($startingDate);
	    	$endingDate_mk = strtotime($endingDate);
	    	$datediff = ( $endingDate_mk > $startingDate_mk ? ( $endingDate_mk - $startingDate_mk ) : ( $endingDate_mk - $startingDate_mk ) );
	    	$days = floor(( $datediff / 3600 ) / 24);
	    	$days = $days + 1;
	    	$detailDays .="<div class='leaveDate'><ul><li>$days</li></ul></div>";
	    	$totDays += $days; 
	    		 
	    	if ($startingDate <= no) {
	    		$startingDate = $from;
	    	}
	    		 
	    	$startingDate = 0;
	    	$endingDate = 0;
	    	$days = 0;
	    }
	    	 
	    if ($i > 1) {
	    	$date .= "<div class='leaveDate'><ul><li><b>Total</b></li></ul></div>";
	    	$detailDays .="<div class='leaveDate'><ul><li><b>$totDays</b></li></ul></div>";
	    	$reviseHoliDtl .= "<div class='leaveDate'><ul><li><b>" . $reviseHoliday . "</b></li></ul></div>";
	    }
	    	 
	    return array($date, $totDays, $detailDays, $reviseHoliday, $reviseHoliDtl);
	    */ 
    }
    
    public function prepareOutstandingBalance() {
         	
    }  
    
    public function adjustOutstandingBalance($employeeId,$fromDate,$toDate) {
        	
    } 
    
    // Currently active
    public function getEmployeeEntitlement($employeeId,$leaveType,$fromDate,$toDate) { 
    	$joinDate = $this->leaveFormMapper->employeeDoj($employeeId);
    	$companyId = $this->leaveFormMapper->employeeCompany($employeeId); 
    	$joinDate = date("Y-m-d", strtotime($joinDate));
        $yearsOfService = $this->dateMethods->numberOfYearsBetween($joinDate,$this->dateMethods->getToday()); 
        $yearsOfService = (int) $yearsOfService; 
    	return $this->leaveFormMapper
    	            ->getEmployeeEntitlement($yearsOfService,$companyId);     
    } 
    // Currently active 
    public function getEmployeeOutstandingBalance($employeeId,$leaveType,$fromDate,$toDate) {
    	return $this->leaveFormMapper
    	            ->getEmployeeOutstandingBalance($employeeId,$leaveType,$fromDate,$toDate);
    	//return '34'; 
    } 
    // Currently active
    public function getEmployeeLeaveDaysTaken($employeeId,$leaveType,$fromDate,$toDate) {
    	$result = $this->leaveFormMapper
    	               ->getEmployeeLeaveDaysTaken($employeeId,$leaveType,$fromDate,$toDate); 
    	$days = 0; 
    	//\Zend\Debug\Debug::dump($result);
    	foreach ($result as $r) {
    		$from = $r['leaveFromDate']; 
    		$to = $r['leaveToDate']; 
    		$publicHoliday = $r['publicHoliday']; 
    		$hoilidayLieu = $r['holidayLieu']; // revised holiday  
    		//\Zend\Debug\Debug::dump($from);
    		//\Zend\Debug\Debug::dump($to);
    		$days += $this->dateMethods->numberOfDaysBetween($from,$to) 
    		         - $publicHoliday - $hoilidayLieu;  
    		// $days = $this-> 
    	} 
    	 
    	return $days;  
    } 
    
    public function getTotalLeaveBalance(Employee $employee,$from,$to) {
    	$employeeNumber = $employee->getEmployeeNumber(); 
    	$info = $this->employeeLeaveInfo($employeeNumber); 
    	$ent = $info['daysEntitled'];
    	$ob = $info['outstandingBalance'];
    	$daysTaken = $info['daysTaken'];  
    	$revised = $info['revisedDays'];
    	// @todo  
    	return $ent + $ob - $daysTaken + $revised;  
    }   
    
    
    // public function 
}