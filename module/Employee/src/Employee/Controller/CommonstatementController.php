<?php  

namespace Employee\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response;
use Employee\Form\CommonStatementForm;
use Employee\Form\CommonStatementFormValidator;
use Application\Model\CommonStatementGrid;
//use Employee\Form\Employee\Form;

class CommonstatementController extends AbstractActionController {
	
	public function indexAction() { exit; }
	
	public function listAction() { }
	
	public function ajaxlistAction() {
		$grid = $this->getGrid();
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getService()->selectStmtList())
		     ->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render());
	}
	
	public function addAction() {
		$form = $this->getForm();
		$prg = $this->prg('/commonstatement/add', true);
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
			         ->addMessage('Common Bank Statement added successfully');
			    $this->redirect ()->toRoute('commonstatement',array (
			        'action' => 'add'
			    ));
			} catch(\Exception $e) {
			    $this->flashMessenger()->setNamespace('error')
			         ->addMessage($e->getMessage()." please check your entries");
			    $this->redirect ()->toRoute('commonstatement',array (
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
			                       ->addMessage('Common Bank Statement not found,Please Add');
			$this->redirect()->toRoute('commonstatement', array(
					'action' => 'add'
			)); 
		}
		$form = $this->getForm();
		$service = $this->getService();
		$commonstatement = $service->fetchById($id);
		$form = $this->getForm();
		$form->bind($commonstatement);
		$form->get('submit')->setAttribute('value','Update Common Bank Statement');
		
		$prg = $this->prg('/commonstatement/edit/'.$id, true);
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
			         ->addMessage('Common Bank Statement updated successfully');
			    $this->redirect()->toRoute('commonstatement',array (
			        'action' => 'list'
			    ));
			} catch(\Exception $e) {
			    $this->flashMessenger()->setNamespace('error')
			    ->addMessage($e->getMessage()." please check your entries");
			    $this->redirect ()->toRoute('commonstatement',array (
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
		return $this->getServiceLocator()->get('commonStatementMapper'); 
	}
	
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	}
	
	private function getEmployeeService() {
		return $this->getServiceLocator()->get('employeeService');
	}
	
    private function getLookupService() {
		return $this->getServiceLocator()->get('lookupService');  
	} 
	
	private function getEmpBank() {
		return $this->getLookupService()->getBankList();
	}
	
	private function getForm() {
		$form = new CommonStatementForm(); 
		$company = $this->getServiceLocator()->get('company');
		$companyId = $company->getId();
		$form->get('employeeId')
		     ->setOptions(array('value_options' =>
				$this->getEmployeeService()->employeeList($companyId)))
		;
		$form->get('bankId')
		     ->setOptions(array('value_options' =>
				$this->getEmpBank()))
		;
		return $form; 
	}
	
	private function getFormValidator() {
		return new CommonStatementFormValidator();
	}
	
	private function getGrid() {
		return new CommonStatementGrid();
	}
    
}