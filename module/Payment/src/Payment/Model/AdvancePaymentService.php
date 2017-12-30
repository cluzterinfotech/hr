<?php 

namespace Payment\Model; 

use Payment\Model\AdvancePaymentMapper; 
use Payment\Model\DateMethods; 
//use Application\Persistence\TransactionDatabase; 
//use Payment\Model\Payment;

class AdvancePaymentService extends Payment { 
	
	protected $service; 
	protected $advancePaymentMapper;
	//private $transactionDatabase;
	//private $dateMethods;
	protected $checkListService;
	
	protected $advancePayments = array( 
	    'AdvanceHousing' => 'AdvanceHousing',
		'AdvanceSalary'  => 'AdvanceSalary',
		'PersonalLoan'   => 'PersonalLoan', 
	); 
	
	public function __construct(AdvancePaymentMapper $advancePaymentMapper,
			ReferenceParameter $reference) { 
		parent::__construct($reference); 
		//$this->service = $sm; 
		$this->advancePaymentMapper = $advancePaymentMapper; 
		// $this->transactionDatabase = $transactionDatabase;  
		// $this->dateMethods = $dateMethods; 
	}
	
	public function selectAdvanceHousing() {
		return $this->advancePaymentMapper->selectAdvanceHousing();
	}
	
	public function selectRepayment() {
	    return $this->advancePaymentMapper->selectRepayment();
	}
	
	public function selectAdvanceSalary() {
		return $this->advancePaymentMapper->selectAdvanceSalary();
	}
	
	public function selectPersonalLoan() {
		return $this->advancePaymentMapper->selectPersonalLoan();
	}
	
	public function selectSpecialLoan() {
	    return $this->advancePaymentMapper->selectSpecialLoan(); 
	}
	
	public function selectSpecialLoanDue() {
	    return $this->advancePaymentMapper->selectSpecialLoanDue();
	}
	
	public function getSpecialLoanDueAmount($employeeId) {
	    return $this->advancePaymentMapper->getSpecialLoanDueAmount($employeeId);
	} 
	
	public function isHaveAdvanceHousingRecords() {
		return $this->advancePaymentMapper->isHaveAdvanceHousingRecords();
	} 
	
	public function isHaveRepaymentRecords() {
	    return $this->advancePaymentMapper->isHaveRepaymentRecords();
	}
	
	public function isHaveAdvanceSalaryRecords() {
		return $this->advancePaymentMapper->isHaveAdvanceSalaryRecords();
	}
	
	public function isHavePersonalLoanRecords() {
		return $this->advancePaymentMapper->isHavePersonalLoanRecords();
	}
	
	public function getAdvanceHousing($employee,$dateRange) {
		return $this->advancePaymentMapper->getAdvanceHousing($employee,$dateRange);  
	}
	
	public function closeAdvanceHousing($routeInfo) { 
		try {
			$this->transaction->beginTransaction();
			if($this->isHaveAdvanceHousingRecords()) {
			    $this->closeList($routeInfo);     	
			} else {
				return 'No records found to close,please add';
			}
			//$res = $this->closeList($routeInfo);
			$this->transaction->commit();
			return 'Advance Housing Applied Successfully';
		} catch(\Exception $e) { 
			throw $e;
			$this->transaction->rollBack();
		}   
	}
	
	public function closeRepayment() {
	    try {
	        $this->transaction->beginTransaction();
	        $res = $this->advancePaymentMapper->getRepaymentRecords(); 
	        foreach($res as $r) {
	            $this->advancePaymentMapper
	                 ->closeAdvPaymentDue($r['advanceType'],$r['employeeId'],$r['monthsPaying']);
	            $this->advancePaymentMapper
	                 ->closeRepaymentRec($r['id']);
	        } 
	        $this->transaction->commit(); 
	    } catch(\Exception $e) {  
	        $this->transaction->rollBack(); 
	        throw $e; 
	    } 
	}
	
	public function closeAdvanceSalary($routeInfo) {
		try {
			$this->transaction->beginTransaction(); 
			if($this->isHaveAdvanceSalaryRecords()) { 
				$this->closeAdvanceSalaryList($routeInfo); 
			} else {
				return 'No records found to close,please add'; 
			} 
			//$res = $this->closeList($routeInfo); 
			$this->transaction->commit(); 
			return 'Advance Salary Applied Successfully'; 
		} catch(\Exception $e) { 
			throw $e; 
			$this->transaction->rollBack(); 
		} 
	    
	} 
	
