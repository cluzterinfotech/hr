<?php

namespace Employee\Controller; 

use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController; 
use Zend\View\Model\ViewModel; 
use Employee\Form\TravelingLocalForm; 
//use Leave\Form\AnnualLeaveFormValidator; 
use Application\Model\LocationGrid;
use Application\Model\TravelLocalFormApprovaListGrid; 
use Application\Form\ApprovalForm;
use Application\Form\ApprovalFormValidator;
use Application\Form\MonthYear; 
use Leave\Form\LeaveReportForm; 
use Employee\Form\TravelingLocalFormValidator;

class TravelingabroadController extends AbstractActionController {
    
	public function indexAction() { exit; }
	
	public function listAction() { }
	
	public function ajaxlistAction() {
		$grid = $this->getGrid();
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getLeaveService()->getLeaveFormApprovalList())
		     ->setParamAdapter($this->getRequest()->getPost()); 
		return $this->htmlResponse($grid->render()); 
	}
	
	public function addAction() { 
		$form = $this->getTravelingLocalForm();
		$prg = $this->prg('/travelinglocal/add', true);
		if ($prg instanceof Response ) {
			return $prg;
		} elseif ($prg === false) {
			return array ('form' => $form);
		}
		$formValidator = $this->getFormValidator(); 
		$form->setInputFilter($formValidator->getInputFilter()); 
		
		$service = $this->getLeaveService(); 
		//echo "outside"; 
		//exit; 
		
		$form->setData($prg); 
		if ($form->isValid()) {
			$data = $form->getData(); 
			//\Zend\Debug\Debug::dump($data);
			//exit; 
			$service->insert($data);   
			$this->flashMessenger()->setNamespace('success')
			     ->addMessage('Traveling Form added successfully');
			$this->redirect()->toRoute('travelinglocal',array(
					'action' => 'add'
			)); 
		}  
		return array(
				'form' => $form,
				$prg
		);  
	} 
	
	public function editAction() {
	    
		$id = (int) $this->params()->fromRoute('id',0);
		if (!$id) {
			$this->flashMessenger()->setNamespace('info')
			     ->addMessage('Traveling form not found,Please Add');
			$this->redirect()->toRoute('travelinglocal', array(
					'action' => 'add'
			)); 
		} 
		
		$form = $this->getLocationForm();
		$service = $this->getLocationService();
		$location = $service->fetchById($id);
		$form = $this->getLocationForm();
		$form->bind($location);
		$form->get('submit')->setAttribute('value','Update Traveling Form');
	    
		$prg = $this->prg('/annualleave/edit/'.$id, true);
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
			\Zend\Debug\Debug::dump($data); 
			exit; 
			/* $service->update($data);
			$this->flashMessenger()->setNamespace('success')
			     ->addMessage('Location updated successfully');
			$this->redirect ()->toRoute('location',array (
					'action' => 'list'
			)); */ 
		} 
		return array(
				'form' => $form,
				$prg
		);
	}
	
	public function approveAction() { 
		$id = (int) $this->params()->fromRoute('id',0); 
		if (!$id) { 
			$this->flashMessenger()->setNamespace('info') 
			     ->addMessage('Traveling Form not found,Please Add'); 
			$this->redirect()->toRoute('travelinglocal', array( 
					'action' => 'add' 
			));    
		}    
		$service = $this->getLeaveService(); 
		$travelInfo = $service->travelInfoById($id); 
		$form = $this->getApprovalForm();  
		// $form->bind($leave);  
		$form->get('id')->setValue($id); 
		// $form->get('submit')->setAttribute('value','Approve Annual Leave');  
		$prg = $this->prg('/travelinglocal/approve/'.$id, true); 
		
		if ($prg instanceof Response ) {  
			return $prg; 
		} elseif ($prg === false) { 
			return array ('form' => $form,'travelInfo' => $travelInfo,); 
		}  
		
		$formValidator = $this->getApprovalFormValidator();
		$form->setInputFilter($formValidator->getInputFilter());
		$form->setData($prg); 
		if ($form->isValid()) { 
			$data = $form->getData();  
			//\Zend\Debug\Debug::dump($data);
			//exit; 
			$message = $service->approveLeave($data,'1');  
		    $this->flashMessenger()->setNamespace('info')
				 ->addMessage($message);  
			$this->redirect ()->toRoute('travelinglocal',array (
				'action' => 'list'
			)); 
		} 
		return array(
				'id'        => $id,
				'form'      => $form,
				'travelInfo' => $travelInfo,
				$prg 
		);  
	} 
	
	/*
	public function approveAction() {
		 
		$id = (int) $this->params()->fromRoute('id',0);
		if (!$id) {
			$this->flashMessenger()->setNamespace('info')
			->addMessage('leave not found,Please Add');
			$this->redirect()->toRoute('annualleave', array(
					'action' => 'add'
			)); 
		} 
	    
		$service = $this->getLeaveService();
		$leave = $service->fetchLeaveById($id);
		//\Zend\Debug\Debug::dump($leave);
		$form = $this->getTravelingLocalForm();
		$form->bind($leave);
		$form->get('submit')->setAttribute('value','Approve Annual Leave');
	    
		$prg = $this->prg('/annualleave/approve/'.$id, true);
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
			// $service->update($data);
			$this->flashMessenger()->setNamespace('success')
			->addMessage('Leave approved successfully');
			$this->redirect ()->toRoute('annualleave',array (
					'action' => 'list'
			));
		}
		return array(
				'id' => $id,
				'form' => $form,
				$prg
		);
	
	}
	*/
	
	public function htmlResponse($html) {
		$response = $this->getResponse();
		$response->setStatusCode(200);
		$response->setContent($html);
		return $response;
	}
	
	private function getLocationService() { 
		return $this->getServiceLocator()->get('locationMapper'); 
	} 
	
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter'); 
	} 
	
	private function getTravelingLocalForm() { 
		$form = new TravelingLocalForm(); 
		// $form = new AnnualLeaveForm(); 
		//$form->get('joinDate')->setAttribute('readOnly', true);
		//$form->get('leaveFrom')->setAttribute('readOnly', true);
		//$form->get('leaveTo')->setAttribute('readOnly', true); 
		$form->get('employeeNumberTravelingLocal')
		     ->setOptions(
		     		array(
		     		    'value_options' => $this->getEmployeeWithDelegatedList() 
		));  
		$form->get('travelingFormEmpPosition')
		     ->setOptions(array('value_options' => $this->getPositionList()))
		     //->setAttribute('disabled', true)
		; 
		$form->get('meansOfTransport')
		->setOptions(array('value_options' => $this->getMeansOfTransport()));
		//$form->get('departmentId')->setOptions(array('value_options' => $this->getDepartmentList()));
		//$form->get('locationId')->setOptions(array('value_options'=> $this->getLocationList()));
		$form->get('delegatedEmployee')->setOptions(array('value_options'=> $this->getEmployeeList()));
		return $form;  
	} 
	
	private function getApprovalForm() {
		return new ApprovalForm(); 
		// return $form; 
	} 
	
	public function employeetravelInfoAction() {
		// @todo get all array info 
		$employeeNumber = $this->params()->fromPost('empNumber');
		$empService = $this->getEmployeeService();
		$leaveService = $this->getLeaveService();
		$empInfo = $empService->employeeInfo($employeeNumber);
		$travelInfo = $leaveService->employeetravelInfo($employeeNumber);
		$empInfo = array(
	        //'isHaveLeave'        => $travelInfo->isHaveLeave(),
			  'position'           => $empInfo['position'],
		      'department'         => $empInfo['department'],
			  'location'           => $empInfo['location'],
			  'doj'                => $empInfo['doj'],
			  'daysEntitled'       => $travelInfo['daysEntitled'],
			  'outstandingBalance' => $travelInfo['outstandingBalance'],
			  'daysTaken'          => $travelInfo['daysTaken'],
			  // 'thisLeaveDays'      => $travelInfo['thisLeaveDays'],
			  'revisedDays'        => $travelInfo['revisedDays'],
			  // 'remainingDays'      => $travelInfo['remainingDays'], 
		); 
		echo json_encode($empInfo);   
		exit;  
	}   
	
	public function reportAction() { 
	    
		$form = $this->getReportForm();
		$request = $this->getRequest();
		if ($request->isPost()) {
			$form->setData($request->getPost());
			if ($form->isValid()) {
				return $this->redirect()->toRoute('paysheet');
			}
		}
		return array(
				'form' => $form,
		);  
	}   
	
	public function getReportForm() {
		$form = new LeaveReportForm(); 
		$form->get('employeeLeaveReport')
		     ->setOptions(array('value_options' => $this->getEmployeeList()
		));  
		$form->get('leaveTypeReport')
		     ->setOptions(array('value_options' => $this->getLeaveType()
		)); 
		$form->get('submit')->setValue('View Annual Leave Report'); 
		return $form;
	} 
	
	private function getMeansOfTransport() {
		return $this->getLookupService()->getMeansOfTransport();
	}
	
	public function viewreportAction() {
	
		$viewmodel = new ViewModel();
		$viewmodel->setTerminal(1);
		$request = $this->getRequest();
		$output = " "; 
		if($request->isPost()) { 
			$values = $request->getPost();
			$month = $values['month'];
			$year = $values['year'];
			$type = 1; 
			$param = array('month' => $month,'year' => $year);
			//$company = $this->getCompanyService();
			//$results = $this->getPaysheetService()->getPaysheetReport($param);
			//$output = $this->getLeaveService()->travelInfoById('50'); 
			$output = $this->getLeaveService()->getAnnualLeaveReport(array());
	        
		}   
		// \Zend\Debug\Debug::dump($output);    
		$viewmodel->setVariables(array( 
				'report'            => $output, 
				'name'              => array('Employee Name' => 'employeeName'), 
				//'allowance'         => $this->getPaysheetAllowanceArray(), 
				//'deduction'         => $this->getPaysheetDeductionArray(), 
				//'companyDeduction'  => $this->companyDeductionArray() 
		)); 
		return $viewmodel; 
	}  
	
	public function ishaveoverlapAction() {
		$service = $this->nonWorkingDaysService();
		$employeeNumber =$this->params()->fromPost('empNumber');
		$fromDate = $this->params()->fromPost('fromDate');
		$toDate = $this->params()->fromPost('toDate'); 		
		$result = $service->isOverlap($employeeNumber,$fromDate,$toDate); 
		$res = array(
				'success' => $result['0'], 
				'message' => $result['1']	
		); 
		echo json_encode($res); 
		exit; 
	} 
	
	private function nonWorkingDaysService() {
		return $this->serviceLocator->get('nonWorkingDays'); 
	}
	
	private function getFormValidator() {
		return new TravelingLocalFormValidator();  
	}
	
	private function getApprovalFormValidator() {
		return new ApprovalFormValidator(); 
	}
	
	private function getGrid() {
		return new TravelLocalFormApprovaListGrid();
	}
	
	private function getLeaveType() {
		return $this->getLookupService()->getLeaveType(); 
	}
	
	private function getLookupService() {
		return $this->getServiceLocator()->get('lookupService');
	}
	
	private function getLeaveService() {
		return $this->getServiceLocator()->get('leaveService'); 
	}
	
	private function getEmployeeService() {
		return $this->getServiceLocator()->get('employeeService'); 
	}
	
	private function getEmployeeWithDelegatedList() {
		//$employeeService = $this->getEmployeeService(); 
		return $this->getEmployeeService()->employeeWithDelegatedList();
	}
	
	private function getEmployeeList() { 
		return $this->getEmployeeService()->employeeList(); 
	}
	
	private function getPositionList() {
		return $this->getPositionService()->getPositionList();
	} 
	
	private function getPositionService() {
		return $this->getServiceLocator()->get('positionService');
	}
	
	private function getDepartmentList() {
		return $this->getLookupService()->getDepartmentList(); 
		
	}
	
	private function getLocationList() {
		return $this->getLookupService()->getLocationList();
	}
	
	private function getDelegatedEmployeeList() {
		return $this->getEmployeeList(); 
	}
	
}