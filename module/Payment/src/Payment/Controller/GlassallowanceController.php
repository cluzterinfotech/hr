<?php

namespace Payment\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response;
use Payment\Form\GlassAllowanceForm;
use Payment\Form\GlassAllowanceFormValidator;
use Application\Model\GlassAllowanceGrid;

class GlassallowanceController extends AbstractActionController {
	
	public function indexAction() { exit; }
	
	public function listAction() { }
	
	public function ajaxlistAction() {
		$grid = $this->getGrid();
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getService()->selectglassallowance())
		     ->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render());
	}
	
	public function addAction() {
		$form = $this->getForm();
		$prg = $this->prg('/glassallowance/add',true);
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
			                       ->addMessage('Glass Allowance added successfully'); 
			$this->redirect ()->toRoute('glassallowance',array (
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
			$this->redirect()->toRoute('glassallowance', array(
					'action' => 'add'
			)); 
		}
		$form = $this->getForm();
		$service = $this->getService();
		$location = $service->fetchById($id);
		$form = $this->getForm();
		$form->bind($location);
		$form->get('submit')->setAttribute('value','Update Glass Allowance');
		
		$prg = $this->prg('/glassallowance/edit/'.$id, true);
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
			// Check is have  
			$service->update($data);
			$this->flashMessenger()->setNamespace('success')
			                       ->addMessage('Glass Allowance updated successfully');
			$this->redirect ()->toRoute('glassallowance',array (
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
		return $this->getServiceLocator()->get('glassAllowanceMapper'); 
	}
	
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	} 
	
	private function getForm() {
		$form = new GlassAllowanceForm(); 
		$form->get('familyMemberId')
		     ->setOptions(array('value_options' => $this->getMembersList()))
		//->setAttribute('readOnly', true)
		;
		return $form;
	}
	
	private function getMembersList() {
	    return $this->getService()->lkpFamilyMembersList();	
	}
	
	private function getFormValidator() {
		return new GlassAllowanceFormValidator();
	}
	
	private function getGrid() {
		return new GlassAllowanceGrid();  
	}
    
	//listing locations
	//add locations
	//edit locations
	
	//policy
	//Manual
	//Checklist
}