<?php 

namespace Payment\Model; 

use Payment\Model\AbstractAllowance; 

class OverTime extends AbstractAllowance { 
    
	public function calculateAmount(Employee $employee,DateRange $dateRange) {  
		$dateService = $this->service->get('dateMethods');
		//$topDate = $this->companyAllowance
		               //->getTopOtAttendanceDate($employee);  
		$topDate = $dateRange->getFromDate(); 
		$topDate = $dateService->getFirstDayOfDate($topDate); 
		if($topDate) { 
			//$dateRange = $this->service->get('dateRange');  
			$company = $this->service->get('company'); 
			$otVal = $this->companyAllowance
			              ->getEmployeeOTValue($employee,$dateRange);
			$todate = $dateService->getLastDayOfDate($dateService->getToday()); 
			$totMonth = round($dateService->numberOfMonthsBetween($topDate,$todate)); 
			$ot = 0; 
			//for($i = 1; $i <= $totMonth; $i++ ) { 
				$toDate = $dateService->getLastDayOfDate($topDate); 
				//$dateRange->setFromDate($topDate);
				//$dateRange->setToDate($toDate); 
				$otHour = $this->companyAllowance
				               ->getEmployeeOTHour($employee,$dateRange);  
				if($otHour) { 
					$otTotHr = 0;
					$basic = $this->getBasic($employee,$company,$dateRange); 
					$otTotHr = ($otHour['normal'] * 1.5) + ($otHour['holiday'] * 2);
					$ot += (($otTotHr * $basic) / $otVal);
				}  
				$topDate = $dateService->getNextMonth($topDate);  
			//} 
			return $ot;  
		} else {
			return 0; 
		} 
	} 
	 
	public function calculateExemption(Employee $employee,DateRange $dateRange) { 
		return 0;  
	}
    
	public function getTableName() { 
		return "OverTime"; 
	} 
}   