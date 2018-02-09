<?php 

namespace Payment\Service;

use Payment\Mapper\OvertimeMapper; 
use Payment\Model\DateRange; 
use Leave\Model\Approvals; 
use Payment\Model\Company;

class OvertimeService extends Approvals { 
	
	private $overtimeMapper; 
	
	public $formType = 'OverTime';
	
	/*public function __construct(OvertimeMapper $overtimeMapper) {
		$this->overtimeMapper = $overtimeMapper;
	}*/
	
	public function getOvertimeMapper() {
	    return $this->services->get('overtimeMapper'); 
	} 
	
	public function getAttendanceByDate($date,$emp) { 
	    $row = $this->getOvertimeMapper()->getAttendanceByDate($date,$emp);
	    if($row) {
	        $inT = $row['startingTime'];
	        $out = $row['endingTime'];
    	    $res = array(
    	        'inTime'          => $inT,
    	        'outTime'         => $out,
    	        'locWorkHours'    => $row['locWorkHours'],
    	        'otElegibleHours' => $row['difference'],
    	        'attendanceId'    => $row['id'],
    	        'dayStatus'       => $row['dayStatus']
    	    ); 
    	    return $res; 
	    }
	    return array('rec' => 0); 
	} 
	
	public function getEmpOtById($id) {
	    $row = $this->getOvertimeMapper()->getEmpOtById($id); 
	    //\Zend\Debug\Debug::dump($row);
	    if($row) {
	        //$inT = $row['startingTime'];
	        //$out = $row['endingTime'];
	        $otHrs = $row['overTimeHours']; 
	        $ot = explode(':', $otHrs); 
	        $hr = $ot[0];
	        $min = $ot[1];
	        $res = array(
	            'id'              => $row['id'], 
	            'attendanceId'    => $row['attendanceId'],
	            'employeeOtId'    => $row['employeeOtId'],
	            'otDate'          => $row['otDate'],
	            'inTime'          => $row['inTime'],
	            'outTime'         => $row['outTime'],
	            'locWorkHours'    => $row['locWorkHours'],
	            'otElegibleHours' => $row['otElegibleHours'],
	            'overTimeHours'   => $hr,
	            'overTimeHoursMin'=> $min,
	            'numberOfMeals'   => $row['numberOfMeals'],
	            'otStatus'        => $row['otStatus'],
	            'dayStatus'       => $row['dayStatus'],
	            
	            //'inTime'          => $inT,
	            //'outTime'         => $out,
	            //'locWorkHours'    => $row['locWorkHours'],
	            //'otElegibleHours' => $row['difference'],
	            //'attendanceId'    => $row['id'],
	            //'dayStatus'       => $row['dayStatus']
	        );
	        return $res;
	    }
	    return array('rec' => 0);
	}
	
	public function saveot($values) {
	    return $this->getOvertimeMapper()->saveot($values); 
	}
	
	public function updateot($values) {
	    return $this->getOvertimeMapper()->updateot($values);
	}
	
	public function selectEmployeeOvertime($employeeNumber) {
		return $this->getOvertimeMapper()->selectEmployeeOvertime($employeeNumber);
	} 
	
	public function selectEmpOvertime($emp) { 
	    if(!$emp) {
			return array(); 
		}  
		return $this->getOvertimeMapper()->selectEmpOvertime($emp);   
	}
	
	public function selectEmpAppOvertime($emp) {
	    if(!$emp) {
	        return array();
	    }
	    
	    // @todo condition 
	    return $this->getOvertimeMapper()->selectEmpAppOvertime(/*@ids$emp*/);
	}
	
	public function selectEmployeeManualAttendance() {
	    return $this->getOvertimeMapper()->selectEmployeeManualAttendance();
	}
	
	public function removeEmpOvertime($id) {
	    return $this->getOvertimeMapper()->removeEmpOvertime($id);
	}
	
	public function removeManualOt($id) {
	    return $this->getOvertimeMapper()->removeManualOt($id);
	}
	
	public function getSubmittedOtIds() { 
	    return $this->getOvertimeMapper()->getSubmittedOtIds();      
	}      
    
	public function updateAttendance($array) {
		return $this->getOvertimeMapper()->updateAttendance($array);
	}
	
	public function getAttendanceOtSum() {
		$ids = $this->getSubmittedOtIds(); 
		return $this->getOvertimeMapper()->getAttendanceOtSum($ids);
	}
	
