<?php 

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response;
use Application\Model\AttendanceEventDurationGrid;
use Application\Form\EventDurationForm;
use Application\Form\EventDurationFormValidator;

class AttendanceeventdurationController extends AbstractActionController {
	
	public function indexAction() { exit; }
	
	public function listAction() { }
	
	public function ajaxlistAction() {
		$grid = $this->getGrid();
		$grid->setAdapter($this->getDbAdapter())
		->setSource($this->getService()->selectEventDuration())
		     ->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render());
	}
	
	public function addAction() {
		$form = $this->getForm();
		$prg = $this->prg('/attendanceeventduration/add', true);
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
			                       ->addMessage('Event Duration added successfully'); 
			$this->redirect ()->toRoute('attendanceeventduration',array (
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
			$this->redirect()->toRoute('attendanceeventduration', array(
					'action' => 'add'
			)); 
		}
		$form = $this->getForm();
		$service = $this->getService();
		$bank = $service->fetchById($id);
		$form = $this->getForm();
		$form->bind($bank);
		$form->get('submit')->setAttribute('value','Update Event Duration');
		
		$prg = $this->prg('/attendanceeventduration/edit/'.$id, true);
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
			                       ->addMessage('Event Duration updated successfully');
			$this->redirect ()->toRoute('attendanceeventduration',array (
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
		return $this->getServiceLocator()->get('eventDurationMapper');
	}
	
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	}
	
	private function getForm() {
		$form = new EventDurationForm(); 
		//$form->get('attendanceGroupId')
		  //->setOptions(array('value_options' => $this->getAttenGroupList())); 
		$form->get('eventId')
		     ->setOptions(array('value_options' => $this->getEventList())); 
		return $form;  
	}
	
	private function getEventList() {
	    return $this->getLookupService()->getEventList();
	}
	
	private function getLookupService() {
	    return $this->getServiceLocator()->get('lookupService');
	}
	
	private function getFormValidator() {
	    return new EventDurationFormValidator(); 
	}
	
	private function getGrid() {
		return new AttendanceEventDurationGrid();  
	}
    
}