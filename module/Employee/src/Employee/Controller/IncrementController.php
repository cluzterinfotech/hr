<?php

namespace Employee\Controller; 

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response; 
use Employee\Form\AnnivIncrementForm;
use Employee\Form\PromotionFormValidator;
use Application\Form\EffectiveDateForm;
use Employee\Form\SubmitButonFormValidator;
use Application\Model\EmployeeAnniversaryIncrementGrid;
use Employee\Form\ApplyIncrementFormValidator;
use Employee\Form\AnnivIncrementFormValidator;
use Application\Form\ApplyIncrementForm;

class IncrementController extends AbstractActionController { 
	
	public function indexAction() { exit; }
	
	public function listAction() { }
	
	public function ajaxlistAction() {
		$grid = $this->getGrid();
		$company = $this->getServiceLocator()->get('company');
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getIncrementService()->selectIncAnniv($company))
		     ->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render()); 
	} 
	
	public function editAction() {
		
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			$this->flashMessenger()->setNamespace('info')
			                       ->addMessage('Increment Info not found,Please Add');
			$this->redirect()->toRoute('increment', array(
					'action' => 'calcannivinc'
			)); 
		} 
		$form = $this->getForm(); 
		$service = $this->getIncrementService(); 
		$annivInc = $service->fetchAnnivIncById($id); 
		//\Zend\Debug\Debug::dump($annivInc);
	    //exit; 
		//$form = $this->getLocationForm(); 
		$form->bind($annivInc);  
		$form->get('submit')->setAttribute('value','Update Increment Info'); 
		$prg = $this->prg('/increment/edit/'.$id, true); 
		if ($prg instanceof Response ) { 
			return $prg; 
		} elseif ($prg === false) { 
			return array ('form' => $form); 
		} 
		$formValidator = $this->getAnnivIncFormValidator(); 
		$form->setInputFilter($formValidator->getInputFilter());
		$form->setData($prg); 
		if ($form->isValid()) {
			$data = $form->getData();
			//\Zend\Debug\Debug::dump($data);
			//exit; 
			$service->updateAnnivInc($data);
			$this->flashMessenger()->setNamespace('success')
			                       ->addMessage('Increment Info updated successfully');
			$this->redirect ()->toRoute('increment',array (
					'action' => 'calcannivinc'
			));  
		}  
		return array( 
				'form' => $form,
				$prg 
		);   
	}  
	
	public function applyincrementAction() {
		$form = $this->getSubmitForm(); 
		$prg = $this->prg('/increment/applyincrement', true); 
		$company = $this->getServiceLocator()->get('company');
		$service = $this->getIncrementService(); 
		if ($prg instanceof Response ) { 
			return $prg; 
		} elseif ($prg === false) { 
			return array ( 
				'form'           => $form, 
				// 'promotionList'  => $promotionList  
			);  
		}  
		//$dateRange = $this->getServiceLocator()->get('dateRange'); 
		$formValidator = $this->getFormValidator();
		$form->setInputFilter($formValidator->getInputFilter());
		$form->setData($prg);
		if ($form->isValid()) {
			// @todo 
			$isBatchOpened = true;
			//$isBatchOpened = 1;//$service->isHaveIncrement(/*Company dateRange*/);
			if($isBatchOpened) { 
				$this->flashMessenger()->setNamespace('info')
				     ->addMessage('No Increment available to close, please calculate');
				$this->redirect ()->toRoute('increment',array (
						'action' => 'calculate'
				));  
			} else { 
				// @todo 
				$data = $form->getData();  
				//$colaPercentage = $data->getIncColaPercentage();  
				//$effectiveDate = $data->getApplyeEfectiveDate();     
				$service->applyIncrement($company);  
				$this->flashMessenger()->setNamespace('success')
				     ->addMessage('Increment applied successfully');
				$this->redirect ()->toRoute('increment',array (
						'action' => 'applyincrement' 
				));   
			} 	
		} 
		return array( 
				'form' => $form, 
				$prg 
		);   
	} 
	
	public function calcannivincAction() { 
		$form = $this->getSubmitForm();
		$form->get('submit')->setValue('Calculate Anniversary Increment'); 
		$prg = $this->prg('/increment/calcannivinc', true); 
		$company = $this->getServiceLocator()->get('company'); 
		$dateRange = $this->getServiceLocator()->get('dateRange');  
		$service = $this->getIncrementService(); 
		if ($prg instanceof Response ) { 
			return $prg; 
		} elseif ($prg === false) { 
			return array ( 
					'form'    => $form 
			);  
		} 
		//$dateRange = $this->getServiceLocator()->get('dateRange');
		//$formValidator = $this->getFormValidator(); 
		//$form->setInputFilter($formValidator->getInputFilter()); 
		$form->setData($prg); 
		if ($form->isValid()) {  
			// @todo 
			$isEmployeeAvailable = $service->isHaveAnnivIncrement($company,$dateRange); 
			if(!$isEmployeeAvailable) { 
				$this->flashMessenger()->setNamespace('info') 
				     ->addMessage('No Employee available to calculate');  
				$service->blankCloseAnniversary($company,$dateRange);   
				$this->redirect ()->toRoute('increment',array ( 
						'action' => 'calcannivinc' 
				));  
			} else { 
				$service->calculateAnniversaryIncrement($company,$dateRange);  
				$this->flashMessenger()->setNamespace('success')
				     ->addMessage('Anniversary Increment calculated successfully'); 
				$this->redirect ()->toRoute('increment',array (
						'action' => 'calcannivinc'
				));  
			}  
		}  
		return array(
				'form' => $form,
				$prg
		); 
	} 
	
	public function calculateAction() {
		$form = $this->getSubmitForm();
		$form->get('submit')->setValue('Calculate Increment');
		$prg = $this->prg('/increment/calculate', true);
		$company = $this->getServiceLocator()->get('company');
		$dateRange = $this->getServiceLocator()->get('dateRange');
		$service = $this->getIncrementService();
		if ($prg instanceof Response ) {
			return $prg;
		} elseif ($prg === false) {
			return array (
					'form'           => $form
			);
		}
		//$dateRange = $this->getServiceLocator()->get('dateRange');
		$formValidator = $this->getFormValidator();
		$form->setInputFilter($formValidator->getInputFilter());
		$form->setData($prg); 
		if ($form->isValid()) {
			// @todo
			$isEmployeeAvailable = $service->isHaveIncrement($company,$dateRange);
			//\Zend\Debug\Debug::dump($isEmployeeAvailable);
			//exit; 
			if($isEmployeeAvailable) {
				$this->flashMessenger()->setNamespace('info')
				     ->addMessage('Increment already closed'); 
				$this->redirect ()->toRoute('increment',array (
						'action' => 'calculate'
				));
			} else {
				// @todo
				$data = $form->getData();
				//$colaPercentage = $data->getIncColaPercentage();
				$effectiveDate = $data->getApplyeEfectiveDate();
				$service->calculateIncrement($company,$dateRange);
				$this->flashMessenger()->setNamespace('success')
				     ->addMessage('Increment calculated successfully');
				$this->redirect ()->toRoute('increment',array (
						'action' => 'calculate'
				));
			}
		}
		return array(
				'form' => $form,
				$prg
		);
	} 
	
	public function applyannivincAction() { 
		$form = $this->getSubmitForm();
		$prg = $this->prg('/increment/applyannivinc', true);
		$company = $this->getServiceLocator()->get('company');
		$dateRange = $this->getServiceLocator()->get('dateRange');
		$service = $this->getIncrementService();
		if ($prg instanceof Response ) {
			return $prg;
		} elseif ($prg === false) {
			return array (
					'form'   => $form,
					// 'promotionList'  => $promotionList
			); 
		} 
		//$dateRange = $this->getServiceLocator()->get('dateRange');
		//$formValidator = $this->getFormValidator();
		//$form->setInputFilter($formValidator->getInputFilter());
		$form->setData($prg);
		if ($form->isValid()) {
			// @todo
			$isBatchOpened = false;
			//$isBatchOpened = 1;//$service->isHaveIncrement(/*Company dateRange*/);
			if($isBatchOpened) {
				$this->flashMessenger()->setNamespace('info')
				     ->addMessage('No Increment available to close, please add');
				$this->redirect ()->toRoute('increment',array (
						'action' => 'calculate'
				));
			} else {
				// @todo 
				$service->applyAnnivInc($company,$dateRange); 
				$this->flashMessenger()->setNamespace('success')
				     ->addMessage('Anniversary Increment applied successfully');
				$this->redirect ()->toRoute('increment',array (
						'action' => 'applyannivinc'
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
    
	/* private function getPromotionService() {
		return $this->getServiceLocator()->get('promotionService');  
	} */ 
	
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter'); 
	}
	
	private function getForm() {
		$form = new AnnivIncrementForm();  
		$form->get('employeeId')
		     ->setOptions(array('value_options' => $this->getEmployeeList()))
		//->setAttribute('readOnly', true)
		; 
		return $form; 
	} 
	
	private function getSubmitForm() {
		$form = new ApplyIncrementForm();
		// $form->get('incColaPercentage')->setLabel('Promotion Effective Date*');
		$form->get('submit')->setValue('Apply Increment');
		return $form; 
	}
	 
	private function getFormValidator() {
		return new ApplyIncrementFormValidator();
	}
	
	private function getAnnivIncFormValidator() {
		return new AnnivIncrementFormValidator();
	}
	
	private function getGrid() { 
		return new EmployeeAnniversaryIncrementGrid();  
	} 
	
	private function getEmployeeService() { 
		return $this->getServiceLocator()->get('employeeService');  
	} 
	 
	private function getEmployeeList() {
		$company = $this->getServiceLocator()->get('company');
		$companyId = $company->getId();
		return $this->getEmployeeService()->employeeList($companyId); 
	}
	
	private function salaryGradeList() {
		$salaryGradeService = $this->getSalaryGradeService();
		return $salaryGradeService->getSalaryGradeList(); 
	}
	
	private function getSalaryGradeService() {
		return $this->getServiceLocator()->get('salaryGradeService');
	    //return array('' => '','12' => '20','13' => '21','14' => '22');
	}
    
	public function getpromotiondetailsAction() {
		$employeeNumber = $this->params()->fromPost('empNumber');
		$toggleOpt = $this->params()->fromPost('toggleOpt');
		$promotionService = $this->getPromotionService();
		$dateRange = $this->serviceLocator->get('dateRange');
		$promotionDetails = $promotionService
		                    ->getPromotionDetails($employeeNumber,$toggleOpt,$dateRange);
		$promotionInfo = array(
				'oldInitial'          => $promotionDetails['oldInitial'],
				'oldSalaryGrade'      => $promotionDetails['oldSalaryGrade'],
				'tenPercentage'       => $promotionDetails['tenPercentage'],
				'maxQuartileOne'      => $promotionDetails['maxQuartileOne'],
				'difference'          => $promotionDetails['difference'],
				
				'promoSalaryGrade'    => $promotionDetails['promoSalaryGrade'],
				'promotedInitial'     => $promotionDetails['promotedInitial'],
				'incrementPercentage' => $promotionDetails['incrementPercentage'],
				'promotedInitial'     => $promotionDetails['promotedInitial'],
		);
		echo json_encode($promotionInfo); 
		exit;  
	} 
	
	protected function savepromotionAction() {
		//$employeeNumber = $this->params()->fromPost('empNumber');
		$formValues = $this->params()->fromPost('formVal');
		//\Zend\Debug\Debug::dump(trim($formValues['employeeNumberPromo']));
		//\Zend\Debug\Debug::dump($formValues);
		//exit;
		/* array ( 
			'employeeNumberPromo',
			'incrementPercentage',
			'promoSalaryGrade',
			'promotedInitial',
			'togglePromoOption',
			'oldSalaryGrade',
			'oldInitial',
			'tenPercentage',
			'maxQuartileOne',
			'difference',
			); */ 
		$promotionService = $this->getPromotionService(); 
		$promotionService->addPromotionToBuffer($formValues); 
		//$promotionList = $promotionService->getPromotionList(/*Company dateRange*/);
		/* $promotionInfo = array(
				'promotionList'  => $promotionList
		);
		echo json_encode($promotionInfo); */
		exit;
	}
    
	// @return latest unclosed promotion batch 
	public function getpromotionnamelistAction() { 
		$employeeNumber = $this->params()->fromPost('empNumber');
		$promotionService = $this->getPromotionService();
		$promotionList = $promotionService->getPromotionList(/*Company*/);
		$promotionInfo = array(
				'promotionList'  => $promotionList
		);
		echo json_encode($promotionInfo);
		exit;
	}
	
	private function getIncrementService() {
		return $this->getServiceLocator()->get('incrementService');
	}
	
	private function getPromotionService() {
		return $this->getServiceLocator()->get('promotionService');
	} 
}