<?php 

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response;
use Application\Model\AttendanceLocGroupGrid;
use Application\Form\LocationGroupForm;
use Application\Form\AttendanceLocGroupFormValidator;

class AttendancelocgroupController extends AbstractActionController {
	
	public function indexAction() { exit; }
	
	public function listAction() { }
	
	public function ajaxlistAction() {
		$grid = $this->getGrid();
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getService()->selectLocGroup())
		     ->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render());
	}
	 
	public function addAction() {
		$form = $this->getForm();
		$prg = $this->prg('/attendancelocgroup/add', true);
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
			                       ->addMessage('Location Group added successfully'); 
			$this->redirect ()->toRoute('attendancelocgroup',array (
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
			                       ->addMessage('Location Group not found,Please Add');
			$this->redirect()->toRoute('attendancelocgroup', array(
					'action' => 'add'
			)); 
		}
		$form = $this->getForm();
		$service = $this->getService();
		$bank = $service->fetchById($id);
		$form = $this->getForm();
		$form->bind($bank);
		$form->get('submit')->setAttribute('value','Update Location Group');
		
		$prg = $this->prg('/attendancelocgroup/edit/'.$id, true);
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
			                       ->addMessage('Location Group updated successfully');
			$this->redirect ()->toRoute('attendancelocgroup',array (
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
		return $this->getServiceLocator()->get('attendnanceLocGroupMapper');
	}
	
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	}
	
	private function getForm() {
	    $form = new LocationGroupForm();
	    $form->get('locationId')
	    ->setOptions(array('value_options' => $this->getLocationList())); 
	    $form->get('attendanceGroupId')
	    ->setOptions(array('value_options' => $this->getAttenGroupList())); 
	    return $form; 
	}
	
	private function getLocationList() {
	    return $this->getLookupService()->getLocationList();
	}
	
	private function getAttenGroupList() {
	    return $this->getLookupService()->getAttenGroupList();
	}
	
	private function getLookupService() {
	    return $this->getServiceLocator()->get('lookupService');
	} 
	
	private function getFormValidator() {
	    return new AttendanceLocGroupFormValidator(); 
	}
	
	private function getGrid() {
		return new AttendanceLocGroupGrid(); 
	}
    
}