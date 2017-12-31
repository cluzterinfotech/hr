<?php 
 
namespace Application\Controller; 

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response;
use Application\Form\JgForm;
use Application\Form\JgFormValidator;
use Application\Model\JgGrid;

class JgController extends AbstractActionController {
	
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
		$prg = $this->prg('/jg/add', true);
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
			
			try {
			    $service->insert($data);
			    $this->flashMessenger()->setNamespace('success')
			         ->addMessage('Job Grade added successfully');
			    $this->redirect ()->toRoute('jg',array (
			        'action' => 'add'
			    ));
			} catch(\Exception $e) {
			    $this->flashMessenger()->setNamespace('error')
			         ->addMessage($e->getMessage()." please check your entries");
			    $this->redirect ()->toRoute('jg',array (
			        'action' => 'add'
			    )); 
			} 
			
			
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
			                       ->addMessage('Job Grade not found,Please Add');
			$this->redirect()->toRoute('jg', array(
					'action' => 'add'
			)); 
		}
		$form = $this->getForm();
		$service = $this->getService();
		$Jg = $service->fetchById($id); 
		$form = $this->getForm();
		$form->bind($Jg);
		$form->get('submit')->setAttribute('value','Update Job Grade');
		
		$prg = $this->prg('/jg/edit/'.$id, true);
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
			
			try {
			    $service->update($data);
			    $this->flashMessenger()->setNamespace('success')
			         ->addMessage('Job Grade updated successfully');
			    $this->redirect ()->toRoute('jg',array (
			        'action' => 'list'
			    ));
			} catch(\Exception $e) {
			    $this->flashMessenger()->setNamespace('error')
			         ->addMessage($e->getMessage()." please check your entries");
			    $this->redirect ()->toRoute('jg',array (
			        'action' => 'list'
			    ));
			}
			
			
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
		return $this->getServiceLocator()->get('jobGradeMapper');
	}
	
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	}
	
	private function getForm() {
		return new JgForm();
	}
	
	private function getFormValidator() {
		return new JgFormValidator();
	}
	
	private function getGrid() {
		return new JgGrid();
	}
    
}