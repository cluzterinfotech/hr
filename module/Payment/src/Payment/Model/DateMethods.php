<?php
namespace Payment\Model;

use Zend\Validator\Date;
use Zend\Stdlib\DateTime;

class DateMethods extends Date {
    
	public function isToDateGreaterOrEqual($fromDate,$toDate) { 
		if(!$this->isValid($fromDate) || !$this->isValid($toDate)) {
			throw new \Exception('Invalid date format');
		}
		if(strtotime($fromDate) <= strtotime($toDate)) {
			return true;
		} 
		return false; 
	}
	
	public function getCustomDate($fromDate,$number) {
		return date("Y-m-d",mktime(0, 0, 0,
				date("m",strtotime($fromDate)),
				date("d",strtotime($fromDate))+ $number,
				date("Y",strtotime($fromDate)))
				);
	}
	
	public function getNextMonth($fromDate) { 
		return date("Y-m-d",mktime(0, 0, 0, 
				date("m",strtotime($fromDate)) + 1, 
				date("d",strtotime($fromDate)), 
				date("Y",strtotime($fromDate)))
		);  
	} 
	
	public function numberOfDaysBetween($fromDate,$todate) {
		$a = new \DateTime($fromDate);
		$b = new \DateTime($todate);
		//\Zend\Debug\Debug::dump($a);
		//\Zend\Debug\Debug::dump($b); 
		//exit; 
		$diff = $a->diff($b);
		$tot = $diff->y * 365.25 + $diff->m * 30 + $diff->d + $diff->h/24 + $diff->i / 60;
		return (int)($tot + 1);  
		/*$startDate = strtotime($fromDate);
		$endDate = strtotime($todate);
		$datediff = ($endDate > $startDate ? ($endDate - $startDate) : ($endDate - $startDate));
		$totDays = floor(( $datediff / 3600 ) / 24);
		$totDays = $totDays + 1; 
		return $totDays;*/  
	} 
	
	public function getTimeDiff($startTime,$endTime, $sep = ":") {
		$start = explode($sep,$startTime);
		$end = explode($sep,$endTime);
		$hrDiff = (int)$end[0] - (int)$start[0]; 
		if ($end[1] < $start[1]) {
			$minDiff = $start[1] - $end[1]; 
			$minDiff = 60 - $minDiff;
			$hrDiff = $hrDiff - 1;
		} else {
			$minDiff = $end[1] - $start[1];
		}
		$diff = 0;
		if ($minDiff < 10) {
			$diff = $hrDiff . ":0" . $minDiff;
		} else {
			$diff = $hrDiff . ":" . $minDiff;
		} 
		
		return $diff;
	}
	
	public function getWorkDiff($startTime,$endTime, $sep = ":") {
	    $start = explode($sep,$startTime);
	    $end = explode($sep,$endTime);
	    $hrDiff =  (int)$end[0] - (int)$start[0] ;
	    $tDiff =  (int)$start[0] - (int)$end[0] ;
	    //if()
	    if ($end[1] < $start[1]) {
	        $minDiff = $start[1] - $end[1];
	        $minDiff = 60 - $minDiff;
	        $hrDiff = $hrDiff - 1;
	    } else {
	        $minDiff = $end[1] - $start[1];
	    }
	    $diff = 0;
	    if ($minDiff < 10) {
	        $diff = $hrDiff . ":0" . $minDiff;
	    } else {
	        $diff = $hrDiff . ":" . $minDiff;
	    }
	    if($tDiff < 0) {
	        return "-".$diff;
	    }
	    
	    return $diff;
	}
	
	public function numberOfHoursBatween($fromDate,$todate) {
		$a = new \DateTime($fromDate);
		$b = new \DateTime($todate);
		$diff = $a->diff($b);
		//$diff = strtotime($todate) - strtotime($fromDate);
		$df = new \DateTime(strtotime($diff));
		return $df->format('H:i:s');
	}
    
	public function numberOfMonthsBetween($fromDate,$todate) {
		$a = new \DateTime($fromDate);
		$b = new \DateTime($todate);
		$diff = $a->diff($b);
		$tot = $diff->y * 12 + $diff->m + $diff->d/30 + $diff->h / 24;
		return number_format($tot,3);
		/*list($start_year, $start_month, $start_day) = explode('-', $fromDate);
        list($end_year, $end_month, $end_day) = explode('-', $todate);
        $no_years = $end_year - $start_year;
        $no_months = $end_month - $start_month;
        $no_days = $end_day - $start_day;
        
        if ($no_days < 0) {
            $no_months = $no_months - 1;
        }
        if ($no_months < 0) {
            $no_years = $no_years - 1;
            $no_months = $no_months + 12;
        }
        $total_months = ($no_years * 12) + $no_months;
        //echo $total_months;
        return $total_months;*/ 
	} 
	
