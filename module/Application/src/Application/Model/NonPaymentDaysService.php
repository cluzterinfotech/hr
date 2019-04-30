<?php 

namespace Application\Model;

use Payment\Model\DateMethods;

class NonPaymentDaysService extends DateMethods {
	
	protected $tables = array(
			'Leave' 
	); 
	
	protected $paySuspendTables = array(
			'EmpSuspendInfo' 
	); 
	
	protected $employeeMainTables = array(
			'EmpEmployeeInfoMain' 
	); 
	
	protected $lookupService; 
	//protected $leaveService;
	//protected $ 
	
	public function __construct(LookupService $lookupService) {
	    $this->lookupService = $lookupService;             	
	} 
	
	public function getEmployeeFinalEntitlementNonWorkingDays($employeeNumber,$fromDate,$toDate) {
		$totalDays = 0;
		$totalDays += $this->leaveWithoutPay($employeeNumber,$fromDate,$toDate);
		$totalDays += $this->paySuspendDays($employeeNumber,$fromDate,$toDate);
		// $totalDays += $this->firstMonthDays($employeeNumber,$fromDate,$toDate); 
		return $totalDays;
	}
	
	public function getCarRentNonWorkingDays($employeeNumber,$fromDate,$toDate) {
	    $totDays = 0;  
	    $leaveWoPay = $this->leaveWithoutPay($employeeNumber,$fromDate,$toDate); 
	    $sickLeaveDays = $this->otherLeaveDays($employeeNumber, $fromDate, $toDate,'7');
	    if($sickLeaveDays < 10) {
	        $sickLeaveDays = 0; 
	    }
	    $suspendDays = $this->paySuspendDays($employeeNumber, $fromDate, $toDate); 
	    $annualLeaveDays = $this->otherLeaveDays($employeeNumber, $fromDate, $toDate,'1'); 
	    $emergencyLeaveDays = $this->otherLeaveDays($employeeNumber, $fromDate, $toDate,'2'); 
	    $examLeaveDays = $this->otherLeaveDays($employeeNumber, $fromDate, $toDate,'3'); 
	    $hejjLeaveDays = $this->otherLeaveDays($employeeNumber, $fromDate, $toDate,'4'); 
	    $materLeaveDays = $this->otherLeaveDays($employeeNumber, $fromDate, $toDate,'6'); 
	    $totDays = $leaveWoPay + $sickLeaveDays + $suspendDays + $annualLeaveDays 
	    + $emergencyLeaveDays + $examLeaveDays + $hejjLeaveDays + $materLeaveDays;
	    $comments = 
	    "  Leave Without Pay " . $leaveWoPay .
	    "  Sick Leave " . $sickLeaveDays .
	    "  Suspend Days " . $suspendDays .
	    "  Annual Leaves" . $annualLeaveDays .
	    "  emergencyDays = " . $emergencyLeaveDays .
	    "  examDays = " . $examLeaveDays .
	    "  hejjDays = " . $hejjLeaveDays .
	    "  maternityDays = " . $materLeaveDays;  

	    return array($totDays,$comments); 
	}
	
	public function getEmployeeLeaveAllowanceNonWorkingDays($employeeNumber,$fromDate,$toDate) {
		return $this->getEmployeePaysheetNonWorkingDays($employeeNumber,$fromDate,$toDate);
	} 
	
	// @return number of days
	public function getEmployeePaysheetNonWorkingDays($employeeNumber,$fromDate,$toDate) { 
		//echo "non pay days";
		//exit; 
	    $totalDays = 0;  
	    $totalDays += $this->leaveWithoutPay($employeeNumber,$fromDate,$toDate); 
	    $totalDays += $this->paySuspendDays($employeeNumber,$fromDate,$toDate);
	    $totalDays += $this->firstMonthDays($employeeNumber,$fromDate,$toDate); 
	    /*if($employeeNumber == '1247') {
	    	echo $totalDays;
	    	exit; 
	    }*/ 
	    return $totalDays;    	
	} 
	
