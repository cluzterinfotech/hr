<?php 

namespace Payment\Controller; 

use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Payment\Model\Company;
use Payment\Model\DateRange;
use Payment\Model\Paysheet;
use Payment\Model\Person; 
use Application\Form\SubmitButonForm;
use Application\Form\FunctionBankMonthYear;
use Application\Form\EmployeeMonthYear; 
use Application\Form\PaysheetOtherMonthYear;
use Employee\Form\EmployeeAllowanceForm;
use Employee\Form\EmployeeForm;

class PaysheetController extends AbstractActionController
{
	public function indexAction()
	{   
		return new ViewModel();
	}
	
	public function calculateAction()
	{   
		$form = $this->getForm();
		$prg = $this->prg('/paysheet/calculate',true); 
		if ($prg instanceof Response ) { 
			return $prg; 
		} elseif ($prg === false) { 
			return array ('form' => $form); 
		} 
		$company = $this->getCompanyService(); 
		$form->setData($prg);
		$dateRange = $this->getDateService(); 
		//\Zend\Debug\Debug::dump($dateRange);
		//exit; 
		$paysheet = $this->getPaysheetService(); 
		$isAlreadyClosed = $paysheet->isPaysheetClosed($company,$dateRange);
		if($isAlreadyClosed) {
		    $this->flashMessenger()->setNamespace('info')
			     ->addMessage('Paysheet Already closed for current month'); 
		} else { 
			$employeeMapper = $this->getServiceLocator()->get('CompanyEmployeeMapper');
			$condition = array( 
					'isActive' => 1,
					'companyId' => $company->getId(),
					'isInPaysheet' => 1,
					//'employeeNumber' => 1007,
			);  
			
			$routeInfo = $this->getRouteInfo(); 
			//$empList = $paysheet->getPaysheetEmployeeList($condition);
			
			$paysheet->calculate($condition,$company,$dateRange,$routeInfo);
		    $this->flashMessenger()->setNamespace('success') 
		         ->addMessage('Paysheet Calculated Successfully'); 
		} 
		$this->redirect()->toRoute('paysheet',array( 
				'action' => 'calculate' 
		));   
		return array(  
			'form' => $form, 
			$prg 
		);  
	}  
	
	private function getForm() {
        $form = new SubmitButonForm();
        $form->get('submit')->setValue('Calculate Paysheet');
		return $form;
	}
	
	public function closeAction() {
				
		$form = $this->getForm();
		$form->get('submit')->setValue('Close Paysheet');
		$prg = $this->prg('/paysheet/close', true);
		if ($prg instanceof Response ) {
			return $prg; 
		} elseif ($prg === false) {
			return array ('form' => $form); 
		} 
		$company = $this->getCompanyService(); 
		$form->setData($prg);  
		$dateRange = $this->getDateService(); 
		$paysheet = $this->getPaysheetService();  
		   
		$isAlreadyClosed = $paysheet->isPaysheetClosed($company,$dateRange);
		if($isAlreadyClosed) {
			$this->flashMessenger()->setNamespace('info')
			     ->addMessage('Paysheet Already closed for current month'); 
		} else {  
			// @todo 
			$routeInfo = $this->getRouteInfo(); 
			$paysheet = $this->getPaysheetService(); 
			$paysheet->close($company,$dateRange,$routeInfo); 
			$this->flashMessenger()->setNamespace('success')
		         ->addMessage('Paysheet Closed Successfully'); 
		}  
		$this->redirect()->toRoute('paysheet',array( 
				'action' => 'close'
		)); 
		return array( 
				'form' => $form, 
				$prg 
		); 
	} 
	
	public function payslipAction() {
		
		
		$form = $this->getReportForm();
		$request = $this->getRequest();
		if ($request->isPost()) {
			$form->setData($request->getPost());
			if ($form->isValid()) {
				return $this->redirect()->toRoute('paysheet');
			}
		}
		return array(
				'form' => $form,
		);
	}
	
