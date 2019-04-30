<?php 

namespace Position\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response;
use Application\Form\EmployeeTypeForm;
use Application\Form\EmployeeTypeFormValidator;
use Application\Model\EmployeeTypeGrid;

class EmployeetypeController extends AbstractActionController {
	
	public function indexAction() { exit; }
	
	public function listAction() { }
	
	public function ajaxlistAction() {
		$grid = $this->getGrid();
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getService()->select())
		     ->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render());
	}
	
	public function addAction() {
		$form = $this->getForm();
		$prg = $this->prg('/employeetype/add', true);
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
			                       ->addMessage('employeetype added successfully'); 
			$this->redirect ()->toRoute('employeetype',array (
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
			                       ->addMessage('employeetype not found,Please Add');
			$this->redirect()->toRoute('employeetype', array(
					'action' => 'add'
			)); 
		}
		$form = $this->getForm();
		$service = $this->getService();
		$employeetype = $service->fetchById($id); 
		$form = $this->getForm();
		$form->bind($employeetype);
		$form->get('submit')->setAttribute('value','Update employeetype');
		
		$prg = $this->prg('/employeetype/edit/'.$id, true);
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
			                       ->addMessage('employeetype updated successfully');
			$this->redirect ()->toRoute('employeetype',array (
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
    
	private function getLookupService() {
		return $this->getServiceLocator()->get('lookupService');
	}
	
	private function getDepartmentList() {
		return $this->getLookupService()->getDepartmentList(); 
	}
	
	private function getService() {
		return $this->getServiceLocator()->get('employeeTypeMapper');
	}
	
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	}
	
	private function getForm() {
		return new EmployeeTypeForm();
		
		//return $form; 
	}
	
	private function getFormValidator() {
		return new EmployeeTypeFormValidator();
	}
	
	private function getGrid() {
		return new EmployeeTypeGrid();
	}
    
}