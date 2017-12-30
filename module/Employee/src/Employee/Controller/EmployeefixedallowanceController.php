<?php

namespace Employee\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response; 
use Employee\Form\AllowanceListForm;
use Application\Model\EmployeeAllowanceGrid;
use Employee\Form\EmployeeAllowanceForm;
use Employee\Form\EmployeeAllowanceFormValidator;
use Employee\Form\EmployeeAllowanceUpdateForm;

class EmployeefixedallowanceController extends AbstractActionController {
	
	protected $eventManager;
	
	public function indexAction() { exit; }
	
	public function getAllowanceListForm() {
		$form = new AllowanceListForm();
		$form->get('allowanceName')
		     ->setOptions(array('value_options' => $this->selectFixedAmountAllowanceList()))
		//->setAttribute('readOnly', true)
		;
		return $form;
	}
	
	public function listAction() { 
		
		return array('form' => $this->getAllowanceListForm()); 
		
	}
	
	public function ajaxlistAction() { 
		$grid = $this->getEmployeeAllowanceGrid(); 
		$postVal = $this->getRequest()->getPost(); 
		$allowanceName = $postVal['allowanceName'];
		if($allowanceName) {
			$table = $allowanceName; 
		} else {
		    $table = 'President';  
		}
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getEmployeeAllowanceService()->employeeAllowanceList($table))
		     ->setParamAdapter($postVal); 
		return $this->htmlResponse($grid->render()); 
	}
	
	public function addAction() {
        
		$service = $this->getEmployeeAllowanceService();
		$form = $this->getEmployeeAllowanceForm();
		$prg = $this->prg('/employeefixedallowance/add', true);
		if ($prg instanceof Response ) {
			return $prg;
		} elseif ($prg === false) { 
			return array ('form' => $form); 
		} 
		$formValidator = $this->getAllowanceFormValidator();
		$form->setInputFilter($formValidator->getInputFilter());
		$form->setData($prg); 
		//echo "nothing";
		//exit;
		if ($form->isValid()) {
			$data = $form->getData(); 
			//\Zend\Debug\Debug::dump($data); 
			//exit; 
			$service->addAllowance($data);
			$this->flashMessenger()->setNamespace('success')
			     ->addMessage('Employee allowance added successfully'); 
			$this->redirect ()->toRoute('employeefixedallowance',array (
					'action' => 'add'
			)); 
		} 
		
		return array(
				'form' => $form,
				$prg
		);
	}
	
	public function editAction() {
		
		$id = (int) $this->params()->fromRoute('id',0);
		$allowanceName = $this->params()->fromRoute('allowanceName',0); 
		if(!$id || !$allowanceName) {
			$this->flashMessenger()->setNamespace('info')
			                       ->addMessage('Allowance not found,Please Add');
			$this->redirect()->toRoute('employeefixedallowance',array(
					'action' => 'list'
			));  
		} 
		$service = $this->getEmployeeAllowanceService();
		$allowance = $service->fetchEmployeeAllowance($id,$allowanceName);
        //\Zend\Debug\Debug::dump($allowance); 
        //exit; 
		$form = $this->getEmployeeAllowanceUpdateForm();
		$form->bind($allowance);
		$form->get('effectiveDate')->setValue(date('Y-m-d'));
        
		$form->get('allowanceNameText')->setValue($allowanceName)
             ->setAttribute('readOnly', true)
		; 
		$form->get('submit')->setAttribute('value','Update Employee '.$allowanceName);
		$prg = $this->prg('/employeefixedallowance/edit/'.$id.'/'.$allowanceName, true);
		if ($prg instanceof Response ) {
			return $prg;
		} elseif ($prg === false) {
			return array ('form' => $form);
		}
		
		$formValidator = $this->getAllowanceFormValidator();
		$form->setInputFilter($formValidator->getInputFilter());
		$form->setData($prg); 
		//var_dump($prg); 
		if ($form->isValid()) {
			$data = $form->getData(); 
			//@todo , data received is ok
			//\Zend\Debug\Debug::dump($data);
			//exit;
			$service->updateAllowance($data); 
			$this->flashMessenger()->setNamespace('success')
			     ->addMessage('Employee Allowance '.$allowanceName.' updated successfully');
			$this->redirect ()->toRoute('employeefixedallowance',array (
					'action' => 'list'
			)); 
		} 
		return array(
				'form' => $form,
				$prg
		); 
	}   
	
	public function htmlResponse($html) {
		$response = $this->getResponse();
		$response->setStatusCode(200);
		$response->setContent($html);
		return $response;
	}
    
	private function getEmployeeAllowanceForm() {
		$form = new EmployeeAllowanceForm(); 
		$form->get('employeeId') 
		     ->setOptions(array('value_options' => $this->getEmployeeList()))
		     ->setAttribute('readOnly', true)
		; 
		$form->get('allowanceNameText')
		     ->setOptions(array('value_options' => $this->selectFixedAmountAllowanceList()))
		     ->setAttribute('readOnly', true)
		;
		return $form; 
	} 
	
	private function getEmployeeAllowanceUpdateForm() { 
		$form = new EmployeeAllowanceUpdateForm();
		$form->get('employeeId')
		     ->setOptions(array('value_options' => $this->getEmployeeList()))
		     ->setAttribute('readOnly', true)
		; 
		return $form;
	}
	
	// EmployeeAllowanceUpdateForm 
	private function getEmployeeAllowanceService() {
		return $this->getServiceLocator()->get('EmployeeAllowanceService');
	}
	
	private function getCompanyAllowanceService() {
		return $this->getServiceLocator()->get('companyAllowance');
	}
	
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	}
	
	private function getAllowanceFormValidator() {
		return new EmployeeAllowanceFormValidator(); 
	}
	
	private function getEmployeeAllowanceGrid() {
		return new EmployeeAllowanceGrid();
	}
	
	private function getEmployeeService() {
		return $this->getServiceLocator()->get('employeeMapper');
	}
    
	private function getEmployeeList() { 
		$company = $this->getServiceLocator()->get('company');
		$companyId = $company->getId();
		return $this->getEmployeeService()->employeeList($companyId);  
	}
	
	private function selectFixedAmountAllowanceList() {
		$companyAllowanceService = $this->getCompanyAllowanceService();
		return $companyAllowanceService->selectFixedAmountAllowance(); 
		
	}
    
}