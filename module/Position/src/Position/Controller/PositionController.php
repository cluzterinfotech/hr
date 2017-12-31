<?php

namespace Position\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Http\PhpEnvironment\Response;
use Position\Form\PositionForm;
use Position\Form\PositionFormValidator;
use Position\Grid\PositionGrid;
use Zend\View\Model\JsonModel;
     
class PositionController extends AbstractActionController {
    
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
		     ->setSource($this->getService()->selectList())
		     ->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render()); 
	}
    
	public function addAction() {
		$form = $this->getForm(); 
		$prg = $this->prg('/position/add', true);
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
			     ->addMessage('Position added successfully');
			$this->redirect()->toRoute('position',array (
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
			     ->addMessage('Position not found,Please Add');
			$this->redirect()->toRoute('position', array(
					'action' => 'add'
			));
		}
		
		$form = $this->getForm();
		$service = $this->getService();
		$values = $service->fetchById($id);
        
		$form->bind($values);
		$form->get('submit')->setAttribute('value','Update Position');
        
		$prg = $this->prg('/position/edit/'.$id, true);
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
			     ->addMessage('Position updated successfully');
			$this->redirect ()->toRoute('position',array (
					'action' => 'list'
			));
		}
		return array(
				'form' => $form,
				$prg
		);
	}
	
	public function orgnstructureAction() {
		$viewmodel = new ViewModel();
		$viewmodel->setTerminal(1);
		$service = $this->getService(); 
		$output = $service->orgnChartAllLevel();  
		$viewmodel->setVariables(array(
				'chart'  => $output,
		));
		return $viewmodel;  
	}
	
	public function orgnstructurechairAction() {
	    $viewmodel = new ViewModel();
	    $viewmodel->setTerminal(1);
	    $service = $this->getService();
	    $output = $service->orgnChartChairLevel();
	    $viewmodel->setVariables(array(
	        'chart'  => $output,
	    ));
	    return $viewmodel;
	}
    
	public function htmlResponse($html) {
		$response = $this->getResponse();
		$response->setStatusCode(200); 
		$response->setContent($html); 
		return $response;
	}
    
	private function getService() {
		return $this->getServiceLocator()->get('positionService');
	}
	
	private function getGrid() {
		return new PositionGrid();
	}
    
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	}
    
	private function getForm() {
		$form = new PositionForm();
		$form->get('section')
		     ->setOptions(array('value_options' => $this->getSectionList()));
		$form->get('organisationLevel')
		     ->setOptions(array('value_options' => $this->getOrganisationLevelList()));
		$form->get('reportingPosition')
		     ->setOptions(array('value_options' => $this->getPositionList()));
		$form->get('positionLocation')
		     ->setOptions(array('value_options' => $this->getLocationList()));
		$form->get('jobGradeId')
		     ->setOptions(array('value_options' => $this->getJobGradeList()));
		return $form;   
	} 
    
	private function getFormValidator() { 
		return new PositionFormValidator(); 
	} 
    
	private function getSectionList() {  
		return $this->getLookupService()->getSectionList(); 
	}
	
	private function getOrganisationLevelList() { 
		return $this->getLookupService()->getOrganisationLevelList(); 
	}
	
    private function getPositionList() { 
    	return $this->getService()->getPositionList(); 
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
	
	public function xmltestAction() {
		$viewmodel = new ViewModel();
		$viewmodel->setTerminal(1);
		//$service = $this->getService();
		//$output = $service->orgnChart();
		//$viewmodel->setVariables(array(
			//	'chart'  => $output,
		//));
		return $viewmodel;
		//$filename = 'customerInfo.xml';
		//$xml = simplexml_load_file($filename);
		//echo $xml; 
		//exit; 
	}
	
	private function getLookupService() {
		return $this->getServiceLocator()->get('lookupService');
	}
	
	private function getLocationList() {
		return $this->getLocationService()->locationList();
	}
	
	private function getJobGradeList() {
	    return $this->getLookupService()->getJobGradeList();
	}
	
	//private function getJobGradeList() {
	    //return $this->getLocationService()->locationList();
	//}
	
	private function getLocationService() {
		return $this->getServiceLocator()->get('locationMapper');
	}
	
}   