	public function leaveWithoutPay($employeeNumber,$fromDate,$toDate) {
		$leaveType = 5; 
		if($employeeNumber) {
			$daysCount = 0;
			foreach ($this->tables as $tableName) { 
				$daysList = $this->lookupService
				                 ->getLeaveRange($tableName,$fromDate,$toDate,
				                 		$employeeNumber,$leaveType);
				/*if($employeeNumber == '1291') {
					\Zend\Debug\Debug::dump($daysList);
					exit; 
				} */ 
				if($daysList) {
					foreach($daysList as $days) { 
						$startingDate = $days['leaveFromDate'];
						$endingDate = $days['leaveToDate'];
						if ($startingDate <= $fromDate)
							$startingDate = $fromDate;
						if ($endingDate >= $toDate) {
							$endingDate = $toDate;
						}
						$numberOfDays = $this->numberOfDaysBetween(
								$startingDate,$endingDate);
						$daysCount += $numberOfDays;
					}
				} 
			}
			/*if($employeeNumber == '1291') {
				echo $daysCount;
				exit; 
			}*/
			return $daysCount; 
		} 
		return 0; 
	} 
	
	
	public function otherLeaveDays($employeeNumber,$fromDate,$toDate,$leaveType = '1') {
	    //$leaveType = 7;
	    if($employeeNumber) {
	        $daysCount = 0;
	        foreach ($this->tables as $tableName) {
	            $daysList = $this->lookupService
	            ->getLeaveRange($tableName,$fromDate,$toDate,
	                $employeeNumber,$leaveType);
	            /*if($employeeNumber == '1291') {
	             \Zend\Debug\Debug::dump($daysList);
	             exit;
	             } */
	            if($daysList) {
	                foreach($daysList as $days) {
	                    $startingDate = $days['leaveFromDate'];
	                    $endingDate = $days['leaveToDate'];
	                    if ($startingDate <= $fromDate)
	                        $startingDate = $fromDate;
	                        if ($endingDate >= $toDate) {
	                            $endingDate = $toDate;
	                        }
	                        $numberOfDays = $this->numberOfDaysBetween(
	                            $startingDate,$endingDate);
	                        $daysCount += $numberOfDays;
	                }
	            }
	        }
	        /*if($employeeNumber == '1291') {
	         echo $daysCount;
	         exit;
	         }*/
	        return $daysCount;
	    }
	    return 0;
	}
	
	public function paySuspendDays($employeeNumber,$fromDate,$toDate) { 
		if($employeeNumber) {
			$daysCount = 0;
			foreach ($this->paySuspendTables as $tableName) { 
				$daysList = $this->lookupService
				                 ->getPaysuspendRange($tableName,$fromDate,$toDate,$employeeNumber);
				if($daysList) {
					foreach($daysList as $days) {
						$startingDate = $days['suspendFrom'];
						$endingDate = $days['suspendTo'];
						if ($startingDate <= $fromDate)
							$startingDate = $fromDate;
						if ($endingDate >= $toDate) {
							$endingDate = $toDate;
						}
						$numberOfDays = $this->numberOfDaysBetween(
								$startingDate,$endingDate);
						$daysCount += $numberOfDays;
					}
				} 
			}
			return $daysCount;
		}
		return 0; 
	}
	
	public function firstMonthDays($employeeNumber,$fromDate,$toDate) {
		/*if($employeeNumber == '1248') {
			echo $numberOfDays;
			exit;
		}*/
		if($employeeNumber) {
			$daysCount = 0;
			foreach ($this->employeeMainTables as $tableName) { 
				$joinDate = $this->lookupService
				            ->getEmpJoinDate($tableName,$employeeNumber); 
				$joinDate = date("Y-m-d", strtotime($joinDate)); 
				$fromDate = date("Y-m-d", strtotime($fromDate));
				$toDate = date("Y-m-d", strtotime($toDate));
				if($joinDate < $fromDate) {
				    return 0;
				}
				//$fromDate = date()
				/*if($employeeNumber == '1247') {
					echo $joinDate."<br/>";
					echo $fromDate;
					exit;
				}*/
				if($joinDate == $fromDate) {
					return 0;
				}
				if($joinDate == $toDate) {
					$numberOfDays = $this->numberOfDaysBetween($fromDate,$toDate); 
				} 
				if($joinDate > $fromDate &&  $joinDate < $toDate) { 
					$numberOfDays = $this->numberOfDaysBetween($fromDate,$joinDate); 
				}
				/*if($employeeNumber == '1248') {
					echo $numberOfDays;
					exit;
				}*/
				return $numberOfDays;
			} 
		}
		return 0; 
	}   
}