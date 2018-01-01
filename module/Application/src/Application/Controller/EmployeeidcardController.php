<?php 

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response;
use Application\Form\IdCardForm;
use Application\Form\IdCardValidator;
use Application\Model\EmployeeIdCardGrid;

class EmployeeidcardController extends AbstractActionController {
	
	public function indexAction() { exit; }
	
	public function listAction() { }
	
	public function ajaxlistAction() {
		$grid = $this->getGrid();
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getAttendanceMapper()->selectIdCard())
		     ->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render());
	}
	
	public function addAction() {
		$form = $this->getForm();
		$prg = $this->prg('/employeeidcard/add', true);
		if ($prg instanceof Response ) {
			return $prg;
		} elseif ($prg === false) {
			return array ('form' => $form); 
		} 
		$formValidator = $this->getFormValidator();
		$form->setInputFilter($formValidator->getInputFilter());
		$form->setData($prg); 
		if ($form->isValid()) {
			$data = $form->getData();
			$service = $this->getService(); 
			$service->insert($data);
			$this->flashMessenger()->setNamespace('success')
			                       ->addMessage('Employee IdCard added successfully'); 
			$this->redirect ()->toRoute('employeeidcard',array (
					'action' => 'add'
			)); 
		}
		return array(
				'form' => $form,
				$prg
		);
	}
	
	public function editAction() { 
		 
		$id = (int) $this->params()->fromRoute('id', 0); 
		if (!$id) {
			$this->flashMessenger()->setNamespace('info')
			                       ->addMessage('Employee IdCard not found,Please Add');
			$this->redirect()->toRoute('employeeidcard', array(
					'action' => 'add'
			));  
		} 
		$form = $this->getForm();
		$service = $this->getService();
		$empIdCard = $service->fetchById($id);
		//\Zend\Debug\Debug::dump($empIdCard);
		//exit; 
		//$form = $this->getForm();
		$form->get('submit')->setAttribute('value','Update Employee Id Card');
		$form->bind($empIdCard);
		
		$prg = $this->prg('/employeeidcard/edit/'.$id, true);
		if ($prg instanceof Response ) {
			return $prg;
		} elseif ($prg === false) {
			return array ('form' => $form);
		}
		
		$formValidator = $this->getFormValidator();
		$form->setInputFilter($formValidator->getInputFilter());
		$form->setData($prg); 
		
		if ($form->isValid()) {
			$data = $form->getData();
			$service->update($data);
			$this->flashMessenger()->setNamespace('success')
			                       ->addMessage('Employee Id Card updated successfully');
			$this->redirect ()->toRoute('employeeidcard',array (
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
    
	private function getService() {
		
		return $this->getServiceLocator()->get('employeeIdCardMapper');
	}
	
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	}
	
	private function getForm() {
		$form = new IdCardForm(); 
		$form->get('employeeIdIdCard')
		     ->setOptions(array('value_options' =>
				$this->getEmployeeService()->employeeWholeList()))
		;
		return $form;  
	}
	
	private function getFormValidator() {
		return new IdCardValidator();
	}
	
	private function getGrid() {
		return new EmployeeIdCardGrid();
	}
	
	private function getEmployeeService() {
		return $this->getServiceLocator()->get('employeeService');
	}
	
	private function getAttendanceMapper() {
		return $this->getServiceLocator()->get('attendanceMapper'); 
	}
	
}