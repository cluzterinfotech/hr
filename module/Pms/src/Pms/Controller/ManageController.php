<?php

namespace Pms\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response;
use Pms\Form\ManageForm;
use Pms\Form\ManageFormValidator;
use Pms\Grid\ManageGrid;
use Zend\View\Model\JsonModel;
     
class ManageController extends AbstractActionController {
    
	public function indexAction() { 
		exit; 
	}
    
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
		$form->get('Curr_Activity')
		     ->setOptions(array('value_options' => $this->getDefaultList())); 
		$prg = $this->prg('/manage/add', true);
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
			     ->addMessage('PMS Fisical Year added successfully');
			$this->redirect()->toRoute('manage',array (
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
			     ->addMessage('PMS Fisical Year not found,Please Add');
			$this->redirect()->toRoute('manage', array(
					'action' => 'add'
			)); 
		}
		
		$form = $this->getForm();
		$service = $this->getService();
		$values = $service->fetchById($id);
		$form->get('Curr_Activity')
		     ->setOptions(array('value_options' => $this->getCurrentActivityList($id)));
        //\Zend\Debug\Debug::dump($values);
        //exit; 
		$form->bind($values);
		$form->get('submit')->setAttribute('value','Update PMS Fisical Year');
        
		$prg = $this->prg('/manage/edit/'.$id, true);
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
			//\Zend\Debug\Debug::dump($data);
			//exit;
			$service->updateRow($data);
			$this->flashMessenger()
			     ->setNamespace('success')
			     ->addMessage('PMS Fisical Year updated successfully');
			$this->redirect ()->toRoute('manage',array (
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
		return $this->getServiceLocator()->get('manageMapper'); 
	}
	
	private function getGrid() {
		return new ManageGrid();
	}
    
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	}
    
	private function getForm() {
		$form = new ManageForm();
		//$form->get('Curr_Activity')
		    // ->setOptions(array('value_options' => $this->getSectionList()));

		return $form; 
	}
    
	private function getFormValidator() { 
		return new ManageFormValidator(); 
	} 
    
	private function getCurrentActivityList($id) {
		return $this->getService()->getCurrentActivityList($id);
	}
	
	private function getDefaultList() {
		return array (
					'1' => 'IPC Open',
					'0' => 'IPC Close' 
			); 
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
	
	private function getLookupService() {
		return $this->getServiceLocator()->get('lookupService');
	}
	
}   