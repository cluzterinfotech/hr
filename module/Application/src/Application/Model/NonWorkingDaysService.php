<?php 

namespace Application\Model;

class NonWorkingDaysService  {
	
	/*
	 * notes for this class 
	 * here fixed rules are followed 
	 */
	
	/*
	 * Case  
	 * payment process
	 * company
	 */
	
	/* Payment Process
	 * leave
	 * traveling
	 * suspend 
	 */
	
	protected $tables = array(
			'LeaveForm'	=> array(
					'leaveFrom','leaveTo','isApproved'
			),
			/*'LeaveFormO'	=> array(
					'leaveFromO','leaveToO','isApprovedO'
			),*/
	); 
	
	protected $lookupService; 
	//protected $leaveService;
	//protected $ 
	
	public function __construct(LookupService $lookupService) {
	    $this->lookupService = $lookupService;             	
	}
	
	public function getEmployeePaysheetNonWorkingDays($employeeNumber,$fromDate,$toDate) {
		$tot = 0;
	    $tot += $this->getLeave($fromDate,$toDate);
	    $tot += $this->getTraveling($fromDate,$toDate);
	    //\Zend\Debug\Debug::dump($tot);  
	    //exit; 
	    return $tot;   	
	} 
	
	public function isHaveLeave($employeeNumber,$fromDate,$toDate) {
		return 1; 
	}
	
	public function isHaveTraveling($employeeNumber,$fromDate,$toDate) {
		return 0; 
	} 
	
	public function getLeave($employeeNumber,$fromDate,$toDate) {
		//
		return 12; 
	}
	
	public function leaveWithoutPay($employeeNumber,$fromDate,$toDate) {
		return 1; 
	}
	
	public function paySuspend($employeeNumber,$fromDate,$toDate) {
	    return 1;  	
	}
	 
	public function getTraveling($employeeNumber,$fromDate,$toDate) {
		return 10;
	}
	
	// @return boolean
	public function isOverlap($employeeNumber,$fromDate,$toDate) {
		//echo $employeeNumber;
		//exit; 
		if($fromDate < date('Y-m-d') ) {
			 return array('0','From date is lesser than today');  
		}
		
		if($fromDate > $toDate ) {
			return array('0','from date is greater than to date');  
		}
		if($employeeNumber) {
			
			$isOverlaps = $this->lookupService
			                   ->isOverlap('LeaveForm',$fromDate,$toDate,$employeeNumber); 
			if($isOverlaps) {
				return array('0',"Leave form already have these date entries");
			}
			
			$isOverlapsSus = $this->lookupService
			->getPaysuspendRangeOverlap('EmpSuspendInfo',$fromDate,$toDate,$employeeNumber); 
			if($isOverlapsSus) {
				return array('0',"Suspend form already have these date entries");
			}
			
			/*foreach ($this->tables as $tableName => $val) { 
				$from = $val['0'];
				$to = $val['1'];
				$status = $val['2'];  
				$isOverlaps = $this->lookupService
				                   ->isOverlap($tableName,$fromDate,$toDate,$employeeNumber); 
				if($isOverlaps) {
					return array('0',$tableName." already have these date entries"); 
				}
			}*/ 
			 
		} 
		return array('1',' ');  
		
	}
	
}