	public function generalgrossAction() { 
	    $form = $this->getEmployeeForm(); 
	    $request = $this->getRequest();
	    if ($request->isPost()) {
	        $form->setData($request->getPost());
	        if ($form->isValid()) {
	            return $this->redirect()->toRoute('paysheet');
	        }
	    }
	    return array(
	        'form' => $form,
	    );
	}
	
	public function viewgrossAction() {
	    $employeeId = $this->params()->fromPost('employeeNumber',0);
	    if(!$employeeId) {
	        $employeeId = $this->getUser();
	    } 
	    $viewmodel = new ViewModel();
	    $viewmodel->setTerminal(1);
	    $request = $this->getRequest();
	    $output = " ";
	    if($request->isPost()) {
	        $values = $request->getPost();
	        //$month = $values['month'];
	        //$year = $values['year'];
	        //$type = 1;
	        //$param = array('month' => $month,'year' => $year,'empId' => $employeeId);
	        $company = $this->getCompanyService();
	        //$results = $this->getPaysheetService()->getPaysheetReport($param);
	        $output = $this->getPaysheetService()->getEmployeeGeneralGross($employeeId,$company);
	        
	    }
	    $viewmodel->setVariables(array(
	        'report'            => $output,
	        'name'              => array('Employee Name' => 'employeeName'),
	        'allowance'         => $this->getPaysheetAllowanceArray(),
	        //'deduction'         => $this->getPaysheetDeductionArray(),
	        //.'companyDeduction'  => $this->companyDeductionArray()
	    ));
	    return $viewmodel;
	}
	
	public function payslipamnAction() {
	
	
		$form = $this->getReportAmnForm(); 
		$request = $this->getRequest();
		if ($request->isPost()) {
			$form->setData($request->getPost());
			if ($form->isValid()) {
				return $this->redirect()->toRoute('paysheet');
			}
		}
		return array(
				'form' => $form,
		);
	}
	
	public function viewpayslipAction() {
		
		$employeeId = $this->params()->fromPost('empMonthYearId',0);
		if(!$employeeId) {
			$employeeId = $this->getUser(); 
		} 
		
		$viewmodel = new ViewModel();
		$viewmodel->setTerminal(1);
		$request = $this->getRequest();
		$output = " "; 
		if($request->isPost()) {
			$values = $request->getPost();
			$month = $values['month'];
			$year = $values['year'];
			$type = 1;
			$param = array('month' => $month,'year' => $year,'empId' => $employeeId);
			$company = $this->getCompanyService();
			//$results = $this->getPaysheetService()->getPaysheetReport($param);
			$output = $this->getPaysheetService()->getPayslipReport($company,$param);
		
		}
		// \Zend\Debug\Debug::dump($output) ;
		$viewmodel->setVariables(array(
				'report'            => $output,
				'name'              => array('Employee Name' => 'employeeName'),
				'allowance'         => $this->getPaysheetAllowanceArray(),
				'deduction'         => $this->getPaysheetDeductionArray(),
				'companyDeduction'  => $this->companyDeductionArray()
		));
		return $viewmodel;
	}
	
	public function reportAction() {
		
		$form = $this->getReportForm(); 
		$request = $this->getRequest();
		if ($request->isPost()) { 
			$form->setData($request->getPost());
			if ($form->isValid()) {
				return $this->redirect()->toRoute('paysheet');
			}
		}
		return array(
				'form' => $form,
		);
	}  
	
	public function paysheettestAction() { 
		$form = $this->getEmployeeForm(); 
		$request = $this->getRequest();
		if ($request->isPost()) {
			$form->setData($request->getPost());
			if ($form->isValid()) {
				return $this->redirect()->toRoute('paysheet');
			}
		}
		return array(
				'form' => $form,
		);
	} 
    
	public function otherreportAction() {
	
		$form = $this->getOtherReportForm();
		$request = $this->getRequest();
		if ($request->isPost()) {
			$form->setData($request->getPost());
			if ($form->isValid()) {
				return $this->redirect()->toRoute('paysheet');
			}
		}
		return array(
				'form' => $form,
		);  
	} 
	
