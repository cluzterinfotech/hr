<?php

namespace Employee\Model;

use Payment\Model\Payment;
use Payment\Model\ReferenceParameter;
use Payment\Model\DateRange;
use Payment\Model\Company;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManager;

class PromotionService extends Payment implements EventManagerAwareInterface{
	
	protected $initialService;
	protected $companyService;
	protected $employeeService;
	protected $dateService;
	protected $promotionMapper;
	protected $salGradeValueService;
	protected $incrementService;
	protected $eventManager; 
	
    public function __construct(ReferenceParameter $reference) {
    	parent::__construct($reference); 
    	$this->initialService = $this->service->get('initial'); 
    	$this->companyService = $this->service->get('company'); 
    	$this->employeeService = $this->service->get('employeeService'); 
    	$this->dateService = $this->service->get('dateRange'); 
    	$this->promotionMapper = $this->service->get('promotionMapper'); 
    	$this->salGradeValueService = $this->service->get('salaryGradeValueService'); 
    	$this->incrementService = $this->service->get('incrementService');
    } 
    
	/*
	 * @todo 
	 * 1. Check weather employee is in current promotion batch or not
	 * 2. Check promotion for company and date combination
	 * 3. 
	 */
	public function addPromotionToBuffer($formValues) {
		//\Zend\Debug\Debug::dump($formValues);
		//exit; 
		$companyId = $this->companyService->getId(); 
		// @todo add promotion to buffer 
		try {
		    // begin transaction
			$promotionInfo = array ( 				
				'companyId'                => $companyId, 
				'employeeNumber'           => $formValues['employeeNumberPromo'],
				'promotionDate'            => date('Y-m-d'),
				'currentSalaryGrade'       => $formValues['oldSalaryGrade'],
				'promotedSalaryGrade'      => $formValues['promoSalaryGrade'],
				'Ten_Per_Next_Sg_Mid'      => $formValues['tenPercentage'],
				'Per_Of_Increment'         => $formValues['incrementPercentage'],
				'Max_Quartile'             => $formValues['maxQuartileOne'],
				'Difference'               => $formValues['difference'],
				'Toggle'                   => $formValues['togglePromoOption'],
				//'Promotion_Effective_From' => $formValues['promotedInitial'],
				'Current_Initial_Salary'   => $formValues['oldInitial'],
				'promotedInitialSalary'    => $formValues['promotedInitial'],
				'Closed'                   => 0, 
				 		
			);  
			$this->promotionMapper->insert($promotionInfo);
			// commit transaction 
		} catch(\Exception $e) {
			// rollback 
			throw $e; 
		}
	}
	
	public function applyPromotion($effectiveDate,Company $company) {
	    try {  
			// begin transaction 
			$this->transaction->beginTransaction(); 
			//\Zend\Debug\Debug::dump($company);
			//exit; 
			// get list
			$promotionList = $this->promotionMapper->getPromotionList($company);
			foreach($promotionList as $promotion) { 
				$id = $promotion["id"];
				$batchId = $promotion["batchId"];
				$companyId = $promotion["companyId"];
				$employeeNumber = $promotion["employeeNumber"];
			    $promotedSalaryGrade = $promotion["promotedSalaryGrade"];
				$Current_Initial_Salary = $promotion["Current_Initial_Salary"];
				$promotedInitialSalary = $promotion["promotedInitialSalary"];
				$Closed = $promotion["Closed"];
				
			    $formval = array (
			    		'newInitial'            => $promotedInitialSalary,
			    		'employeeNumberInitial' => $employeeNumber,
			    		'oldInitial'            => $Current_Initial_Salary, 
			    );
			    
			    $this->employeeService->saveEmployeeInitialBuffer($formval);
			    
			    $empMainId = $this->employeeService->getIdByEmployeeNumber($employeeNumber);
			    
			    $data = array(
			    		'id'             => $empMainId,
			    		'empSalaryGrade' => $promotedSalaryGrade
			    );
			    
			    $this->employeeService->updateExistingEmployeeInfoMain($data); 
			    // update employee salary grade  
			    // $this->employeeService-> 
			    
			    // exit; 
			    $this->employeeService->applyInitialAfterTransaction($company,$effectiveDate); 
				//\Zend\Debug\Debug::dump($allowanceName); 
				
			    // apply salary grade allowance 
			    $sgAllowanceService = $this->service->get('salaryGradeService');  
			    
			    $sgAllowanceService->addEmployeeSalaryGradeAllowance( 
				    $promotedSalaryGrade,$employeeNumber,$company,$effectiveDate);  
			    // exit; 
		        //\Zend\Debug\Debug::dump($allowanceId);  
		        //exit;  
		        
			    // add promotion to history 
			    $promotionInfo = array(
			        'id'   => $id,
				    'Closed' => 1,
			    );
			    $this->promotionMapper->update($promotionInfo);
                //exit;
			} 
			//echo "test";
			//exit;
			//commit 
	        $this->transaction->commit();   
	        
		} catch(\Exception $e) {
			// rollback 
            $this->transaction->rollBack(); 
            throw  $e;
            //exit;
            //throw new \Exception("Sorry! unable to apply employee promotion");   
	    } 
	}
	
