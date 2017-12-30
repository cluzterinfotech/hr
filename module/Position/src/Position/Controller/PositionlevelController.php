<?php 

namespace Position\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response;
use Application\Form\PositionLevelForm;
use Application\Form\PositionLevelFormValidator;
use Application\Model\PositionLevelGrid;

class PositionlevelController extends AbstractActionController {
	
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
		$prg = $this->prg('/positionlevel/add', true);
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
			                       ->addMessage('positionlevel added successfully'); 
			$this->redirect ()->toRoute('positionlevel',array (
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
			                       ->addMessage('positionlevel not found,Please Add');
			$this->redirect()->toRoute('positionlevel', array(
					'action' => 'add'
			)); 
		}
		$form = $this->getForm();
		$service = $this->getService();
		$positionlevel = $service->fetchById($id); 
		$form = $this->getForm();
		$form->bind($positionlevel);
		$form->get('submit')->setAttribute('value','Update positionlevel');
		
		$prg = $this->prg('/positionlevel/edit/'.$id, true);
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
			                       ->addMessage('positionlevel updated successfully');
			$this->redirect ()->toRoute('positionlevel',array (
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
    
	private function getLookupService() {
		return $this->getServiceLocator()->get('lookupService');
	}
	
	private function getDepartmentList() {
		return $this->getLookupService()->getDepartmentList(); 
	}
	
	private function getService() {
		return $this->getServiceLocator()->get('positionLevelMapper');
	}
	
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	}
	
	private function getForm() {
		return new PositionLevelForm();
		/*$form->get('department')
		     ->setOptions(array('value_options' => $this->getDepartmentList()
		));
		return $form;*/ 
	}
	
	private function getFormValidator() {
		return new PositionLevelFormValidator();
	}
	
	private function getGrid() {
		return new PositionLevelGrid();
	}
    
}