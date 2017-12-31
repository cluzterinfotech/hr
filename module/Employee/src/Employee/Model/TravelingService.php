<?php 

namespace Employee\Model; 
      
use Payment\Model\DateRange; 
use Leave\Model\Approvals; 

class TravelingService extends Approvals {   
    
	protected $localFormType = "TravelLocal";  
	
	protected $abroadFormType = "TravelAbroad"; 
	
    public function isHaveLeave($employeeNumber,$fromDate,$toDate) { 
    	//echo $employeeNumber; 
    	//exit;  
    	return $this->nonWorkingDays->isHaveLeave($employeeNumber,$fromDate,$toDate); 
    	// return false;  
    }  
    
    public function isWaitingForApproval($id) {
    	// check is waiting for approval
    	return $this->travelingFormMapper->isWaitingForApproval($id);
    	// return 1; 
    } 
    
    public function isHaveLeaveForApproval($employeeNumber,$from,$to) {
    	return false;
    } 
    
    public function fetchTravelingById($id) {
    	return $this->travelingFormMapper->fetchTravelingById($id); 
    }
    
    public function getTravelLocalFormApprovedList() {
    	return $this->travelingFormMapper->getTravelLocalFormApprovedList();
    }
    
    public function getTravelingLocalFormApprovalList() {   
    	$employeeNumber = $this->userInfoService->getEmployeeId(); 
    	$travelList = $this->travelingFormMapper->getTravelingLocalFormList(); 
    	if($travelList) { 
    		$totId = array(); 
    		$i = 1; 
	    	foreach($travelList as $lst) { 
	    		//\Zend\Debug\Debug::dump($lst);  
	    		$applicant = $lst['employeeNumberTravelingLocal'];    
	    		$approvedLevel = $lst['approvedLevel'] + 1; 
	    		/*if($approvedLevel == 0) {
	    			$approvedLevel = 1; 
	    		}*/
	    		$approver = $employeeNumber;  
	    		//echo "Employee Number <br/>".$employeeNumber; 
	    		// @todo check is the current user approver for current level  
	    		$isApprover = $this->checkIsApprover($applicant,$approver,$approvedLevel);   
	    		if($isApprover) {  
	    		    $totId[] = $lst['id'];   
	    		}   
	    		$i++;  
	    	}   
	    	//\Zend\Debug\Debug::dump($totId);  
	    	//exit; 
	    	if(!$totId) {   
	    		$totId[] = 0;     
	    	}    
    	}     
    	return $this->travelingFormMapper->getTravelLocalFormApprovalList($totId);        	
    } 
    
    public function getTravelingLocalFormApprovalListAdmin() { 
    	$travelList = $this->travelingFormMapper->getTravelingLocalFormListAdmin();
    	if($travelList) {
    		$totId = array();
    		$i = 1;
    		foreach($travelList as $lst) {
    		    $totId[] = $lst['id'];
    			$i++;
    		} 
    		if(!$totId) {
    			$totId[] = 0;
    		}
    	}
    	return $this->travelingFormMapper->getTravelLocalFormApprovalList($totId);
    } 
    
    public function getTravelingLocalApprovalSequenceList() { 
    	return $this->travelingFormMapper->getTravelLocalApprovalSeqList();
    }
    
    public function checkIsApprover($applicant,$approver,$approvedLevel) {
    	/*
    	 * @param formType,applicant,approvalLevel,approver
    	 */
    	//return true;
    	return $this->approvalService->isApprover($this->localFormType,$applicant,$approver,$approvedLevel); 
    } 
    
