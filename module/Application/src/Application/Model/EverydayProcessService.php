<?php  

namespace Application\Model;
      
use Leave\Model\Approvals;

class EverydayProcessService extends Approvals {  
	
	protected $attendanceRecord = array();
	
	public function getAttendanceService() {
	    return $this->services->get('attendanceMapper');     	
	}
	
	/*
	 * @todo all the following methods 
	 */
	public function isDailyProcessPrepared() { 
	    return $this->leaveFormMapper
	                ->isAttendancePrepared($this->dateMethods->getYesterday());  
	} 
	
	public function performDailyProcess() { 
		$this->prepareDailyAttendance(); 
		//$this->sendDailyAlerts(); 
	}
	
	public function isHaveExceptionAll($date,$loc,$day) { 
		return $this->leaveFormMapper->isHaveExceptionAll($date,$loc,$day);  
	} 
	
	public function getLocHrs($attenLocArray,$date,$loc,$day) { 
		// ishave exception 
		// @todo 
		return array(
				'DayName'       => '0',
				'Status'        => 'N',
				'WorkingHours'  => '08:00', 
				'location'      => '1',
				'startTime'     => '08:00',
				'endTime'       => '04:00',
				'locationGroup' => '1', 
		); 
		$isHaveExcDate = $this->isHaveExceptionAll($date,$loc,$day); 
		if(!$isHaveExcDate) {
			foreach ($attenLocArray as $arr) {
				if(($arr['location'] == $loc) && ($arr['Status'] == $day)) {
				    return $arr; 
				}
			} 
			throw new \Exception('Location Hours Not found! Please add');
		} else {
			return $isHaveExcDate; 
		} 
	} 
	
	public function prepareDailyAttendance() {  
	    try {
		    $this->databaseTransaction->beginTransaction();
    		$employeeList = $this->leaveFormMapper->getAllActiveEmployee(); 
    		$wh = $this->leaveFormMapper->getAllLocationOvertime();  
    		$from = '2017-12-01';//$this->leaveFormMapper->getLastAttendanceDate(); 
    		//$workHrs = $this->getLocHrs($wh,$from,'1','N'); 
    		// to date from yesterday 
    		$to = '2017-12-07';//$this->dateMethods->getYesterday(); 
    		$noOfDays = $this->dateMethods->numberOfDaysBetween($from,$to);
    		$noOfDays -= 1; 
    		$this->leaveFormMapper
    		     ->addAttendancePreparedDate($this->dateMethods->getYesterday());  
    		//echo $noOfDays; 
    		//exit;  
    		// @todo update last attendance date 
    		//echo "Number of days - ".$noOfDays."<br/>";  
    		foreach($employeeList as $lst) { 
    		    //\Zend\Debug\Debug::dump($lst);
    		    //\Zend\Debug\Debug::dump($noOfDays);
    		    //exit; 
    			$empId = trim($lst['employeeNumber']);  
    			$loc = $lst['positionLocation'];  
    			$this->attendanceRecord = '';  
    			$this->attendanceRecord['cardId'] = $empId; 
    			for($i=0;$i<$noOfDays;$i++) { 
    			    $noAttendance = 0;
    				$date = $this->dateMethods->getCustomDate($from,$i);
    				$this->attendanceRecord['attendanceDate'] = $date; 
    				$fromToTime = $this->dateMethods->getBeginningEndDay($date);
    				$start = $fromToTime['starting'];
    				$end = $fromToTime['ending']; 
    				$this->attendanceRecord['attendanceDate'] = $date;
    			    $startingTime = $this->leaveFormMapper->fetchStatingTime($empId,$start,$end);
    			    $dt1 = new \DateTime($startingTime);
    			    $fromTime = $dt1->format('H:i:s');
    			    $endTime =  $this->leaveFormMapper->fetchEndingTime($empId,$start,$end);
    			    $dt2 = new \DateTime($endTime);
    			    $toTime = $dt2->format('H:i:s');
    			    $day = date('w', strtotime($date)); 
    			    $actWorkHr = $this->getLocHrs($nrWrkHr,$date,$loc,$day); 
    			    $nrWrkHr = $actWorkHr['WorkingHours']; 
    			    $locStartTime = $actWorkHr['startTime'];  
    			    $locEndTime = $actWorkHr['endTime'];  
    			    $dayStatus = $wh[$day]['Status'];
    			    $this->attendanceRecord['dayStatus'] = $dayStatus;
    			    if(isset($fromTime)) {
    			    	$this->attendanceRecord['startingTime'] = $fromTime;
    			    	if($fromTime == $toTime) {  
    			    	    //Single Entry 
    			    	    $this->attendanceRecord['endingTime'] = $fromTime; 
    			    	    $this->attendanceRecord['duration'] = '00:00'; 
    			    	    $this->attendanceRecord['isSingleEntry'] = true;  
    			    	    $this->attendanceRecord['difference'] = $nrWrkHr; 
    			    	    $duration = '00:00'; 
    			        } else { 
    			        	$duration = $this->dateMethods->getTimeDiff($fromTime,$toTime, $sep = ":");  
    			        	$this->attendanceRecord['endingTime'] = $toTime; 
    			        	$this->attendanceRecord['duration'] = $duration;
    			        	$this->attendanceRecord['isSingleEntry'] = false;  	
    			        } 
    			        $difference = $this->dateMethods->getWorkDiff($duration,$nrWrkHr, $sep = ":");   
    			        $this->attendanceRecord['difference'] = $difference; 
    			    } 
    			    $this->attendanceRecord['locStartTime'] = $locStartTime;
    			    $this->attendanceRecord['locEndTime'] = $locEndTime;
    			    if($difference > 0) {
    			        $this->attendanceRecord['overTime'] = $difference;
    			    } else {
    			        $this->attendanceRecord['overTime'] = "00:00";
    			    } 
    			    $this->attendanceRecord['normalHour'] = "00:00";
    			    $this->attendanceRecord['holidayHour'] = "00:00";
    			    $this->attendanceRecord['noOfMeals'] = 0;
    			    $this->attendanceRecord['isUsed'] = 0;
    			    $this->attendanceRecord['isSubmitted'] = 0;
    			    $this->attendanceRecord['empOtId'] = 0;
    			    $this->attendanceRecord['isApproved'] = 0;
    			    $this->attendanceRecord['isEndorsed'] = 0;
    			    $this->attendanceRecord['isLateEntry'] = 0;
    			    $this->attendanceRecord['isEarlyExit'] = 0;
    			    if($startingTime == '00:00') {
    			        $r = $this->getNoAttendanceReason($date,$empId); 
    			        $this->attendanceRecord['isNoAttendance'] = 1;
    			        $this->attendanceRecord['noAttendanceReason'] = $r; 
    			    } else {
    			        $this->attendanceRecord['isNoAttendance'] = 0;
    			        $this->attendanceRecord['noAttendanceReason'] = 0; 
    			    }
    			    //\Zend\Debug\Debug::dump($this->attendanceRecord);  
    			    //exit;
    			    $this->leaveFormMapper->insertEmployeeAttendance($this->attendanceRecord); 
    			}  
    		}
    		$this->databaseTransaction->commit(); 
	    } catch(\Exception $e) {
	        $this->databaseTransaction->rollBack(); 
	        throw $e; 
	    }
	}
	