	public function closePersonalLoan($routeInfo) {
		try {
			$this->transaction->beginTransaction();
			if($this->isHavePersonalLoanRecords()) { 
				$this->closePersonalLoanList($routeInfo);
			} else {
				return 'No records found to close,please add';
			} 
			$this->transaction->commit();
			return 'Personal Loan Applied Successfully'; 
		} catch(\Exception $e) {
			throw $e;
			$this->transaction->rollBack(); 
		} 
	
	} 
	
	
	public function closeList($routeInfo) { 
		// @todo close 
			$advhousingList = $this->advancePaymentMapper->getAdvanceHousingList();
			//\Zend\Debug\Debug::dump($advhousingList); 
			//exit; 
			foreach ($advhousingList as $advHousing) { 
				//\Zend\Debug\Debug::dump($advHousing);
				$advId = $advHousing['id'];
				$employeeId = $advHousing['employeeId'];  
				$fromDate = $advHousing['advanceFromDate']; 
				$totalMonths = $advHousing['totalMonths'];
				$amount = $advHousing['advanceAmount']; 
				$due = $amount/$totalMonths; 
				$mstData = array(
					'employeeId'       => $employeeId, 
					'deuStartingDate'  => $fromDate, 
					'amount'           => $amount, 
					'dueValue'         => $due,
					'taxAmount'        => $advHousing['taxAmount'],
					'netAmount'        => $advHousing['netAmount'],
					'ahGroup'          => $advHousing['groupId'],
					'numberOfMonths'   => $totalMonths,
					'entryDate'	       => date("Y-m-d"), 
				);  
				$id = $this->advancePaymentMapper->insertAdvanceHousingMst($mstData); 
				//\Zend\Debug\Debug::dump($mstData); 
				//\Zend\Debug\Debug::dump($id); 
				$i = 0; 
				for($i=1;$i<=$totalMonths;$i++) { 
					$dtlsData = array(
					    'mstId'                  => $id,
						'dueAmount'              => $due,
						'paidStatus'             => 0,
						'dueCurrentCalcStatus'   => 0, 	
					); 
					//\Zend\Debug\Debug::dump($dtlsData);
				    $this->advancePaymentMapper->insertAdvanceHousingDtls($dtlsData);	
				}
				$close = array('id' => $advId,'isClosed' => 1); 
				$this->advancePaymentMapper->update($close); 
			} 
		    $checkListService = $this->service->get('checkListService'); 
		    $checkListService->closeLog($routeInfo); 
		    
	}
	
	public function getDueAmount($employee,$dateRange) {
		$amount = 0;
		return $amount;
	}
	
	public function getadvancehousingdetails($employeeNumber,$noOfMonths) { 
		if(!$noOfMonths) { 
			$noOfMonths = 1; 
		} 
		$employeeService = $this->service->get('CompanyEmployeeMapper');
		$employee = $employeeService->fetchEmployeeByNumber($employeeNumber);
		$housingService = $this->service->get('housing');
		$dateRange = $this->service->get('dateRange');
		$housingAmount = $housingService->getAmount($employee,$dateRange);
		
		$taxService = $this->service->get('taxService');
		$taxPercentage = $taxService->getTaxPercentage($housingService->getTableName(),$dateRange);
		
		$amount = $housingAmount * $noOfMonths; 
		$tax = $taxPercentage * $amount; 
		$net = $amount - $tax; 
		
		$housingInfo = array(
				'amount'         => $amount,
				'tax'            => $tax,
				'net'            => $net,
		); 
		return $housingInfo; 
	}
	
