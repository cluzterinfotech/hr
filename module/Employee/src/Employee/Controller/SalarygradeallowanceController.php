<?php

namespace Employee\Controller; 

use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController; 
use Application\Model\EmployeeConfirmationGrid; 
use Zend\View\Model\ViewModel;
use Payment\Model\Company;
use Payment\Model\DateRange;
use Application\Form\SubmitButonForm;
use Application\Form\MonthYear;
use Payment\Form\AdvanceHousingForm; 
use Employee\Mapper\EmployeeService;
use Employee\Form\EmployeeConfirmationForm; 
use Employee\Form\SalaryGradeAllowanceForm;
use Application\Model\SalaryGradeAllowanceGrid;
use Application\Form\ApplyEffectiveDateForm;
use Application\Form\ApplyEffectiveDateFormValidator;
use Application\Model\SalaryGradeAllowanceExistingGrid;

class SalarygradeallowanceController extends AbstractActionController {
    
	public function listAction() { }
	
	public function ajaxlistAction() {
		$grid = $this->getGrid();
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getSalaryGradeService()->selectSalaryGradeAllowance()) 
		     ->setParamAdapter($this->getRequest()->getPost()); 
		return $this->htmlResponse($grid->render()); 
	} 
	
	// listexisting 
	public function listexistingAction() { }
	
	public function ajaxlistexistingAction() {
		$grid = $this->getExistingGrid(); 
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getSalaryGradeService()->selectExistingSalaryGradeAllowance())
		     ->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render());
	}  
	
	public function ajaxlisthistAction() {
		$grid = $this->getHistGrid();
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getPositionService()
				->selectPositionAllowanceHist())
				->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render());
	}
	
	public function ajaxlistnewAction() {
		$grid = $this->getNewGrid();
		$grid->setAdapter($this->getDbAdapter())
		->setSource($this->getPositionService()
				->selectPositionAllowanceNew())
				->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render());
	} 
	
	public function htmlResponse($html) {
		$response = $this->getResponse();
		$response->setStatusCode(200);
		$response->setContent($html);
		return $response;
	}
	
	public function addnewAction()
	{   
		$form = $this->getSgAllowanceForm();  
		return array('form' => $form);  
	} 
	
	public function applynewAction() { 
		$form = $this->getForm(); 
		$form->get('submit')->setValue('Apply New Salary Grade Allowance');
		$prg = $this->prg('/salarygradeallowance/applynew',true); 
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
		//$salaryGradeService = $this->getSalaryGradeService(); 
		$salaryGradeService = $this->getServiceLocator()->get('salaryGradeService');
		//\Zend\Debug\Debug::dump($salaryGradeService);
		//exit;
		if ($form->isValid()) { 
			$data = $form->getData(); 
			$effectiveDate = $data['applyeEfectiveDate'];  
			$response = $salaryGradeService->applySalaryGradeAllowance($company,$effectiveDate); 
			$this->flashMessenger()->setNamespace('info')
				 ->addMessage($response); 
			$this->redirect()->toRoute('salarygradeallowance',array(
				'action' => 'applynew'
			)); 
		} 
		return array ( 
			'form' => $form, 
			$prg 
		); 
	} 
	
	// editexisting 
	public function updateexistingAction() { 
		
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			$this->flashMessenger()->setNamespace('info')
			     ->addMessage('Salary Grade Allowance not found,Please Add'); 
			$this->redirect()->toRoute('salarygradeallowance', array(
					'action' => 'add'
			)); 
		} 
		$form = $this->getSgAllowanceForm();  
		
		//$form->get('allowanceId')->setAttribute('disabled','true');
		
		//$form->get('lkpSalaryGradeId')->setAttribute('disabled','true'); 

		//$form->get('isApplicableToAll')->setAttribute('disabled','true'); 
		
		$service = $this->getSalaryGradeService(); 
		$emp = $service->sgAllowanceById($id);  
		// \Zend\Debug\Debug::dump($emp);  
		// exit;  
		$form->bind($emp);  
		$form->get('submit')->setAttribute('value','Update Salary Grade Amount');
		$prg = $this->prg('/salarygradeallowance/updateexisting/'.$id,true);
		if ($prg instanceof Response) { 
			return $prg; 
		} elseif ($prg === false) {
			return array ('form' => $form); 
		}
		$formValidator = $this->getFormValidator();
		$form->setInputFilter($formValidator->getInputFilter());
		$form->setData($prg); 
			
		if ($form->isValid()) {
			$data = $form->getData(); 
			$service->updateNewEmployeeInfoBuffer($data);
			$this->flashMessenger()->setNamespace('success')
			     ->addMessage('Employee updated successfully');
			$this->redirect ()->toRoute('newemployee',array (
					'action' => 'approve'
			)); 
		}
		
		return array(
				'form' => $form,
				$prg
		); 
		
	}
	
	// approveexisting 
	/*public function approveexistingAction() { 
		$form = $this->getForm();
		$form->get('submit')->setValue('Apply New Salary Grade Allowance');
		$prg = $this->prg('/salarygradeallowance/applynew',true);
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
		//$salaryGradeService = $this->getSalaryGradeService(); 
		$salaryGradeService = $this->getSalaryGradeService(); 
		//\Zend\Debug\Debug::dump($salaryGradeService); 
		//exit; 
		if ($form->isValid()) { 
			$data = $form->getData(); 
			$effectiveDate = $data['applyeEfectiveDate'];
			$response = $salaryGradeService->applySalaryGradeAllowance($company,$effectiveDate);
			$this->flashMessenger()->setNamespace('info')
			     ->addMessage($response);
			$this->redirect()->toRoute('salarygradeallowance',array(
					'action' => 'applynew'
			)); 
		} 
		return array (
				'form' => $form,
				$prg
		); 	
	}*/  
	
	public function removeAction()
	{
		// @todo 
		$id = (int) $this->params()->fromRoute('id',0);
		//$sgService = $this->getSalaryGradeService();
		//echo json_encode($id); 
		$this->getSalaryGradeService()->removeSgAllowanceBuffer($id);
		exit; 
	}
	
	protected function savesgallowanceAction() {
		$formValues = $this->params()->fromPost('formVal');
		//$employeeService = $this->getSalaryGradeService();
		//var_dump($formValues); 
		//exit; 
		$company = $this->getServiceLocator()->get('company'); 
		$this->getSalaryGradeService()->saveSgAllowanceBuffer($formValues,$company); 
		exit; 
	} 
	
	/*protected function savesgallowanceexistingAction() {
		$formValues = $this->params()->fromPost('formVal');
		//$employeeService = $this->getSalaryGradeService();
		var_dump($formValues); 
		exit;  
		$company = $this->getServiceLocator()->get('company');
		$this->getSalaryGradeService()->saveSgAllowanceBuffer($formValues,$company);
		exit;
	}*/ 
	
	public function getSgAllowanceForm() { 
		$form = new SalaryGradeAllowanceForm();
		$form->get('allowanceId')
		     ->setOptions(array('value_options' => $this->getAllowanceList()))
		;
		$form->get('lkpSalaryGradeId')
		     ->setOptions(array('value_options' => $this->getSalaryGradeList()))
		;
		return $form; 
	} 
	
	private function getForm() {
		return new ApplyEffectiveDateForm(); 
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
	
	private function getSalaryGradeService() {
		return $this->getServiceLocator()->get('salaryGradeService');
	}
	
	private function getNotConfirmedEmployeeList() {
		return $this->getSalaryGradeService()->notConfirmedEmployeeList();
	}
    	
	public function successAction() {
		return new ViewModel();
	}
	
	public function getoldsalarydetailsAction() {
		$employeeNumber = $this->params()->fromPost('empNumber');
		$employeeService = $this->getSalaryGradeService();
		$salaryInfo = $employeeService->getSalaryInfo($employeeNumber);
		echo json_encode($salaryInfo);
		exit;
	}
    	
	
	
	
	public function getAllowanceList() {
		$allowanceService = $this->serviceLocator->get('allowanceservice');
		return $allowanceService->getAllowanceList(); 
	}
	
	public function getSalaryGradeList() {
		//$service = $this->serviceLocator->get('salaryGradeService');
		return $this->getSalaryGradeService()->getSalaryGradeList();  
	}
	
	public function getReportForm() {
		$form = new MonthYear();
		$form->get('submit')->setValue('View Paysheet Report');
		return $form;
	}
	
	public function applyFormValidator() {
		return new ApplyEffectiveDateFormValidator();
	}
    
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter'); 
	}
	
	private function getGrid() { 
		return new SalaryGradeAllowanceGrid(); 
	}
	
	private function getExistingGrid() {
		return new SalaryGradeAllowanceExistingGrid(); 
	} 
	
}