	public function viewotherreportAction() {
	
		$viewmodel = new ViewModel();
		$viewmodel->setTerminal(1);
		$request = $this->getRequest();
		$output = " ";
		if($request->isPost()) {
			$values = $request->getPost();
			$month = $values['month'];
			$year = $values['year'];
			$allowanceDeduction = $values['allowanceDeduction'];
			$type = $values['reportType'];
			//$type = 1;
			$param = array(
					'month' => $month,
					'year' => $year,
					'allowanceDeduction' => $allowanceDeduction,
					//'year' => $year,
			);
			$company = $this->getCompanyService(); 
			
			$arr = $this->getBasedOnType($allowanceDeduction); 
			
			if($type == 1) {
				$output = $this->getPaysheetService()->getPaysheetByFunction($company,$param);
				$vm = array(
						'report'            => $output,
						'name'              => array('Function' => 'sectionCode'),
						'allowance'         => $arr['allowance'],
						'deduction'         => $arr['deduction'],
						'companyDeduction'  => array(),
						'type'              => $type,
				);
				//$name = array('Function' => 'employeeName');
				 
			} else {
				$output = $this->getPaysheetService()->getPaysheetReport($company,$param);
				$vm = array(
						'report'            => $output,
						'name'              => array('Employee Name' => 'employeeName'),
						'allowance'         => $arr['allowance'],
						'deduction'         => $arr['deduction'],
						'companyDeduction'  => array(),
						'type'              => $type,
				);
			}
		}
		//\Zend\Debug\Debug::dump($output);
		$viewmodel->setVariables($vm);
		return $viewmodel;
	}
	
	/*private function getBasedOnType($allowanceDeduction) {
		// switch ($allowanceDeduction)
		switch ($allowanceDeduction) {
			case 'Cooperation':
				return array(
					'allowance' => array(
						'Cooperation'           => 'Cooperation',
					),
					'deduction' => array(),
				);
				break;
			case 'Zamala':
				return array(
					'allowance' => array(
						'Zamala'           => 'Zamala',
					),
					'deduction' => array(),
				);
			break;
			case 'UnionShare':
				return array(
					'allowance' => array(
						'UnionShare'  => 'Union',
					),
					'deduction' => array(),
				);
			break;
			case 'Zakat':
				$arr =  $this->getPaysheetAllowanceArray(); 
				$arr['Zakat'] = 'Zakat'; 
				return array(
				'allowance' => $arr,
				'deduction' => array(), 
				);
				break;
			default:
				return array(
					'allowance' => array(),
					'deduction' => array(),
				);
		}
		 
	}*/ 
	
	private function getBasedOnType($allowanceDeduction) {
	    // switch ($allowanceDeduction)
	    switch ($allowanceDeduction) {
	        case 'Cooperation':
	            return array(
	            'allowance' => array(
	            'Cooperation'           => 'Cooperation',
	            ),
	            'deduction' => array(),
	            );
	            break;
	        case 'Zamala':
	            return array(
	            'allowance' => array(
	            'Zamala'           => 'Zamala',
	            ),
	            'deduction' => array(),
	            );
	            break;
	        case 'UnionShare':
	            return array(
	            'allowance' => array(
	            'UnionShare'  => 'Union',
	            ),
	            'deduction' => array(),
	            );
	            break;
	        case 'IncomeTax':
	            return array(
	            'allowance' => array(
	            'IncomeTax'  => 'IncomeTax',
	            ),
	            'deduction' => array(),
	            );
	            break;
	        case 'KhartoumUnion':
	            return array(
	            'allowance' => array(
	            'KhartoumUnion'  => 'KhartoumUnion',
	            ),
	            'deduction' => array(),
	            );
	            break;
	        case 'ProvidentFund':
	            return array(
	            'allowance' => array(
	            'ProvidentFund'  => 'ProvidentFund',
	            ),
	            'deduction' => array(),
	            );
	            break;
	        case 'SocialInsurance':
	            return array(
	            'allowance' => array(
	            'SocialInsurance'  => 'SocialInsurance',
	            ),
	            'deduction' => array(),
	            );
	            break;
	        case 'Zakat':
	            $arr =  $this->getPaysheetAllowanceArray();
	            $arr['Zakat'] = 'Zakat';
	            return array(
	                'allowance' => $arr,
	                'deduction' => array(),
	            );
	            break;
	            /*case 'IncomeTax':
	             $arr =  $this->getPaysheetAllowanceArray();
	             $arr['IncomeTax'] = 'IncomeTax';
	             return array(
	             'allowance' => $arr,
	             'deduction' => array(),
	             );
	             break;			default:
	             return array(
	             'allowance' => array(),
	             'deduction' => array(),
	             );*/
	    }
	    
	}
	