	public function removeEmployeePromotion($id) {
		return $this->promotionMapper->removeEmployeePromotion($id);
	}
	
	public function updateSalaryGrade($employeeNumber,$effectiveDate,$newSalaryGrade) { 
		/* $this->getEventManager()->trigger(
				'updateSalaryGrade',null,array('employeePromotion' => $promotionDetails)
		); */ 
	}
	
	/*public function updateInitial($employeeNumber,$effectiveDate,$newInitial) { 
		$initialDetails = array(
				'effectiveDate' => $effectiveDate,
				'amount'        => $newInitial,
				'employeeId'    => $employeeNumber
		);
		
		$this->getEventManager()->trigger(
				'updateInitial',null,array('initialDetails' => $initialDetails)
		); 
	}*/
    
	
	//$this->dateService->setFromDate('2015-05-01');
	//$this->dateService->setToDate('2015-05-31');
	//\Zend\Debug\Debug::dump($this->dateService);
	//\Zend\Debug\Debug::dump($this->companyService);
	//exit; 
	
	public function selectPromotion() { 
		//$company = $this->companyService;
		return $this->promotionMapper->selectPromotion($this->companyService);
	}
	
	// always have to get latest initial!?
	protected function getInitial($employeeNumber,DateRange $dateRange) { 
		//echo "test ini";
		//exit; 
		// $initialService = $this->service->get('Initial'); 
		$employee = $this->getEmployeeById($employeeNumber);
		//\Zend\Debug\Debug::dump($employee);
		//\Zend\Debug\Debug::dump($dateRange);
		//exit; 
		// $employee = $employeeService->fetchEmployeeByNumber($employeeNumber); 
		return $this->initialService->getLastAmount($employee,$dateRange);
		// getEmployeeInitial
		            //->getAmount($employee,$dateRange); 
	}
    	
	protected function getSalaryGrade($employeeNumber,DateRange $dateRange) {
		$employeeService = $this->service->get('CompanyEmployeeMapper');
		return $employeeService->fetchEmployeeSalaryGrade($employeeNumber,$dateRange);
	} 
	
	protected function tenPercentageNextMid($salaryGrade,DateRange $dateRange) {
		// $salaryGradeValueService = $this->service->get('salaryGradeValueService');
		return $this->incrementService->tenPercentageNextMid($salaryGrade,$dateRange);
	}
	
	protected function maxQuartileOne($employeeNumber,DateRange $dateRange) {
		
		return $this->incrementService->maxQuartileOne($employeeNumber,$dateRange);
	}
	
	/* protected function getSalaryGradeByDate($employeeNumber,DateRange $dateRange) {
		
	} */
	
	// PromotionBuffer 
	public function getPromotionDetails($employeeNumber,$toggleOpt,DateRange $dateRange) {
		$salaryGrade = $this->getSalaryGrade($employeeNumber,$dateRange);
		$promotedGrade = $salaryGrade + 1;
		$oldInitial = $this->getInitial($employeeNumber,$dateRange);
		$tenPerNextMid = $this->tenPercentageNextMid($salaryGrade,$dateRange); 
		$maxQuartileOne = $this->maxQuartileOne($employeeNumber, $dateRange); 
		$promInitial = $tenPerNextMid + $oldInitial;
		$percentage =  $this->twoDigit(($promInitial / $oldInitial));  
		$diff = ($promInitial - $maxQuartileOne); 
		return array(
			'oldInitial'          => $this->twoDigit($oldInitial),
			'oldSalaryGrade'      => $this->getSalaryGrade($employeeNumber,$dateRange),
			'tenPercentage'       => $tenPerNextMid, 
			'maxQuartileOne'      => $maxQuartileOne, 
			//'difference'          => '100',  
			'promoSalaryGrade'    => $promotedGrade,
			'promotedInitial'     => $toggleOpt,
			'incrementPercentage' => $percentage,
		    'difference'          => $diff,
			'promotedInitial'     => $this->twoDigit($promInitial),
		); 
	} 
	
	public function getPromotionList() {
		$promotionList = $this->promotionMapper->getPromotionList($this->companyService); 
		$output .= "
		    <table class='sortable' cellspacing='0' bordercolor='#C0C0C0' style='border-collapse: collapse'  border='1' cellpadding='6px' align='center' width='100%'>
    	        <thead>
				    <tr>
   		               <th width='20%'><a href=# >Employee Name</a></th>
   		               <th width='20%'><a href=# >Promotion Date</a></th>
   		               <th width='20%'><a href=# >Current Salary</a></th>
   		               <th width='20%'><a href=# >Promoted SalaryGrade</a></th>
   		               <th width='20%'><a href=# >Actions</a></th>
				    </tr>
				</thead>
				<tbody>
				"; 
	    foreach ($promotionList as $list) {  
		    $output .= " <tr>
	    	                 <td width='20%'>".$list['employeeNumber']."</td>
	    	                 <td width='20%'>".$list['promotionDate']."</td>
	    	                 <td width='20%'>".$list['currentSalaryGrade']."</td>
	    	                 <td width='20%'>".$list['promotedSalaryGrade']."</td>
	    	                 <td width=20% >".$list['']."</td>
	    	             </tr>";
	    } 
	    $output .= " </tbody> 
	    	</table> 
	    "; 
		return $output; 
	}
	
