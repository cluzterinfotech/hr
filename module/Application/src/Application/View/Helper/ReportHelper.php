<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

class ReportHelper extends AbstractHelper {
		
	public function __invoke($name,$alllowance,$deduction,$companyDeduction,$results) {
		$output = "";
		$total = 0;
		$output .= "<table class='sortable'><thead><tr>";
		//$output .= $this->prepare($name,$results); 
		foreach ($name as $key=>$val) {
			$output .= "<th  >".$key."</th>";
		}
		foreach ($alllowance as $key=>$val) {
			$output .= "<th >".$key."</th>";
		}
		$output .= "<th>Gross</th>";
		foreach ($deduction as $key=>$val) {
			$output .= "<th >".$key."</th>";
		}
		foreach ($companyDeduction as $key=>$val) {
			$output .= "<th >".$key."</th>";
		}
		$output .= "<th >Net</th>";
		$output .= "</thead></tr><tbody class='scrollingContent'>";
		foreach ($results as $result) {
			$output .= "<tr >";
			$total = 0;
			foreach ($name as $key=>$val) { 
				$value = $result[$val];
				$output .= "<td>".$value."</td>";
			}
			foreach ($alllowance as $key=>$val) {
				$value = $result[$val];
				$total += $value;
				$output .= "<td>".$value."</td>";
			}
			$output .= "<td>".$total."</td>";
			foreach ($deduction as $key=>$val) {
				//\Zend\Debug\Debug::dump($key); 
				//\Zend\Debug\Debug::dump($val); 
				//\Zend\Debug\Debug::dump($result); 
				$value = $result[$val]; 
				if($key != 'Zakat') {  
				    $total -= $value; 
				}  
				$output .= "<td>".$value."</td>";  
			}   
			foreach ($companyDeduction as $key=>$val) { 
				$value = $result[$val];  
				$output .= "<td>".$value."</td>"; 
			} 
			$output .= "<td>".$total."</td></tr>"; 
		} 
		$output .= "</tbody></table>";  
		return $output; 
	}   
	
	/*<tfoot >
	        <tr><th>&nbsp;</th></tr></tfoot>
	public function prepare($array,$results) {
		$output = ""; 
		$total = 0; 
		foreach ($array as $key=>$val) { 
			$output .= "<td>".$key."</td>"; 
		} 
		$output .= "<td>Net</td>"; 
		$output .= "</thead></tr><tbody>";
		foreach ($results as $result) {
			$output .= "<tr  class='grid'>";
			$total = 0;
			foreach ($array as $key=>$val) {
		
				$value = $result[$val];
				$total += $value;
				// number_format($value, 2, '.', '')
				$output .= "<td>".$value."</td>";
			}
			$output .= "<td>".$total."</td></tr></tbody>";
		}
		return $output;
	}*/ 
	
	
} 