	/*private function getPaysheetService() {
		return $this->getServiceLocator()->get('Paysheet'); 
	}*/
	
	private function getCompanyService() {
	   return $this->getServiceLocator()->get('company'); 
    }
    
    private function getDateService() {
        return $this->getServiceLocator()->get('dateRange');
    } 
	
	public function viewreportAction() { 
                                                                                
        $viewmodel = new ViewModel();
        $viewmodel->setTerminal(1);       
        $request = $this->getRequest();
        $output = " "; 
        if($request->isPost()) { 
            $values = $request->getPost(); 
            $month = $values['month']; 
            $year = $values['year']; 
            $bank = $values['Bank'];
            $type = $values['reportType'];
            //$type = 1; 
            $param = array(
            		'month' => $month,
            		'year' => $year,
            		'bank' => $bank,
            		//'year' => $year,
            ); 
            $company = $this->getCompanyService(); 
            //$results = $this->getPaysheetService()->getPaysheetReport($param);  
            if($type == 1) {
            	$output = $this->getPaysheetService()->getPaysheetByFunction($company,$param);
            	$vm = array(
            			'report'            => $output,
            			'name'              => array('Function' => 'sectionCode'),
            			'allowance'         => $this->getPaysheetAllowanceArray(),
            			'deduction'         => $this->getPaysheetDeductionArray(),
            			'companyDeduction'  => $this->companyDeductionArray(),
            			'type'              => $type,
            	);
            	//$name = array('Function' => 'employeeName'); 
            	
            } elseif($type == 2) {
            	$output = $this->getPaysheetService()->getPaysheetByBank($company,$param);
            	$vm = array(
            			'report'            => $output,
            			'name'              => array('Employee Name' => 'employeeName'),
            			'allowance'         => array('Allowance' => 'allowance'),
            			'deduction'         => array('Deduction' => 'deduction'),
            			'companyDeduction'  => array(
            					'Account Number'   => 'accountNumber',
            					'Reference Number' => 'referenceNumber',
            			),
            			'type'              => $type,
            			'param'             => $param,
            	);
            } elseif($type == 3) {
            	$output = $this->getPaysheetService()->getPaysheetBankSummary($company,$param);
            	$vm = array(
            			'report'            => $output,
            			'name'              => array('Bank Name' => 'bankName'),
            			'allowance'         => array('Allowance' => 'allowance'),
            			'deduction'         => array('Deduction' => 'deduction'),
            			'companyDeduction'  => array(),
            			'type'              => $type,
            			'param'             => $param,
            	);
            } else {
            	$output = $this->getPaysheetService()->getPaysheetReport($company,$param);
            	$vm = array(
            			'report'            => $output,
            			'name'              => array('Employee Name' => 'employeeName'),
            			'allowance'         => $this->getPaysheetAllowanceArray(),
            			'deduction'         => $this->getPaysheetDeductionArray(),
            			'companyDeduction'  => $this->companyDeductionArray(),
            			'type'              => $type,
            	); 
            } 
        }   
        // \Zend\Debug\Debug::dump($output);          
        $viewmodel->setVariables($vm);
        return $viewmodel; 
	} 
	
	public function successAction() {
		return new ViewModel();
	}
	
	public function policyAction() {
		
	}
	
	public function manualAction() {
	
	}
	
	public function getReportForm() {
		$form = new FunctionBankMonthYear(); 
		$form->get('Bank')
		     ->setOptions(array('value_options' => $this->getEmpBank()
		));
		$form->get('submit')->setValue('View Paysheet Report');
		return $form; 
	} 
	