	/*public function isAllowedToSubmit($user,DateRange $dateRange) {
		if(!$this->isHaveThisMonthOt($user,$dateRange)) { 
		    return 1;  	
		}  
		if($this->isWaitingForApproval($user,$dateRange)) { 
			return 1;   
		} 
		return 0;    
	}*/        
	
	public function isHaveThisMonthOt($user,DateRange $dateRange) { 
		return $this->getOvertimeMapper()->isHaveThisMonthOt($user,$dateRange);	 
	}     
	
	public function isWaitingForApproval($id) {   
		return $this->getOvertimeMapper()->isWaitingForApproval($id);  	 
	}     
	
	public function getEmployeeOvertimeHours($user) {
		return $this->getOvertimeMapper()->getEmployeeOvertimeHours($user); 
	}
	
	public function saveManualOt($data,$month,$year) {
	    $firstDay = $this->dateMethods->getFirstDayByMonthYear($month,$year);   
	    $lastDay = $this->dateMethods->getLastDayOfDate($firstDay); 
	    $data['startingDate'] = $firstDay;  
	    $data['endingDate'] = $lastDay;  
	    return $this->getOvertimeMapper()->saveManualOt($data); 
	}
	
	public function fetchById($id) {
	    return $this->getOvertimeMapper()->fetchById($id);	
	}
	
	public function insert($entity) {
		return $this->getOvertimeMapper()->insert($entity); 
	}
	
	public function update($entity) {
		return $this->getOvertimeMapper()->update($entity); 
	}
	
	public function getOvertimeFormApprovalList($userId) { 
		return $this->getOvertimeMapper()
		            ->getOvertimeFormApprovalList($this->getIdsList($userId,'1'));
	}
	
	public function endorseAllByHr(DateRange $dateRange) {
	    try {
    	    $this->databaseTransaction->beginTransaction();
    	    $date = $dateRange->getFromDate(); 
    	    $list = $this->getOvertimeMapper()->endorseAllByHr();  
    	    foreach($list as $lst) {
    	        //\Zend\Debug\Debug::dump($lst);   
    	        $id = $lst['id']; 
    	        $otArray = array(
    	            'cardId'          => $lst['empIdOvertime'],
    	            'attendanceDate'  => $date,
    	            'normalHour'      => $lst['employeeNoNOHours'],
    	            'holidayHour'     => $lst['employeeNoHOHours'],  
    	        );
    	        $this->getOvertimeMapper()->insertOtAttendancePaysheet($otArray); 
    	        $otMeal = array(
    	            'employeeId'      => $lst['empIdOvertime'],
    	            'mealDate'        => $date,
    	            'numberOfMeals'   => $lst['numberOfMeals'],
    	            'amount'          => 0,
    	            'Status'          => 0,
    	        );
    	        $this->getOvertimeMapper()->insertOtMealPaysheet($otMeal); 
    	        $this->getOvertimeMapper()->supervisorApproval($id); 
    	    } 
    	    $this->databaseTransaction->commit(); 
	    } catch(\Exception $e) {
	        $this->databaseTransaction->rollBack(); 
	        throw $e; 
	    } 
	}
	
	// @todo endorse approver check
	public function getOvertimeFormEndorseList($userId) { 
	
		return $this->getOvertimeMapper()
		            ->getOvertimeFormApprovalListHr($this->getIdsList($userId,'3'));
	} 
	
