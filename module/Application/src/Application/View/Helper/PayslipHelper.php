<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

class PayslipHelper extends AbstractHelper {
		
	public function __invoke($name,$alllowance,$deduction,$companyDeduction,$results) {
		/*$output = "";
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
		return $output; */
		$output = "<center>
		<h2>Oil Energy</h2>
		<h1 align='center'>&nbsp;</h1>"; 
		$output .= "<table width='800px' border='0' cellpadding='0'>
		<tr>
		<td colspan='2'><b>Name :".$results['employeeName']."</td>
		</tr>
		<tr>
		<td valign='top'><table width='100%' style='border-collapse: collapse' border='1' cellspacing='5px' cellpadding='2px'>"; 
		
		foreach ($alllowance as $key=>$val) { 
			$value = $results[$val];
			$total += $value;
		    $output .= "<tr><td>".$key."</td>";
		    $output .= "<td>".$results[$val]."</td></tr>";
		}
		$output .= "<tr>
		    <td><b>Gross : </b></td>
		    <td><b>".$total."</b></td>
		</tr>
		</tr>
		</table>
		</td> 
		<td valign='top'><table width='100%' valign='top' style='border-collapse: collapse' border='1' cellspacing='5px' cellpadding='2px'>
		";
		
		foreach ($deduction as $key=>$val) {
			 
			$value = $results[$val];
			if($key != 'Zakat') {
				$totalDed += $value;
			}
			// $total += $value;
		    $output .= "<tr><td>".$key."</td>";
		    $output .= "<td>".$results[$val]."</td></tr>";
		}
		$output .= "<tr>
		<td><b>Tot Deduction</b></td>
		<td><b>".$totalDed."</b></td>
		</tr>"; 
		
		/*</table></td>
		</tr>
		<tr>
		<td>&nbsp;</td>
		<td><table width='100%' border='0' cellpadding='5px' cellspacing ='5px'>
		<tr>
		<td><b>Net Pay SDG : </b></td>
		<td align='left'><b>4443.56</b></td>
		</tr>*/ 
		$output .= "</table></td>
		</tr>
				<tr>
		<td colspan='2'><b>Net Pay :".($total - $totalDed)."</td>
		</tr>
		</table></center> <center>
	<br>
	<div id='printButton'>
	<input  type='button' value='Print' name='ok' onclick=\"printDoc('printButton', 'none')\">
	</div>
	</center>
				";
		
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