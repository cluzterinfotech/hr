<?php  

namespace Allowance\Controller; 

use Zend\Mvc\Controller\AbstractActionController; 
use Zend\Http\PhpEnvironment\Response; 
use Allowance\Form\IncrementCriteriaForm; 
use Employee\Form\LocationFormValidator; 
use Application\Model\IncrementCriteriaGrid; 
use Allowance\Form\IncrementCriteriaFormValidator;

class IncrementcriteriaController extends AbstractActionController {
	
	public function indexAction() { exit; }
	
	public function listAction() { }
	
	public function ajaxlistAction() {
	    	
		$grid = $this->getGrid();
		$company = $this->getServiceLocator()->get('company'); 
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getService()->selectIncrementCriteria($company))
		     ->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render()); 
	} 
	
	public function addAction() {
		$form = $this->getForm();
		$prg = $this->prg('/incrementcriteria/add', true);
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
			$service->insertCriteria($data);
			$this->flashMessenger()->setNamespace('success')
			                       ->addMessage('Increment Criteria added successfully'); 
			$this->redirect ()->toRoute('incrementcriteria',array (
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
			                       ->addMessage('Increment Criteria not found,Please Add');
			$this->redirect()->toRoute('incrementcriteria', array(
					'action' => 'add'
			)); 
		}
		//$form = $this->getForm();
		$service = $this->getService();
		$criteria = $service->fetchCriteriaById($id); 
		$form = $this->getForm();
		$form->bind($criteria);
		$form->get('submit')->setAttribute('value','Update Increment Criteria');
		
		$prg = $this->prg('/incrementcriteria/edit/'.$id, true);
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
			$service->updateCriteria($data);
			$this->flashMessenger()->setNamespace('success')
			                       ->addMessage('Increment Criteria updated successfully');
			$this->redirect ()->toRoute('incrementcriteria',array (
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
		return $this->getServiceLocator()->get('incrementService');
	}
	
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	}
	
	private function getForm() {
		return new IncrementCriteriaForm(); 
	}
	
	private function getFormValidator() {
		return new IncrementCriteriaFormValidator(); 
	}
	
	private function getGrid() {
		return new IncrementCriteriaGrid();
	} 
}