	public function getNoAttendanceReason($date,$empId) {
	    $isOnLeave = $this->nonWorkingDays->isHaveLeave($employeeNumber,$fromDate,$toDate); 
	    if($isOnLeave) {
	        return 1; 
	    }
	}
	
	public function getAbscentReason() {
		// On leave?
		// $this->nonWorkingDays->isHaveLeave($employeeNumber,$fromDate,$toDate); 
		// On Travel Local
		// $this->isHaveTravelLocal->
		// On Travel Abroad
		// $this->isHaveTravelAbroad 
		// return 'reason';  
	} 
	
	public function getAttendanceException() { 
		//Baby care 
		//Early exit Winter 
		//Early Exit Ramadan 
	}
	
	public function sendDailyAlerts() {
	    $this->getToDayAlerts();
	    $applicant = '1226';
	    $approver = '1075';
	    $this->mailService->leaveFormApprovalAlert($applicant, $approver);
	}
	
	public function getToDayAlerts() {
	    $AlertArray = $this->getAlertService()->getAlertsTypesObj();
	    //echo \Zend\Debug\Debug::dump( $AlertArray );
	    foreach($AlertArray as $alert) {
	        $this->PerpareEmplAlert($alert['formula'] , $alert['Id'] ,  $alert['alertType'] ); 
	       
	    }
	}	
	private function getAlertService() {
	    return  $this->services->get('AlertService');
	}
	private function PerpareEmplAlert($formula , $alertId , $alertType) {
	    $EmpArray =  $this->getAlertService()->PerpareEmployees($formula , $alertId);
	    $ToMailsArray =   $this->getAlertService()->getToEmails($alertId);
	    //if($alertId == 1 ) 
	        $this->mailService->SendEmpAlerts($EmpArray , $ToMailsArray , $alertType );

	}
		
	
}