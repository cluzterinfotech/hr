<?php
     
namespace Payment\Controller;
      
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController; 
use Payment\Form\OverTimeForm;
use Payment\Form\OvertimeFormValidator; 
use Payment\Model\DateRange; 
use Application\Model\OvertimeApproveGrid;
use Application\Model\OvertimeEndorseGrid;
use Application\Model\AttendanceGrid;
use Application\Form\OtApprovalForm;
use Application\Form\OtApprovalFormValidator;
use Application\Form\SubmitButonForm;
use Payment\Form\JustificationForm;

class AttenjustificationController extends AbstractActionController { 
    
    public function htmlResponse($html) {
        $response = $this->getResponse();
        $response->setStatusCode(200);
        $response->setContent($html);
        return $response;
    }   
    
    public function listAction() { } 
    
    public function testAction() { }
    
    public function ajaxlistAction() {
        $grid = $this->getGrid();
        $postVal = $this->getRequest()->getPost();
        $emp = $postVal['empIdOvertime'];
        $from = $postVal['otFromDate'];
        $to = $postVal['otToDate'];
        $arr = array('emp' => $emp,'from' => $from,'to' => $to);
        $grid->setAdapter($this->getDbAdapter())
             ->setSource($this->getService()
             		->selectEmployeeAttendance($arr))
             ->setParamAdapter($this->getRequest()->getPost()); 
        return $this->htmlResponse($grid->render());   
    } 
    
    public function attendanceajaxlistAction() {
    	$grid = $this->getGrid();
    	$grid->setAdapter($this->getDbAdapter())
    	     ->setSource($this->getService()
    		 ->selectEmployeeOvertime($this->getUser()))
    		 ->setParamAdapter($this->getRequest()->getPost());
    			//\Zend\Debug\Debug::dump($grid); exit;
    	return $this->htmlResponse($grid->render());  
    }
    
    public function approvelistAction() {
    	$grid = $this->getApproveGrid();
    	$grid->setAdapter($this->getDbAdapter())
    	     ->setSource($this->getService()
    			->getOvertimeFormApprovalList($this->getUser()))
    			->setParamAdapter($this->getRequest()->getPost());
    	//\Zend\Debug\Debug::dump($grid); exit;
    	return $this->htmlResponse($grid->render());
    } 
    
    public function endorselistAction() {
    	$grid = $this->getEndorseGrid();
    	$grid->setAdapter($this->getDbAdapter())
    	     ->setSource($this->getService()
    			->getOvertimeFormEndorseList($this->getUser()))
    			->setParamAdapter($this->getRequest()->getPost());
    	//\Zend\Debug\Debug::dump($grid); exit;
    	return $this->htmlResponse($grid->render()); 
    } 
    
    public function jsonResponse($data)
    {
    	if(!is_array($data)){
    		throw new \Exception('$data param must be array');
    	} 
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	$response->setContent(json_encode($data));
    	return $response;
    }
    
    public function updateotrowAction() {
    	$param = $this->getRequest()->getPost(); 
    	$array = array(
    			'from' => $param['from'],
    			'to' => $param['to'],
    			'emp' => $param['employee'],
    	);
    	$arr = array(
    			$param['column'] => $param['value'],
    			'id' => $param['row']
    	); 
    	$this->getService()->updateAttendance($arr); 
    	$row = $this->getService()->getAttendanceOtSum($array); 
    	$res = array(
    			'employeeNoNOHours' => $row['normalHour'],
    			'employeeNoHOHours' => $row['holidayHour'],
    			'numberOfMeals'     => $row['noOfMeals'],
    	);
    	return $this->jsonResponse($res); 
    }
    
