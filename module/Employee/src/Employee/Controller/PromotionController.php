<?php 

namespace Employee\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Http\PhpEnvironment\Response; 
use Employee\Form\PromotionForm;
use Employee\Form\PromotionFormValidator;
use Application\Form\EffectiveDateForm;
use Employee\Form\SubmitButonFormValidator;
use Application\Model\PromotionGrid; 
use Employee\Form\PromotionReport;
use Employee\Form\MismatchReportForm;

class PromotionController extends AbstractActionController {
	
	public function indexAction() { exit; }
	
	public function listAction() { }
	
	public function ajaxlistAction() {
		$grid = $this->getGrid();
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getPromotionService()->selectPromotion())
		     ->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render()); 
	} 
	
	public function addAction() {
		$form = $this->getForm();
		$promotionService = $this->getPromotionService();
		$promotionList = $promotionService->getPromotionList(
				$this->serviceLocator->get('company'));
		$prg = $this->prg('/promotion/add', true);
		if ($prg instanceof Response ) {
			return $prg;
		} elseif ($prg === false) {
			return array (
					'form' => $form,
					'promotionList'   => $promotionList 
			); 
		}
		
		$formValidator = $this->getFormValidator();
		$form->setInputFilter($formValidator->getInputFilter());
		$form->setData($prg);
		
		if ($form->isValid()) {
			$data = $form->getData();
			$service = $this->getPromotionService(); 
			$service->insert($data);
			$this->flashMessenger()->setNamespace('success')
			                       ->addMessage('Promotion added successfully'); 
			$this->redirect ()->toRoute('promotion',array (
					'action' => 'add'
			));
		}
		//var_dump($this->getPromotionList());
		//exit;
		
		return array(
				'form' => $form,
				'promotionList'   => $promotionList,
				$prg
		);
	}
    
	public function editAction() {
		
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			$this->flashMessenger()->setNamespace('info')
			                       ->addMessage('Location not found,Please Add');
			$this->redirect()->toRoute('promotion', array(
					'action' => 'add'
			)); 
		}
		$form = $this->getForm(); 
		$service = $this->getPromotionService(); 
		$location = $service->fetchById($id); 
		$form = $this->getLocationForm(); 
		$form->bind($location); 
		$form->get('submit')->setAttribute('value','Update Promotion'); 
		
		$prg = $this->prg('/promotion/edit/'.$id, true); 
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
			                       ->addMessage('Promotion updated successfully');
			$this->redirect ()->toRoute('promotion',array (
					'action' => 'list'
			));
		}
		return array(
				'form' => $form,
				$prg
		); 
	}
	
	public function applypromotionAction() {
		$form = $this->getSubmitForm(); 
		$prg = $this->prg('/promotion/applypromotion', true); 
		$company = $this->getServiceLocator()->get('company');
		$promotionService = $this->getPromotionService(); 
		$promotionList = $promotionService->getPromotionList(/*Company*/); 
		if ($prg instanceof Response ) { 
			return $prg; 
		} elseif ($prg === false) { 
			return array ( 
					'form' => $form, 
					'promotionList'   => $promotionList  
			); 
		} 
		
		//$dateRange = $this->getServiceLocator()->get('dateRange');
         
		$formValidator = $this->getFormValidator();
		$form->setInputFilter($formValidator->getInputFilter());
		$form->setData($prg);
		
		if ($form->isValid()) {
			// @todo 
			$isBatchOpened = false;
			//$isBatchOpened = 1;//$promotionService->isHaveOpenedBatch(/*Company dateRange*/);
			if($isBatchOpened) {
				$this->flashMessenger()->setNamespace('info')
				     ->addMessage('No Promotion batch available to close, please add');
				$this->redirect ()->toRoute('promotion',array (
						'action' => 'add'
				)); 
			} else {
				// @todo 
				$data = $form->getData(); 
				$service = $this->getPromotionService(); 
				$effectiveDate = $data->getEffectiveDate();
				//\Zend\Debug\Debug::dump($data);
				//\Zend\Debug\Debug::dump($effectiveDate); 
				//exit; 
				$service->applyPromotion($effectiveDate,$company); 
				$this->flashMessenger()->setNamespace('success')
				     ->addMessage('Promotion applied successfully');
				$this->redirect ()->toRoute('promotion',array (
						'action' => 'add'
				)); 
			} 	
		}
		
		return array(
				'form' => $form,
				'promotionList'   => $promotionList,
				$prg
		);  
	} 
	
	public function removeAction()
	{
		// @todo
		$id = (int) $this->params()->fromRoute('id',0);
		$promotionService = $this->getPromotionService();
		$promotionService->removeEmployeePromotion($id);
		// echo json_encode($id);
		exit;
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
		$form = new PromotionForm();
		$form->get('employeeNumberPromo')
		     ->setOptions(array('value_options' => $this->getEmployeeList()))
		//->setAttribute('readOnly', true)
		;
		$form->get('oldSalaryGrade')
		     ->setOptions(array('value_options' => $this->salaryGradeList()))
		//->setAttribute('readOnly', true)
		;
		$form->get('promoSalaryGrade')
		     ->setOptions(array('value_options' => $this->salaryGradeList()))
		//->setAttribute('readOnly', true)
		;
		return $form;
	}
	
	private function getSubmitForm() {
		$form = new EffectiveDateForm();
		$form->get('effectiveDate')->setLabel('Promotion Effective Date*');
		$form->get('submit')->setValue('Apply Promotion');
		return $form;
	}
	
	private function getFormValidator() {
		return new SubmitButonFormValidator();
	}
	
	private function getGrid() {
		return new PromotionGrid();
	}
	
	private function getEmployeeService() {
		return $this->getServiceLocator()->get('employeeMapper');
	}
	
	private function getEmployeeList() {
		$company = $this->getCompanyService(); 
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
		$employeeService = $this->getEmployeeService();
		$initial = $employeeService->getEmployeeInitial($employeeNumber);
		//\Zend\Debug\Debug::dump($initial);
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
	
	public function reportAction() {
		$form = $this->getReportForm();
		$request = $this->getRequest();
		if ($request->isPost()) {
			$form->setData($request->getPost());
			if ($form->isValid()) {
				return $this->redirect()->toRoute('promotion');
			}
		}
		return array (
				'form' => $form
		); 
	}
	
	public function reportmismatchAction() {
		$form = $this->getMismatchReportForm(); 
		$request = $this->getRequest();
		if ($request->isPost()) {
			$form->setData($request->getPost());
			if ($form->isValid()) {
				return $this->redirect()->toRoute('promotion');
			}
		}
		return array (
				'form' => $form
		);
	}
	
	public function viewmismatchreportAction() {
		$viewmodel = new ViewModel ();
		$viewmodel->setTerminal ( 1 );
		$request = $this->getRequest ();
		$output = " ";
		if ($request->isPost ()) {
			$values = $request->getPost();
			$company = $this->getCompanyService();
			$output = $this->getPromotionService()->mismatchReport($company,$values);
		}
		// \Zend\Debug\Debug::dump($output) ;
		$viewmodel->setVariables ( array (
				'report' => $output
		));
		return $viewmodel;
	}
	
	public function viewreportAction() {
		$viewmodel = new ViewModel ();
		$viewmodel->setTerminal ( 1 );
		$request = $this->getRequest ();
		$output = " ";
		if ($request->isPost ()) {
			$values = $request->getPost();
			$company = $this->getCompanyService();
			$output = $this->getPromotionService()->promotionReport($company,$values); 
		}
		// \Zend\Debug\Debug::dump($output) ;
		$viewmodel->setVariables ( array (
				'report' => $output
		));
		return $viewmodel;
	}
	
	public function getReportForm() {
		$form = new PromotionReport(); 
		$form->get('empIdPromotion')
		     ->setOptions(array('value_options' => $this->getEmployeeList()))
		;
		$form->get('departmentPromotion')
		     ->setOptions(array('value_options' => $this->getDepartmentList()))
		; 
		return $form; 
	}   
	
	public function getMismatchReportForm() {
		$form = new MismatchReportForm();
		$form->get('empIdMismatch')
		     ->setOptions(array('value_options' => $this->getEmployeeList()))
		;
		$form->get('departmentMismatch')
		     ->setOptions(array('value_options' => $this->getDepartmentList()))
		;
		$form->get('mismatchJobGrade')
		     ->setOptions(array('value_options' => $this->getJobGradeList()))
		;
		return $form; 
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
	
	private function getCompanyService(){
		return $this->getServiceLocator()->get('company');
	}
	
	private function getJobGradeList() {
		return $this->getLookupService()->getJobGradeList();
	}
	
	private function getDepartmentList() {
		return $this->getLookupService()->getDepartmentList();
	} 
	
	private function getLookupService() {
		return $this->getServiceLocator()->get('lookupService');
	} 
	
	private function getPromotionService() {
		return $this->getServiceLocator()->get('promotionService');
	} 
}