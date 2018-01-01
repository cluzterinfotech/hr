<?php 

namespace Lbvf\Controller;

use Zend\Mvc\Controller\AbstractActionController; 
use Zend\Http\PhpEnvironment\Response; 
use Lbvf\Form\NominationForm;
use Lbvf\Form\NominationFormValidator;
use Application\Model\NominationGrid;

class NominationController extends AbstractActionController {
	
	public function indexAction() { exit; } 
	
	public function listAction() { }
	
	public function ajaxlistAction() {
		$grid = $this->getGrid();
		$userInfo = $this->getUserInfoService();
		$empId = '14';//$this->getUserInfoService()->getEmployeeId();
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getService()->selectById($empId))
		     ->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render());
	}   
	
	public function addAction() {
		$form = $this->getForm();
		$prg = $this->prg('/nomination/add', true);
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
			     ->addMessage('Nomination Form added successfully');
			$this->redirect ()->toRoute('nomination',array (
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
			     ->addMessage('Nomination not found,Please Add');
			$this->redirect()->toRoute('nomination', array(
					'action' => 'add'
			));
		}
		$form = $this->getForm();
		$service = $this->getService();
		$location = $service->fetchById($id);
		$form = $this->getForm();
		$form->bind($location);
		$form->get('submit')->setAttribute('value','Update Form');
	
		$prg = $this->prg('/nomination/edit/'.$id, true); 
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
			     ->addMessage('Nomination updated successfully');
			$this->redirect ()->toRoute('nomination',array (
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
		return $this->getServiceLocator()->get('nominationMapper');  
	}
	
	private function getUserInfoService() {
		return $this->getServiceLocator()->get('userInfoService');
	}
	
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	}
	
	private function getEmployeeService() {
		return $this->getServiceLocator()->get('employeeService');
	}
	
	private function getEmployeeWithDelegatedList() {
		//$employeeService = $this->getEmployeeService();
		return $this->getEmployeeService()->employeeWithDelegatedList();
	}
	
	private function getForm() {
		$form = new NominationForm(); 
		$form->get('employeeNumber')
		     ->setOptions(array('value_options' => $this->getEmployeeWithDelegatedList()
		));  
		     
		$form->get('SuperiorName')
		     ->setOptions(array('value_options' => $this->getEmployeeList()
		));
		$form->get('OthSuperiorName')
		     ->setOptions(array('value_options' => $this->getEmployeeList()
		));
		$form->get('Subordinate01')
		     ->setOptions(array('value_options' => $this->getEmployeeList()
		));
		$form->get('Subordinate02')
		     ->setOptions(array('value_options' => $this->getEmployeeList()
		));
		$form->get('Subordinate03')
		     ->setOptions(array('value_options' => $this->getEmployeeList()
		));
		$form->get('Subordinate04')
		     ->setOptions(array('value_options' => $this->getEmployeeList()
		));
		$form->get('Subordinate05')
		     ->setOptions(array('value_options' => $this->getEmployeeList()
		));
		$form->get('Subordinate06')
		     ->setOptions(array('value_options' => $this->getEmployeeList()
		));
		$form->get('Subordinate07')
		     ->setOptions(array('value_options' => $this->getEmployeeList()
		));
		$form->get('Subordinate08')
		     ->setOptions(array('value_options' => $this->getEmployeeList()
		));
		$form->get('Subordinate09')
		     ->setOptions(array('value_options' => $this->getEmployeeList()
		));
		$form->get('Subordinate10')
		     ->setOptions(array('value_options' => $this->getEmployeeList()
		));
		$form->get('Peers01')
		     ->setOptions(array('value_options' => $this->getEmployeeList()
		));
		$form->get('Peers02')
		     ->setOptions(array('value_options' => $this->getEmployeeList()
		));
		$form->get('Peers03')
		     ->setOptions(array('value_options' => $this->getEmployeeList()
		)); 
		return $form; 
	}
	
	private function getEmployeeList() {
		$company = $this->getServiceLocator()->get('company');
		$companyId = $company->getId();
		return $this->getEmployeeService()->employeeList($companyId);
	} 
	
	private function getFormValidator() {
		return new NominationFormValidator(); 
	}
	
	private function getGrid() {
		return new NominationGrid(); 
	} 
}   