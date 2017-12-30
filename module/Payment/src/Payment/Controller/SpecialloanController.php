<?php

namespace Payment\Controller;

//use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Payment\Model\Company;
use Payment\Model\DateRange; 
use Application\Form\SubmitButonForm;
use Application\Form\MonthYear;
use Payment\Form\PersonalLoanForm; 
use Employee\Mapper\EmployeeService; 
use Application\Model\PersonalLoanGrid;
use Application\Model\SpecialLoanGrid;
use Payment\Form\SpecialLoanForm;
use Application\Model\SpecialLoanDueGrid;
use Application\Model\SpecialLoanPaidDueGrid;

class SpecialloanController extends AbstractActionController {
	
	public function listAction() { } 
	
	public function ajaxlistAction() {
		$grid = $this->getGrid();
		$grid->setAdapter($this->getDbAdapter())
		->setSource($this->getAdvancePaymentService()->selectSpecialLoan())
		     ->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render());
	}  
	
	public function updatedueAction() { }
	
	public function updatedueajaxlistAction() {
	    $grid = $this->getDueGrid(); 
	    $grid->setAdapter($this->getDbAdapter())
	    ->setSource($this->getAdvancePaymentService()->selectSpecialLoanDue())
	    ->setParamAdapter($this->getRequest()->getPost());
	    return $this->htmlResponse($grid->render());
	}
	
	public function paiddueAction() { }
	
	public function paiddueajaxlistAction() {
	    $grid = $this->getPaidDueGrid();
	    $grid->setAdapter($this->getDbAdapter())
	    ->setSource($this->getAdvancePaymentService()->selectSpecialLoan())
	    ->setParamAdapter($this->getRequest()->getPost());
	    return $this->htmlResponse($grid->render());
	}
	
	public function htmlResponse($html) {
		$response = $this->getResponse();
		$response->setStatusCode(200);
		$response->setContent($html);
		return $response;
	}
	
	public function calculateAction()
	{   
		// @todo
		//$id = (int) $this->params()->fromRoute('id',0); 
		//echo json_encode($id);
		//exit;
		//var_dump($this->getEmployeeList()); 
		$company = $this->getServiceLocator()->get('company');
		$companyId = $company->getId();
		$form = new SpecialLoanForm(); // PersonalLoanForm(); // AdvanceSalaryForm(); 
		$form->get('employeeNumberSpecialLoan') 
		     ->setOptions(array('value_options' => $this->getEmployeeList($companyId))) 
		   //->setAttribute('readOnly', true) 
		;  
		return array('form' => $form); 
		//exit; 
	} 
	
	public function removeAction()
	{
		// @todo 
		$id = (int) $this->params()->fromRoute('id',0);
		$routeInfo = $this->getRouteInfo();
		$advancePaymentService = $this->getAdvancePaymentService(); 
		$advancePaymentService->removeSpecialLoan($id,$routeInfo);  
		//echo json_encode($id); 
		exit; 
	}
	
	public function calcAction()
	{   
		$form = $this->getForm();
		$prg = $this->prg('/paysheet/calculate', true);
		if ($prg instanceof Response ) {
			return $prg;
		} elseif ($prg === false) {
			return array ('form' => $form);
		}
		$company = $this->getServiceLocator()->get('company');
		$form->setData($prg);
		$dateRange = $this->getServiceLocator()->get('dateRange');
		$paysheet = $this->getServiceLocator()->get('Paysheet'); 
		$isAlreadyClosed = $paysheet->isPaysheetClosed($company,$dateRange);
		if($isAlreadyClosed) {
		    $this->flashMessenger()->setNamespace('info')
			     ->addMessage('Paysheet Already closed for current month');
		} else {
			$employeeMapper = $this->getServiceLocator()->get('CompanyEmployeeMapper');
			$employeeList = $employeeMapper->fetchAll(); 
			$paysheet->calculate($employeeList,$company,$dateRange); 
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
        $form->get('submit')->setValue('Apply Special Loan');  
		return $form;  
	}  
	
	public function closeAction() { 
		$form = $this->getForm();
		$prg = $this->prg('/specialloan/close', true);
		if ($prg instanceof Response ) {
			return $prg;
		} elseif ($prg === false) {
			return array ('form' => $form);
		}
		$form->setData($prg); 
		$service = $this->getAdvancePaymentService(); 
		//$isHaveRecords = $service->isHaveAdvanceHousingRecords();   
		//if(!$isHaveRecords) {  
			//$this->flashMessenger()->setNamespace('info') 
			  //   ->addMessage('No records found to close,please add');  
		//} else { 
			$routeInfo = $this->getRouteInfo(); 
			$res = $service->closeSpecialLoanList($routeInfo);     
			$this->flashMessenger()->setNamespace('success') 
			     ->addMessage($res); 
		//} 
		$this->redirect()->toRoute('specialloan',array( 
				'action' => 'calculate' 
		));  
		return array( 
				'form' => $form, 
				$prg 
		);  
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
	
	public function viewreportAction() {                                                                       
        $viewmodel = new ViewModel();
        $viewmodel->setTerminal(1);       
        $request = $this->getRequest();
        $output = " ";
        if($request->isPost()) { 
            $values = $request->getPost(); 
            $month = $values['month']; 
            $year = $values['year']; 
            $type = 1;
            $param = array('month' => $month,'year' => $year); 
            //$results = $this->getPaysheetService()->getPaysheetReport($param); 
            $output = $this->getPaysheetService()->getPaysheetReport($param); 
            /* if($results) {
            	foreach($results as $result) {
            		$output .= $result['employeeNumber']."<br/>";
            	}
            } else {
            	$output = "Sorry! no results found";
            }  */ 
            /* if ($type == 1) {
                $output = $this->getPaysheetService()->getPaysheetReport($param); 
            } else if ($type == 2) {
                $output = $this->getReportTable()->summary($values);
            } else if ($type == 3) {
                $output = $this->getReportTable()->byorder($values);
            } else if ($type == 4) {
                $output = $this->getReportTable()->bystatus($values);
            } else if ($type == 5) {
                $output = $this->getReportTable()->report($values,'2'); 
            } else if ($type == 6) {
                $output = $this->getReportTable()->duplicateobr($values); 
            } */
            
        }     
        $viewmodel->setVariables(array(
            'report' => $output,
        	'paysheetArray'  => $this->getPaysheetAllowanceArray()
        ));
        return $viewmodel; 
	}
	
	private function getEmployeeService() {
		return $this->getServiceLocator()->get('employeeMapper');
	}
	
	private function getEmployeeList($companyId) {
		return $this->getEmployeeService()->employeeList($companyId);
	}
	
	public function successAction() {
		return new ViewModel();
	}
	
	protected function getEmployeeLoanAmount($employeeNumber) {
		// @todo calculate elegible loan amount 
	    $company = $this->getCompanyService();
	    $dateRange = $this->getDateService(); 
	    $paysheet = $this->getPaysheet();
	    return $paysheet->getEmployeeBasic($employeeNumber,$company,$dateRange);
		// return '50000'; 
	}
	    
	public function getpersonalloanamountAction() {
		$employeeNumber = $this->params()->fromPost('empNumber'); 
		$loanAmount = $this->getEmployeeLoanAmount($employeeNumber);  
		$loan = array('employeeLoanAmount' => $loanAmount);
		echo json_encode($loan); 
		exit; 
	} 
	
	private function getCompanyService() {
	    return $this->getServiceLocator()->get('company');
	}
	
	private function getPaysheet() {
	    return $this->getServiceLocator()->get('paysheet');
	}
	
	private function getDateService() {
	    return $this->getServiceLocator()->get('dateRange');
	}
	
	protected function getAdvancePaymentService() {
		return $this->serviceLocator->get('advancePaymentService');
	}
	
	protected function savespecialloanAction() {
		$routeInfo = $this->getRouteInfo();
		$formValues = $this->params()->fromPost('formVal'); 
		$advancePaymentService = $this->getAdvancePaymentService(); 
		$advancePaymentService->saveSpecialLoan($formValues,$routeInfo); 
		exit; 
	}
	
	public function getTaxService() {
		
	}
	
	public function getReportForm() {
		$form = new MonthYear(); 
		$form->get('submit')->setValue('View Paysheet Report');
		return $form;
	}
    
	private function getPaysheetService() {
		return $this->getServiceLocator()->get('paysheetMapper');
	} 
    
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	}
	
	private function getGrid() { 
	    return new SpecialLoanGrid(); 
	}
	
	private function getDueGrid() {
	    return new SpecialLoanDueGrid(); 
	}
	
	private function getPaidDueGrid() {
	    return new SpecialLoanPaidDueGrid(); 
	}
	
	private function getRouteInfo() {  
		return array(
			'controller' => $this->getEvent()->getRouteMatch()->getParam('controller','index'),
			'action'     => $this->getEvent()->getRouteMatch()->getParam('action','index'),
		); 
	} 
	
}