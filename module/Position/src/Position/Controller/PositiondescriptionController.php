<?php

namespace Position\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response;
use Position\Form\PositionDescriptionForm;
use Position\Form\PositionDescriptionFormValidator;
use Position\Grid\PositionDescriptionGrid;
use Zend\View\Model\JsonModel;
     
class PositiondescriptionController extends AbstractActionController {
    
	public function indexAction() {  
		exit;  
	} 
    
	public function listAction() { }  
    
	public function ajaxlistAction() { 
	    
		$grid = $this->getGrid();
		//return $this->htmlResponse("text"); 
		//\Zend\Debug\Debug::dump($this->getService()); 
		//exit;
		// chages applied 
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getService()->selectPositionDescriptionList())
		     ->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render()); 
	}
    
	public function addAction() {
		$form = $this->getForm(); 
		$prg = $this->prg('/positiondescription/add', true);
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
			//\Zend\Debug\Debug::dump($data); 
			//exit; 
			$service->insert($data);
			$this->flashMessenger()
			     ->setNamespace('success')
			     ->addMessage('positiondescription added successfully');
			$this->redirect()->toRoute('positiondescription',array (
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
			$this->flashMessenger()
			     ->setNamespace('info')
			     ->addMessage('positiondescription not found,Please Add');
			$this->redirect()->toRoute('positiondescription', array(
					'action' => 'add'
			));
		}
		
		$form = $this->getForm();
		$service = $this->getService();
		$values = $service->fetchById($id);
        
		$form->bind($values);
		$form->get('submit')->setAttribute('value','Update positiondescription');
        
		$prg = $this->prg('/positiondescription/edit/'.$id, true);
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
			$this->flashMessenger()
			     ->setNamespace('success')
			     ->addMessage('positiondescription updated successfully');
			$this->redirect ()->toRoute('positiondescription',array (
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
		return $this->getServiceLocator()->get('positionDescriptionMapper');
	}
	
	private function getGrid() {
		return new PositionDescriptionGrid();
	}
    
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	}
    
	private function getForm() {
		$form = new PositionDescriptionForm();
		$form->get('positionId')
		     ->setOptions(array('value_options' => $this->getPositionList()));  
		return $form; 
	}
    
	private function getFormValidator() { 
		return new PositionDescriptionFormValidator(); 
	} 
    
	private function getSectionList() { 
		return $this->getLookupService()->getSectionList();
	}
	
	private function getOrganisationLevelList() {
		return $this->getLookupService()->getOrganisationLevelList();
	}
	
    private function getPositionList() {
    	return $this->getPositionService()->getPositionList(); 
	} 
	
	private function getPositionService() {
		return $this->getServiceLocator()->get('positionService');
	}
	
	private function getEmpTypeList() {
		return $this->getLookupService()->getEmpTypeList();
	} 
	 
	public function getReportingPositionsAction() { 
		if($id == null) {
			$id =  $this->params()->fromPost('organisationLevel');
		}
		$positions = array();
		$service = $this->getService(); 
		$getPositions = $service->getHigherPosition($id); 
		foreach ($getPositions as $key=>$val) { 
			//$positions[$pos->getPositionId()] = $pos->getPositionName(); 
			$positions[$key] = $val; 
		} 
		return new JsonModel(array('result' => $positions));  
	} 
	
	private function getLookupService() {
		return $this->getServiceLocator()->get('lookupService');
	}
	
}   