	public function getrepaymentdetails($employeeNumber,$advType) {
	    return $this->advancePaymentMapper->getSumEmpAdvPaymentDue($advType,$employeeNumber);
	    /*if(!$noOfMonths) {
	        $noOfMonths = 1;
	    }
	    $employeeService = $this->service->get('CompanyEmployeeMapper');
	    $employee = $employeeService->fetchEmployeeByNumber($employeeNumber);
	    $housingService = $this->service->get('housing');
	    $dateRange = $this->service->get('dateRange');
	    $housingAmount = $housingService->getAmount($employee,$dateRange);
	    $taxService = $this->service->get('taxService');
	    $taxPercentage = $taxService->getTaxPercentage($housingService->getTableName(),$dateRange);
	    
	    $amount = $housingAmount * $noOfMonths;
	    $tax = $taxPercentage * $amount;
	    $net = $amount - $tax;
	    
	    $housingInfo = array(
	        'amount'         => $amount,
	        'tax'            => $tax,
	        'net'            => $net,
	    );
	    return $housingInfo;*/
	}
	
	public function saveAdvanceHousing($formValues,$routeInfo) {
		try {
			$this->transaction->beginTransaction();
			$data = array(
					'employeeId'       => $formValues['employeeNumberHousing'],
					'paidDate'         => date('Y-m-d'),
					'advanceFromDate'  => $formValues['advanceHousingFromDate'],
					//'advanceToDate'    =>
					'totalMonths'      => $formValues['numberOfMonthsHousing'],
					'advanceAmount'    => $formValues['housingAmount'],
					'taxAmount'        => $formValues['housingTax'],
					'netAmount'        => $formValues['housingNetAmount'],
					'isClosed'         => 0,
					// 'groupId'         =>
			); 
			$this->advancePaymentMapper->insertAdvanceHousing($data); 
			$this->getCheckListService()->checkListlog($routeInfo); 
			$this->transaction->commit(); 
		} catch (\Exception $e) { 
			$this->transaction->rollBack(); 
			throw $e;  
		} 
	} 
	
	public function saveRepayment($formValues,$routeInfo) {
	    try {
	        $this->transaction->beginTransaction();
	        $data = array(
	            'employeeId'     => $formValues['employeeIdRepayment'],
	            'advanceType'    => $formValues['advanceType'],
	            'monthsPending'  => $formValues['monthsPending'],
	            'monthsPaying'   => $formValues['monthsPaying'],
	            'amountPending'  => $formValues['amountPending'],
	            'amountPaying'   => $formValues['amountPaying'],
	            'notes'          => $formValues['notes'],
	            'isClosed'       => 0,
	        );
	        $this->advancePaymentMapper->insertRepayment($data);
	        $this->getCheckListService()->checkListlog($routeInfo);
	        $this->transaction->commit();
	    } catch (\Exception $e) {
	        $this->transaction->rollBack();
	        throw $e;
	    }
	} 
	
	public function savePersonalLoan($formValues,$routeInfo) {
		try {
			$this->transaction->beginTransaction();
			$data = array(
					'employeeNumberPersonalLoan'   => $formValues['employeeNumberPersonalLoan'],
					'loanDate'                     => $formValues['loanDate'],
					'loanAmount'                   => $formValues['loanAmount'],
					'numberOfMonthsLoanDue'        => $formValues['numberOfMonthsLoanDue'],
					'monthlyDue'                   => $formValues['monthlyDue'],
					'paidDate'                     => date('Y-m-d')
			);
			$this->advancePaymentMapper->insertPersonalLoan($data);
			$this->getCheckListService()->checkListlog($routeInfo);
			$this->transaction->commit();
		} catch (\Exception $e) {
			$this->transaction->rollBack();
			throw $e;
		}
	}
	
	public function saveSpecialLoan($formValues,$routeInfo) {
	    try {
	        $this->transaction->beginTransaction();
	        $data = array(
	            'employeeNumberSpecialLoan'   => $formValues['employeeNumberSpecialLoan'],
	            'loanDate'                    => $formValues['loanDate'],
	            'splLoanAmount'               => $formValues['splLoanAmount'],
	            'numberOfMonthsSplLoanDue'    => $formValues['numberOfMonthsSplLoanDue'],
	            'monthlyDue'                  => $formValues['monthlyDue'],
	            'paidDate'                    => date('Y-m-d')
	        );
	        $this->advancePaymentMapper->insertSpecialLoan($data); 
	        $this->getCheckListService()->checkListlog($routeInfo);
	        $this->transaction->commit();
	    } catch (\Exception $e) {
	        $this->transaction->rollBack();
	        throw $e;
	    }
	} 
	
