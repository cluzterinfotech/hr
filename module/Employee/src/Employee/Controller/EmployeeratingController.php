<?php

namespace Employee\Controller; 

use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController; 
use Application\Model\EmployeeRatingGrid;
use Zend\View\Model\ViewModel;
use Payment\Model\Company;
use Payment\Model\DateRange;
use Application\Form\SubmitButonForm;
use Application\Form\MonthYear;
use Employee\Mapper\EmployeeService; 
use Employee\Form\EmployeeRatingForm;

class EmployeeratingController extends AbstractActionController {
    
	public function listAction() { }
	
	public function ajaxlistAction() {
		$grid = $this->getGrid();
		$company = $this->getServiceLocator()->get('company'); 
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getService()->selectEmployeeRating($company)) 
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
		// $form = new AdvanceHousingForm();
		
		$form = new EmployeeRatingForm(); 
		$form->get('employeeNumberRating')
		     ->setOptions(array('value_options' => $this->getEmployeeList()))
		//->setAttribute('readOnly', true)
		;
		$form->get('rating')
		     ->setOptions(array('value_options' => $this->getRatingList()))
		//->setAttribute('readOnly', true)
		;
		return array('form' => $form);  
		//exit;  
	} 
	
	public function closeAction() { 
		$form = $this->getForm();
		$form->get('submit')->setValue('Close Employee Rating');
		$prg = $this->prg('/employeerating/close', true);
		if ($prg instanceof Response ) {
			return $prg;
		} elseif ($prg === false) {
			return array ('form' => $form);
		}
		$company = $this->getServiceLocator()->get('company');
		$form->setData($prg);
		$dateRange = $this->getServiceLocator()->get('dateRange');
	    
		$paysheet = $this->getServiceLocator()->get('Paysheet');
		$isAlreadyClosed = 0;//$paysheet->isPaysheetClosed($company,$dateRange);
		if($isAlreadyClosed) {
			$this->flashMessenger()->setNamespace('info')
			     ->addMessage('No records found to close'); 
		} else { 
			$this->flashMessenger()->setNamespace('success')
			     ->addMessage('Employee Rating Closed Successfully');
		}
		$this->redirect()->toRoute('employeerating',array(
				'action' => 'calculate'
		));
		return array( 
				'form' => $form,
				$prg
		); 
	}
	
	public function removeAction()
	{
		// @todo
		$id = (int) $this->params()->fromRoute('id',0);
		$deductionService = $this->getService();
		$deductionService->removeEmployeePhoneDeduction($id); 
		exit; 
	} 
	
	private function getForm() {
		return new SubmitButonForm();
		//$form->get('submit')->setValue('Close Advance Housing');
		//return $form;
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
			
	
		}
		 
		$viewmodel->setVariables(array(
				'report' => $output,
				'paysheetArray'  => $this->getPaysheetAllowanceArray()
		));
	
		return $viewmodel;
	
	}
	
	private function getService() {
		return $this->getServiceLocator()->get('incrementService');
	}
	
	private function getEmployeeService() {
		return $this->getServiceLocator()->get('employeeService');
	}
	
	private function getEmployeeList() {
		$company = $this->getServiceLocator()->get('company');
		$companyId = $company->getId(); 
		return $this->getEmployeeService()->employeeList($companyId);  
	}
	
	private function getRatingList() {
		return $this->getLookupService()->getRatingList(); 
	} 
	
	private function getLookupService() {
		return $this->getServiceLocator()->get('lookupService');
	} 
    	
	public function successAction() {
		return new ViewModel();
	}
	
	public function getoldsalarydetailsAction() {
		$employeeNumber = $this->params()->fromPost('empNumber');
		$employeeService = $this->getEmployeeService();
		$salaryInfo = $employeeService->getSalaryInfo($employeeNumber);
		echo json_encode($salaryInfo);
		exit;
	}
    	
	protected function saveemployeetelephoneAction() {
	
		$formValues = $this->params()->fromPost('formVal');
		$deductionService = $this->getService();
		$deductionService->saveEmployeeConfirmation($formValues);
		//$employeeService = $this->getEmployeeService();
		//$employeeService->saveEmployeeConfirmation($formValues);
		//\Zend\Debug\Debug::dump($formValues);
		exit; 
	}
	
	public function getTaxService() {
	
	}
	
	public function getReportForm() {
		$form = new MonthYear();
		$form->get('submit')->setValue('View Report'); 
		return $form;
	}
	
	private function getPaysheetService() {
		return $this->getServiceLocator()->get('paysheetMapper');
	}
	
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	}
	
	private function getGrid() {
		return new EmployeeRatingGrid(); 
	}
	
}