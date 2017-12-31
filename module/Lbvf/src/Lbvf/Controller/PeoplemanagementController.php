<?php

namespace Lbvf\Controller;

use Zend\Mvc\Controller\AbstractActionController; 
use Zend\Http\PhpEnvironment\Response; 
use Application\Model\PeopleManagementGrid;  
use Lbvf\Form\PeopleManagementForm;
use Lbvf\Form\PeopleManagementFormValidator;

class PeoplemanagementController extends AbstractActionController {
	
	public function indexAction() { exit; } 
	
	public function listAction() { }
	
	public function ajaxlistAction() {
		$grid = $this->getGrid();
		//$userInfo = $this->getUserInfoService();
		$empId = $this->getUserInfoService()->getEmployeeId();
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getService()->selectById($empId))
		     ->setParamAdapter($this->getRequest()->getPost()); 
		return $this->htmlResponse($grid->render()); 
	}      
	
	public function addAction() {
		$form = $this->getForm();
		$prg = $this->prg('/peoplemanagement/add', true);
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
			     ->addMessage('People management Staff Invovement Form added successfully');
			$this->redirect ()->toRoute('peoplemanagement',array (
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
			->addMessage('People management Staff Invovement not found,Please Add');
			$this->redirect()->toRoute('peoplemanagement', array(
					'action' => 'add'
			));
		}
		$form = $this->getForm();
		$service = $this->getService();
		$location = $service->fetchById($id);
		$form = $this->getForm();
		$form->bind($location);
		$form->get('submit')->setAttribute('value','Update Form');
	
		$prg = $this->prg('/peoplemanagement/edit/'.$id, true);
		if ($prg instanceof Response ) {
			return $prg;
		} elseif ($prg === false) {
			return array ('form' => $form);
		}
	
		$formValidator = $this->getFormValidator();
		$form->setInputFilter($formValidator->getInputFilter());
		$form->setData($prg);
		//\Zend\Debug\Debug::dump($form);
		if ($form->isValid()) {
			$data = $form->getData();
			//\Zend\Debug\Debug::dump($data);
			//exit; 
			$service->update($data);
			$this->flashMessenger()->setNamespace('success')
			     ->addMessage('People management Staff Invovement updated successfully');
			$this->redirect ()->toRoute('peoplemanagement',array (
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
		return $this->getServiceLocator()->get('peopleManagementMapper');  
	}
	
	private function getUserInfoService() {
		return $this->getServiceLocator()->get('userInfoService');
	}
	
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	}
	
	private function getForm() {
		$form = new PeopleManagementForm();  
		$form->get('employeeNumber')
		     ->setOptions(array('value_options' => $this->getEmployeeWithDelegatedList()
		));
		$form->get('Role01')
		     ->setOptions(array('value_options' => $this->lbvfRoleList()
		));
		$form->get('lOI01')
		     ->setOptions(array('value_options' => $this->lbvfLoiList()
		)); 
		$form->get('Role02')
		     ->setOptions(array('value_options' => $this->lbvfRoleList()
		));
		$form->get('lOI02')
		     ->setOptions(array('value_options' => $this->lbvfLoiList()
		));
		$form->get('Role03')
		     ->setOptions(array('value_options' => $this->lbvfRoleList()
		));
		$form->get('lOI03')
		     ->setOptions(array('value_options' => $this->lbvfLoiList()
		));
		$form->get('Role04')
		     ->setOptions(array('value_options' => $this->lbvfRoleList()
		));
		$form->get('lOI04')
		     ->setOptions(array('value_options' => $this->lbvfLoiList()
		));
		$form->get('Role05')
		     ->setOptions(array('value_options' => $this->lbvfRoleList()
		));
		$form->get('lOI05')
		     ->setOptions(array('value_options' => $this->lbvfLoiList()
		));
		return $form;  
	}   
	
	private function getEmployeeService() {
		return $this->getServiceLocator()->get('employeeService');
	}
	
	private function getEmployeeWithDelegatedList() {
		//$employeeService = $this->getEmployeeService();
		return $this->getEmployeeService()->employeeWithDelegatedList();
	}
	
	/*private function getEmployeeList() {
		$company = $this->getServiceLocator()->get('company');
		$companyId = $company->getId();
		return $this->getEmployeeService()->employeeList($companyId);
	}*/
	
	private function getLookupService() {
		return $this->getServiceLocator()->get('lookupService');
	}
	
	private function lbvfRoleList() {
		return $this->getLookupService()->lbvfRoleList();
	}
	
	private function lbvfLoiList() {
		return $this->getLookupService()->lbvfLoiList();
	}
	
	private function getFormValidator() {
		return new PeopleManagementFormValidator(); 
	}
	
	private function getGrid() {
		return new PeopleManagementGrid();
	} 
}   