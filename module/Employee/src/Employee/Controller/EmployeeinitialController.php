<?php

namespace Employee\Controller; 

use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController; 
use Zend\View\Model\ViewModel;
use Payment\Model\Company;
use Payment\Model\DateRange;  
use Application\Model\PositionAllowanceHistGrid;
use Application\Model\PositionAllowanceNewGrid;
use Application\Form\ApplyEffectiveDateForm;
use Application\Form\ApplyEffectiveDateFormValidator;
use Employee\Form\UpdateInitialForm;
use Application\Model\EmployeeInitialGrid;
use Application\Form\MonthYear;

class EmployeeinitialController extends AbstractActionController {
    
	public function ajaxlistAction() {
		$grid = $this->getGrid();
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getEmployeeService()
		     ->selectEmployeeInitialBuffer())  
		     ->setParamAdapter($this->getRequest()->getPost()); 
		return $this->htmlResponse($grid->render()); 
	}
	
	public function htmlResponse($html) {
		$response = $this->getResponse();
		$response->setStatusCode(200);
		$response->setContent($html);
		return $response; 
	} 
	
	public function listAction() 
	{   
		$form = new UpdateInitialForm(); 
		$form->get('employeeNumberInitial') 
		     ->setOptions(array('value_options' => $this->getEmployeeList())) 
		;    
		return array('form' => $form);   
	}   
	
	public function applyinitialAction() { 
		$form = $this->getForm();
		$form->get('submit')->setValue('Apply New Initial Salary');
		$prg = $this->prg('/employeeinitial/applyinitial', true); 
		if ($prg instanceof Response ) { 
			return $prg;
		} elseif ($prg === false) {
			return array ('form' => $form); 
		} 
		$company = $this->getServiceLocator()->get('company'); 
		$form->setData($prg);
		$dateRange = $this->getServiceLocator()->get('dateRange');
		$formValidator = $this->applyFormValidator();
		$form->setInputFilter($formValidator->getInputFilter());
		$form->setData($prg); 
		$employeeService = $this->getEmployeeService(); 
		// $isAlreadyClosed = 0; // $positionService->isHaveAllowances($company); 
		if ($form->isValid()) {  
			$data = $form->getData(); 
			$effectiveDate = $data['applyeEfectiveDate']; 
			$response = $employeeService->applyInitial($company,$effectiveDate); 
			$this->flashMessenger()->setNamespace('info')
			     ->addMessage($response);   
			$this->redirect()->toRoute('employeeinitial',array(
				'action' => 'applyinitial' 
			));   
		} 
		return array( 
			'form' => $form,
			$prg
		); 
	}
	
	public function updateexistingAction() {
		
	}
	
	/*
	public function applyupdateAction() {
		$form = $this->getForm();
		$form->get('submit')->setValue('Apply Updated Position Allowance');
		$prg = $this->prg('/positionallowance/applyupdate', true);
		if ($prg instanceof Response ) {
			return $prg;
		} elseif ($prg === false) {
			return array ('form' => $form);
		}
		
		$formValidator = $this->applyFormValidator();
		$form->setInputFilter($formValidator->getInputFilter());
		$form->setData($prg);
		
		$company = $this->getServiceLocator()->get('company');
		$form->setData($prg);
		$dateRange = $this->getServiceLocator()->get('dateRange');
		if ($form->isValid()) { 
			$data = $form->getData();
			$positionService = $this->getPositionService();
			$isAlreadyClosed = 0; //$positionService->isHaveAllowances($company);
			if($isAlreadyClosed) {
				$this->flashMessenger()->setNamespace('info')
				     ->addMessage('No records found to Apply');
			} else {
				$positionService->applyCompanyPosition($company,$dateRange);
				$this->flashMessenger()->setNamespace('success')
				     ->addMessage('Updated Position Allowances Applied Successfully');
			} 
			$this->redirect()->toRoute('positionallowance',array(
					'action' => 'applynew'
			));
		}
		return array(
				'form' => $form,
				$prg
		);
	} */ 
	
	public function removeAction()
	{   
		$id = (int) $this->params()->fromRoute('id',0); 
		$this->getEmployeeService()->removeEmployeeInitialBuffer($id); 
		exit;  
	} 
	
	protected function saveemployeeinitialAction() {
		$formValues = $this->params()->fromPost('formVal');   
		$this->getEmployeeService()->saveEmployeeInitialBuffer($formValues);   
		exit; 
	} 
    
	private function getForm() {
		return new ApplyEffectiveDateForm(); 
	} 
	
	private function getApplyForm() {
		return new ApplyEffectiveDateForm(); 
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
	
	public function successAction() {
		return new ViewModel();
	}
	
	public function applyFormValidator() {
		return new ApplyEffectiveDateFormValidator();
	}
	
	public function getoldinitialAction() { 
		$employeeNumber = $this->params()->fromPost('empNumber'); 
		$employeeService = $this->getEmployeeService();
		$initial = $employeeService->getEmployeeInitial($employeeNumber);
		echo json_encode($initial);
		exit;
	}
    
    private function getEmployeeService() {
		return $this->getServiceLocator()->get('employeeService');
	}
    
	private function getEmployeeList() { 
		$company = $this->getServiceLocator()->get('company');
		$companyId = $company->getId();
		return $this->getEmployeeService()->employeeList($companyId);  
	} 
	
	public function getReportForm() {
		$form = new MonthYear();
		$form->get('submit')->setValue('View Paysheet Report');
		return $form;
	}
    
	private function getDbAdapter() { 
		return $this->getServiceLocator()->get('sqlServerAdapter'); 
	} 
	
	private function getGrid() { 
		return new EmployeeInitialGrid(); 
	}
	
	private function getHistGrid() {
		return new PositionAllowanceHistGrid(); 
	}
	
	private function getNewGrid() {
		return new PositionAllowanceNewGrid();
	}
	
}