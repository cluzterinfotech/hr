<?php

namespace Payment\Controller;

use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Payment\Model\Company;
use Payment\Model\DateRange;
use Application\Form\SubmitButonForm;
use Application\Form\MonthYear;
use Payment\Form\AdvanceSalaryForm; 
use Employee\Mapper\EmployeeService; 
use Application\Model\AdvanceSalaryGrid;

class AdvancesalaryController extends AbstractActionController {
	
	public function listAction() { }
	
	public function ajaxlistAction() {
		$grid = $this->getGrid();
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getAdvancePaymentService()->selectAdvanceSalary())
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
		$form = new AdvanceSalaryForm(); 
		$form->get('employeeNumberAdvSalary') 
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
		$advancePaymentService->removeAdvanceSalary($id,$routeInfo);
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
        $form->get('submit')->setValue('Close Advance Salary'); 
		return $form; 
	} 
	
	public function closeAction() { 
		$form = $this->getForm();
		$prg = $this->prg('/advancesalary/close', true);
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
			$res = $service->closeAdvanceSalary($routeInfo);     
			$this->flashMessenger()->setNamespace('success') 
			     ->addMessage($res); 
		//} 
		$this->redirect()->toRoute('advancesalary',array( 
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
				return $this->redirect()->toRoute('advancesalary');
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
	    
	public function getadvancesalarydetailsAction() {
		$employeeNumber = $this->params()->fromPost('empNumber'); 
		$net = $this->getEmployeeNetAmount($employeeNumber); 
		$net = array('employeeNetAmount' => $net); 
		echo json_encode($net);   
		exit;   
	}   
	
	protected function getAdvancePaymentService() { 
		return $this->serviceLocator->get('advancePaymentService');  
	}
	
	protected function getEmployeeNetAmount($employeeNumber) { 
	    $company = $this->getCompanyService(); 
	    $dateRange = $this->getDateService();
	    $condition = array(
	        'isActive' => 1,
	        'companyId' => $company->getId(),
	        'isInPaysheet' => 1,
	        'employeeNumber' => $employeeNumber,
	    );
	    $paysheet = $this->getPaysheet(); 
	    return $paysheet->calculateIndividualNet($condition,$company,$dateRange);
		// @todo get net amount 
		//return '1234'; 
	}
	
	private function getCompanyService() {
	    return $this->getServiceLocator()->get('company');
	}
	
	private function getDateService() {
	    return $this->getServiceLocator()->get('dateRange');
	} 
	
	protected function saveadvancesalaryAction() {
		$routeInfo = $this->getRouteInfo();
		$formValues = $this->params()->fromPost('formVal'); 
		$advancePaymentService = $this->getAdvancePaymentService();  
		$advancePaymentService->saveAdvanceSalary($formValues,$routeInfo); 
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
	
	private function getPaysheet() {
	    return $this->getServiceLocator()->get('paysheet');
	} 
    
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	}
	
	private function getGrid() {
		return new AdvanceSalaryGrid(); 
	}
	
	private function getRouteInfo() {  
		return array(
			'controller' => $this->getEvent()->getRouteMatch()->getParam('controller','index'),
			'action'     => $this->getEvent()->getRouteMatch()->getParam('action','index'),
		); 
	} 
	
}