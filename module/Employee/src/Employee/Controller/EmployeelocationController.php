<?php

namespace Employee\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response;
use Employee\Form\LocationForm;
use Employee\Form\LocationFormValidator;
use Application\Model\LocationGrid;
use Application\Model\EmployeeLocationGrid;
use Employee\Form\EmployeeLocationForm;
use Employee\Form\EmployeeLocationFormValidator;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManager;

class EmployeelocationController extends AbstractActionController {
	
	protected $eventManager;
	
	public function indexAction() { exit; }
	
	public function listAction() { }
	
	public function ajaxlistAction() {
		$grid = $this->getEmployeeLocationGrid();
		$company = $this->getServiceLocator()->get('company');
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getEmployeeLocationService()
		     		->employeeLocationList($company))
		     ->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render());
	}
	
	public function addAction() {
		$this->redirect ()->toRoute('employeelocation',array (
				'action' => 'list'
		));
		/*
		$form = $this->getLocationForm();
        
		$prg = $this->prg('/employeelocation/add', true);
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
			$this->redirect ()->toRoute('employeelocation',array (
					'action' => 'add'
			));
		}
		
		return array(
				'form' => $form,
				$prg
		);*/
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
		//$form = $this->getLocationForm();
		$service = $this->getEmployeeLocationService();
		$location = $service->fetchById($id);
        //\Zend\Debug\Debug::dump($location);
        //exit; 
		$form = $this->getEmployeeLocationForm();
		$form->bind($location);
		$form->get('effectiveDate')->setValue(date('Y-m-d'));
		$form->get('submit')->setAttribute('value','Update Employee Location');
		
		$prg = $this->prg('/employeelocation/edit/'.$id, true);
		if ($prg instanceof Response ) {
			return $prg;
		} elseif ($prg === false) {
			return array ('form' => $form);
		} 
		
		$formValidator = $this->getLocationFormValidator();
		$form->setInputFilter($formValidator->getInputFilter());
		$form->setData($prg); 
		//var_dump($prg); 
		if ($form->isValid()) {
			$data = $form->getData(); 
			//\Zend\Debug\Debug::dump($data); 
			//exit;  
			$allowanceByCalcService = $this->getServiceLocator()->get('locationService');
			$allowanceByCalcService->updateEmployeeLocation($data); 
			$this->flashMessenger()->setNamespace('success')
			                       ->addMessage('Employee Location updated successfully');
			$this->redirect ()->toRoute('employeelocation',array (
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
    
	private function getLocationService() {
		return $this->getServiceLocator()->get('locationMapper');
	}
	
	private function getEmployeeLocationService() {
		return $this->getServiceLocator()->get('EmployeeLocationMapper');
	}
	
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	}
	
	//private function getLocationForm() {
		// return new LocationForm();
		//return new EmployeeLocationForm();
	//}
	
	private function getEmployeeLocationForm() {
		$form = new EmployeeLocationForm();
		$form->get('employeeNumber')
		     ->setOptions(array('value_options' => $this->getEmployeeList()))
		     //->setAttribute('readOnly', true)
		;
		$form->get('empLocation')
		     ->setOptions(array('value_options'=> $this->getLocationList()))
		     //->setAttribute('readOnly', true)
		; 
		return $form;
	}
	
	private function getLocationFormValidator() {
		return new EmployeeLocationFormValidator();
	}
	
	private function getLocationGrid() {
		return new LocationGrid();
	}
	
	private function getEmployeeLocationGrid() {
		return new EmployeeLocationGrid();
	}
	
	private function getEmployeeService() {
		return $this->getServiceLocator()->get('employeeMapper');
	}
    
	private function getEmployeeList() { 
		$company = $this->getServiceLocator()->get('company');
		$companyId = $company->getId();
		return $this->getEmployeeService()->employeeList($companyId); 
	}
	
	private function employeeWholeList() {
		return $this->getEmployeeService()->employeeWholeList();
	}
	
	private function getLocationList() {
		return $this->getLocationService()->locationList();  
	} 
}