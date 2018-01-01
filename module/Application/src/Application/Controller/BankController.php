<?php 

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response;
use Application\Form\BankForm;
use Application\Form\BankFormValidator;
use Application\Model\BankGrid;

class BankController extends AbstractActionController {
	
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
		$prg = $this->prg('/bank/add', true);
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
			    $service = $this->getService();
			    $service->insert($data);
			    $this->flashMessenger()->setNamespace('success')
			         ->addMessage('bank added successfully');
			    $this->redirect ()->toRoute('bank',array (
			        'action' => 'add'
			    ));
			} catch(\Exception $e) {
			    $this->flashMessenger()->setNamespace('error')
			         ->addMessage($e->getMessage()." please check your entries");
			    $this->redirect ()->toRoute('bank',array (
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
			                       ->addMessage('bank not found,Please Add');
			$this->redirect()->toRoute('bank', array(
					'action' => 'add'
			)); 
		}
		$form = $this->getForm();
		$service = $this->getService();
		$bank = $service->fetchById($id);
		$form = $this->getForm();
		$form->bind($bank);
		$form->get('submit')->setAttribute('value','Update bank'); 
		$prg = $this->prg('/bank/edit/'.$id, true);
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
			    $service = $this->getService();
			    $service->update($data);
			    $this->flashMessenger()->setNamespace('success')
			         ->addMessage('bank updated successfully');
			    $this->redirect ()->toRoute('bank',array (
			        'action' => 'list'
			    ));
			} catch(\Exception $e) {
			    $this->flashMessenger()->setNamespace('error')
			         ->addMessage($e->getMessage()." please check your entries");
			    $this->redirect ()->toRoute('bank',array (
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
		return $this->getServiceLocator()->get('bankMapper');
	}
	
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	}
	
	private function getForm() {
		return new BankForm();
	}
	
	private function getFormValidator() {
		return new BankFormValidator();
	}
	
	private function getGrid() {
		return new BankGrid();
	}
    
}