    public function insert($travelData) { 
    	try { 
    		//\Zend\Debug\Debug::dump($travelData);
    		//exit;
    	    $lastInsertId = $this->travelingFormMapper->insert($travelData); 
    	    $employeeId = $travelData->getEmployeeNumberTravelingLocal(); 
    	    // @todo get approval level
    	    $totApprovalLevel = $this->travelingFormMapper->getTravelLocalTotAppLevel(); 
    	    // \Zend\Debug\
    	    $openingValue = array( 
    	    	'id'            => $lastInsertId,
    	    	'appliedDate'   => date('Y-m-d'), 
    	        'approvalLevel' => 	$totApprovalLevel, 
    	    	'isCanceled'    =>  0,
    	    	'approvedLevel' =>  0,
    	    	'isApproved'    =>  0,          
    	    ); 
    	    $this->travelingFormMapper->update($openingValue); 
    	} catch(\Exception $e) {
    		throw $e; 
    	} 
    	$approver = $this->positionService->getImmediateSupervisorByEmployee($employeeId); 
    	$this->mailService->travelFormLocalSubmitAlert($employeeId,$approver);  
    } 
    
    public function employeeLeaveCompleteDtls($employeeNumber,DateRange $dateRange = null) {
        $leaveArray = $this->travelingFormMapper
                           ->employeeLeaveCompleteDtls($employeeNumber,$dateRange);   
        return $leaveArray; 	
    }
    
