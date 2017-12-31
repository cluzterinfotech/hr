<?php 

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response;
use Application\Form\IdCardForm;
use Application\Form\IdCardValidator;
use Application\Model\ChecklistGrid;
use Application\Model\CurrentChecklistGrid;

class ChecklistController extends AbstractActionController {
	
	public function indexAction() { exit; }
	
	public function listAction() { }
	
	public function ajaxlistAction() {
		$grid = $this->getGrid();
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getService()->selectChecklist())
		     ->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render());
	}
	
	public function currentlistAction() { }
	
	public function ajaxlistcurrentAction() {
		$grid = $this->getCurrentGrid();
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getService()->selectChecklistCurrent())
		     ->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render());
	} 
	
	/*public function addAction() {
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
			                       ->addMessage('Location added successfully'); 
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
		$location = $service->fetchById($id);
		$form = $this->getForm();
		$form->bind($location);
		$form->get('submit')->setAttribute('value','Update Employee Id Card');
		
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
	} */ 
	
	public function htmlResponse($html) {
		$response = $this->getResponse();
		$response->setStatusCode(200);
		$response->setContent($html);
		return $response;
	}
    
	private function getService() {
		return $this->getServiceLocator()->get('checkListService'); 
	}
	
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	}
	
	private function getForm() {
		$form = new IdCardForm();
		$form->get('employeeidCardName')
		     ->setOptions(array('value_options' =>
				$this->getEmployeeService()->employeeList()))
		;
		return $form;  
	}
	
	private function getFormValidator() {
		return new IdCardValidator();
	}
	
	private function getGrid() {
		return new ChecklistGrid();
	}
	
	private function getCurrentGrid() {
		return new CurrentChecklistGrid();
	}
	
	private function getEmployeeService() {
		return $this->getServiceLocator()->get('employeeService');
	}
	
	private function getAttendanceMapper() {
		return $this->getServiceLocator()->get('attendanceMapper'); 
	}
	
	
    
    
}