<?php 

namespace Leave\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response; 
use Leave\Form\PublicHolidayForm;
use Leave\Form\PublicHolidayFormValidator;
use Application\Model\PublicHolidayGrid;

class PublicholidayController extends AbstractActionController {
	
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
		$prg = $this->prg('/publicholiday/add', true);
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
			                       ->addMessage('Public Holiday added successfully'); 
			$this->redirect ()->toRoute('publicholiday',array (
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
			$this->flashMessenger()
			     ->setNamespace('info')
			     ->addMessage('Public Holiday not found,Please Add');
			$this->redirect()->toRoute('publicholiday', array(
					'action' => 'add'
			)); 
		}
		$form = $this->getForm();
		$service = $this->getService();
		$entitlement = $service->fetchById($id); 
		//\Zend\Debug\Debug::dump($entitlement);  
		//exit; 
		// $form = $this->getForm();
		
		$form->get('submit')->setAttribute('value','Update Public Holiday');
		$form->bind($entitlement);
		//\Zend\Debug\Debug::dump($form);
		//exit;
		$prg = $this->prg('/publicholiday/edit/'.$id, true);
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
			                       ->addMessage('Public Holiday updated successfully');
			$this->redirect ()->toRoute('publicholiday',array (
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
		return $this->getServiceLocator()->get('publicHolidayMapper');  
	}
	
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	}
	
	private function getCompany() {
		return $this->getLookupService()->getCompanyList();
	}
	
	private function getLeaveType() {
		return $this->getLookupService()->getLeaveType();
	} 
	
	private function getLookupService() {
		return $this->getServiceLocator()->get('lookupService');
	}
	
	private function getForm() {
		return new PublicHolidayForm();   
	}
	
	private function getFormValidator() {
		return new PublicHolidayFormValidator(); 
	}
	
	private function getGrid() {
		return new PublicHolidayGrid(); 
	}
    
}