<?php
namespace Application\Utility;

class DateMethods {
	
	public function numberOfDays($fromDate,$todate) {
		$startDate = strtotime($fromDate);
		$endDate = strtotime($todate);
		$datediff = ( $endDate > $startDate ? ( $endDate - $startDate ) : ( $endDate - $startDate ) );
		$totDays = floor(( $datediff / 3600 ) / 24);
		$totDays = $totDays + 1;
		return $totDays;
	}
	
}