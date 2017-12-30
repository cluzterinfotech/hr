<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper; 

class EmployeeReportHelper extends AbstractHelper {
		
	public function __invoke($name,$results) {
		$output = "";
		$total = 0;
		$output .= "<table id = 'myReport'><thead><tr>"; 
		$output .= "<td>SNo.</td>";
		foreach ($name as $key=>$val) {
			$output .= "<td>".$key."</td>";
		} 
		$output .= "</thead></tr><tbody>";
		$i = 1; 
		foreach ($results as $result) {
			$output .= "<tr  class='grid'>";
			$output .= "<td>".$i++."</td>";
			foreach ($name as $key=>$val) {
				//$value = $results[$key]; 
				$output .= "<td>".$result[$val]."</td>";
			} 
			$output .= "</tr></tbody>";
		}
		$output .= "</table>";
		return $output;
	}   
	
} 