	public function saveAdvanceSalary($formValues,$routeInfo) {
		try {
			$this->transaction->beginTransaction();
			$data = array(
					'employeeNumberAdvSalary'   => $formValues['employeeNumberAdvSalary'],
					'advancePaidDate'           => date('Y-m-d'),
					'netPay'                    => $formValues['netPay'],
					'numberOfMonthsNetPay'      => $formValues['numberOfMonthsNetPay'],
					'advanceAmount'             => $formValues['advanceAmount'],
					'numberOfMonthsDue'         => $formValues['numberOfMonthsDue'],
					'monthlyDue'                => $formValues['monthlyDue'], 
			);
			$this->advancePaymentMapper->insertAdvanceSalary($data); 
			$this->getCheckListService()->checkListlog($routeInfo); 
			$this->transaction->commit();
		} catch (\Exception $e) {
			$this->transaction->rollBack();
			throw $e;
		}
	}
	
	public function removeAdvanceHousing($id,$routeInfo) {
	    	
		try {
			$this->transaction->beginTransaction(); 
			$this->advancePaymentMapper->removeAdvanceHousing($id); 
			$this->getCheckListService()->removeLog($routeInfo);
			$this->transaction->commit();
		} catch (\Exception $e) {
		    $this->transaction->rollBack();
		    throw $e; 
		} 
	} 
	
	public function removeRepayment($id,$routeInfo) {
	    try {
	        $this->transaction->beginTransaction();
	        $this->advancePaymentMapper->removeRepayment($id);
	        $this->getCheckListService()->removeLog($routeInfo);
	        $this->transaction->commit();
	    } catch (\Exception $e) {
	        $this->transaction->rollBack();
	        throw $e;
	    }
	} 
	
	public function removeAdvanceSalary($id,$routeInfo) {
	
		try {
			$this->transaction->beginTransaction();
			$this->advancePaymentMapper->removeAdvanceSalary($id);
			$this->getCheckListService()->removeLog($routeInfo);
			$this->transaction->commit();
		} catch (\Exception $e) {
			$this->transaction->rollBack();
			throw $e;
		}
	}
	
	public function removePersonalLoan($id,$routeInfo) {
	
		try {
			$this->transaction->beginTransaction();
			$this->advancePaymentMapper->removePersonalLoan($id); 
			$this->getCheckListService()->removeLog($routeInfo); 
			$this->transaction->commit();
		} catch (\Exception $e) {
			$this->transaction->rollBack();
			throw $e;
		}
	}
	
	public function removeSpecialLoan($id,$routeInfo) { 
	    try {
	        $this->transaction->beginTransaction();
	        $this->advancePaymentMapper->removeSpecialLoan($id);
	        $this->getCheckListService()->removeLog($routeInfo);
	        $this->transaction->commit();
	    } catch (\Exception $e) {
	        $this->transaction->rollBack();
	        throw $e;
	    }
	}
	
	public function getCheckListService() { 
		return $this->service->get('checkListService');
	} 
	
    public function getThisMonthEmpAdvPaymentDue($advancePayment,
    		$employeeId,DateRange $dateRange) { 	
    	return $this->advancePaymentMapper 
    	            ->getThisMonthEmpAdvPaymentDue($advancePayment,$employeeId,$dateRange);    	
    }   
    
    public function addThisMonthDue($advancePaymentService, 
    		$dueId,$companyId,DateRange $dateRange) { 
    	$due = array( 
			'dtlsId'                 => $dueId,
			'companyId'              => $companyId,
			'advancePaymentTable'    => $advancePaymentService 
    	); 
    	$this->advancePaymentMapper->addThisMonthDue($due);    
    } 
    
    public function removeThisMonthDue(Company $company) {
    	return $this->advancePaymentMapper->removeThisMonthDue($company);
    }
    // closeAdvancePaymentDeduction 
    public function closeAdvancePaymentDeduction(Company $company) {  
    	$advanceList = $this->advancePaymentMapper->getThisMonthDueList($company);   
    	foreach ($advanceList as $lst) { 
    		$bufferId = $lst['id'];  
    		$dtlsId = $lst['dtlsId'];   	
    		$advTable = $lst['advancePaymentTable'];  
    	    $this->advancePaymentMapper->closeAdvancePaymentDeduction($dtlsId,$advTable); 
    	    $this->advancePaymentMapper->removeFromBuffer($bufferId); 
    	}  
    } 
    
