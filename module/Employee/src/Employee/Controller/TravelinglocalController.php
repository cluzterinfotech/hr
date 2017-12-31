<?php 

namespace Employee\Controller; 

use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController; 
use Zend\View\Model\ViewModel; 
use Employee\Form\TravelingLocalForm; 
//use Leave\Form\AnnualLeaveFormValidator; 
//use Application\Model\LocationGrid;
use Application\Model\TravelLocalFormApprovaListGrid;  
use Application\Model\TravelLocalFormApprovaSeqListGrid; 
use Application\Model\TravelLocalFormApprovedListGrid;
use Application\Model\TravelLocalFormAdminApprovaListGrid; 
use Application\Form\ApprovalForm; 
use Application\Form\AdminApprovalTraLocForm; 
use Application\Form\ApprovalFormValidator; 
//use Application\Form\MonthYear;  
use Leave\Form\LeaveReportForm;  
use Employee\Form\TravelingLocalFormValidator; 

class TravelinglocalController extends AbstractActionController {
    
	public function indexAction() { exit; }
	
	public function listAction() { }
	
	public function ajaxlistAction() { 
		$grid = $this->getGrid();
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getTravelingService()->getTravelingLocalFormApprovalList())
		     ->setParamAdapter($this->getRequest()->getPost()); 
		return $this->htmlResponse($grid->render()); 
	} 
	
	public function listadminAction() { }
	
	public function ajaxlistadminAction() {
		$grid = $this->getAdminGrid(); 
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getTravelingService()->getTravelingLocalFormApprovalListAdmin())
		     ->setParamAdapter($this->getRequest()->getPost());  
		return $this->htmlResponse($grid->render());  
	}  
	
	public function appsequencelistAction() { } 
	
	public function ajaxappsequencelistAction() { 
		$grid = $this->getSeqGrid(); 
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getTravelingService()->getTravelingLocalApprovalSequenceList())
		     ->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render()); 
	} 
	
	public function formstatusAction() { } 
	
	public function statuslistAction() { 
		$grid = $this->getGrid();
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getTravelingService()->getTravelingLocalFormApprovalList())
		     ->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render());
	}   
	
	public function reportadminAction() { }
	
	public function ajaxadmlistAction() {
		$grid = $this->getReportAdmGrid(); 
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getTravelingService()->getTravelLocalFormApprovedList())
		     ->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render());
	} 
	
	public function addAction() { 
		$form = $this->getTravelingForm();
		$prg = $this->prg('/travelinglocal/add',true);
		if ($prg instanceof Response ) {
			return $prg;
		} elseif ($prg === false) {
			return array ('form' => $form); 
		} 
		$formValidator = $this->getFormValidator();  
		$form->setInputFilter($formValidator->getInputFilter()); 
		$service = $this->getTravelingService(); 
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
	    
		$prg = $this->prg('/travelinglocal/edit/'.$id, true);
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
		$service = $this->getTravelingService(); 
		$travelInfo = $service->travelInfoById($id); 
		$form = $this->getApprovalForm(); 
		$localFormApp = $service->fetchTravelingById($id);
		//\Zend\Debug\Debug::dump($localFormApp);
		//exit; 
		//$form = $this->getLocationForm();
		$form->bind($localFormApp);
		// $form->bind($leave); 
		//$form->get('id')->setValue($id); 
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
			$appType = $form->get('approvalType')->getValue();
			$obj = $form->getData(); 
			$data = array('id'              => $obj->getId(),
				          'approvalType'    => $appType,
					      'expenseApproved' => $obj->getExpenseApproved(),
			);  
			$message = $service->approveTravelLocal($data,'1');  
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
	
	public function approveadminAction() {
		$id = (int) $this->params()->fromRoute('id',0);
		if (!$id) {
			$this->flashMessenger()->setNamespace('info')
			     ->addMessage('Traveling Form not found,Please Add');
			$this->redirect()->toRoute('travelinglocal', array(
					'action' => 'add'
			));
		}
		$service = $this->getTravelingService();
		$travelInfo = $service->travelInfoById($id);
		$form = $this->getAdminApprovalForm(); 
		$localFormApp = $service->fetchTravelingById($id);  
		$form->bind($localFormApp); 
		$prg = $this->prg('/travelinglocal/approveadmin/'.$id, true);
		if ($prg instanceof Response ) {
			return $prg; 
		} elseif ($prg === false) {
			return array ('form' => $form,'travelInfo' => $travelInfo,);
		}
		$formValidator = $this->getApprovalFormValidator();
	    
		$form->setInputFilter($formValidator->getInputFilter());
		$form->setData($prg);
		if ($form->isValid()) {
			$appType = $form->get('approvalType')->getValue();
			$obj = $form->getData();
			$data = array('id'              => $obj->getId(),
					'approvalType'    => $appType,
					'expenseApproved' => $obj->getExpenseApproved(),
			);
			$message = $service->approveAdminTravelLocal($data,'1'); 
			$this->flashMessenger()->setNamespace('info')
			                       ->addMessage($message);
			$this->redirect ()->toRoute('travelinglocal',array (
					'action' => 'listadmin'
			));  
		}
		return array(
				'id'        => $id,
				'form'      => $form,
				'travelInfo' => $travelInfo,
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
     
	private function getTravelingForm() {
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
		//$form->get('locationId')->setOptions(array('value_options'=> $this->getLocationList()));
		$form->get('delegatedEmployee')
		     ->setOptions(array('value_options'=> $this->getEmployeeList()));
		return $form;   
	} 
	
	private function getApprovalForm() {
		return new ApprovalForm(); 
		// return $form; 
	} 
	
	private function getAdminApprovalForm() {
		return new AdminApprovalTraLocForm();
		// return $form; 
	} 
	
	public function employeepositionAction() { 
		// @todo get all array info 
		$employeeNumber = $this->params()->fromPost('empNumber');
		$empService = $this->getEmployeeService();
		// $leaveService = $this->getTravelingService();
		$empInfo = $empService->employeeInfo($employeeNumber); 
		$empInfo = array( 
			  'position'           => $empInfo['position'],
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
				return $this->redirect()->toRoute('travelinglocal'); 
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
	
	public function viewreportAction() {
		$id = (int) $this->params()->fromRoute('id',0);
		//\Zend\Debug\Debug::dump($id);
		//exit; 
		$viewmodel = new ViewModel();
		$viewmodel->setTerminal(1);
		$request = $this->getRequest();
		// $output = " "; 
		//if($request->isPost()) { 
			$values = $request->getPost(); 
			$output = $this->getTravelingService()->getTravelingFormReport($id); 
		//}     
		$viewmodel->setVariables(array( 
				'report'            => $output, 
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
	
	private function getAdminGrid() {
		return new TravelLocalFormAdminApprovaListGrid();
	} 
	
	private function getSeqGrid() {
		return new TravelLocalFormApprovaSeqListGrid();
	}
	
	private function getStatusGrid() {
		return new TravelLocalFormApprovaListGrid();
	}
	
	private function getReportAdmGrid() {
		return new TravelLocalFormApprovedListGrid();
	}
	
	private function getLeaveType() {
		return $this->getLookupService()->getLeaveType(); 
	}
	
	private function getMeansOfTransport() {
		return $this->getLookupService()->getMeansOfTransport(); 
	}
	
	private function getLookupService() {
		return $this->getServiceLocator()->get('lookupService');
	}
	
	private function getTravelingService() {
		return $this->getServiceLocator()->get('travelingService'); 
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
	
}