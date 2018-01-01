<?php 

namespace Application\View\Helper;   

use Zend\View\Helper\AbstractHelper;   

class EmpBankReportHelper extends AbstractHelper { 
		
	public function __invoke($name,$alllowance,$deduction,
			$bankDetails,$results,$param) {
		$output = "";
		$total = 0;
		$cp = 1;
		$output .= "<table class='sortable' width='100%'><thead><tr>";
		//$output .= $this->prepare($name,$results); 
		$c = 1;
		foreach ($name as $key=>$val) {
			$output .= "<th  >Sno</th>";
			$output .= "<th  >".$key."</th>";
			$cp++; 
		}
		/*foreach ($alllowance as $key=>$val) {
			//$output .= "<th >".$key."</th>";
		}
		$output .= "<th>Gross</th>";
		foreach ($deduction as $key=>$val) {
			//$output .= "<th >".$key."</th>";
		}*/
		foreach ($bankDetails as $key=>$val) {
			$output .= "<th >".$key."</th>";
			$cp++;
		}
		$output .= "<th >Net</th>";
		$output .= "</thead></tr><tbody class='scrollingContent'>";
		$mainTot = 0; 
		
		foreach ($results as $result) {
			$output .= "<tr >";
			$total = 0;
			foreach ($name as $key=>$val) { 
				$output .= "<td>".$c++."</td>";
				$value = $result[$val];
				$output .= "<td>".$value."</td>";
				//$cp++; 
			}
			foreach ($alllowance as $key=>$val) {
				$value = $result[$val];
				$total += $value;
				//$output .= "<td>".$value."</td>";
			}
			//$output .= "<td>".$total."</td>";
			foreach ($deduction as $key=>$val) { 
				$value = $result[$val]; 
				if($key != 'Zakat') {  
				    $total -= $value; 
				}  
				//$output .= "<td>".$value."</td>";  
			}   
			foreach ($bankDetails as $key=>$val) { 
				$bankName = $result['bankName']; 
				$value = $result[$val];  
				$output .= "<td>".$value."</td>"; 
				//$cp++;
			} 
			$output .= "<td>".$total."</td></tr>"; 
			$mainTot += $total; 
		} 
		$output .= "<tr >
				
				<td colspan = ".$cp."><b>Total</b></td>
				
				<td><b>".$mainTot."</b></td>
				</tr>";
		$output .= "</tbody></table>"; 
		$time = mktime(0, 0, 0, $param['month']);
		$name = strftime("%B", $time);
		$bnkName = "<center><p>".$bankName."</p></center>"; 
		//\Zend\Debug\Debug::dump($param['month']); 
		$bnkName .= "<center><p>".$name."-".$param['year']."</p></center>";
		$bnkName .= $output; 
		return $bnkName;  
	}   
	
} 