<?php 

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response;
use Application\Form\SectionForm;
use Application\Form\SectionFormValidator;
use Application\Model\SectionGrid;

class SectionController extends AbstractActionController {
	
	public function indexAction() { exit; }
	
	public function listAction() { }
	
	public function ajaxlistAction() {
		$grid = $this->getGrid();
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getService()->selectSection())
		     ->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render());
	}
	
	public function addAction() {
		$form = $this->getForm();
		$prg = $this->prg('/section/add', true);
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
			                       ->addMessage('Section added successfully'); 
			$this->redirect ()->toRoute('section',array (
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
			                       ->addMessage('Section not found,Please Add');
			$this->redirect()->toRoute('section', array(
					'action' => 'add'
			)); 
		}
		$form = $this->getForm();
		$service = $this->getService();
		$Section = $service->fetchById($id); 
		$form = $this->getForm();
		$form->bind($Section);
		$form->get('submit')->setAttribute('value','Update Section');
		
		$prg = $this->prg('/section/edit/'.$id, true);
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
			                       ->addMessage('Section updated successfully');
			$this->redirect ()->toRoute('section',array (
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
		return $this->getServiceLocator()->get('sectionMapper');
	}
	
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	}
	
	private function getForm() {
		$form = new SectionForm();
		$form->get('department')
		     ->setOptions(array('value_options' => $this->getDepartmentList()
		));
		return $form; 
	}
	
	private function getFormValidator() {
		return new SectionFormValidator();
	}
	
	private function getGrid() {
		return new SectionGrid();
	}
    
}