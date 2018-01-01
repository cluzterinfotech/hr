<?php 

namespace Leave\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response;
use Leave\Form\LeaveAdminForm; 
use Leave\Form\LeaveAdminFormValidator;
use Application\Model\LeaveAdminGrid;

class LeaveadminController extends AbstractActionController {
	
	public function indexAction() { exit; }
	
	public function listAction() { }
	
	public function ajaxlistAction() {
		$grid = $this->getGrid();
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getService()->selectAdminLeave())
		     ->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render());
	}
	
	public function addAction() {
		$form = $this->getForm();
		$prg = $this->prg('/leaveadmin/add', true);
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
			$service->insertAdminLeave($data);
			$this->flashMessenger()->setNamespace('success')
			                       ->addMessage('Leave added successfully'); 
			$this->redirect ()->toRoute('leaveadmin',array (
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
			                       ->addMessage('Leave not found,Please Add');
			$this->redirect()->toRoute('leaveadmin', array(
					'action' => 'add'
			)); 
		}
		$form = $this->getForm();
		$service = $this->getService();
		$Leave = $service->fetchAdminLeaveById($id);
		$form = $this->getForm();
		$form->bind($Leave);
		$form->get('submit')->setAttribute('value','Update Leave');
		
		$prg = $this->prg('/leaveadmin/edit/'.$id, true);
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
			$service->updateAdminLeave($data);
			$this->flashMessenger()->setNamespace('success')
			                       ->addMessage('Leave updated successfully');
			$this->redirect ()->toRoute('leaveadmin',array (
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
		return $this->getServiceLocator()->get('leaveService'); 
	}
	
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	}
	
	private function getForm() {
		$form = new LeaveAdminForm(); 
		$company = $this->getServiceLocator()->get('company');
		$companyId = $company->getId();
		$form->get('employeeId')
		     ->setOptions(array('value_options' =>
				$this->getEmployeeService()->employeeList($companyId)))
		;
		$form->get('LkpLeaveTypeId')
		     ->setOptions(array('value_options' =>
		     		$this->getLeaveType()))
		;
		return $form; 
	}
	
	private function getEmployeeService() {
		return $this->getServiceLocator()->get('employeeService');
	}
	
	private function getLeaveType() {
		return $this->getLookupService()->getLeaveType(); 
	}
	
	private function getLookupService() {
		return $this->getServiceLocator()->get('lookupService');
	}
	
	private function getFormValidator() {
		return new LeaveAdminFormValidator();
	}
	
	private function getGrid() {
		return new LeaveAdminGrid();
	}
    
}