	public function promotionReport($company,$values) { 
		$details = $this->promotionMapper->promotionReport($company,$values); 
		$i = 1; 
		$output = "
			  <table font-size='6px' id='table1' bordercolorlight='#C0C0C0' 
					bordercolordark='#C0C0C0' width='100%' cellpadding='5px' border='1' align='center'>
			    <thead>
			      <tr>
			        <th bgcolor='#F0F0F0'>#</th>
			        <th bgcolor='#F0F0F0'>Employee Name</th>
			        <th bgcolor='#F0F0F0'>Working For</th>
			        <th bgcolor='#F0F0F0'>Last Promotion Date</th>
			        <th bgcolor='#F0F0F0'>Promotion Eff Date</th>
			        <th bgcolor='#F0F0F0'>Old Salary Grade</th>
			        <th bgcolor='#F0F0F0'>Old Salary </th>
			        <th bgcolor='#F0F0F0'>New Salary Grade</th>
			        <th bgcolor='#F0F0F0'>New Salary </th>
			      </tr>
			    </thead>
			    <tbody>"; 
		    foreach ($details as $dtls) {
			     $output .= " <tr>
			        <td><p align='center'>".$i++."</p></td>
			        <td><p align='left'>".$dtls['employeeName']."</p></td>
			        <td><p align='center'>".$dtls['']."</p></td>
			        <td><p align='center'>".$dtls['promotionDt']."</p></td>
			        <td><p align='center'>".$dtls['promotionDt']."</p></td>
			        <td><p align='center'>".$dtls['currentSalaryGrade']."</p></td>
			        <td><p align='right'>".$dtls['Current_Initial_Salary']."</p></td>
			        <td><p align='right'>".$dtls['promotedSalaryGrade']."</p></td>
			        <td><p align='right'>".$dtls['promotedInitialSalary']."</p></td>
			      </tr>";
		    } 
			   $output .= "  </tbody>
			    <tfoot>
			      <tr>
			        <td><p align='center'> </p></td>
			        <td><p align='left'><strong>Total</strong></p></td>
			        <td><p align='center'> </p></td>
			        <td><p align='center'> </p></td>
			        <td><p align='center'> </p></td>
			        <td><p align='center'> </p></td>
			        <td><p align='right'>42,005.38</p></td>
			        <td><p align='right'> </p></td>
			        <td><p align='right'>47,023.38</p></td>
			      </tr>
			    </tfoot>
			  </table>";
		
		return $output; 
	}
	
	public function mismatchReport($company,$values) {  
		$details = $this->promotionMapper->mismatchReport($company,$values);
		$i = 1;
		$output = "
			  <table font-size='6px' id='table1' bordercolorlight='#C0C0C0'
					bordercolordark='#C0C0C0' width='100%' cellpadding='5px' border='1' align='center'>
			    <thead>
			      <tr>
			        <th bgcolor='#F0F0F0'>#</th>
			        <th bgcolor='#F0F0F0'>Employee Name</th>
				    <th bgcolor='#F0F0F0'>Department</th>
			        <th bgcolor='#F0F0F0'>Current Job Grade</th>
			        <th bgcolor='#F0F0F0'>Current Salary Grade</th> 
			      </tr>
			    </thead>
			    <tbody>";
		foreach ($details as $dtls) {
			$output .= " <tr>
			        <td><p align='center'>".$i++."</p></td>
			        <td><p align='left'>".$dtls['employeeName']."</p></td>
			        <td><p align='center'>".$dtls['departmentName']."</p></td>
			        <td><p align='center'>".$dtls['jobGrade']."</p></td>
			        <td><p align='center'>".$dtls['salaryGrade']."</p></td> 
			      </tr>";
		}
		$output .= "  </tbody>
			    <tfoot>
			      <tr>
			        <td><p align='center'> </p></td>
			        <td><p align='left'></p></td>
			        <td><p align='center'> </p></td>
			        <td><p align='center'> </p></td>
			        <td><p align='center'> </p></td> 
			      </tr>
			    </tfoot>
			  </table>";
	
		return $output;
	}
	
	public function getEventManager() {
		if($this->eventManager === null) {
			$this->eventManager = new EventManager(__CLASS__);
		}
		return $this->eventManager;
	}
	
	public function setEventManager(EventManagerInterface $eventManager) {
		$this->eventManager = $eventManager;
		return $this;
	}
}