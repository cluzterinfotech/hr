<?php 

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response; 
use Application\Model\AttendanceGroupHrsGrid;
use Application\Form\GroupWorkHoursForm;
use Application\Form\GroupWorkHoursFormValidator;

class AttendancegrpworkhrsController extends AbstractActionController {
	
	public function indexAction() { exit; }
	
	public function listAction() { }
	
	public function ajaxlistAction() {
		$grid = $this->getGrid();
		$grid->setAdapter($this->getDbAdapter())
		->setSource($this->getService()->selectGroupHrs())
		     ->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render());
	}
	 
	public function addAction() {
		$form = $this->getForm();
		$prg = $this->prg('/attendancegrpwrkhrs/add', true);
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
			                       ->addMessage('Group Work Hours added successfully'); 
			$this->redirect ()->toRoute('attendancegrpwrkhrs',array (
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
			                       ->addMessage('Group Work Hours not found,Please Add');
			$this->redirect()->toRoute('attendancegrpwrkhrs', array('action' => 'add')); 
		}
		$form = $this->getForm();
		$service = $this->getService();
		$bank = $service->fetchById($id);
		$form = $this->getForm();
		$form->bind($bank);
		$form->get('submit')->setAttribute('value','Update Group Work Hours');
		$prg = $this->prg('/attendancegrpwrkhrs/edit/'.$id, true);
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
			                       ->addMessage('Group Work Hours updated successfully');
			$this->redirect ()->toRoute('attendancegrpwrkhrs',array (
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
		return $this->getServiceLocator()->get('attendnanceGroupHrsMapper');
	}
	
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	}
	
	private function getForm() {
		$form = new GroupWorkHoursForm(); 
		$form->get('eventId')
		     ->setOptions(array('value_options' => $this->getEventList())); 
		$form->get('DayName')
		     ->setOptions(array('value_options' => $this->dayList()));
		$form->get('locationGroup')
		     ->setOptions(array('value_options' => $this->getAttenGroupList())); 
		
		return $form; 
	}
	
	private function dayList() {
	    return $this->getLookupService()->dayList();
	}
	
	private function getEventList() {
	    return $this->getLookupService()->getEventList();
	}
	
	private function getAttenGroupList() {
	    return $this->getLookupService()->getAttenGroupList();
	}
	
	private function getLookupService() {
	    return $this->getServiceLocator()->get('lookupService');
	}
	
	private function getFormValidator() {
		return new GroupWorkHoursFormValidator(); 
	}
	
	private function getGrid() {
	    return new AttendanceGroupHrsGrid(); 
	}
    
}