<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper; 

class CarRentReportHelper extends AbstractHelper {
		
	public function __invoke($results) {
		$output = "";
		$total = 0;
		$output .= "<table id = 'myReport'><thead><tr>"; 
		$output .= "<td>SNo.</td> 
		                      <td>Employee Name</td> 
				              <td>Position</td>
		                      <td>Group</td> 
		                      <td>Amount</td>
				              <td>Bank</td>
				              <td>Account No.</td>
				              <td>Reference No.</td>
				              <td>Location</td> 
		"; 
		$output .= "</thead></tr><tbody>";   
		$i = 1;   
		foreach ($results as $result) { 
			$output .= "<tr  class='grid'>"; 
			$output .= "<td>".$i++."</td> 
			                      <td>".$result['employeeName']."</td> 
			                      <td>".$result['positionName']."</td> 
			                      <td>".$result['groupName']."</td>
			                      <td>".$result['paidAmount']."</td> 
			                      <td>".$result['bankName']."</td> 
			                      <td>".$result['accountNumber']."</td>
			                      <td>".$result['referenceNumber']."</td> 
			                      <td>".$result['locationName']."</td> 
			";   
			//}   
			$output .= "</tr></tbody>"; 
		}
		$output .= "</table>";
		return $output;
	}   
	
} 