<?php 

namespace Leave\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response;
use Employee\Form\LocationFormValidator;
use Application\Model\LocationGrid;
use Leave\Form\LeaveEntitlementForm;
use Leave\Form\LeaveEntitlementFormValidator;
use Application\Model\LeaveEntitlementGrid;

class EntitlementannualleaveController extends AbstractActionController {
	
	public function indexAction() { exit; }
	
	public function listAction() { }
	
	public function ajaxlistAction() {
		$grid = $this->getGrid();
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getService()->selectEntitlement())
		     ->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render());
	}
	
	public function addAction() {
		$form = $this->getForm();
		$prg = $this->prg('/entitlementannualleave/add', true);
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
			                       ->addMessage('Entitlement added successfully'); 
			$this->redirect ()->toRoute('entitlementannualleave',array (
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
			     ->addMessage('Entitlement not found,Please Add');
			$this->redirect()->toRoute('entitlementannualleave', array(
					'action' => 'add'
			)); 
		}
		$form = $this->getForm();
		$service = $this->getService();
		$entitlement = $service->fetchById($id); 
		//\Zend\Debug\Debug::dump($entitlement);  
		//exit; 
		// $form = $this->getForm();
		
		$form->get('submit')->setAttribute('value','Update Entitlement');
		$form->bind($entitlement);
		//\Zend\Debug\Debug::dump($form);
		//exit;
		$prg = $this->prg('/entitlementannualleave/edit/'.$id, true);
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
			                       ->addMessage('Entitlement updated successfully');
			$this->redirect ()->toRoute('entitlementannualleave',array (
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
		return $this->getServiceLocator()->get('leaveEntitlementMapper'); 
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
		$form = new LeaveEntitlementForm();
		$form->get('companyId')
		     ->setOptions(array('value_options' => $this->getCompany()
		)); 
		$form->get('LkpLeaveType')
		     ->setOptions(array('value_options' => $this->getLeaveType()
		)); 
		$form->get('LkpLeaveType')->setValue('1');
		return $form;   
	}
	
	private function getFormValidator() {
		return new LeaveEntitlementFormValidator(); 
	}
	
	private function getGrid() {
		return new LeaveEntitlementGrid();
	}
    
}