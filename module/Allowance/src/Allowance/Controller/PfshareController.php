<?php  

namespace Allowance\Controller; 

use Zend\Mvc\Controller\AbstractActionController; 
use Zend\Http\PhpEnvironment\Response; 
use Allowance\Form\PfShareForm; 
use Allowance\Model\PfShareMapper;   
use Allowance\Form\PfShareFormValidator;
use Application\Model\PfShareGrid;

class PfshareController extends AbstractActionController {
	
	public function indexAction() { exit; }
	
	public function listAction() { }
	
	public function ajaxlistAction() {
		
		$grid = $this->getGrid();
		$company = $this->getServiceLocator()->get('company'); 
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getService()->selectPfShare($company))
		     ->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render());
		
	} 
	
	public function addAction() {
		$form = $this->getForm();
		$prg = $this->prg('/pfshare/add', true);
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
			                       ->addMessage('PF Share value added successfully'); 
			$this->redirect ()->toRoute('pfshare',array (
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
			                       ->addMessage('Value not found,Please Add');
			$this->redirect()->toRoute('pfshare', array(
					'action' => 'add'
			)); 
		}
		$form = $this->getForm();
		$service = $this->getService();
		$pfshare = $service->fetchById($id);
		//\Zend\Debug\Debug::dump($quartile);
		//exit; 
		$form = $this->getForm();
		$form->bind($pfshare);
		$form->get('submit')->setAttribute('value','Update PF Share');
		
		$prg = $this->prg('/pfshare/edit/'.$id, true);
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
			//exit; 
			$service->update($data);
			$this->flashMessenger()->setNamespace('success')
			                       ->addMessage('PF Share updated successfully');
			$this->redirect ()->toRoute('pfshare',array (
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
		return $this->getServiceLocator()->get('pfShareMapper');
	}
	
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	}
	
	private function getForm() {
		$form = new PfShareForm(); 
		$company = $this->getServiceLocator()->get('company');
		$companyId = $company->getId(); 
		$form->get('employeeId')
		     ->setOptions(array('value_options' => $this->getEmployeeService()->employeeList($companyId)
		));
		return $form; 
	}
	
	private function getEmployeeService() {
		return $this->getServiceLocator()->get('employeeService');
	} 
	
	private function getFormValidator() {
		return new PfShareFormValidator(); 
	}
	
	private function getGrid() {
		return new PfShareGrid(); 
	}
    
	
}