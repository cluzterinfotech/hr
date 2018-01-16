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
                              <td>Employee Number</td>
				              <td>Position</td>
		                      <td>Group</td> 
		                      <td>Amount</td>
                              <td>Actual Amount</td>
				              <td>Bank</td>
				              <td>Account No.</td>
				              <td>Reference No.</td>
				              <td>Location</td> 
                              <td>Details</td>
		"; 
		$output .= "</thead></tr><tbody>";   
		$i = 1;   
		$totAct = 0;
		$totAmt = 0; 
		foreach ($results as $result) { 
		    $actAmt = 0;
		    $amt = 0;
		    $actAmt = $result['actualRent'];
		    $amt = $result['paidAmount'];
		    $totAct += $actAmt;
		    $totAmt += $amt; 
			$output .= "<tr  class='grid'>"; 
			$output .= "<td>".$i++."</td> 
			                      <td>".$result['employeeName']."</td> 
                                  <td>".$result['employeeNumber']."</td> 
			                      <td>".$result['positionName']."</td> 
			                      <td>".$result['groupName']."</td>
			                      <td>".$amt."</td> 
                                  <td>".$actAmt."</td> 
			                      <td>".$result['bankName']."</td> 
			                      <td>".$result['accountNumber']."</td>
			                      <td>".$result['referenceNumber']."</td> 
			                      <td>".$result['locationName']."</td> 
                                  <td>".$result['dtls']."</td> 
			";   
			//}   
			$output .= "</tr></tbody>"; 
		}
		$output .= "<tr ><td>&nbsp;</td> 
			             <td><b>Total</b></td> 
			             <td>&nbsp;</td> 
                         <td>&nbsp;</td>
			             <<td>&nbsp;</td>
			             <td><b>".$totAmt."</b></td> 
                         <td><b>".$totAct."</b></td> 
			             <td>&nbsp;</td>
			             <td>&nbsp;</td>
			             <td>&nbsp;</td>
			             <td>&nbsp;</td>
                         <td>&nbsp;</td>";
		return $output;
	}   
	
} 