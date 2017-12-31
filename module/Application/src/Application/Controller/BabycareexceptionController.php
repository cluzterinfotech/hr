<?php 

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response; 
use Application\Form\BabyCareForm;
use Application\Form\BabyCareFormValidator;
use Application\Model\BabyCareGrid;

class BabycareexceptionController extends AbstractActionController {
	
	public function indexAction() { exit; }
	
	public function listAction() { }
	
	public function ajaxlistAction() {
		$grid = $this->getGrid();
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getService()->selectBabyCare())
		     ->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render());
	}
	
	public function addAction() {
		$form = $this->getForm();
		$prg = $this->prg('/babycareexception/add', true);
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
			                       ->addMessage('Baby Care Duration added successfully'); 
			$this->redirect ()->toRoute('babycareexception',array (
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
			                       ->addMessage('baby care duration not found,Please Add');
			$this->redirect()->toRoute('babycareexception', array(
					'action' => 'add'
			)); 
		}
		$form = $this->getForm();
		$service = $this->getService();
		$department = $service->fetchById($id); 
		$form = $this->getForm();
		$form->bind($department);
		$form->get('submit')->setAttribute('value','Update Baby Care Duration');
		
		$prg = $this->prg('/babycareexception/edit/'.$id, true);
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
			                       ->addMessage('Baby Care Duration updated successfully');
			$this->redirect ()->toRoute('babycareexception',array (
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
		return $this->getServiceLocator()->get('babyCareMapper');
	}
	
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	}
	
	private function getForm() {
		$form = new BabyCareForm(); 
		$company = $this->getServiceLocator()->get('company');
		$companyId = $company->getId(); 
		$form->get('employeeNumber')
		     ->setOptions(array('value_options' =>
				$this->getEmployeeService()->employeeList($companyId)))
				;
		return $form;
	}
	
	private function getEmployeeService() {
		return $this->getServiceLocator()->get('employeeService');
	}
	
	private function getFormValidator() {
		return new BabyCareFormValidator(); 
	}
	
	private function getGrid() {
		return new BabyCareGrid(); 
	}
	
	public function updateRowAction()
	{
		$param = $this->getRequest()->getPost();
		$arr = array(
			'noOfMinutes' => $param['value'],
			'id' => $param['row']
		);   
        $this->getService()->update($arr); 
		return $this->jsonResponse(array('succes' => 1)); 
	} 
    
	public function jsonResponse($data)
	{
		if(!is_array($data)){
			throw new \Exception('$data param must be array');
		} 
		$response = $this->getResponse();
		$response->setStatusCode(200);
		$response->setContent(json_encode($data));
		return $response;
	} 
}