	public function getOtherReportForm() {
		$form = new PaysheetOtherMonthYear(); 
		//$form->get('Bank')
		//->setOptions(array('value_options' => $this->getEmpBank()
		//));
		$form->get('submit')->setValue('View Paysheet Report');
		return $form;
	}
	
	public function getEmployeeForm() {
		$form = new EmployeeForm(); 
		$form->get('employeeNumber')
		     ->setOptions(array('value_options' => $this->getEmployeeList()
		));
		return $form;
	}
	 
	public function getReportAmnForm() {
		$form = new EmployeeMonthYear();  
		//$company = $this->getCompanyService();
		//$companyId = $company->getId();
		$form->get('empMonthYearId')
		     ->setOptions(array('value_options' =>
		         $this->getEmployeeList()))
		;
		$form->get('submit')->setValue('View Paysheet Report');
		return $form;
	}
    
	private function getPaysheetService() {
		return $this->getServiceLocator()->get('paysheet');
	} 
	
	private function getPaysheetAllowanceArray() {
		return array(
				
				// 'Employee Number'  => 'employeeNumber', 
				'Initial Salary'   => 'Initial',
				'Cola'             => 'Cola',
				'Housing'          => 'Housing',
				'Transportation'   => 'Transportation',
				'Representative'   => 'Representative',
				'NatureofWork'     => 'NatureofWork', 
				'Hardship'         => 'Hardship',
				'Cashier'          => 'Cashier',
				'Airport'          => 'Airport',
				'Fitter'           => 'Fitter',
				//'Shift'            => 'Shift',
				'OtherAllowance'   => 'OtherAllowance',
				'SpecialAllowance' => 'SpecialAllowance',
				//'President'        => 'President',
				'Overtime'         => 'Overtime',
				'Meal'             => 'Meal',
				
				
		);
	}
	
	public function getPaysheetDeductionArray() {
		return array( 
				'Social Insurance' => 'SocialInsurance',
				'IncomeTax'        => 'IncomeTax',
				'Zakat'            => 'Zakat',
				'Provident Fund'   => 'ProvidentFund', 
				'Zamala'           => 'Zamala',
				'Union Share'           => 'UnionShare',
				'Telephone'             => 'PhoneDeduction',
				//'Punishment'          => 'Punishment',
				'OtherDeduction'        => 'OtherDeduction',
				'Over Payment'          => 'OverPayment',
				'KhartoumUnion'         => 'KhartoumUnion',
				'Cooperation'           => 'Cooperation',
				'AdvanceSalary'         => 'AdvanceSalary',
				//'Advance Housing'       => 'AdvanceHousing',
				//'Absenteeism'         => 'Absenteeism',
				'PersonalLoan'          => 'PersonalLoan',
		); 
	}
	
	public function companyDeductionArray() {
		return array(
			'Company SI'  => 'SocialInsuranceCompany',
			'Company PF'  => 'ProvidentFundCompany',
		); 
	}
	
	private function getRouteInfo() {
		return array(
				'controller' => $this->getEvent()
				                     ->getRouteMatch()
				                     ->getParam('controller','index'),
				'action'     => $this->getEvent()
				                     ->getRouteMatch()
				                     ->getParam('action','index'),
		); 
	}
	
	private function getEmployeeList($companyId) {
		$company = $this->getServiceLocator()->get('company');
		$companyId = $company->getId();
		return $this->getEmployeeService()->employeeList($companyId);
	} 
	
	private function getEmpBank() {
		return $this->getLookupService()->getBankList();
	}
	
	private function getLookupService() {
		return $this->getServiceLocator()->get('lookupService');
	}
	
	private function getEmployeeService() {
	    return $this->getServiceLocator()->get('employeeService');
	}
	
	private function getUser() {
		return $this->getUserInfoService()->getEmployeeId();
	}
	
	private function getUserInfoService() {
		return $this->getServiceLocator()->get('userInfoService');
	} 
	
	
}