    public function employeeLeaveInfo($employeeNumber) { 
    	
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
    // Travel type 1 local 
    public function approveTravelLocal(array $data,$travelType = 1) { 
    	// $employeeNumber is an approver 
    	//echo "inside leave service"; 
    	//exit; 
    	$approver = $this->userInfoService->getEmployeeId(); 
    	$approval = $data['approvalType']; 
    	$expenseApproved = $data['expenseApproved']; 
    	$id = $data['id']; 
    	//echo "Approver ".$approver."<br/>";
    	//echo "Approval ".$approval."<br/>";
    	//echo "id ".$id."<br/>";
    	//exit; 
    	
    	if(!$this->isWaitingForApproval($id)) {
    		return "This form is not valid!";
    	} 
    	
    	$travelRow = $this->fetchTravelingById($id); 
    	$leaveLevel = $this->travelingFormMapper->getTravelLocalLevel();  
    	$applicant =  $travelRow->getEmployeeNumberTravelingLocal();  
    	$c = 1; 
    	$waitingApprovalLevel = $travelRow->getApprovedLevel();  
    	$totalLevel = $travelRow->getApprovalLevel(); 
            	
    	if($totalLevel < $waitingApprovalLevel) {
    		return "Sorry! Error in form"; 
    	} 
    	$c = 1; 
    	$w = $totalLevel - $waitingApprovalLevel; 
    	while($w) { 
    		//echo "<br/>wwwwww - ".$w;
    		//echo "<br/>Waitinig approval level before - ".$waitingApprovalLevel;
    		//exit;
    		//echo "<br/> "; 
    		$isApprover = $this->approvalService
    		                   ->isApprover($this->localFormType,$applicant,$approver,$waitingApprovalLevel+1); 
    		// echo "Is Approver ".$isApprover."<br/>";
    		// exit; 
    		if($isApprover) { 
    			$levelToApprove = $waitingApprovalLevel;  
    			//if($c > 1) {
    			$waitingApprovalLevel++;  
    			//}
    			$c++;
    			$w--;
    		} else {
    			$w = 0;
    		}   
    		// echo "Level To Approve ".$levelToApprove."before<br/>"; 
    		 //echo "<br/>Waiting approval level after - ".$waitingApprovalLevel;  
    	} 
        //exit; 
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
	    		$this->databaseTransaction->beginTransaction(); 
	    		
	    		$delegatedEmployee = $travelRow->getDelegatedEmployee();  
	    		$isApproved = 0; 
	    		
	    		if($levelToApprove == $totalLevel) {
	    			$isApproved = 1;
	    		}
	    		
	    		$update = array(
	    			'id'               => $id,
	    		    'approvedLevel'    => $levelToApprove,
	    			'isApproved'       => $isApproved,
	    			'expenseApproved'  => $expenseApproved, 
	    		); 
	    		$this->travelingFormMapper->update($update);
	    		
	    		//@todo 
	    		$approverInfo = array(
	    				
	    			'travelLocalId'    => $id,
	    			'approverId'       => $approver,
	    			'approvedDate'     => date('Y-m-d'), 
	    			'approvedLevelId'  => $levelToApprove, 
	    		); 
	    		$this->travelingFormMapper->addTravelLocalApproverInfo($approverInfo);
	    		
	    		if($isApproved) {
	    			$this->positionService->addEmployeeDelegation($applicant,$delegatedEmployee); 
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
    			throw new \Exception('Sorry! Unable to approve Travel Form Local '.$e->getMessage());
    		}
    		// $levelToApprove
    		$this->mailService->travelFormLocalApprovalAlert($applicant,$approver);
    		
    		return "Form approved successfully"; 
    	} else { 
    		// cancel leave form 
    		$update = array(
    				'isCanceled'   => 1,
    				'canceledBy'   => $approver,
    				'canceledDate' => date('Y-m-d'),
    				'id'           => $id,
    		); 
    		
    		$this->travelingFormMapper->update($update); 
    		$this->mailService->travelFormLocalRejectedAlert($applicant,$approver);   
    		return "Form rejected Successfully"; 
    	} 
    } 
    
    
    public function approveAdminTravelLocal(array $data,$travelType = 1) { 
    	$approver = $this->userInfoService->getEmployeeId();
    	$approval = $data['approvalType'];
    	$expenseApproved = $data['expenseApproved'];
    	$id = $data['id']; 
    	$message = " "; 
    	$travelRow = $this->fetchTravelingById($id);
    	// $leaveLevel = $this->travelingFormMapper->getTravelLocalLevel(); 
    	$applicant =  $travelRow->getEmployeeNumberTravelingLocal(); 
    	//\Zend\Debug\Debug::dump($applicant); 
    	//exit; 
    	$waitingApprovalLevel = $travelRow->getApprovedLevel();
    	$totalLevel = $travelRow->getApprovalLevel(); 
        
    	if($approval == 1) {
    		$levelToApprove = $waitingApprovalLevel + 1; 
    		$message = "Approved one level "; 
    	}
    	if($approval == 2) {
    		$levelToApprove = $totalLevel; 
    		$message = "Approved Completely ";
    	}
    	
    	$isApproved = 0;
    	if($levelToApprove == $totalLevel) {
    		$isApproved = 1;
    	}
    	$update = array(
    			'id'               => $id,
    			'approvedLevel'    => $levelToApprove,
    			'isApproved'       => $isApproved,
    			'expenseApproved'  => $expenseApproved,
    	);
    	if($approval == 3) {
    		$levelToApprove = 0; 
    		$update = array(
    				'isCanceled'   => 1,
    				'canceledBy'   => $approver,
    				'canceledDate' => date('Y-m-d'),
    				'id'           => $id,
    		);
    		$message = "Form Rejected/Cancelled Successfully ";
    		
    	}
        try {
    	    $this->databaseTransaction->beginTransaction();
    	    //\Zend\Debug\Debug::dump($update); 
    		$this->travelingFormMapper->update($update); 
    		$approverInfo = array( 
    			'travelLocalId'    => $id,
    			'approverId'       => $approver,
    			'approvedDate'     => date('Y-m-d'),
    			'approvedLevelId'  => $levelToApprove,
    		);
    		 
    		$this->travelingFormMapper->addTravelLocalApproverInfo($approverInfo);  
    		//\Zend\Debug\Debug::dump($approverInfo);
    		//exit;
    		$this->databaseTransaction->commit();
    		if($approval == 3) {
    			$this->mailService->travelFormLocalRejectedAlert($applicant,$approver); 
    		} else {
    		    $this->mailService->travelFormLocalApprovalAlert($applicant,$approver); 
    		}
    	} catch(\Exception $e) {
    		echo $e->getMessage(); 
    		exit; 
    		$this->databaseTransaction->rollBack();
    		throw new \Exception('Sorry! Unable to approve Travel Form Local '.$e->getMessage());
    	} 
    	    // $this->mailService->leaveFormApprovalAlert($applicant,$approver); 
    	return $message; 
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
        $this->travelingFormMapper->addToLeave($leaveArray);  
    }
    