    public function savedinfoAction() { 
    	$param = $this->getRequest()->getPost(); 
    	$arr = array(
    			'from' => $param['from'],
    			'to' => $param['to'],
    			'emp' => $param['employee'],
    	);
    	$row = $this->getService()->getAttendanceOtSum($arr); 
    	$res = array(
    		       'employeeNoNOHours' => $row['normalHour'],
    			   'employeeNoHOHours' => $row['holidayHour'],
    			   'numberOfMeals' => $row['noOfMeals'],
    	       );
    	return $this->jsonResponse($res); 
    }
     
    public function addAction() { 
    	$form = $this->getForm();
    	/*$form = new OverTimeForm();
    	$form->get('empIdOvertime')
    	     ->setOptions(array('value_options' => $this->getEmployeeList())) 
    	;    
    	$user = $this->getUser(); 
    	$form->get('empIdOvertime')->setValue($user);*/  
    	//$otValue = $this->getExistingOtValue($user); 
    	//$form->get('employeeNoNOHours')->setValue($otValue['normalHour']); 
    	//$form->get('employeeNoHOHours')->setValue($otValue['holidayHour']); 
    	//$form->get('month')->setValue($otValue['month']); 
    	//$form->get('year')->setValue($otValue['year']);  
    	$dateRange = $this->getDateRange(); 
    	/*$isAllowed = $this->isAllowedToSubmit($user,$dateRange);  
    	
    	if(!$isAllowed) { 
    		$form->get('employeeNoNOHours')->setAttribute('disabled', 'true'); 
    		$form->get('employeeNoHOHours')->setAttribute('disabled', 'true'); 
    		$form->get('submit')->setAttribute('disabled', 'true'); 
    	}*/
    	
    	$prg = $this->prg('/overtimenew/add', true);
    	if ($prg instanceof Response ) {
    		return $prg;
    	} elseif ($prg === false) {
    		return array ('form' => $form);
    	} 
    	
    	$formValidator = $this->getFormValidator();
    	$form->setInputFilter($formValidator->getInputFilter());
    	 
    	$service = $this->getService(); 
    	//echo "outside";
    	//exit;
    	$dateRange = $this->getDateRange();
    	$form->setData($prg);
    	
    	if ($form->isValid()) {
    		$data = $form->getData();
    		//\Zend\Debug\Debug::dump($data);
    		//exit;
    		$service->insert($data,$dateRange); 
    		$this->flashMessenger()->setNamespace('success')
    		     ->addMessage('Overtime Submitted successfully');
    		$this->redirect()->toRoute('overtimenew',array(
    				'action' => 'add'
    		)); 
    	}  
    	
    	return array('form' => $form,$prg);   
    }   
    
    public function editAction() {
    
    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) {
    		$this->flashMessenger()->setNamespace('info')
    		     ->addMessage('Overtime not found,Please Add');
    		$this->redirect()->toRoute('overtimenew', array(
    				'action' => 'add'
    		));
    	} 
    	
    	$service = $this->getService();
    	
    	$isAllowedToEdit = $service->isAllowedToEdit($id); 
    	if(!$isAllowedToEdit) {
    		$this->flashMessenger()->setNamespace('info')
    		     ->addMessage('Overtime not allowed to edit now');
    		$this->redirect()->toRoute('overtimenew', array(
    				'action' => 'add'
    		));
    	}
    	
    	$form = $this->getForm();
    	$form = $this->getForm('overtimeFormUpdate');
    	$ot = $service->fetchById($id);
    	$form->bind($ot);
    	$form->get('submit')->setAttribute('value','Update');
    	
