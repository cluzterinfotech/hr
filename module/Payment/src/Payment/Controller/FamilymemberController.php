<?php

namespace Payment\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response;
use Payment\Form\FamilyMemberForm;
use Payment\Form\FamilyMemberFormValidator; 
use Application\Model\FamilyMemberGrid;

class FamilymemberController extends AbstractActionController {
	
	public function indexAction() { exit; }
	
	public function listAction() { }
	
	public function ajaxlistAction() {
		$grid = $this->getGrid();
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getService()->selectFamilyMember())
		     ->setParamAdapter($this->getRequest()->getPost()); 
		return $this->htmlResponse($grid->render());
	}
	
	public function addAction() {
		$form = $this->getForm();
		$prg = $this->prg('/familymember/add', true);
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
			     ->addMessage('Family Member added successfully');
			$this->redirect ()->toRoute('familymember',array (
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
			->addMessage('Family member not found,Please Add');
			$this->redirect()->toRoute('familymember', array(
					'action' => 'add'
			));
		}
		//$form = $this->getForm();
		$service = $this->getService();
		$location = $service->fetchById($id);
		$form = $this->getForm();
		$form->bind($location);
		$form->get('submit')->setAttribute('value','Update Family Member');
	
		$prg = $this->prg('/familymember/edit/'.$id, true);
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
			     ->addMessage('Family Member updated successfully');
			$this->redirect ()->toRoute('familymember',array (
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
	
	
	
	/*private function getLocationService() {
		return $this->getServiceLocator()->get('locationMapper');
	}*/ 
	
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter'); 
	} 
	
	private function getForm() {
		$form = new FamilyMemberForm(); 
		$company = $this->getServiceLocator()->get('company');
		$companyId = $company->getId();
		$form->get('employeeId')
		     ->setOptions(array('value_options' => 
		     		$this->getEmployeeService()->employeeList($companyId)))
		//->setAttribute('readOnly', true)
		;  
		$form->get('memberTypeId')
		     ->setOptions(array('value_options' => $this->getMemberType()))
		//->setAttribute('readOnly', true)
		;  
		return $form;   
	}
	
	private function getPositionList() {
		return $this->getPositionService()->getPositionList();
	}
	
	private function getPositionService() {
		return $this->getServiceLocator()->get('positionService');
	}
	
	private function getFormValidator() {
		return new FamilyMemberFormValidator();
	}
	
	private function getLookupService() {
		return $this->getServiceLocator()->get('lookupService');
	}
	
	private function getEmployeeService() {
		return $this->getServiceLocator()->get('employeeService');
	}
	
	private function getMemberType() { 
		return $this->getLookupService()->memberTypeList();  
	}  
    
	private function getService() {
		return $this->getServiceLocator()->get('familyMemberMapper');
	}   
	
	private function getGrid() {
		return new FamilyMemberGrid();
	}
	
	
}