<?php 
namespace Payment\Model;

use Payment\Model\Company;
use Payment\Model\DateRange;

class BonusService extends Payment {  
    
    protected $paysheet = array(); 
    
    public function getBonusMapper() { 
    	return $this->service->get('bonusMapper'); 
    } 
    
    public function getNonPayDays($employeeId,$fromDate,$toDate) {
    	$service = $this->service->get('NonPaymentDaysService'); 
    	$days = $service->getEmployeePaysheetNonWorkingDays($employeeId,$fromDate,$toDate); 
    	return $days;
    }
	 
	public function calculate(Company $company) {  
	 	try { 
	 	    $this->transaction->beginTransaction(); 
	 	    $bonusMapper = $this->getBonusMapper(); 
		    
	 	    
		    $this->transaction->commit();  
		} catch(\Exception $e) { 
		 	$this->transaction->rollBack(); 
		 	throw $e; 
		} 
		// return $this->paysheet;   
	 } 
     	 
	 public function bonusReport($year,$companyId) {
	     //$results = $this->incrementMapper->incReport($year,$companyId);
	     $output = '<table  border="1" class="sortable" font-size="6px"
                   align="center" id="table1" width="100%" cellpadding="5px"
                   bordercolorlight="#C0C0C0" bordercolordark="#C0C0C0"
                   style="border-collapse: collapse">
        	        <thead >
            	        <tr>  	 	 	 	 	 	 	
                	        <th bgcolor="#F0F0F0">#</th>
                	        <th bgcolor="#F0F0F0">Employee Name</th>
                	        <th bgcolor="#F0F0F0">Salary Grade</th>
                	        <th bgcolor="#F0F0F0">Rating</th>
                	        <th bgcolor="#F0F0F0">No Of Months</th>
                	        <th bgcolor="#F0F0F0">No Of Days</th>
                	        <th bgcolor="#F0F0F0">Initial</th>
                	        <th bgcolor="#F0F0F0">Cola</th>
                	        <th bgcolor="#F0F0F0">Bonus</th>
                	        <th bgcolor="#F0F0F0">Tax</th>
                	        <th bgcolor="#F0F0F0">Net Due</th>
            	        </tr>
        	        </thead>
	        <tbody class="scrollingContent">';
	     $c = 1;
	     $gTot = 0;
	     $gTotInc = 0;
	    // foreach($results as $r) {
	    $r = array(); 
	         $oldInitial = 0;
	         $newInitial = 0;
	         $oldInitial = $r[''];
	         $newInitial = $r[''];
	         $gTot += $oldInitial;
	         $gTotInc += $newInitial;
	         $output .="<tr >
                	        <td><p align='center'>".$c++."</td>
                	        <td><p align='left'>".$r['']."</td>
                	        <td><p align='left'>".$r['']."</td>
                	        <td><p align='center'>".$r['']."</td>
                	        <td><p align='center'>".$r['']."</td>
                	        <td><p align='right'>".$r['']."</td>
                	        <td><p align='right'>".$r['']."</td>
                	        <td><p align='right'>".$r['']."</td>
                	        <td><p align='right'>".$oldInitial."</td>
                	        <td><p align='right'>".$newInitial."</td>
                	        <td><p align='right'>".$r['']."</td>
                	      </tr>";
	     //}
	     $output .= "</tbody><tfoot>
                	    <tr>
                            <td><p align='center'>&nbsp;</td>
                		    <td><p align='left'><b>Total</b></td>
                		    <td><p align='center'>&nbsp;</td>
                		    <td><p align='center'>&nbsp;</td>
                		    <td><p align='center'>&nbsp;</td>
                		    <td><p align='center'>&nbsp;</td>
                		    <td><p align='center'>&nbsp;</td>
                		    <td><p align='center'>&nbsp;</td>
                		    <td><p align='right'><b>".$gTot."</b></td>
                		    <td><p align='right'><b>".$gTotInc."</b></td>
                		    <td><p align='center'>&nbsp;</td>
                	    </tr>
                	</tfoot>
                	</table>";
	     return $output;
	 } 
     
} 