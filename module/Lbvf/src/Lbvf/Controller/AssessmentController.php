<?php

namespace Lbvf\Controller;

use Zend\Mvc\Controller\AbstractActionController; 
use Zend\Http\PhpEnvironment\Response; 
use Application\Model\PeopleManagementGrid;  
use Lbvf\Form\AssessmentFormValidator;
use Lbvf\Form\AssessOneForm; 

class AssessmentController extends AbstractActionController {
	
	public function indexAction() { exit; } 
	
	public function listAction() { 
		// @todo  
		// get lbvf 
	}
	
	public function ajaxlistAction() {
		$grid = $this->getGrid();
		$userInfo = $this->getUserInfoService();
		$empId = '14';//$this->getUserInfoService()->getEmployeeId();
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getService()->selectById($empId))
		     ->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render());
	}   
	
	/*public function addAction() {
		$form = $this->getForm();
		$prg = $this->prg('/peoplemanagement/add', true);
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
			     ->addMessage('People management Staff Invovement Form added successfully');
			$this->redirect ()->toRoute('peoplemanagement',array (
					'action' => 'add'
			)); 
		}
		
		return array(
				'form' => $form,
				$prg
		);
	}*/
	
	public function assessAction() {
	
		$id = 2069;//(int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			$this->flashMessenger()->setNamespace('info')
			     ->addMessage('Assessment not found,Please Add');
			$this->redirect()->toRoute('assessment', array(
					'action' => 'add'
			));
		}
		//$form = $this->getForm();
		$service = $this->getService();
		$assessment = $service->fetchById($id);
		//\Zend\Debug\Debug::dump($assessment);
		//exit; 
		$form = $this->getForm();
		$form->bind($assessment);
		//$form->get('submit')->setAttribute('value','Update Assessment');
	
		$prg = $this->prg('/assessment/assess/'.$id, true);
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
			//$service->update($data); 
			$this->flashMessenger()->setNamespace('success')
			     ->addMessage('Assessment updated successfully');
			$this->redirect ()->toRoute('assessment',array (
					'action' => 'list'
			));
		} else {
			// save partially 
			$this->flashMessenger()->setNamespace('info')
			     ->addMessage('Form Saved Partially');
			$this->redirect ()->toRoute('assessment',array (
					'action' => 'list'
			));
		}
		return array(
				'form' => $form,
				$prg
		);
	}
	
	/*public function assessAction() { 
		$form = $this->getForm();
		$prg = $this->prg('/assessment/add', true);
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
			     ->addMessage('Assessment Form added successfully');
			$this->redirect ()->toRoute('assessment',array (
					'action' => 'add'
			));
		} 
		return array(
				'form' => $form,
				$prg
		);
		
	} */
	
	/*//$this->params()->fromRoute('empId', 0);
	 //$this->params()->fromRoute('assesId', 0);
	 $service = $this->getService();
	 // $form = $service->formOne();
	 $form = $this->getForm();
	 // @todo fetch from DB
	 $assesseeDetails = "ASSESSEE DETAILS will come here... from people management/staff involvement";
	 return array(
	 'form' => $form,
	 'assesseeDetails' => $assesseeDetails
	 ); */
		
	public function getService() {
		return $this->getServiceLocator()->get('assessmentService'); 
	}
	
	public function htmlResponse($html) {
		$response = $this->getResponse();
		$response->setStatusCode(200);
		$response->setContent($html);
		return $response;
	}
	
	private function getUserInfoService() {
		return $this->getServiceLocator()->get('userInfoService');
	}
	
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	}
	
	private function getForm() {
		return new AssessOneForm();
	}
	
	private function getFormValidator() {
		return new AssessmentFormValidator(); 
	}
	
	private function getGrid() {
		return new PeopleManagementGrid();
	} 
}   