	public function getIdsList($userId,$lvl) {
		$employeeNumber = $userId;// $this->userInfoService->getEmployeeId(); 
		$otWaitingList = $this->getOvertimeMapper()->getOvertimeFormWaitingAppList();
		if($otWaitingList) {
			$totId = array();
			$i = 1;
			foreach($otWaitingList as $lst) {
				//\Zend\Debug\Debug::dump($lst);
				//exit;
				$applicant = $lst['empIdOvertime'];
				$approvedLevel = $lst['otStatus'];
				//\Zend\Debug\Debug::dump($approvedLevel);
				//exit; 
				/*if($lvl == 2) {
					$approvedLevel = 3;  
				}*/
				$approver = $employeeNumber;
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
		return $totId; 
	} 
    
	public function checkIsApprover($applicant,$approver,$approvedLevel) {
		/*
		 * @param formType,applicant,approvalLevel,approver
		 */
		//return true;
		return $this->approvalService->isApprover($this->formType,$applicant,$approver,$approvedLevel);
	}
	
	public function submittosup($empId) { 
	    try { 
	        $this->databaseTransaction->beginTransaction();
	        // fetch maximum reference id 
	        $tot = 0; 
	        $maxRef = $this->getOvertimeMapper()->getMaxRef(); 
	        $plusOne = $maxRef + 1; 
	        // update reference number for current user 
	        // get sum of normal
	        $n = $this->getOvertimeMapper()->getEmpOtSum($empId,'N');
	        //\Zend\Debug\Debug::dump($n);
	        //exit; 
	        if($n) {
    	        $normalHr = $n['hour']; 
    	        $nSplit = explode(':',$normalHr); 
    	        $tot = $nSplit[0] + ($nSplit[0]/60); 
    	        $meals =  $n['noOfMeals'];  
    	        if(!$normalHr) {
    	            $normalHr = 0; 
    	        }
	        }
	        $h = $this->getOvertimeMapper()->getEmpOtSum($empId,'H');
	        //\Zend\Debug\Debug::dump($h);
	        //exit; 
	        if($h) {
	            $holidayHr = $h['hour'];
	            $hSplit = explode(':',$holidayHr);
	            $tot += $hSplit[0] + ($hSplit[0]/60); 
	            $meals +=  $h['noOfMeals']; 
	            if(!$holidayHr) {
	                $holidayHr = 0;
	            }
	            if(!$meals) {
	                $meals = 0;
	            }
	        }
	        $this->getOvertimeMapper()->updateRef($empId,$plusOne);
	        $this->getOvertimeMapper()->updateOtStatus($empId,$plusOne); 
	        
	        if($normalHr || $holidayHr || $meals) {
    	        $buff = array(
    	            'normalHours'   => $normalHr,
    	            'holidayHours'  => $holidayHr,
    	            'numberOfMeals' => $meals,
    	            'employeeId'    => $empId,
    	            'refNumber'     => $plusOne,
    	            'totalHours'     => $tot,
    	        ); 
    	        // insert into buffer  
    	        $this->getOvertimeMapper()->insertOtBuff($buff); 
    	        $this->databaseTransaction->commit();  
	        }
	        
	    } catch(\Exception $e ) {
	        $this->databaseTransaction->rollBack();
	        throw $e; 
	    } 
	    // send mail 
	    //$approver = $this->positionService->getImmediateSupervisorByEmployee($empId);  
	    //$this->mailService->overtimeFormSubmitAlert($empId,$approver);    
	}
	
	public function isAllowedToEdit($id) {
		return $this->getOvertimeMapper()->isAllowedToEdit($id); 
	}
	
	public function closeOt(Company $company,DateRange $dateRange,$routeInfo) {
		try {
			$this->databaseTransaction->beginTransaction(); 
			$results = $this->getOvertimeMapper()->fetchAllEndorsedOt(); 
			foreach ($results as $r) {
				$arr = array(
							 'cardId'          => $r['cardId'],
							 'attendanceDate'  => $r['attendanceDate'],
							 'normalHour'      => $r['normalHour'],
							 'holidayHour'     => $r['holidayHour'],
							 'noOfMeals'       => $r['noOfMeals'],
							 'attendanceId'    => $r['id'], 
				); 
				$this->getOvertimeMapper()->insertOtAttendancePaysheet($arr); 
			} 
			$this->getCheckListService()->closeLog($routeInfo); 
			$this->databaseTransaction->commit();
		} catch(\Exception $e) {
			$this->databaseTransaction->rollBack();
			throw $e; 
		}
	} 
	
	public function isOtClosed($company,$routeInfo) { 
		list($module,$controller,$controllerName) = explode('\\',$routeInfo['controller']);
		$isHave = $this->getCheckListService()->isHaveController($controllerName,$company);
		if($isHave) {
			return false;
		}
		return true;  
	}
	
	public function overtimeInfoById($id) { 
		$otInfoArray = $this->getOvertimeMapper()->getOvertimeById($id); 
		if(!$otInfoArray) {
			return "<p>No records found</p>";  
		} 
		$refNum = $otInfoArray['refNumber']; 
		$details = $this->getOvertimeMapper()->getAttenDetails($refNum);  
		$output = "
            <table cellpadding='10px' cellspacing='10px'>
                <tr>
                    <td>Name :</td>
                    <td><b>".$otInfoArray['employeeName']."</b></td>
                    <td>&nbsp;</td>
                    <td>Holiday Hour :</td>
    			    <td><b>".$otInfoArray['holidayHours']."</b></td> 
                </tr>
                <tr>
                    <td>Number Of Meal:</td>
                    <td><b>".$otInfoArray['numberOfMeals']."</b></td>
                    <td>&nbsp;</td>
    			<td>Normal Hours :</td>
    			<td><b>".$otInfoArray['normalHours']."</b></td>
    			</tr></table>
    			<br/>
    			<p><b>Attendance Details (N:Normal,H:Holiday)</b></p>
    			<table id = 'myReport' cellpadding='5px' cellspacing='5px'>
				  <thead><tr><th >Attendance Date</th>
				  <th >In Time</th><th >Out Time</th>
				  <th >Location Work Hrs</th><th >Elegible OT Hrs</th>
				  <th >Actual OT</th><th >No. Of Meal</th>
				  <th >Day Status</th></tr></thead><tbody>";
		foreach ($details as $dtls) {
	        $output .= "
			<tr ><td>".$dtls['otDate']."</td>
			<td>".$dtls['inTime']."</td><td>".$dtls['outTime']."</td>
			<td>".$dtls['locWorkHours']."</td><td>".$dtls['otElegibleHours']."</td>
			<td >".$dtls['overTimeHours']."</td><td >".$dtls['numberOfMeals']."</td>
			<td >".$dtls['dayStatus']."</td></tr>
		    "; 
		} 
        $output .= "</tbody></table>"; 
		return $output; 
	} 
		
	public function approveOtBySup($data,$userId) { 
		try {
		    $inc = 0; 
			$this->databaseTransaction->beginTransaction(); 
			$id = $data->getId(); 
			$appType = $data->getApprovalType(); 
			
			$ref = $this->getOvertimeMapper()->isNotApproved($id); 
			if(!$ref) {
			    return 0;     
			} 
			$otId = $ref['id']; 
			$status = $ref['otStatus']; 
			$totHrs = $ref['totalHours']; 
			$refNumber = $ref['refNumber'];
            
			if($appType == 1) {
			    if(($totHrs > 50) && ($status == '2')) {
			        $inc = 3;
			    } else {
			        $inc = $status + 1;
			    }
			    $update = array(
			        'otStatus' => $inc,
			        'id'       => $otId,
			    );
			    $this->getOvertimeMapper()->updateot($update); 
			} else {
			    $inc = 1; 
			    $update = array(
			        'otStatus' => $inc,
			        'approvalRefNumber'       => 0,
			    );
			    $this->getOvertimeMapper()->reverseot($update,$refNumber); 
			} 
			
			$this->databaseTransaction->commit(); 
			//return 1; 
		} catch (\Exception $e) { 
			$this->databaseTransaction->rollBack(); 
			throw $e; 
		}
		if($inc == 1) {
		    // send cancel alert 
		}
		if($inc == 3) {
		    // send mail to HOD
		}
		if($inc == 4) {
		    // send mail to HR  
		}
		if($inc == 4) {
		    // send approval alert 
		}
		return 0; 
	} 
	
	
	public function attendanceReport($company,$values) { 
		$i = 1; 
		$details = $this->getOvertimeMapper()->getAttendanceReport($company,$values); 
		$output = "
				<table cellspacing='5px' cellpadding='5px'>
				<thead><tr>
				<td >#</td>
				<td >EMP NAME</td>
				<td >cardId</td>
			    <td >date</td>
				<td >Day Status</td>
			    <td >In-Time</td>
			    <td >Out-Time</td>
			    <td >late entry</td>
			    <td >reason</td>
			    <td >early exit</td>
			    <td >Reason</td>
			    <td >isNoAttendance</td>
			    <td >noAttendanceReason</td>
				<td >Exception</td>
				<td >Department</td>
				<td >Location</td>
				</tr></thead><tbody>";   
		foreach ($details as $dtls) { 
			 $output .= "<tr>
						<td >".$i++."</td>
						<td >".$dtls['employeeName']."</td> 
						<td >".$dtls['cardId']."</td>
						<td >".$dtls['attendanceDt']."</td> 
						<td >".$dtls['dayStatus']."</td>
						<td >".$dtls['startingTime']."</td> 
						<td >".$dtls['endingTime']."</td>
						<td >".$dtls['isLateEntry']."</td> 
						<td >".$dtls['']."</td> 
						<td >".$dtls['isEarlyExit']."</td> 
						<td >".$dtls['']."</td> 
						<td >".$dtls['isNoAttendance']."</td>
					    <td >".$dtls['reason']."</td>
					    <td >Ramadan</td> 
						<td >".$dtls['departmentName']."</td>
					    <td >".$dtls['locationName']."</td>
						</tr>";  
		}
		$output .= "</tbody></table>"; 
		return $output;  
	} 
	
}
?>