<?php 

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response; 
use Application\Form\BabyCareForm;
use Application\Form\BabyCareFormValidator;
use Application\Model\AttendanceEventGrid;
use Application\Form\AttendanceEventForm;
use Application\Form\EventFormValidator;

class AttendanceeventController extends AbstractActionController {
	
	public function indexAction() { exit; }
	
	public function listAction() { }
	
	public function ajaxlistAction() {
		$grid = $this->getGrid();
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getService()->select())
		     ->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render());
	}
	
	private function getGrid() {
		return new AttendanceEventGrid(); 
	} 
	
	private function getService() {
		return $this->getServiceLocator()->get('attendanceEventMapper');
	}
	
	private function getEmployeeService() {
		return $this->getServiceLocator()->get('employeeService');
	} 
	
	public function addAction() {
		$form = $this->getForm();
		$prg = $this->prg('/attendanceevent/add', true);
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
			                       ->addMessage('Event added successfully'); 
			$this->redirect ()->toRoute('attendanceevent',array (
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
			                       ->addMessage('Event not found,Please Add');
			$this->redirect()->toRoute('attendanceevent', array(
					'action' => 'add'
			)); 
		}
		$form = $this->getForm();
		$service = $this->getService();
		$department = $service->fetchById($id); 
		$form = $this->getForm();
		$form->bind($department);
		$form->get('submit')->setAttribute('value','Update Event');
		
		$prg = $this->prg('/attendanceevent/edit/'.$id, true);
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
			                       ->addMessage('Event updated successfully');
			$this->redirect ()->toRoute('attendanceevent',array (
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
    
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	}
	
	private function getForm() {
	    return new AttendanceEventForm(); 
	}
	
	private function getFormValidator() {
	    return new EventFormValidator();
	}
	
	public function updateRowAction()
	{
		$param = $this->getRequest()->getPost();
		$arr = array(
			'noOfMinutes' => $param['value'],
			'id' => $param['row']
		);   
        $this->getService()->update($arr); 
		return $this->jsonResponse(array('succes' => 1)); 
	} 
    
	public function jsonResponse($data)
	{
		if(!is_array($data)){
			throw new \Exception('$data param must be array');
		} 
		$response = $this->getResponse();
		$response->setStatusCode(200);
		$response->setContent(json_encode($data));
		return $response;
	} 
}