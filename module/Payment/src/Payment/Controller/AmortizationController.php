<?php 
namespace Payment\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response;
use Payment\Form\AmortizationForm; 
use Payment\Form\AmortizationFormValidator; 
use Application\Model\CarAmortizationGrid;  

class AmortizationController extends AbstractActionController {
	
	public function indexAction() { exit; }
	
	public function listAction() { }
	
	public function ajaxlistAction() {
		$grid = $this->getGrid();
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getService()->selectCarAmortization())
		     ->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render()); 
	}
	
	public function addAction() {
		$form = $this->getForm();
		$prg = $this->prg('/amortization/add', true);
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
			                       ->addMessage('Car Amortization added successfully'); 
			$this->redirect ()->toRoute('amortization',array (
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
			                       ->addMessage('Group not found,Please Add');
			$this->redirect()->toRoute('amortization', array(
					'action' => 'add'
			)); 
		}
		$form = $this->getForm();
		$service = $this->getService();
		$location = $service->fetchById($id);
		$form = $this->getForm();
		$form->bind($location);
		$form->get('submit')->setAttribute('value','Update Car Amortization');
		
		$prg = $this->prg('/amortization/edit/'.$id, true);
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
			                       ->addMessage('Car Amortization updated successfully');
			$this->redirect ()->toRoute('amortization',array (
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
		return $this->getServiceLocator()->get('amortizationMapper'); 
	}
	
	private function getEmployeeService() {
		return $this->getServiceLocator()->get('employeeService');
	} 
	
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	} 
	
	private function getForm() {
		$form = new AmortizationForm(); 
		$company = $this->getServiceLocator()->get('company');
		$companyId = $company->getId();
		$form->get('employeeNumber')
		     ->setOptions(array('value_options' =>
				$this->getEmployeeService()->employeeList($companyId)))
		; 
		return $form; 
	}
	
	private function getFormValidator() {
		return new AmortizationFormValidator(); 
	}
	
	private function getGrid() {
		return new CarAmortizationGrid();  
	}
    
}