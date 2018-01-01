<?php

namespace Payment\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response;
use Employee\Form\LocationForm;
use Employee\Form\LocationFormValidator; 
use Application\Model\LocationGrid; 
use Application\Model\PositionGroupGrid;
use Payment\Form\PositionGroupForm;
use Payment\Form\PositionGroupFormValidator;

class CarrentpositionController extends AbstractActionController {
	
	public function indexAction() { exit; }
	
	public function listAction() { }
	
	public function ajaxlistAction() {
		$grid = $this->getGrid();
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getCarRentPositionService()->selectPositionGroup())
		     ->setParamAdapter($this->getRequest()->getPost()); 
		return $this->htmlResponse($grid->render());
	}
	
	public function addAction() {
		$form = $this->getForm();
		$prg = $this->prg('/carrentposition/add', true);
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
			$service = $this->getCarRentPositionService();
			$service->insert($data);
			$this->flashMessenger()->setNamespace('success')
			     ->addMessage('Position Group added successfully');
			$this->redirect ()->toRoute('carrentposition',array (
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
			->addMessage('Position Group not found,Please Add');
			$this->redirect()->toRoute('carrentposition', array(
					'action' => 'add'
			));
		}
		//$form = $this->getForm();
		$service = $this->getCarRentPositionService();
		$location = $service->fetchById($id);
		$form = $this->getForm();
		$form->bind($location);
		$form->get('submit')->setAttribute('value','Update Position Group');
	
		$prg = $this->prg('/carrentposition/edit/'.$id, true);
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
			     ->addMessage('Location updated successfully');
			$this->redirect ()->toRoute('carrentposition',array (
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
		$form = new PositionGroupForm(); 
		$form->get('lkpCarRentGroupId')
		     ->setOptions(array('value_options' => $this->getPositionLkpGroup()))
		//->setAttribute('readOnly', true)
		;  
		$form->get('positionId')
		     ->setOptions(array('value_options' => $this->getPositionList()))
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
		return new PositionGroupFormValidator();
	}
	
	private function getPositionLkpGroup() { 
		return $this->getPositionGroupService()->lkpPositionGroupList();  
	}  
	
	private function getPositionGroupService() { 
		return $this->getServiceLocator()->get('carRentGroupMapper'); 
	}
	
	private function getCarRentPositionService() {
		return $this->getServiceLocator()->get('carRentPositionMapper');
	}   
	
	private function getGrid() {
		return new PositionGroupGrid();
	}
	
	
}