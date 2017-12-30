<?php

namespace Leave\Controller; 

use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController; 
use Zend\View\Model\ViewModel; 
use Leave\Form\AnnualLeaveForm; 
use Leave\Form\AnnualLeaveFormValidator; 
use Application\Model\LeaveFormApprovaListGrid;
use Application\Form\ApprovalForm;
use Application\Form\ApprovalFormValidator;
use Leave\Form\LeaveReportForm; 
use Application\Model\OutstandingBalanceGrid;
use Application\Form\LeaveApprovalFormValidator;
use Application\Model\LeaveAppForm;
use Application\Form\LeaveApprovalForm;

class AnnualleaveController extends AbstractActionController {
    
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
		$form = $this->getAnnualLeaveForm();
		$prg = $this->prg('/annualleave/add', true);
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
			     ->addMessage('Annual Leave added successfully');
			$this->redirect()->toRoute('annualleave',array(
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
			     ->addMessage('leave not found,Please Add');
			$this->redirect()->toRoute('annualleave', array(
					'action' => 'add'
			)); 
		} 
		
		$form = $this->getLocationForm();
		$service = $this->getLocationService();
		$location = $service->fetchById($id);
		$form = $this->getLocationForm();
		$form->bind($location);
		$form->get('submit')->setAttribute('value','Update Annual Leave');
	    
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
			     ->addMessage('leave not found,Please Add'); 
			$this->redirect()->toRoute('annualleave', array( 
					'action' => 'add' 
			));  
		}  
		$service = $this->getLeaveService(); 
		$leaveInfo = $service->leaveInfoById($id); 
		$form = $this->getApprovalForm();  
		// $form->bind($leave); 
		$form->get('id')->setValue($id); 
		// $form->get('submit')->setAttribute('value','Approve Annual Leave'); 
		$prg = $this->prg('/annualleave/approve/'.$id, true); 
		