    	$prg = $this->prg('/overtimenew/edit/'.$id, true);
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
    		     ->addMessage('Overtime updated successfully');
    		$this->redirect ()->toRoute('overtimenew',array (
    				'action' => 'add'
    		)); 
    	}
    	return array(
    			'form' => $form,
    			$prg
    	); 
    } 
    
    public function getForm() {
    	$form = new JustificationForm(); 
    	$form->get('empIdOvertime')
    	     ->setOptions(array('value_options' => $this->getEmployeeList()))
    	;
    	$user = $this->getUser(); 
    	$form->get('empIdOvertime')->setValue($user);
    	//$form->get('employeeNoNOHours')->setAttribute('readOnly',true);
    	//$form->get('employeeNoHOHours')->setAttribute('readOnly',true);
    	//$form->get('numberOfMeals')->setAttribute('readOnly',true); 
    	return $form;  
    } 
    
    public function approveAction() { 
    	
    	/*$id = (int) $this->params()->fromRoute('id',0);
    	if (!$id) {
    		$this->flashMessenger()->setNamespace('info')
    		->addMessage('leave not found,Please Add');
    		$this->redirect()->toRoute('overtimenew', array(
    				'action' => 'add'
    		));
    	}
    	$service = $this->getLeaveService();
    	$leaveInfo = $service->leaveInfoById($id);
    	$form = $this->getApprovalForm();
    	// $form->bind($leave);
    	$form->get('id')->setValue($id);
    	// $form->get('submit')->setAttribute('value','Approve Annual Leave');
    	$prg = $this->prg('/overtimenew/approve/'.$id, true); 
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
    	);*/ 
    } 
    
    /*public function saveempotAction() {
    	$formValues = $this->params()->fromPost('formVal'); 
    	$overtimeService = $this->getService();
    	$data = array( 
    		'empIdOvertime'      => $formValues['empIdOvertime'],
    		'employeeNoNOHours'  => $formValues['employeeNoNOHours'],
    		'employeeNoHOHours'  => $formValues['employeeNoHOHours'],
    		'otStatus'           => '1', 
    		'month'              => $formValues['month'], 
    		'year'               => $formValues['year'], 
    	);        
        // \Zend\Debug\Debug::dump($data);  
        // exit;  
    	$overtimeService->saveempot($data);  
    	exit;   
    }*/    
    
    public function submittosupAction() {  
    	$postVal = $this->getRequest()->getPost();
    	$emp = $postVal['employee'];
    	$from = $postVal['from'];
    	$to = $postVal['to'];
    	$arr = array('emp' => $emp,'from' => $from,'to' => $to);   
    	echo $this->getService()->submittosup($arr);  
    	exit; 
    } 
    
    public function approvesupAction() {      
    	$id = (int) $this->params()->fromRoute('id',0);
    	if (!$id) {
    		$this->flashMessenger()->setNamespace('info')
    		->addMessage('Overtime not found,Please Add');
    		$this->redirect()->toRoute('overtimenew', array(
    				'action' => 'add'
    		));
    	}
    	$service = $this->getService();
    	$otInfo = $service->overtimeInfoById($id);  
    	$form = $this->getApprovalForm();
    	$form->get('id')->setValue($id);
    	$prg = $this->prg('/overtimenew/approvesup/'.$id, true);
    	
    	if ($prg instanceof Response ) {
    		return $prg;
    	} elseif ($prg === false) {
    		return array ('form' => $form,'otInfo' => $otInfo,);
    	} 
    	$formValidator = $this->getApprovalFormValidator();
    	$form->setInputFilter($formValidator->getInputFilter()); 
    	$form->setData($prg);
    	if ($form->isValid()) {
    		$data = $form->getData(); 
    		//\Zend\Debug\Debug::dump($data); 
    		//exit;
    		$res = $service->approveOtBySup($data,$this->getUser()); 
    		if($res == 1) {
    			$message = "Approval Submitted Successfully";
    		} else {
    			$message = "Error! Some error occured while submit"; 
    		}
    		$this->flashMessenger()->setNamespace('info')
    		     ->addMessage($message);
    		$this->redirect ()->toRoute('overtimenew',array (
    				'action' => 'approve'
    		));
    	}
    	return array('id'  => $id,'form'  => $form,'otInfo'  => $otInfo,$prg);
    } 
    
    private function getCloseForm() {
    	$form = new SubmitButonForm(); 
    	$form->get('submit')->setValue('Close Overtime');
    	return $form;
    } 
    
    public function closeAction() { 
    	$form = $this->getCloseForm(); 
    	$prg = $this->prg('/overtimenew/close', true);
    	if ($prg instanceof Response ) {
    		return $prg;
    	} elseif ($prg === false) {
    		return array ('form' => $form); 
    	}
    	$company = $this->getCompanyService();
    	$form->setData($prg);
    	$dateRange = $this->getDateService();
    	$ot = $this->getService(); 
    	$routeInfo = $this->getRouteInfo();
    	$isAlreadyClosed = $ot->isOtClosed($company,$routeInfo);  
    	if($isAlreadyClosed) {
    		$this->flashMessenger()->setNamespace('info')
    		     ->addMessage('Overtime Already closed for current month');
    	} else { 
    		$ot = $this->getService();
    		$ot->closeOt($company,$dateRange,$routeInfo); 
    		$this->flashMessenger()->setNamespace('success')
    		     ->addMessage('Overtime Closed Successfully'); 
    	}
    	$this->redirect()->toRoute('overtimenew',array('action'=>'close')); 
    	return array(
    			'form' => $form,
    			$prg
    	);
    }
     
    public function rejectsupAction() {
    	
    }
    
    public function endorsehrAction() {
    	 
    } 
    
    public function rejecthrAction() {
    	
    }
    
    private function getCompanyService() {
    	return $this->getServiceLocator()->get('company');
    } 
    
    private function getDateService() {
    	return $this->getServiceLocator()->get('dateRange');
    } 
    
    private function getExistingOtValue($user) { 
        $otNormal = 0;
        $otHoliday = 0; 
        // @todo get existing OT value which is top 1 
        $otHours = $this->getService()->getEmployeeOvertimeHours($user); 
        if($otHours['normalHour']) {
        	$otNormal = $otHours['normalHour']; 
        }
        if($otHours['holidayHour']) {
        	$otHoliday = $otHours['holidayHour'];
        }
    	return array( 
            'normalHour'   => $otNormal,
    		'holidayHour'  => $otHoliday,
    		'month'        => $otHours['month'],
    		'year'         => $otHours['year'],
        ); 
    }  
    
    private function getRouteInfo() {
    	return array(
    			'controller' => $this->getEvent()
    			                     ->getRouteMatch()
    			                     ->getParam('controller','index'),
    			'action'     => $this->getEvent()
    			                     ->getRouteMatch()
    			                     ->getParam('action','index'), 
    	);
    } 
    
    private function isAllowedToSubmit($user,DateRange $dateRange) {  
    	return $this->getService()->isAllowedToSubmit($user,$dateRange); 
    }  
     
    private function getGrid() { 
    	return new AttendanceGrid();  
    } 
    
    private function getApproveGrid() {
    	return new OvertimeApproveGrid();   
    }
    
    private function getEndorseGrid() {
    	return new OvertimeEndorseGrid(); 
    } 
    
    private function getUser() {
    	return $this->getUserInfoService()->getEmployeeId(); 
    }
    
    private function getUserInfoService() {
    	return $this->getServiceLocator()->get('userInfoService');
    }
    
    private function getService() {
    	return $this->getServiceLocator()->get('overtimeService'); 
    }
    
    private function getDbAdapter() {
    	return $this->getServiceLocator()->get('sqlServerAdapter');
    }
    
    private function getEmployeeService() {
    	return $this->getServiceLocator()->get('employeeService');
    }
    
    private function getEmployeeList() {
    	$company = $this->getServiceLocator()->get('company'); 
    	$companyId = $company->getId(); 
    	return $this->getEmployeeService()->employeeList($companyId);  
    } 
    
    private function getDateRange() {
        return $this->getServiceLocator()->get('dateRange');  	
    } 
    
    private function getApprovalForm() {
    	return new OtApprovalForm();
    } 
    
    private function getFormValidator() {
    	return new OvertimeFormValidator();  
    }
    
    private function getApprovalFormValidator() {
		return new OtApprovalFormValidator();
	}
    
} 