    public function paysheetSickLeaveDays() { 
    	return 180; 
    }
    
    public function travelInfoById($id) {  
    	//$leaveInfo = $this->fetchEmployeeLeave($id); 
    	$travelInfoArray = $this->travelingFormMapper->fetchEmployeeTravelLocal($id);  
    	//\Zend\Debug\Debug::dump($leaveInfoArray);     
    	//exit;   
    	$output = " 
            <table cellpadding='10px' cellspacing='10px'> 
                <tr> 
    			    <td>Name :</td><td><b>".$travelInfoArray['employeeName']."</b></td>
                    <td>&nbsp;</td><td>&nbsp;</td><td>Fuel Liters :</td>
                    <td>".$travelInfoArray['fuelLiters']."</td>
                </tr>
                <tr>
                    <td>Position :</td>
                    <td>".$travelInfoArray['positionName']."</td>
    			    <td>&nbsp;</td><td>&nbsp;</td>
                    <td>Class Of Air Ticket :</td>
    		        <td>".$travelInfoArray['classOfAirTicket']."</td>
    			<!--</tr>
    			    <tr><td>Department :</td>
    			    <td>".$travelInfoArray['employeeName']."</td><td>&nbsp;</td>
    			    <td>&nbsp;</td>
    			    <td></td>
    			    <td></td>
    			</tr>-->
                
    			<tr>
    			    <td>Travel From Date :</td>
    			    <td><b>".$travelInfoArray['effectiveFrom']."</b></td>
    			    <td>&nbsp;</td><td>&nbsp;</td>
    			    <td>Class Of hotel :</td>
    		        <td>".$travelInfoArray['classOfHotel']."</td>
    		    </tr>
    		    <tr>
    		        <td>Travel To Date</td>
    		        <td><b>".$travelInfoArray['effectiveTo']."</b></td>
    		        <td>&nbsp;</td>
    		        <td>&nbsp;</td>
    		        <td>Means Of transport:</td>
    			    <td>".$travelInfoArray['meansOfTransport']."</td>
    		        	
    		    </tr>
    		    <tr>
    		        <td>Purpose of trip :</td>
    		        <td>".$travelInfoArray['purposeOfTrip']."</td>
    		        <td>&nbsp;</td><td>&nbsp;</td> 
    			    <td>Comments</td>
    		        <td>".$travelInfoArray['travelingComments']."</td>
    		    </tr>
                 
    			<tr>
    		        <td>Traveling To:</td>
    			    <td>".$travelInfoArray['travelingTo']."</td>
    		        <td>&nbsp;</td><td>&nbsp;</td>
    		        <td>Expenses Required:</td>
    			    <td><b>".$travelInfoArray['expensesRequired']."</b></td>
    			</tr>
    			<!--<tr> 
    			    <td>&nbsp;</td><td>&nbsp;</td>
    			    <td>Expense Approved :</td>
    			    <td><b>".$travelInfoArray['expenseApproved']."</b></td>
    			</tr> -->
    			<tr>
    			    <td>Delegated Employee :</td>
    		        <td><b>".$travelInfoArray['delegatedEmployee']."</b></td>
    			    <td>&nbsp;</td>
    			    <td>&nbsp;</td>
    			    <td>Advance Required:</td>
    			    <td><b>".$travelInfoArray['amount']."</b></td>
    			</tr> 
    	    </table>
    	";  
    	return $output;
    } 
    
