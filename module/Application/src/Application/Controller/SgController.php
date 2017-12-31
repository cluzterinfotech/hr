<?php 

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response;
use Application\Form\SgForm;
use Application\Form\SgFormValidator;
use Application\Model\SgGrid;

class SgController extends AbstractActionController {
	
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
		$prg = $this->prg('/sg/add', true);
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
			         ->addMessage('Salary Grade added successfully');
			    $this->redirect ()->toRoute('sg',array (
			        'action' => 'add'
			    ));
			} catch(\Exception $e) {
			    $this->flashMessenger()->setNamespace('error')
			         ->addMessage($e->getMessage()." please check your entries");
			    $this->redirect ()->toRoute('sg',array (
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
			                       ->addMessage('Salary Grade not found,Please Add');
			$this->redirect()->toRoute('sg', array(
					'action' => 'add'
			)); 
		}
		$form = $this->getForm();
		$service = $this->getService();
		$Sg = $service->fetchById($id);
		$form = $this->getForm();
		$form->bind($Sg);
		$form->get('submit')->setAttribute('value','Update Salary Grade');
		
		$prg = $this->prg('/sg/edit/'.$id, true);
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
			// exit; 
			try {
			    $service->update($data);
			    $this->flashMessenger()->setNamespace('success')
			    ->addMessage('Salary Grade updated successfully');
			    $this->redirect ()->toRoute('sg',array (
			        'action' => 'list'
			    ));
			} catch(\Exception $e) {
			    $this->flashMessenger()->setNamespace('error')
			    ->addMessage($e->getMessage()." please check your entries");
			    $this->redirect ()->toRoute('sg',array (
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
		return $this->getServiceLocator()->get('sgMapper');  
	}
	
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	}
	
	private function getForm() {
		return new SgForm();
	}
	
	private function getFormValidator() {
		return new SgFormValidator();
	}
	
	private function getGrid() {
		return new SgGrid();
	}
    
}