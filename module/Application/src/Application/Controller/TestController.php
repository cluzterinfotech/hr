<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response;
use Employee\Form\LocationForm;
use Employee\Form\LocationFormValidator;
use Application\Model\LocationGrid;

class TestController extends AbstractActionController {
	
	public function indexAction() { exit; }
	
	public function listAction() { }
	
	public function ajaxlistAction() {
		$grid = $this->getLocationGrid();
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getLocationService()->select())
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
			                       ->addMessage('Location updated successfully');
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
    
	private function getLocationService() {
		return $this->getServiceLocator()->get('locationMapper');
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
		return new LocationGrid();
	}
    
	public function swapidAction() {
		
	    $service = $this->getServiceLocator()->get('locationMapper');
	    $mappingList = $service->getMappingList();
	    
	    foreach($mappingList as $list) {
	    	$table = 'NatureofWork'; 
	    	//\Zend\Debug\Debug::dump($list['id_in_hr']);
	    	//\Zend\Debug\Debug::dump($list['is_in_new_system']);
	    	$res = $service->isHaveId($table,$list['id_in_hr']); 
	    	//\Zend\Debug\Debug::dump($res); 
	    	if($res) { 
	    	    $service->updateEmployeeIds($table,$list['id_in_hr'],$list['is_in_new_system']);
	    	}
	    }
	    echo "migrated successfully"; 
	    exit;         
	}
     
	
	//listing locations
	//add locations
	//edit locations
	
	//policy
	//Manual
	//Checklist
}