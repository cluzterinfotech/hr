<?php

namespace Payment\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response;
use Employee\Form\LocationForm;
use Employee\Form\LocationFormValidator;
use Application\Model\LocationGrid;
use Application\Model\PositionLkpGroupGrid;
use Payment\Form\PositionGroupLkpForm;
use Employee\Form\CarRentGroupFormValidator;

class CarrentgroupController extends AbstractActionController {
	
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
		$prg = $this->prg('/carrentgroup/add', true);
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
			                       ->addMessage('Car Rent Group added successfully'); 
			$this->redirect ()->toRoute('carrentgroup',array (
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
			$this->redirect()->toRoute('carrentgroup', array(
					'action' => 'add'
			)); 
		}
		$form = $this->getForm();
		$service = $this->getService();
		$location = $service->fetchById($id);
		$form = $this->getForm();
		$form->bind($location);
		$form->get('submit')->setAttribute('value','Update Car Rent Group');
		
		$prg = $this->prg('/carrentgroup/edit/'.$id, true);
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
			                       ->addMessage('Car Rent Group updated successfully');
			$this->redirect ()->toRoute('carrentgroup',array (
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
		return $this->getServiceLocator()->get('carRentGroupMapper'); 
	}
	
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	} 
	
	private function getForm() {
		return new PositionGroupLkpForm();
	}
	
	private function getFormValidator() {
		return new CarRentGroupFormValidator();
	}
	
	private function getGrid() {
		return new PositionLkpGroupGrid();  
	}
    
	//listing locations
	//add locations
	//edit locations
	
	//policy
	//Manual
	//Checklist
}