    /*
        <table cellpadding='10px' cellspacing='10px'>
                <tr>
    			    <td>Name :</td><td><b>".$leaveInfoArray['employeeName']."</b></td>
                    <td>&nbsp;</td><td>&nbsp;</td><td>Date Of Join :</td>
                    <td>".$leaveInfoArray['joinDate']."</td>
                </tr>
                <tr>
                    <td>Position :</td>
                    <td>".$leaveInfoArray['positionName']."</td>
    			    <td>&nbsp;</td><td>&nbsp;</td>
                    <td>Location :</td>
    			    <td>".$leaveInfoArray['locationName']."</td>
    			</tr>
    			    <tr><td>Department :</td>
    			    <td>".$leaveInfoArray['departmentName']."</td><td>&nbsp;</td>
    			    <td>&nbsp;</td>
    			    <td></td>
    			    <td></td>
    			</tr>
                
    			<tr>
    			    <td>Leave From Date :</td>
    			    <td><b>".$leaveInfoArray['leaveFrom']."</b></td>
    			    <td>&nbsp;</td><td>&nbsp;</td>
    			    <td>Advance Salary Required :</td>
    		        <td>".$leaveInfoArray['advanceSalaryRequest']."</td>
    		    </tr>
    		    <tr>
    		        <td>Leave To Date</td>
    		        <td><b>".$leaveInfoArray['leaveTo']."</b></td>
    		        <td>&nbsp;</td>
    		        <td>&nbsp;</td>
    		        <td>Address On Leave :</td>
    		        <td>".$leaveInfoArray['address']."</td>
    		    </tr>
    		    <tr>
    		        <td>Delegated Employee :</td>
    		        <td>".$leaveInfoArray['delegatedEmployee']."</td>
    		        <td>&nbsp;</td><td>&nbsp;</td>
    		        <td></td>
    		        <td></td>
    		    </tr>
                 
    			<tr>
    		        <td>Leave Days Entitled(+) :</td>
    		        <td>".$leaveInfoArray['daysEntitled']."</td>
    		        <td>&nbsp;</td><td>&nbsp;</td>
    		        <td>Days (This Leave)(-):</td>
    			    <td><b>".$leaveInfoArray['thisLeaveDays']."</b></td>
    			</tr>
    			<tr>
    		        <td>Outstanding Balance:</td>
    			    <td>".$leaveInfoArray['outstandingBalance']."</td>
    			    <td>&nbsp;</td><td>&nbsp;</td>
    			    <td>Revise Holidays(+) :</td>
    			    <td>".$leaveInfoArray['revisedDays']."</td>
    			</tr>
    			<tr>
    			    <td>Days Already Taken(-):</td>
    			    <td>".$leaveInfoArray['daysTaken']."</td>
    			    <td>&nbsp;</td>
    			    <td>&nbsp;</td>
    			    <td>Remaining Balance:</td>
    			    <td>".$leaveInfoArray['remainingDays']."</td>
    			</tr> 
    	    </table>
    	    */
    
    
    public function getTravelingFormReport($id) {
    	$row = $this->travelingFormMapper->fetchEmployeeTravelLocal($id);     	
        $output = "<table width='686px' border='0' align='left' cellpadding='0' 
        cellspacing='0' style='border-collapse:collapse'>
		  <tr>
		    <td valign='top'><table width='100%' border='0' cellpadding='0' cellspacing='0'>
		      <tr>
		        <td valign='top' height='28'><table width='100%' height='94' 
		        border='0' cellpadding='0' cellspacing='0'>
		          <tr>
		            <td width='65%' height='46' align='center' valign='top'><span style='padding:5px;'>
		            <strong>Oil Energy Company LTD.</strong><br />
		                <strong>Human Resources  Department</strong><br />
		                 Business Traveling Form - LOCAL</span></td>
		            <td width='35%' align='right'  valign='top' style='font-size:12px;
		            font-family:Arial, Helvetica, sans-serif;line-height:18px;padding:1px;'>
		            <img src='/img/oilEnergyLogo.jpg' width='165' height='68'></td>
		          </tr>
		        </table></td>
		      </tr>
		      <tr>
		        <td height='19' align='right' style='padding: 0 5px;' 
		        valign='top'><strong>Date: </strong>". date('d-M-Y')."</td>
		      </tr>
		      <tr>
		        <td valign='top' height='19' ><strong>(A) Basic Data</strong></td>
		      </tr>
		      <tr>
		        <td valign='top' height='19' align='left'> 
		          <table width='100%' border='0' cellpadding='0' cellspacing='0'>
		            <tr>
		              <td width='33%'><strong>1. Name</strong></td>
		              <td width='1%'>:</td>
		              <td width='66%'>&nbsp;". $row['employeeName']."<hr/></td>
		            </tr>
		            <tr>
		              <td><strong>2. Position</strong></td>
		              <td>:</td>
		              <td>&nbsp;". $row['positionName']."<hr/></td>
		            </tr>
		            <tr>
		              <td height='25'><strong>3. Travel To</strong></td>
		              <td>:</td>
		              <td>&nbsp;". $row['travelingTo']."<hr/></td>
		            </tr>
		            <tr>
		              <td height='25'><strong>4. Purpose of Trip</strong></td>
		              <td>:</td>
		              <td>&nbsp;". $row['purposeOfTrip']."<hr/></td>
		            </tr>
		            <tr>
		              <td height='25'><strong>5. Effective From</strong></td>
		              <td>:</td>
		              <td valign='baseline'>&nbsp;". $row['effectiveFrom']."<hr/></td>
		            </tr>
		            <tr>
		
		              <td height='25'><strong>6. Effective To</strong></td>
		              <td>:</td>
		              <td valign='bottom'>&nbsp;". $row['effectiveTo']."<hr/></td>
		            </tr>
		            <tr>
		              <td height='36'><strong>7. Expenses Required</strong></td>
		              <td>:</td>
		              <td valign='bottom'>&nbsp;". $row['expensesRequired']."<hr/></td>
		            </tr>
		          </table></td>
		      </tr>
		      <tr>
		        <td valign='top' height='22'><table width='100%' border='0' cellspacing='0' cellpadding=' 0 3px'>
		          <tr>
		            <td width='33%' align='center'>&nbsp;". $row['employeeName']."<hr/></td>
		            <td width='1%' align='center'>&nbsp;</td>
		            <td width='33%' align='center'>&nbsp;". $immSupName."<hr/></td>
		            <td width='1%' align='center'>&nbsp;</td>
		            <td width='32%' align='center'>&nbsp;". $hodName."<hr/></td>
		            
		          </tr>
		          <tr>
		            <td align='center'><strong>Applicant</strong></td>
		            <td align='center'>&nbsp;</td>
		            <td align='center'><strong>Immediate Superior</strong></td>
		            <td align='center'>&nbsp;</td>
		            <td align='center'><strong>HoD</strong></td>           
		          </tr>
		        </table></td>
		      </tr>
		      <tr>
		        <td valign='top'>         
		          <table class='repor' width='100%' border='0' cellspacing='0' cellpadding='0' 
		            		style='border-collapse:collapse'>
		            <tr>
		              <th valign='top' align='left' height='21' scope='col'>&nbsp;</th>
		              </tr>
		            <tr>
		              <th height='21' align='left' scope='col'>(B) HR Department Review</th>
		              </tr>
		            <tr>
		              <th align='left' valign='top' scope='col'><table width='100%' border='0' 
		            		cellspacing='0' cellpadding='0'>
		                <tr>
		                  <td width='2%'>&nbsp;</td>
		                  <td colspan='3'>&nbsp;</td>
		                  </tr>
		                <tr>
		                  <td>&nbsp;</td>
		                  <td width='30%' align='left'><strong>* Means Of Transportation </strong></td>
		                  <td width='1%' align='center'> :</td>
		                  <td width='67%'>&nbsp;". $row['meansOfTransport']."<hr/> </td>
		                </tr>
		                
		                <tr>
		                  <td>&nbsp;</td>
		                  <td align='left' valign='top'><strong>* Class of Air Tickets</strong></td>
		                  <td align='center'>:</td>
		                  <td>&nbsp;". $row['classOfAirTicket']."<hr/></td>
		                </tr>
		                <tr>
		                  <td>&nbsp;</td>
		                  <td align='left' valign='top'><strong>* Class of Hotel</strong></td>
		                  <td align='center'>:</td>
		                  <td>&nbsp;". $row['classOfHotel']."<hr/></td>
		                </tr>
		                <tr>
		                  <td>&nbsp;</td>
		                  <td align='left' valign='top'><strong>* Advance expenses</strong></td>
		                  <td align='center'>:</td>
		                  <td>&nbsp;". $row['amount']."<hr/></td>
		                </tr>
		                <tr>
		                  <td>&nbsp;</td>
		                  <td align='left' valign='top'><strong>* Debit</strong></td>
		                  <td align='center'>:</td>
		                  <td>030802&nbsp;&nbsp;&nbsp;&nbsp;". $row['expenseApproved']."
		                  		&nbsp;&nbsp;&nbsp;&nbsp;For SDG<hr/></td>
		                </tr>
		                <tr>
		                  <td>&nbsp;</td>
		                  <td align='left' valign='top' style='text-decoration:underline' >
		                  		 <strong>Comments:</strong></td>
		                  <td align='center'>&nbsp;</td>
		                  <td>&nbsp;</td>
		                </tr>
		              </table></th>
		            </tr>
		            <tr>
		              <th align='left' valign='top'  style='padding: 5px;border:thin dashed #999;'>
		                  		&nbsp;". $row['travelingComments']." </th>
		            </tr>
		            <tr>
		              <th align='left' valign='top' scope='col'>
		                  		<table width='100%' border='0' cellspacing='0' cellpadding=' 0 3px'>
		                <tr>
		                  <td width='49%' align='center'>&nbsp;". $hrAdminName."<hr/></td>
		                  <td width='2%' align='center'>&nbsp;</td>
		                  <td width='49%' align='center'>&nbsp;". $hrMgrName."<hr/></td>
		                </tr>
		                <tr>
		                  <td align='center'><strong>". $hrAdminStatus." Senior Ex. Administration</strong></td>
		                  <td align='center'>&nbsp;</td>
		                  <td align='center'><strong>". $hrMgrStatus." Head - HR Department</strong></td>
		                </tr>
		                <tr>
		                  <td colspan='3' align='left'>
		                  		<table width='100%' border='0' cellspacing='0' cellpadding='3px'>
		                    <tr>
		                      <td width='25%'>&nbsp;</td>
		                      <td width='45%' align='center'>&nbsp;". $gmName."<hr/></td>
		                      <td width='30%'>&nbsp;</td>
		                    </tr>
		                    <tr>
		                      <td>&nbsp;</td>
		                      <td align='center'><strong>". $gmStatus." General Manager</strong></td>
		                      <td>&nbsp;</td>
		                    </tr>
		                  </table></td>
		                  </tr>
		              </table></th>
		            </tr>
		          </table></td>
		      </tr>
		      <tr>
		        <td align='center' valign='top'>This is Computer generated receipt. No signature is required</td>
		      </tr>
		    </table></td>
		  </tr>
		</table> ";
                  
        // \Zend\Debug\Debug::dump($output); 
        		
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
    	// @todo implementation
    	return $this->travelingFormMapper
    	            ->getEmployeeEntitlement($employeeId,$leaveType,$fromDate,$toDate); 
    	//return '33'; 
    } 
    // Currently active 
    public function getEmployeeOutstandingBalance($employeeId,$leaveType,$fromDate,$toDate) {
    	return $this->travelingFormMapper
    	            ->getEmployeeOutstandingBalance($employeeId,$leaveType,$fromDate,$toDate);
    	//return '34'; 
    }
    // Currently active
    public function getEmployeeLeaveDaysTaken($employeeId,$leaveType,$fromDate,$toDate) {
    	$result = $this->travelingFormMapper
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
    
    
    // public function 
}