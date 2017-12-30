<?php 

namespace Employee\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response;
use Employee\Form\SplHousingForm;
use Employee\Form\SplHousingFormValidator;
use Application\Model\SplHousingGrid;

class SplhousingController extends AbstractActionController {
	
	public function indexAction() { exit; }
	
	public function listAction() { }
	
	public function ajaxlistAction() {
		$grid = $this->getGrid();
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getService()->selectSplHousList())
		     ->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render());
	}
	
	public function addAction() {
		$form = $this->getForm();
		$prg = $this->prg('/splhousing/add', true);
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
			$this->flashMessenger()->setNamespace('success')
			                       ->addMessage('Special Housing added successfully'); 
			$this->redirect ()->toRoute('splhousing',array (
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
			                       ->addMessage('Special Housing not found,Please Add');
			$this->redirect()->toRoute('splhousing', array(
					'action' => 'add'
			)); 
		}
		$form = $this->getForm();
		$service = $this->getService();
		$splhousing = $service->fetchById($id);
		$form = $this->getForm();
		$form->bind($splhousing);
		$form->get('submit')->setAttribute('value','Update Special Housing');
		
		$prg = $this->prg('/splhousing/edit/'.$id, true);
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
			                       ->addMessage('Special Housing updated successfully');
			$this->redirect()->toRoute('splhousing',array (
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
		return $this->getServiceLocator()->get('splHousingMapper'); 
	}
	
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	}
	
	private function getEmployeeService() {
		return $this->getServiceLocator()->get('employeeService');
	}
	
	private function getForm() {
		$form = new SplHousingForm();
		$company = $this->getServiceLocator()->get('company');
		$companyId = $company->getId();
		$form->get('employeeId')
		     ->setOptions(array('value_options' =>
				$this->getEmployeeService()->employeeList($companyId)))
		;
		return $form;  
	}
	
	private function getFormValidator() {
		return new SplHousingFormValidator();
	}
	
	private function getGrid() {
		return new SplHousingGrid();
	}
    
}