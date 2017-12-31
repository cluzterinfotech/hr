<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response;
use Employee\Form\LocationForm;
use Employee\Form\LocationFormValidator;
use Application\Model\LocationGrid;
use Application\Model\EmployeeAllowanceAmountGrid; 

class EmployeeallowanceamountController extends AbstractActionController {
	
	public function indexAction() { exit; }
	
	public function listAction() { }
	
	public function ajaxlistAction() {
		$grid = $this->getLocationGrid();
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getEmployeeAllowanceAmountService()->select())
		     ->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render());
	}
	
	public function addAction() {
		$form = $this->getLocationForm();
        
		$prg = $this->prg('/location/add', true);
		if ($prg instanceof Response ) {
			return $prg;
		} elseif ($prg === false) {
			return array ('form' => $form);
		}
		
		$formValidator = $this->getLocationFormValidator();
		$form->setInputFilter($formValidator->getInputFilter());
		$form->setData($prg);
		
		if ($form->isValid()) {
			$data = $form->getData();
			$service = $this->getLocationService(); 
			$service->insert($data);
			$this->flashMessenger()->setNamespace('success')
			                       ->addMessage('Location added successfully'); 
			$this->redirect ()->toRoute('location',array (
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
			                       ->addMessage('Location not found,Please Add');
			$this->redirect()->toRoute('location', array(
					'action' => 'add'
			)); 
		}
		$form = $this->getLocationForm();
		$service = $this->getLocationService();
		$location = $service->fetchById($id);
		$form = $this->getLocationForm();
		$form->bind($location);
		$form->get('submit')->setAttribute('value','Update Location');
		
		$prg = $this->prg('/location/edit/'.$id, true);
		if ($prg instanceof Response ) {
			return $prg;
		} elseif ($prg === false) {
			return array ('form' => $form);
		}
		
		$formValidator = $this->getLocationFormValidator();
		$form->setInputFilter($formValidator->getInputFilter());
		$form->setData($prg);
		
		if ($form->isValid()) {
			$data = $form->getData();
			$service->update($data);
			$this->flashMessenger()->setNamespace('success')
			                       ->addMessage('Location update successfully');
			$this->redirect ()->toRoute('location',array (
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
	
	
	private function getEmployeeAllowanceAmountService() {
		return $this->getServiceLocator()->get('EmployeeAllowanceAmountMapper');
	}
	
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	}
	
	private function getLocationForm() {
		return new LocationForm();
	}
	
	private function getLocationFormValidator() {
		return new LocationFormValidator();
	}
	
	private function getLocationGrid() {
		return new   EmployeeAllowanceAmountGrid();
	}
	
	//listing locations
	//add locations
	//edit locations
	//approval list
	//confirm approval
	
	//policy
	//Manual
	//Checklist
	
}


