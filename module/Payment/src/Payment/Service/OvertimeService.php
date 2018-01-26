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
	
	public function saveot($values) {
	    return $this->getOvertimeMapper()->saveot($values); 
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
	
	public function selectEmployeeManualAttendance() {
	    return $this->getOvertimeMapper()->selectEmployeeManualAttendance();
	}
	
	public function removeManualOt($id) {
	    return $this->getOvertimeMapper()->removeManualOt($id);
	}
	
	public function getSubmittedOtIds($arr) { 
	    return $this->getOvertimeMapper()->getSubmittedOtIds($arr);      
	}      
    
	public function updateAttendance($array) {
		return $this->getOvertimeMapper()->updateAttendance($array);
	}
	
	public function getAttendanceOtSum($arr) {
		$ids = $this->getSubmittedOtIds($arr);
		return $this->getOvertimeMapper()->getAttendanceOtSum($arr,$ids);
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
	
	public function submittosup($emp) { 		 
		try {
			$empId = $array['emp'];
			$this->databaseTransaction->beginTransaction(); 
			// get sum 
			$sum = $this->getAttendanceOtSum($array); 
			// N
			$norHr = $sum['normalHour'];
			$holiHr = $sum['holidayHour'];
			$norHrArr = explode(':', $norHr); 
			$holiHrArr = explode(':', $holiHr); 
			
			$normalHr = (int)$norHrArr[0]+((int)$norHrArr[1]/60); 
			$holidayHr = (int)$holiHrArr[0]+((int)$holiHrArr[1]/60); 
			//$norHr = str_replace(':', '.', $norHr);
			//$holiHr = str_replace(':', '.', $holiHr);
			//$sum = $this->getAttendanceOtSum($array); 
			$empOt = array(
					'empIdOvertime'     => $empId,
					'startingDate'      => $from,
					'endingDate'        => $to,
					'otStatus'          => 2,
			        'employeeNoNOHours' => $normalHr,
			        'employeeNoHOHours' => $holidayHr,
					'numberOfMeals'     => $sum['noOfMeals'], 
			); 
			// add ot details
			$empOtId = $this->getOvertimeMapper()->insert($empOt);  
			//exit;
			// update attendance flag in EmployeeAttendance
			$updateAtten = array(
					'isSubmitted'  => 1,
					'empOtId'      => $empOtId,
			);
			$this->getOvertimeMapper()->updateEmployeeAttendance($updateAtten,$from,$to,$empId); 
			$this->databaseTransaction->commit();  
		} catch(\Exception $e) {
			$this->databaseTransaction->rollBack();
			throw  $e;
		}
		// send mail 
		$this->mailService->overtimeFormSubmitAlert($empId);  
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
		$details = $this->getOvertimeMapper()->getAttenDetails($id); 
		$output = "
            <table cellpadding='10px' cellspacing='10px'>
                <tr><td>Name :</td><td><b>".$otInfoArray['employeeName']."</b></td>
                <td>&nbsp;</td><td>Number Of Meal:</td>
                <td><b>".$otInfoArray['numberOfMeals']."</b></td>
                </tr><tr><td>OT From :</td><td>".$otInfoArray['startingDate']."</td>
    			<td>&nbsp;</td><td>Normal Hours :</td>
    			<td><b>".$otInfoArray['employeeNoNOHours']."</b></td>
    			</tr><tr> <td>OT To :</td>
                <td>".$otInfoArray['endingDate']."</td>
    			<td>&nbsp;</td><td>Holiday Hour :</td>
    			<td><b>".$otInfoArray['employeeNoHOHours']."</b></td> 
    			</tr></table>
    			<br/>
    			<p><b>Attendance Details</b></p>
    			<table id = 'myReport' cellpadding='5px' cellspacing='5px'>
				  <thead><tr><th >Attendance Date</th>
				  <th >In Time</th><th >Out Time</th>
				  <th >Total Hrs</th><th >OT Hrs</th>
				  <th >Actual OT</th><th >Actual Holiday OT</th>
				  <th >No. Of Meal</th></tr></thead><tbody>";
		foreach ($details as $dtls) {
	        $output .= "
			<tr ><td>".$dtls['attendanceDate']."</td>
			<td>".$dtls['startingTime']."</td><td>".$dtls['endingTime']."</td>
			<td>".$dtls['duration']."</td><td>".$dtls['difference']."</td>
			<td >".$dtls['normalHour']."</td><td >".$dtls['holidayHour']."</td>
			<td >".$dtls['noOfMeals']."</td></tr>
		    "; 
		} 
        $output .= "</tbody></table>"; 
		return $output; 
	} 
	
	
	public function approveOtBySup($data,$userId) { 
		try {
			$this->databaseTransaction->beginTransaction(); 
			$id = $data->getId(); 
			if(!$this->isWaitingForApproval($id)) { 
				return 0; 
			} 
			$appType = $data->getApprovalType(); 
			if($appType == 1) {
				$this->getOvertimeMapper()->supervisorApproval($id);  
			} else {
				$this->getOvertimeMapper()->supervisorReject($id);
				$this->getOvertimeMapper()->reverseAttendance($id); 
			} 
			$this->databaseTransaction->commit(); 
			return 1; 
		} catch (\Exception $e) { 
			$this->databaseTransaction->rollBack(); 
			throw $e; 
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