		if ($prg instanceof Response ) { 
			return $prg; 
		} elseif ($prg === false) { 
			return array ('form' => $form,'leaveInfo' => $leaveInfo,); 
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
			$this->redirect ()->toRoute('annualleave',array (
				'action' => 'list'
			)); 
		} 
		return array(
				'id'        => $id,
				'form'      => $form,
				'leaveInfo' => $leaveInfo,
				$prg 
		); 
	} 
	
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
	
	private function getAnnualLeaveForm() {
		$form = new AnnualLeaveForm(); 
		//$form->get('joinDate')->setAttribute('readOnly', true);
		//$form->get('leaveFrom')->setAttribute('readOnly', true);
		//$form->get('leaveTo')->setAttribute('readOnly', true);
		$form->get('employeeId')
		     ->setOptions(
		     		array(
		     		    'value_options' => $this->getEmployeeWithDelegatedList() 
		     		)); 
		$form->get('positionId')
		     ->setOptions(array('value_options' => $this->getPositionList()))
		     //->setAttribute('disabled', true)
		; 
		$form->get('departmentId')->setOptions(array('value_options' => $this->getDepartmentList()));
		$form->get('locationId')->setOptions(array('value_options'=> $this->getLocationList()));
		$form->get('delegatedPositionId')->setOptions(array('value_options'=> $this->getEmployeeList()));
		return $form;  
	} 
	
	private function getApprovalForm() {
		return new LeaveApprovalForm();  
		// return $form; 
	} 
	
	public function employeeleaveinfoAction() {
		// @todo get all array info 
		$employeeNumber = $this->params()->fromPost('empNumber');
		$empService = $this->getEmployeeService();
		$leaveService = $this->getLeaveService();
		$empInfo = $empService->employeeInfo($employeeNumber);
		$leaveInfo = $leaveService->employeeLeaveInfo($employeeNumber);
		$empInfo = array(
	        //'isHaveLeave'        => $leaveInfo->isHaveLeave(),
			  'position'           => $empInfo['position'],
		      'department'         => $empInfo['department'],
			  'location'           => $empInfo['location'],
			  'doj'                => $empInfo['doj'],
			  'daysEntitled'       => $leaveInfo['daysEntitled'],
			  'outstandingBalance' => $leaveInfo['outstandingBalance'],
			  'daysTaken'          => $leaveInfo['daysTaken'],
			  // 'thisLeaveDays'      => $leaveInfo['thisLeaveDays'],
			  'revisedDays'        => $leaveInfo['revisedDays'],
			  // 'remainingDays'      => $leaveInfo['remainingDays'], 
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
		$form->get('leaveDepartment')
		     ->setOptions(array('value_options' => $this->getDepartmentList()
		));
		$form->get('leaveLocation')
		     ->setOptions(array('value_options' => $this->getLocationList()
		));
		$form->get('leaveTypeReport')
		     ->setOptions(array('value_options' => $this->getLeaveType()
		)); 
		$form->get('submit')->setValue('View Leave Report'); 
		return $form;
	} 
	
	public function viewreportAction() { 	
		$viewmodel = new ViewModel();
		$viewmodel->setTerminal(1);
		$request = $this->getRequest();
		$output = " "; 
		if($request->isPost()) { 
		    $dateRange = $this->getServiceLocator()->get('dateRange'); 
		    $dateMethods = $this->getServiceLocator()->get('DateMethods');
			$values = $request->getPost();  
			//$t = 1; 
			$year = $values['year'];
			$month = $values['month'];
			if($month && $year) {
			    $from = $year."-".$month."-01";
			    $to = $dateMethods->getLastDayOfDate($from);
			}
			if($month && !$year) {
			    $from =date('Y')."-".$month."-01"; 
			    $to = $dateMethods->getLastDayOfDate($from);
			}
			if($year && !$month) {
			    $from = $year."-01-01"; //.date('m').date('d');
			    $to = $year."-12-31";  
			}
			if(!$month && !$year) {
			    $from = $dateRange->getFromDate(); 
			    $to = $dateRange->getToDate();  
			}
			
			$fromDt = $dateMethods->customFormatDate($from);
			$toDt = $dateMethods->customFormatDate($to);
			$reportDtls .= "<b>From : </b>".$leaveEmployee."<br/>";
			$leaveType = $values['leaveTypeReport_combobox'];
			$leaveLocation = $values['leaveLocation_combobox'];
			$leaveDepartment = $values['leaveDepartment_combobox'];
			$leaveEmployee = $values['employeeLeaveReport_combobox']; 
			$reportDtls = "";
			$reportDtls .= "<b>From Date : </b>".$fromDt."<br/>"; 
			$reportDtls .= "<b>To Date : </b>".$toDt."<br/>"; 
			if($leaveEmployee)
			    $reportDtls .= "<b>Employee Name : </b>".$leaveEmployee."<br/>"; 
			if($leaveType) 
			    $reportDtls .= "<b>Leave Type : </b>".$leaveType."<br/>";
			if($leaveLocation) 
			    $reportDtls .= "<b>Location : </b>".$leaveLocation."<br/>";
			if($leaveDepartment) 
			    $reportDtls .= "<b>Department : </b>".$leaveDepartment."<br/>";
			// \Zend\Debug\Debug::dump($values);  
			// exit;  
			// 1 when no arguments selected  
			
			// 2 when only year 
			// 3 when only month 
			// 4 when month and year(date range)  
			// 5 
			$company = $this->getServiceLocator()->get('company');  
			//if($t == 1) {
			$output = $this->getLeaveService()->employeeAllRecentLeave($company,$values,$from,$to); 
			//}
			// $output = $this->getLeaveService()->getAnnualLeaveReport($company,$values);  
			$reportDtls .= "<br/>"; 
		}       
		$viewmodel->setVariables(array( 
				'report'            => $output, 
		    'reportDtls'        => $reportDtls,   
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
		return new AnnualLeaveFormValidator(); 
	}
	
	private function getApprovalFormValidator() {
	    return new LeaveApprovalFormValidator(); 
	}
	
	private function getGrid() {
		return new LeaveFormApprovaListGrid();
	}
	
	private function getobGrid() {
		return new OutstandingBalanceGrid(); 
	}
	
	private function getEmpLocation() {
	    return $this->getLookupService()->getLocationList();
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
		$company = $this->getServiceLocator()->get('company');
		$companyId = $company->getId(); 
		return $this->getEmployeeService()->employeeList($companyId); 
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
	
	public function outstandingbalanceAction() { }
	
	public function ajaxoutstandingbalanceAction() {
		$grid = $this->getobGrid();
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getLeaveService()->outstandingBalanceList())
		     ->setParamAdapter($this->getRequest()->getPost()); 
		return $this->htmlResponse($grid->render());
	}
	
}