	public function numberOfYearsBetween($fromDate,$todate) {
	    $a = new \DateTime($fromDate); 
		$b = new \DateTime($todate); 
		$diff = $a->diff($b); 
		$tot = $diff->y + $diff->m / 12 + $diff->d / 365.25;
        return number_format($tot,3); 
		 
	}  
	
	/*
	    case "y":
            $total = $diff->y + $diff->m / 12 + $diff->d / 365.25; break;
        case "m":
            $total= $diff->y * 12 + $diff->m + $diff->d/30 + $diff->h / 24;
            break;
        case "d":
            $total = $diff->y * 365.25 + $diff->m * 30 + $diff->d + $diff->h/24 + $diff->i / 60;
            break;
        case "h":
            $total = ($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h + $diff->i/60;
            break;
        case "i":
            $total = (($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i + $diff->s/60;
            break;
        case "s":
            $total = ((($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i)*60 + $diff->s;
    */
	
	public function numberOfFracMonthsBetween($fromDate,$todate) {
		//$today = this_month(); 
		list($start_year, $start_month, $start_day) = explode('-', $fromDate);
		list($end_year, $end_month, $end_day) = explode('-', $todate);
		$no_years = $end_year - $start_year;
		$no_months = $end_month - $start_month;
		$no_days = $end_day - $start_day;
	    
		if ($no_days < 0) {
			$no_months = $no_months - 1;
			$no_days = ($this->getDaysInMonth($fromDate) - $start_day) + $end_day;
			$no_days = $no_days / $this->getDaysInMonth($fromDate);
		} else {
			$no_days += 1;
			$no_days = $no_days / $this->getDaysInMonth($todate);
		}
		if ($no_months < 0) {
			$no_years = $no_years - 1;
			$no_months = $no_months + 12; 
		} 
		$total_months = ($no_years * 12) + $no_months + $no_days; 
		return $total_months; 
	}
	
	// returns first day of the month for given date 
	public function getFirstDayOfDate($date) { 
		$d = new \DateTime($date);
		$d->modify('first day of this month');
		return $d->format('Y-m-d');
		//list($year,$month,$day) = explode('-',$date); 
		//return $year."-".$month."-01"; 
	} 
	
	public function getLastDayOfDate($date) { 
		return date("Y-m-t", strtotime($date)); 
	}
	
	public function getBeginningEndDay($from) {
		$toTime =  $from;
		$dt = new \DateTime($toTime);
		$toTime = $dt->setTime(23,59,59);
		$toTime = $dt->format('Y-m-d H:i:s');
		$df = new \DateTime($from);
		$from = $df->format('Y-m-d H:i:s');
		return array('starting' =>$from,'ending' =>$toTime); 
	}
	
	public function customFormatDate($from) {
	    return date("d-m-Y",strtotime($from));
	}
	
	public function getToday() {
	    $str = date('Y')."-".date('m')."-".date('d');
	    return date("Y-m-d",strtotime($str));
	}
	
	public function getFirstDayByMonthYear($month,$year) {
	    $str = $year."-".$month."-01"; 
	    return date("Y-m-d",strtotime($str));
	}
	
	public function getYesterday() {
		$str = date('Y')."-".date('m')."-".(date('d')-1);
		return date("Y-m-d",strtotime($str)); 
	}
	
	public function getPrevFifteenthDays($fromDate) { 
		
		/*list($year,$month,$day) = explode('-',$fromDate); 
		$lastMonth = $month - 1; 
		$datestring = '2011-03-30 first day of last month';
		$dt = date_create($datestring);
		echo $dt->format('Y-m');
		*/
		
	}
	
	public function numberOfYearsByDays($days = 0) { 
		if($days > 0) {
		    $months = $days / 30;
		    $years = $months/ 12; 
		    return $years; 
		}
	}
	
	public function numberOfDaysInMonth($fromDate) {
		if(!$fromDate) {
			return 0; 
		    // $fromDate = date("Y-m-d"); 
		}
		list($year,$month,$day) = explode('-',$fromDate);
	    // CAL_GREGORIAN
		return cal_days_in_month(CAL_GREGORIAN, $month, $year); 
	}
    
}