<?php 
namespace Payment\Model;

use Payment\Model\Company;
use Payment\Model\DateRange;

class BonusService extends Payment {  
    
    protected $paysheet = array(); 
    
    public function getBonusMapper() { 
    	return $this->service->get('bonusMapper'); 
    } 
    
    public function getIncrementMapper() {
        return $this->service->get('incrementMapper');
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
	 	    $year = date('Y-m-d'); 
	 	    $companyId = $company->getId(); 
	 	    $criteria = $bonusMapper->getCriteria($year,$companyId);  
	 	    $empRating = $this->getIncrementMapper()->getEmployeeRating($year,$employeeId); 
	 	    $type = $criteria['bonusType']; 
	 	    
	 	    $service = $this->service->get('Initial');
	 	    $colaService = $this->service->get('Cola');
	 	    
	 	    $list = $bonusMapper->getBonusElegibleList($companyId);
	 	    
	 	    foreach($list as $r) {
	 	        
	 	        $empId = $r['employeeNumber'];
	 	        $employee = $this->getEmployeeById($empId); 
	 	        $amount = $service->getLastAmount($employee,$dateRange);
	 	        $cola = $colaService->getLastAmount($employee,$dateRange);
	 	        $initial = $this->twoDigit($amount);
	 	        $cola =  $this->twoDigit($cola); 
	 	        
	 	        if($type == 1) {
	 	            $months = $criteria[''];
	 	        } elseif($type == 2) {
	 	            
	 	        } else {
	 	            
	 	        } 
	 	        
	 	        $sg = $r['empSalaryGrade']; 
    	 	    $bonus = array(
    	 	        'Pmnt_Emp_Mst_Id'    => $empId,
    	 	        'Bonus_Date'         => date('Y-m-d'),
    	 	        'Bonus_year'         => '2018',
    	 	        'Bonus_Func_Code'    => 0,
    	 	        'Bonus_Dept_Id'      => 0,
    	 	        'Bonus_Bnk_Id'       => 0,
    	 	        'Bonus_Acct_No'      => 0,
    	 	        'Emp_Rating'         => $empRating,
    	 	        'Bonus_Percentage'   => 0,
    	 	        'Initial'            => 0,
    	 	        'Cola'               => 0,
    	 	        'No_Of_Months'       => 0,
    	 	        'Bonus_Amt'          => 0,
    	 	        'Bonus_Tax'          => 0,
    	 	        'Bonus_Net'          => 0,
    	 	        'Bonus_Closed'       => 0,
    	 	        'numberOfDays'       => 0,
    	 	        'companyId'          => $companyId,
    	 	        'salaryGradeId'      => $sg,
    	 	    ); 
    	 	    $bonusMapper->insert($bonus); 
	 	    }
		    $this->transaction->commit();  
		} catch(\Exception $e) { 
		 	$this->transaction->rollBack(); 
		 	throw $e; 
		} 
		// return $this->paysheet;   
	 } 
     	 
	 public function bonusReport($year,$companyId) {
	     $results = $this->getBonusMapper()->bonusReport($year,$companyId); 
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
	     $gNet = 0; 
	     foreach($results as $r) {
	         $bonus = 0;
	         $tax = 0;
	         $net = 0; 
	         $bonus = $r['Bonus_Amt'];
	         $tax = $r['Bonus_Tax'];
	         $net = $r['Bonus_Net'];
	         $gTot += $bonus;
	         $gTotInc += $tax;
	         $gNet += $net; 
	         $output .="<tr >
                	        <td><p align='center'>".$c++."</td>
                	        <td><p align='left'>".$r['employeeName']."</td>
                	        <td><p align='left'>".$r['salaryGrade']."</td>
                	        <td><p align='center'>".$r['Emp_Rating']."</td>
                	        <td><p align='center'>".$r['No_Of_Months']."</td>
                	        <td><p align='right'>".$r['numberOfDays']."</td>
                	        <td><p align='right'>".$r['Initial']."</td>
                	        <td><p align='right'>".$r['Cola']."</td> 
                	        <td><p align='right'>".$bonus."</td>
                	        <td><p align='right'>".$tax."</td> 
                            <td><p align='right'>".$net."</td>
                	      </tr>";
	     }
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
                            <td><p align='center'>".$gNet."</td>
                	    </tr>
                	</tfoot>
                	</table>"; 
	     return $output; 
	 } 
     
} 