    public function closePersonalLoanList($routeInfo) { 
    	// @todo close
    	$loanList = $this->advancePaymentMapper->getPersonalLoanList();  
    	//\Zend\Debug\Debug::dump($loanList);
    	//exit;
    	foreach ($loanList as $personalLoan) {
    		//\Zend\Debug\Debug::dump($advHousing);
    		$advId = $personalLoan['id'];
    		$employeeId = $personalLoan['employeeNumberPersonalLoan'];
    		$fromDate = $personalLoan['loanDate'];
    		$totalMonths = $personalLoan['numberOfMonthsLoanDue'];
    		$amount = $personalLoan['loanAmount'];
    		$due = $amount/$totalMonths;
    		$mstData = array(    				
    			'loanDate'         => $fromDate,
    			'employeeId'       => $employeeId,
    			'lkpLoanType'      => '1',
    			'loanAmount'       => $amount,
    			'dueValue'         => $due,
    			'noOfMonths'       => $totalMonths,
    			'paidMonths'       => '0',
    			'deuStartingDate'  => $fromDate, 
    		);   
    		$id = $this->advancePaymentMapper->insertPersonalLoanMst($mstData);
    		//\Zend\Debug\Debug::dump($mstData); 
    		//\Zend\Debug\Debug::dump($id); 
    		//exit; 
    		$i = 0; 
    		for($i=1;$i<=$totalMonths;$i++) { 
    			$dtlsData = array(
    				'mstId'                  => $id,
    				'dueAmount'              => $due,
    				'paidStatus'             => 0,
    				'dueCurrentCalcStatus'   => 0,
    			); 
    			//\Zend\Debug\Debug::dump($dtlsData);
    			$this->advancePaymentMapper->insertPersonalLoanDtls($dtlsData);
    		} 
    		$this->advancePaymentMapper->removePersonalLoan($advId); 
    		// applicable for adv housing 
    		//$close = array('id' => $advId,'isClosed' => 1);
    		//$this->advancePaymentMapper->update($close);
    	} 
    	$checkListService = $this->service->get('checkListService');
    	$checkListService->closeLog($routeInfo); 
    } 
    
    public function closeSpecialLoanList($routeInfo) {
        // @todo close
        $loanList = $this->advancePaymentMapper->getSpecialLoanList();
        //\Zend\Debug\Debug::dump($loanList);
        //exit; 
        foreach ($loanList as $specialLoan) {
            //\Zend\Debug\Debug::dump($advHousing);
            $advId = $specialLoan['id'];
            $employeeId = $specialLoan['employeeNumberSpecialLoan'];
            $fromDate = $specialLoan['loanDate'];
            $totalMonths = $specialLoan['numberOfMonthsSplLoanDue'];
            $amount = $specialLoan['splLoanAmount'];
            $due = $amount/$totalMonths;
            $mstData = array(
                'loanDate'         => $fromDate,
                'employeeId'       => $employeeId,
                'lkpLoanType'      => '1',
                'loanAmount'       => $amount,
                'dueValue'         => $due,
                'noOfMonths'       => $totalMonths,
                'paidMonths'       => '0',
                'deuStartingDate'  => $fromDate,
            );
            $id = $this->advancePaymentMapper->insertSpecialLoanMst($mstData); 
            //\Zend\Debug\Debug::dump($mstData);
            //\Zend\Debug\Debug::dump($id);
            //exit;
            $i = 0;
            for($i=1;$i<=$totalMonths;$i++) {
                $dtlsData = array(
                    'mstId'                  => $id,
                    'dueAmount'              => $due,
                    'paidStatus'             => 0,
                    'dueCurrentCalcStatus'   => 0,
                );
                //\Zend\Debug\Debug::dump($dtlsData);
                $this->advancePaymentMapper->insertSpecialLoanDtls($dtlsData);
            }
            $this->advancePaymentMapper->removeSpecialLoan($advId);
            // applicable for adv housing
            //$close = array('id' => $advId,'isClosed' => 1);
            //$this->advancePaymentMapper->update($close);
        }
        $checkListService = $this->service->get('checkListService');
        $checkListService->closeLog($routeInfo);
    } 
    
    
    public function closeAdvanceSalaryList($routeInfo) {
    	// @todo close
    	$advSalaryList = $this->advancePaymentMapper->getAdvanceSalaryList();
    	//\Zend\Debug\Debug::dump($advhousingList);
    	//exit;
    	foreach ($advSalaryList as $advSalary) {
    		//\Zend\Debug\Debug::dump($advHousing);
    		$advId = $advSalary['id'];
    		$employeeId = $advSalary['employeeNumberAdvSalary'];
    		$fromDate = $advSalary['advancePaidDate'];
    		$totalMonths = $advSalary['numberOfMonthsDue'];
    		$amount = $advSalary['advanceAmount']; 
    		
    		$due = $amount/$totalMonths;
    		$mstData = array(
    				'entryDate'       => $fromDate,
    				'employeeId'      => $employeeId,
    				'amount'          => $amount,
    				'dueValue'        => $due,
    				'numberOfMonths'  => $totalMonths,
    				'paidMonths'      => '0', 
    		);
    		$id = $this->advancePaymentMapper->insertAdvanceSalaryMst($mstData); 
    		$i = 0;
    		for($i=1;$i<=$totalMonths;$i++) {
    			$dtlsData = array(
    					'mstId'                  => $id,
    					'dueAmount'              => $due,
    					'paidStatus'             => 0,
    					'dueCurrentCalcStatus'   => 0,
    			); 
    			$this->advancePaymentMapper->insertAdvanceSalaryDtls($dtlsData);
    		}
    		//$close = array('id' => $advId,'isClosed' => 1);
    		//$this->advancePaymentMapper->update($close);
    		$this->advancePaymentMapper->removeAdvanceSalary($advId); 
    	}
    	$checkListService = $this->service->get('checkListService');
    	$checkListService->closeLog($routeInfo);
    
    } 
    
    
    // Final Entitlement
    
