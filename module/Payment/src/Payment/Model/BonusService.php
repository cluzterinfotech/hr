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
    
    private function bonusLeaveDed($bonus,$months,$nonPayDays,$elegibleDays) { 
        $BonusPerDay = 0;  
        $actual = 0 ;  
        $BonusPerDay = ((($bonus/12) * $months)/365);   
        $actual = $BonusPerDay * ($elegibleDays - $nonPayDays);    
        return $actual;  
    } 
	 
	public function calculate(Company $company) {   
	 	try { 
	 	    $this->transaction->beginTransaction(); 
	 	    $bonusMapper = $this->getBonusMapper(); 
	 	    $year = date('Y'); 
	 	    $companyId = $company->getId(); 
	 	    
	 	    if($bonusMapper->isHaveBonus($year,$companyId)) {
	 	        return 0;     
	 	    }
	 	    
	 	    $bonusMapper->deletePreviousBonus($year,$companyId);
	 	    
	 	    $criteria = $bonusMapper->getCriteria($year,$companyId);  
	 	    
	 	    $from = $criteria['joinDate']; 
	 	    $to = $criteria['confirmationDate']; 
	 	    
	 	    $bonusFrom = $criteria['joinDate']; 
	 	    
	 	    $ratingOne = (float)$criteria['ratingOne']; 
	 	    $ratingTwo = (float)$criteria['ratingTwo']; 
	 	    $rh = (float)$criteria['ratingH3']; 
	 	    $rs = (float)$criteria['ratingS3']; 
	 	    $rm = (float)$criteria['ratingM3']; 
	 	    $rf = (float)$criteria['ratingFour']; 
	 	    
	 	    
	 	    $dateMethods = $this->service->get('dateMethods'); 
	 	    $type = $criteria['bonusType']; 
	 	    $dateRange = $this->service->get('dateRange'); 
	 	    
	 	    $service = $this->service->get('Initial');
	 	    $colaService = $this->service->get('ColaSalaryGrade');
	 	    
	 	    $list = $bonusMapper->getBonusElegibleList($companyId,$from,$to);
	 	    
	 	    foreach($list as $r) {
	 	        $basic = 0; 
	 	        $initial = 0;
	 	        $cola = 0; 
	 	        $bonus = 0;
	 	        $tax = 0;
	 	        $net = 0; 
	 	        $percentage = 0; 
	 	        $months = 0;
	 	        $nonPayDays = 0;  
	 	        $elegibleDays = 0; 
	 	        $empRating = 0; 
	 	        //\Zend\Debug\Debug::dump($empRating);
	 	        $empId = $r['employeeNumber'];
	 	        $empjoinDate = $r['empJoinDate'];
	 	        $empRating = $this->getIncrementMapper()->getEmployeeRating($year,$empId); 
	 	        
	 	        if($empRating === '1') { 
	 	            $percentage = $ratingOne; 
	 	        } else if ($empRating === '2') {
	 	            $percentage = $ratingTwo; 
	 	        } else if($empRating === 'h3') {
	 	            $percentage = $rh;
	 	        } else if($empRating === 's3') {
	 	            $percentage = $rs;
	 	        } else if($empRating === 'm3') {
	 	            $percentage = $rm;
	 	        } else if($empRating === '4') { 
	 	            $percentage = $rf;
	 	        } else {
	 	            $percentage = 0;
	 	        } 
                
	 	        $startingDate = ($year-1).'-01-01';  
	 	        $months = $dateMethods->numberOfMonthsBetween($empjoinDate,$to);
	 	        if($months >= 12) {
	 	            $months = 12; 
	 	            $elegibleDays = 365; 
	 	        } else { 
	 	            $startingDate = $empjoinDate;
	 	            $elegibleDays = $dateMethods->numberOfDaysBetween($startingDate,$to);   
	 	        } 
	 	        // 
	 	        $nonPayDays = $this->getNonPayDays($employeeId,$startingDate,$to);    
	 	        
	 	        //$percentage = 0; 
	 	        $employee = $this->getEmployeeById($empId); 
	 	        
	 	        //\Zend\Debug\Debug::dump($employee);
	 	        //exit; 
	 	        //$dateRange->setFromDate(); 
	 	        //$dateRange->setToDate(); 
	 	        $amount = $service->getLastAmount($employee,$dateRange);
	 	        //echo "here";
	 	        //exit;
	 	        $cola = $colaService->getLastAmount($employee,$dateRange);
	 	        
	 	        $initial = $this->twoDigit($amount); 
	 	        $cola =  $this->twoDigit($cola);  
                
	 	        if($type == 1) {  
	 	            $bonus = ($initial + $cola) * $percentage;  
	 	        } elseif($type == 2) {  
	 	            $bonus = (($initial + $cola) * 12) * ($percentage/100);   
	 	        } else {  
	 	            $bonus = 0;  
	 	        }  
                
	 	        $bonus = $this->bonusLeaveDed($bonus,$months,$nonPayDays,$elegibleDays);   
	 	        
	 	        $tax = $bonus * .1;  
	 	        $net = $bonus - $tax;   
	 	        
	 	        $sg = $r['empSalaryGrade']; 
    	 	    $bonus = array(
    	 	        'Pmnt_Emp_Mst_Id'    => $empId,
    	 	        'Bonus_Date'         => date('Y-m-d'),
    	 	        'Bonus_year'         => '2018',
    	 	        'Bonus_Func_Code'    => 0,
    	 	        'Bonus_Dept_Id'      => 0,
    	 	        'Bonus_Bnk_Id'       => $r['empBank'],
    	 	        'Bonus_Acct_No'      => $r['accountNumber'], 
    	 	        'Emp_Rating'         => $empRating,
    	 	        'Bonus_Percentage'   => $percentage,
    	 	        'Initial'            => $initial,
    	 	        'Cola'               => $cola,
    	 	        'No_Of_Months'       => $months,
    	 	        'Bonus_Amt'          => $bonus, 
    	 	        'Bonus_Tax'          => $tax,
    	 	        'Bonus_Net'          => $net,
    	 	        'Bonus_Closed'       => 0,
    	 	        'numberOfDays'       => $elegibleDays,
    	 	        'companyId'          => $companyId,
    	 	        'salaryGradeId'      => $sg,
    	 	    ); 
    	 	    $bonusMapper->insert($bonus); 
	 	    }
	 	    //exit; 
		    $this->transaction->commit();  
		} catch(\Exception $e) { 
		 	$this->transaction->rollBack(); 
		 	throw $e; 
		} 
		// return $this->paysheet;   
		return 1; 
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
                            <th bgcolor="#F0F0F0">Percentage</th>
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
                            <td><p align='center'>".$r['Bonus_Percentage']."</td>
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