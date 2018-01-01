<?php  

namespace Allowance\Controller; 

use Zend\Mvc\Controller\AbstractActionController; 
use Zend\Http\PhpEnvironment\Response; 
use Allowance\Form\SalaryStructureForm; 
use Allowance\Form\SalaryStructureFormValidator;
use Application\Model\SalaryStructureGrid; 

class SalarystructureController extends AbstractActionController {
	
	public function indexAction() { exit; }
	
	public function listAction() { }
	
	public function ajaxlistAction() {
		
		$grid = $this->getSalaryStructureGrid();
		$company = $this->getServiceLocator()->get('company'); 
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getService()->selectSalaryStructure($company))
		     ->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render());
		
	} 
	
	public function addAction() {
		$form = $this->getForm();
		$prg = $this->prg('/location/add', true);
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
			                       ->addMessage('Location added successfully'); 
			$this->redirect ()->toRoute('location',array (
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
			                       ->addMessage('Salary Structure not found,Please Add');
			$this->redirect()->toRoute('salarystructure', array(
					'action' => 'add'
			)); 
		}
		$form = $this->getForm();
		$service = $this->getService();
		$salStructure = $service->fetchSalStructureById($id);
		$form = $this->getForm(); 
		$form->bind($salStructure); 
		$form->get('submit')->setAttribute('value','Update Salary Structure');
		
		$prg = $this->prg('/salarystructure/edit/'.$id, true);
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
			$service->updateSalStructure($data); 
			$this->flashMessenger()->setNamespace('success')
			                       ->addMessage('Salary Structure updated successfully');
			$this->redirect ()->toRoute('salarystructure',array (
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
		$form = new SalaryStructureForm(); 
		$form->get('salaryGradeId')
		     ->setOptions(array('value_options' => $this->getEmpSalaryGrade()
		));
		return $form; 
	}
	
	private function getFormValidator() {
		return new SalaryStructureFormValidator();
	}
	
	private function getSalaryStructureGrid() {
		return new SalaryStructureGrid();
	}
	
	private function getEmpSalaryGrade() {
		return $this->getLookupService()->getSalaryGradeList();
	}
	
	private function getLookupService() {
		return $this->getServiceLocator()->get('lookupService');
	}
    
	
}