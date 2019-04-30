<?php

namespace Employee\Controller; 

use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController; 

use Zend\View\Model\ViewModel;
use Payment\Model\Company;
use Payment\Model\DateRange;
use Application\Form\SubmitButonForm;
use Application\Form\MonthYear;
use Payment\Form\AdvanceHousingForm; 
use Application\Model\PositionAllowanceGrid;
use Employee\Form\PositionAllowanceForm;
use Application\Model\PositionAllowanceHistGrid;
use Application\Model\PositionAllowanceNewGrid;
use Application\Form\ApplyEffectiveDateForm;
use Application\Form\ApplyEffectiveDateFormValidator;

class PositionallowanceController extends AbstractActionController {
    
	public function listAction() { }
	
	public function ajaxlistexistingAction() {
		$grid = $this->getGrid();
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getPositionService()
		     		          ->selectPositionAllowance()) 
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
	
	public function listexistingAction() { }
	
	public function htmlResponse($html) {
		$response = $this->getResponse();
		$response->setStatusCode(200);
		$response->setContent($html);
		return $response;
	}
	
	public function addnewAction()
	{   
		$form = $this->getPositionAllowanceForm();
		
		return array('form' => $form);  
	} 
	
	public function updateexistingAction() {
	
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			$this->flashMessenger()->setNamespace('info')
			     ->addMessage('Position Allowance not found,Please Add');
			$this->redirect()->toRoute('positionallowance', array(
					'action' => 'add'
			)); 
		} 
		$form = $this->getPositionAllowanceForm(); 
	    
		//$form->get('allowanceId')->setAttribute('disabled','true');
	    
		//$form->get('lkpSalaryGradeId')->setAttribute('disabled','true');
	    
		//$form->get('isApplicableToAll')->setAttribute('disabled','true');
	    
		$service = $this->getPositionService(); 
		$positionAllowance = $service->selectPositionAllowanceById($id);
		//\Zend\Debug\Debug::dump($positionAllowance); 
		//exit; 
		$form->bind($positionAllowance); 
		$form->get('submit')->setAttribute('value','Delete Position Allowance');
		$prg = $this->prg('/positionallowance/updateexisting/'.$id,true);
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
	
	public function editAction() { 
		
		
		
	}
	
	public function getPositionAllowanceForm() {
		$form = new PositionAllowanceForm(); 
		$form->get('positionAllowanceName')
		     ->setOptions(array('value_options' => $this->getAllowanceList()))
		;
		$form->get('positionName')
		     ->setOptions(array('value_options' => $this->getPositionList()))
		;
		return $form; 
	}
	
	public function applynewAction() {
	    
		$form = $this->getForm(); 
		$form->get('submit')->setValue('Apply New Position Allowance');
		$prg = $this->prg('/positionallowance/applynew', true); 
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
		$positionService = $this->getPositionService();
		$isAlreadyClosed = 0; // $positionService->isHaveAllowances($company);
		if ($form->isValid()) {
			$data = $form->getData();
			//var_dump($data); 
			//exit;
			/*if($isAlreadyClosed) { 
				$this->flashMessenger()->setNamespace('info') 
				     ->addMessage('No records found to Apply');   
			} else {*/  
				$effectiveDate = $data['applyeEfectiveDate']; 
				$response = $positionService->applyCompanyPositionAllowance($company,$effectiveDate); 
				$this->flashMessenger()->setNamespace('info')
				     ->addMessage($response); 
			//}  
			$this->redirect()->toRoute('positionallowance',array(
				'action' => 'applynew'
			));  
		}
		return array(
			'form' => $form,
			$prg
		); 
	}
     
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
	}
	
	public function removeAction()
	{   
		// @todo 
		$id = (int) $this->params()->fromRoute('id',0);
		//$sgService = $this->getPositionService();
		//echo json_encode($id);
		$this->getPositionService()->removePositionAllowanceBuffer($id);
		exit; 
	} 
	
	protected function savepositionallowanceAction() {
		$formValues = $this->params()->fromPost('formVal');
		//$employeeService = $this->getPositionService();
		//var_dump($formValues);
		$company = $this->getServiceLocator()->get('company'); 
		$this->getPositionService()
		     ->savePositionAllowanceBuffer($formValues,$company); 
		
		exit;  
	} 
	
	public function removeexistingAction()
	{
		// @todo
		$id = (int) $this->params()->fromRoute('id',0); 
		//$sgService = $this->getPositionService(); 
		$this->getPositionService()->removePositionAllowanceBuffer($id); 
		exit; 
	} 
	
	protected function savepositionallowanceexistingAction() {
		$formValues = $this->params()->fromPost('formVal');
		$company = $this->getServiceLocator()->get('company'); 
		$this->getPositionService()->savePositionAllowanceBuffer($formValues,$company);
		exit;
	}
	
	public function calcAction()
	{
		$form = $this->getForm();
		$prg = $this->prg('/positionallowance/calculate', true);
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
		$this->redirect()->toRoute('positionallowance',array(
				'action' => 'calculate'
		)); 
		return array(
				'form' => $form,
				$prg
		); 
	} 
	
	private function getForm() {
		return new ApplyEffectiveDateForm();
		//return new SubmitButonForm();
		//$form->get('submit')->setValue('Close Advance Housing');
		//return $form;
	} 
	
	private function getApplyForm() {
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
	
	private function getPositionService() {
		return $this->getServiceLocator()->get('positionService');
	}
	
	private function getNotConfirmedEmployeeList() {
		return $this->getPositionService()->notConfirmedEmployeeList();
	}
    	
	public function successAction() {
		return new ViewModel();
	}
	
	public function applyFormValidator() {
		return new ApplyEffectiveDateFormValidator();
	}
	
	public function getoldsalarydetailsAction() {
		$employeeNumber = $this->params()->fromPost('empNumber');
		$employeeService = $this->getPositionService();
		$salaryInfo = $employeeService->getSalaryInfo($employeeNumber);
		echo json_encode($salaryInfo);
		exit;
	}
    
	public function getAllowanceList() {
		$allowanceService = $this->serviceLocator->get('allowanceservice');
		return $allowanceService->getAllowanceList(); 
	}
	
	public function getPositionList() {
		//$service = $this->serviceLocator->get('salaryGradeService');
		return $this->getPositionService()->getPositionList();  
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
		return new PositionAllowanceGrid(); 
	}
	
	private function getHistGrid() {
		return new PositionAllowanceHistGrid(); 
	}
	
	private function getNewGrid() {
		return new PositionAllowanceNewGrid();
	}
	
}