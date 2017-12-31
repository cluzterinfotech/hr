<?php 

namespace Allowance\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response;
use Employee\Form\LocationFormValidator; 
use Application\Model\SiAllowanceGrid;  
use Employee\Form\SiAllowanceFormValidator;
use Allowance\Form\CompanyAllowanceForm;
use Application\Model\AllowanceNotToHaveGrid;
use Application\Model\AffectedAllowanceGrid;
use Application\Model\PaysheetAllowanceGrid;

class PaysheetallowanceController extends AbstractActionController {
	
	private $tableName = 'PaysheetAllowance'; 
    
    public function indexAction() { exit; }
	
	public function listAction() { }
	
	public function ajaxlistAction() {
		$grid = $this->getPaysheetAllowanceGrid(); 
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getCompanyAllowanceService()
		     		          ->selectPaysheetAllowance()) 
		     ->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render()); 
	} 
	
	public function addAction() { 
		$form = $this->getSiAllowanceForm(); 
		$prg = $this->prg('/allowancenottohave/add', true); 
		if ($prg instanceof Response ) {   
			return $prg; 
		} elseif ($prg === false) { 
			return array ('form' => $form);  
		}  
		$formValidator = $this->getSiAllowanceFormValidator();
		$form->setInputFilter($formValidator->getInputFilter());
		$form->setData($prg);
		
		if ($form->isValid()) {
			$data = $form->getData();
			$service = $this->getCompanyAllowanceService(); 
			unset($data['submit']); 
			$service->insert($data,$this->tableName); 
			$this->flashMessenger()->setNamespace('success')
			                       ->addMessage('Allowance Criteria added successfully'); 
			$this->redirect ()->toRoute('siallowance',array (
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
			                       ->addMessage('Allowance not found,Please Add');
			$this->redirect()->toRoute('allowancenottohave', array(
					'action' => 'add'
			));  
		} 
		$form = $this->getSiAllowanceForm();
		$service = $this->getCompanyAllowanceService();
		$location = $service->fetchById($id);
		$form = $this->getSiAllowanceForm();
		$form->bind($location);
		$form->get('submit')->setAttribute('value','Update Location');
		
		$prg = $this->prg('/allowancenottohave/edit/'.$id, true);
		if ($prg instanceof Response ) {
			return $prg;
		} elseif ($prg === false) {
			return array ('form' => $form);
		}
		
		$formValidator = $this->getSiAllowanceFormValidator();
		$form->setInputFilter($formValidator->getInputFilter());
		$form->setData($prg);
		
		if ($form->isValid()) {
			$data = $form->getData();
			$service->update($data);
			$this->flashMessenger()->setNamespace('success')
			                       ->addMessage('Location updated successfully');
			$this->redirect ()->toRoute('allowancenottohave',array ( 
					'action' => 'list'
			));
		}
		return array(
				'form' => $form,
				$prg
		); 
	}
	
	public function deleteAction()
	{
		// @todo 
		$id = (int) $this->params()->fromRoute('id',0); 
		$siAllowanceService = $this->getSiAllowanceService();
		$siAllowanceService->delete($id); 
		exit; 
	} 
	
	public function htmlResponse($html) {
		$response = $this->getResponse();
		$response->setStatusCode(200);
		$response->setContent($html);
		return $response;
	} 
    
	private function getCompanyAllowanceService() {
		return $this->getServiceLocator()->get('companyAllowance'); 
	}
	
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	}
	
	private function getSiAllowanceForm() {
		$form = new CompanyAllowanceForm();
		$form->get('companyId')
		     ->setOptions(array('value_options' => $this->getCompanyList()))
		   //->setAttribute('readOnly', true)
		; 
		$form->get('allowanceId')
		     ->setOptions(array('value_options'=> $this->getAllowanceList()))
		   //->setAttribute('readOnly', true)
		; 
		$form->get('submit')
		     ->setValue('Add '.$this->tableName)
		//->setAttribute('readOnly', true)
		;
		return $form;
	}
	
	private function getCompanyList() {
		return $this->companyService()->getCompanyList(); 
	}
	
	private function getAllowanceList() {
		return $this->allowanceService()->getAllowanceList();  
	}
	
	private function allowanceService() {  
		return $this->serviceLocator->get('allowanceService');  
	} 
	
	private function companyService() { 
		return $this->serviceLocator->get('companyService');  
	}
	
	private function getSiAllowanceFormValidator() {
		return new SiAllowanceFormValidator();  
	} 
	 
	private function getPaysheetAllowanceGrid() {
		return new PaysheetAllowanceGrid(); 
	}
    
}