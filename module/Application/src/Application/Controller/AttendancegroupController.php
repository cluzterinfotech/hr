<?php 

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response;
use Application\Form\BankForm;
use Application\Form\BankFormValidator; 
use Application\Model\AttendanceGroupGrid;
use Application\Form\AttendanceGroupForm;
use Application\Form\AttendanceGroupFormValidator;

class AttendancegroupController extends AbstractActionController {
	
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
		$prg = $this->prg('/attendancegroup/add', true);
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
			                       ->addMessage('Attendance Group added successfully'); 
			$this->redirect ()->toRoute('attendancegroup',array (
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
			                       ->addMessage('Group not found,Please Add');
			$this->redirect()->toRoute('attendancegroup', array(
					'action' => 'add'
			)); 
		}
		$form = $this->getForm();
		$service = $this->getService();
		$bank = $service->fetchById($id);
		$form = $this->getForm();
		$form->bind($bank);
		$form->get('submit')->setAttribute('value','Update Attendance Group');
		
		$prg = $this->prg('/attendancegroup/edit/'.$id, true);
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
			                       ->addMessage('Attendance group updated successfully');
			$this->redirect ()->toRoute('attendancegroup',array (
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
		return $this->getServiceLocator()->get('attendnanceGroupMapper');
	}
	
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	}
	
	private function getForm() {
	    return new AttendanceGroupForm(); 
	}
	
	private function getFormValidator() {
	    return new AttendanceGroupFormValidator(); 
	}
	
	private function getGrid() {
	    return new AttendanceGroupGrid(); 
	} 
}