    public function getFeAdvSal(Employee $employee) {
    	// @todo 
    	$employeeId = $employee->getEmployeeNumber(); 
        return $this->advancePaymentMapper
        ->getTotalEmpAdvPaymentDue($this->advancePayments['AdvanceSalary'],$employeeId); 	
    }
    
    public function getFeAdvHousing(Employee $employee) {
        $employeeId = $employee->getEmployeeNumber(); 
        return $this->advancePaymentMapper
                    ->getTotalEmpAdvPaymentDue($this->advancePayments['AdvanceHousing'],$employeeId);
    }
    
    public function getFePersonalLoan(Employee $employee) {
    	$employeeId = $employee->getEmployeeNumber(); 
        return $this->advancePaymentMapper
                   ->getTotalEmpAdvPaymentDue($this->advancePayments['PersonalLoan'],$employeeId); 
    }
    
    public function getFeSpecialLoan(Employee $employee) {
        $employeeId = $employee->getEmployeeNumber();
        return $this->advancePaymentMapper
                    ->getTotalEmpAdvPaymentDue('SpecialLoan',$employeeId);
    } 
    
    public function getFeCarLoanAmortization(Employee $employee,$relievingDate) {
        $employeeId = $employee->getEmployeeNumber();
        $row = $this->advancePaymentMapper
                    ->getFeCarLoanAmortization('CarAmortization',$employeeId); 
        if($row) {
            $paidDate = $row['paidDate']; 
            $paidAmount = $row['paidAmount']; 
            $months = $row['numberOfMonths']; 
            $numberOfMonthsServed = $this->dateMethods->numberOfMonthsBetween($paidDate,$relievingDate); 
            
            if($numberOfMonthsServed >=  $months) {
                return 0; 
            } else {
                $diffMonths = $months - $numberOfMonthsServed; 
                $amount = ($paidAmount/$months); 
                //return ($amount * $diffMonths); 
                return number_format(($amount * $diffMonths),2,'.','');   
            } 
        }
        return 0;  
    }
    
    // @todo add phone , over payment 
    public function getFeOverPayment(Employee $employee) {
        $employeeId = $employee->getEmployeeNumber();
        return $this->advancePaymentMapper
                    ->getTotalEmpAdvPaymentDue('OverPayment',$employeeId); 
    } 
    
    public function getFePhoneDed(Employee $employee) {
        $employeeId = $employee->getEmployeeNumber();
        return $this->advancePaymentMapper
                    ->getTotalEmpAdvPaymentDue('PhoneDeduction',$employeeId); 
    } 
}