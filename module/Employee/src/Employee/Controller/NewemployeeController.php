<?php

namespace Employee\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Http\PhpEnvironment\Response;
//use Employee\Form\LocationForm;
//use Employee\Form\LocationFormValidator;
//use Application\Model\LocationGrid; 
use Employee\Form\NewEmployeeForm; 
use Employee\Form\NewEmployeeFormValidator;
use Application\Model\EmployeeGrid;
use Application\Form\EffectiveDateForm;
use Employee\Form\SubmitButonFormValidator;
use Application\Model\ExistingEmployeeGrid;
use Employee\Form\ExistingEmployeeForm;
use Application\Form\EmpMstReportForm;
use Application\Form\MonthYear;
 
class NewemployeeController extends AbstractActionController {
	
	public function indexAction() { exit; }
	
	public function listAction() { }
	// 
	public function ajaxlistnewAction() {
		$grid = $this->getGrid();
		$company = $this->getCompanyService(); 
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getEmployeeService()->selectEmployeeNew($company))
		     ->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render()); 
	}
	
	// listexisting 
	public function listexistingAction() { } 
	 
	public function ajaxlistexistingAction() {
		$grid = $this->getExistingEmpGrid();
		$company = $this->getCompanyService();
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getEmployeeService()
				->selectEmployee($company))
		     ->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render()); 
	}   
	
	public function addAction() { 
		$form = $this->getForm(); 
		$company = $this->getServiceLocator()->get('company'); 
		$service = $this->getEmployeeService(); 
		$uniqueEmpNo = $service->getUniqueEmployeeNumber($company); 
		$form->get('employeeNumber')->setValue($uniqueEmpNo);  
		$form->get('employeeNumber')->setAttribute('readonly','readonly');
		
		$prg = $this->prg('/newemployee/add',true); 
		if ($prg instanceof Response ) { 
			return $prg; 
		} elseif ($prg === false) { 
			return array('form' => $form);  
		}  
		
		$formValidator = $this->getFormValidator(); 
		$form->setInputFilter($formValidator->getInputFilter());  
		$form->setData($prg); 
		if ($form->isValid()) {  
			$data = $form->getData(); 
			//\Zend\Debug\Debug::dump($data);  
			//exit; 
			$service->insertNewEmployeeInfoBuffer($data);  
			$this->flashMessenger()->setNamespace('success') 
			     ->addMessage('New Employee added successfully');    
			$this->redirect ()->toRoute('newemployee',array( 
					'action' => 'add' 
			));   
		}   
		return array( 'form' => $form,$prg ); 
	}  
	
	public function editAction() { 
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			$this->flashMessenger()->setNamespace('info')
			                       ->addMessage('Employee not found,Please Add');
			$this->redirect()->toRoute('newemployee', array(
				'action' => 'add'
			)); 
		} 
		$form = $this->getForm(); 
		$form->get('employeeNumber')->setAttribute('readonly','readonly');
		$service = $this->getEmployeeService(); 
		$emp = $service->fetchEmployeeById($id); 
		// \Zend\Debug\Debug::dump($emp); 
		// exit;  
		$form->bind($emp);  
		$form->get('submit')->setAttribute('value','Update Employee'); 
		$prg = $this->prg('/newemployee/edit/'.$id,true);  
		if ($prg instanceof Response) { 
			return $prg; 
		} elseif ($prg === false) { 
			return array ('form' => $form); 
		} 
		$formValidator = $this->getFormValidator(); 
		$form->setInputFilter($formValidator->getInputFilter()); 
		$form->setData($prg); 
		 
		if ($form->isValid()) {  
			$data = $form->getData();  
			 //\Zend\Debug\Debug::dump($form); 
			 //exit; 
			$service->updateNewEmployeeInfoBuffer($data); 
			$this->flashMessenger()->setNamespace('success') 
			                       ->addMessage('Employee updated successfully'); 
			$this->redirect ()->toRoute('newemployee',array ( 
					'action' => 'approve' 
			));  
		} 
		//\Zend\Debug\Debug::dump($form);
		//exit;
		return array( 
				'form' => $form, 
				$prg 
		);  
	} 
	
	public function approveAction() {
		$form = $this->getSubmitForm();
		$prg = $this->prg('/newemployee/approve',true); 
		// $promotionService = $this->getPromotionService(); 
		// $promotionList = $promotionService->getPromotionList();  
		if ($prg instanceof Response ) { 
			return $prg;  
		} elseif ($prg === false) { 
			return array ( 
				'form' => $form, 
			);   
		}  
		$formValidator = $this->getApproveFormValidator(); 
		$form->setInputFilter($formValidator->getInputFilter()); 
		$form->setData($prg); 
		if ($form->isValid()) {    
			$employeeService = $this->getEmployeeService(); 
			$company = $this->getServiceLocator()->get('company'); 
			// @todo 
			$isHaveNewEmployee = true; // $employeeService->isHaveNewEmployee($company); 
			if($isHaveNewEmployee) { 
				$data = $form->getData(); 
				$res = $employeeService->approveNewEmployee($data,$company);   
				$this->flashMessenger()->setNamespace('info') 
				     ->addMessage($res);    
				$this->redirect ()->toRoute('newemployee',array ( 
					'action' => 'approve' 
				));      
			} else { 
				$this->flashMessenger()->setNamespace('info')
				     ->addMessage('No new employees available to approve, please add');
				$this->redirect ()->toRoute('newemployee',array (
					'action' => 'add' 
				));   
			}   
	    } 
	    return array(
	    		'form' => $form,
	    		$prg
	    ); 
	}  
	
	public function removeAction()
	{
		$id = (int) $this->params()->fromRoute('id',0);
		//echo $id;
		$this->getEmployeeService()->removeNewEmployeeFromBuffer($id); 
		exit; 
	} 
	 
	 
    
	// editexisting 
	public function editexistingAction() { 
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			$this->flashMessenger()->setNamespace('info')
			     ->addMessage('Employee not found,Please Add');
			$this->redirect()->toRoute('newemployee', array(
					'action' => 'add'
			)); 
		}  
		//\Zend\Debug\Debug::dump($id);    
		//exit;   
		$form = $this->getForm(); 
		//$form->get('employeeNumber')->setAttribute('readonly','readonly');
		$value = 0;//$this->getEmployeeService()->
		//$form->get('empInitialSalary')->
		$form->get('empInitialSalary')->setAttribute('readonly','readonly');
		//$form->get('employeeName')->setAttribute('readonly','readonly');
		//$form->get('empDateOfBirth')->setAttribute('readonly','readonly');
		//$form->get('empPosition')->setAttribute('disabled', 'true');
		//$form->get('empLocation')->setAttribute('disabled', 'true');
		//$form->get('empSalaryGrade')->setAttribute('disabled', 'true'); 
		// setValue('Apply Updated Position Allowance'); 
		// $form-> 
		// readonly="readonly"  
		$service = $this->getEmployeeService();   
		
		$dateRange = $this->getServiceLocator()->get('dateRange');  
		$emp = $service->fetchExistingEmployeeById($id); 
		//\Zend\Debug\Debug::dump($emp);  
		//exit;   
		$imgLoc = $emp->getImgLoc(); 
		$employeeNumber = $emp->getEmployeeNumber();  
		$value = $service->getEmployeeInitial($employeeNumber);  
		//\Zend\Debug\Debug::dump($value); 
		//exit; 
		$form->bind($emp); 
		$form->get('empInitialSalary')->setValue($value['oldInitial']);
		$form->get('submit')->setAttribute('value','Update Employee');
		$prg = $this->prg('/newemployee/editexisting/'.$id,true);
		if ($prg instanceof Response) { 
			return $prg; 
		} elseif ($prg === false) {
		    return array ('form' => $form,'empNum' => $imgLoc,);
		} 
		
		$formValidator = $this->getFormValidator(); 
		//\Zend\Debug\Debug::dump($formValidator->getInputFilter());
		//exit; 
		$form->setInputFilter($formValidator->getInputFilter()); 
		$form->setData($prg);  
		//\Zend\Debug\Debug::dump($form);
		//\Zend\Debug\Debug::dump($form->getData());
		//exit; 
		$form->get('empPosition')->setAttribute('disabled', 'false');
		$form->get('empLocation')->setAttribute('disabled', 'false');
		$form->get('empSalaryGrade')->setAttribute('disabled', 'false');
		//try {
		//$data = $form->getData();
		//\Zend\Debug\Debug::dump($data);
		//exit;
		//var_dump($form->isValid());
		//exit;
		//$data = $form->getData();
		if ($form->isValid()) {
			$data = $form->getData();
			
			//\Zend\Debug\Debug::dump($data);
			//exit;
			$service->updateExistingEmployeeInfoMain($data); 
			$this->flashMessenger()->setNamespace('success')
			     ->addMessage('Employee updated successfully'); 
			$this->redirect ()->toRoute('newemployee',array (
					'action' => 'listexisting'
			)); 
		} else {
			echo "invalid"; 
		}
		
		
		//$data = $form->getData();
		\Zend\Debug\Debug::dump($form);
		\Zend\Debug\Debug::dump($data);
		exit;
		//\Zend\Debug\Debug::dump("invalid"); 
		//exit;
		return array(
				'form' => $form,
		    'empNum' => $imgLoc,
				$prg
		); 
	} 
	
	// approveexisting 
	public function approveexistingAction() { 
		
	} 
    
	public function htmlResponse($html) {
		$response = $this->getResponse();
		$response->setStatusCode(200);
		$response->setContent($html);
		return $response;
	}  
	
	private function getInitialService() {
		// getAmount($employee,$dateRange); 
		return $this->getServiceLocator()->get('Initial');
	}
    
	private function getEmployeeService() {
		return $this->getServiceLocator()->get('employeeService');    
	} 
	
	private function getDbAdapter() { 
		return $this->getServiceLocator()->get('sqlServerAdapter');  
	} 
	
	private function getFormValidator() { 
		return new NewEmployeeFormValidator(); 
	} 
	
	private function getApproveFormValidator() {  
		return new SubmitButonFormValidator(); 
	} 
	
	private function getExistingEmpGrid() {
		return new ExistingEmployeeGrid();
	} 
	
	private function getGrid() {
		return new EmployeeGrid();
	}
	
	private function getSubmitForm() { 
		$form = new EffectiveDateForm();
		$form->get('effectiveDate')->setLabel('Employee Effective Date*');
		$form->get('submit')->setValue('Approve New Employee'); 
		return $form; 
	} 
	
	private function getForm() { 
		$form = new NewEmployeeForm(); 
		$form->get('gender')
		     ->setOptions(array('value_options' => array(
				' '   => ' ',
				'1'  => 'Male',
				'0'  => 'Female'
		)));  
		$form->get('companyId')
		     ->setOptions(array('value_options' => $this->getCompany()
		)); 
		$form->get('maritalStatus')
		     ->setOptions(array('value_options' => array(
		     	''  => '', 
		     	'1' => 'Married',
		     	'2' => 'Single', 
		     	'3' => 'Divorced',
		     	'4' => 'Widow',
		     	'5' => 'Widower', 
		))); 
		$form->get('religion')
		     ->setOptions(array('value_options' => $this->getReligion() 
		)); 
		     
		$form->get('currency')
		     ->setOptions(array('value_options' => $this->getCurrency()
		));
		  
		$form->get('nationality')
		     ->setOptions(array('value_options' => $this->getNationality()
		));    
		$form->get('state')
		     ->setOptions(array('value_options' => $this->getState() 
		));  
		//$form->get('empType')
		     //->setOptions(array('value_options' => $this->getEmpType() 
		//));
		$form->get('empSalaryGrade')
		     ->setOptions(array('value_options' => $this->getEmpSalaryGrade() 
		)); 
		/*$form->get('empJobGrade')
		     ->setOptions(array('value_options' => $this->getEmpJobGrade() 	
		));*/ 
		$form->get('empBank')
		     ->setOptions(array('value_options' => $this->getEmpBank() 
		));
		$form->get('empPosition')
		     ->setOptions(array('value_options' => $this->getEmpPosition()
		));
		$form->get('isPreviousContractor')
		     ->setOptions(array('value_options' => $this->getIsPreviousContractor()
		));
		/*$form->get('empLocation')
		     ->setOptions(array('value_options' => $this->getEmpLocation()
		));*/ 
		$form->get('skillGroup')
		     ->setOptions(array('value_options' => $this->getSkillGroup()
		));
		return $form; 
	} 
	
	public function terminatedreportAction() {
	
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
	
	public function viewterminatedreportAction() {
	
		$viewmodel = new ViewModel();
		$viewmodel->setTerminal(1);
		$request = $this->getRequest();
		$output = " ";
		if($request->isPost()) {
			$values = $request->getPost();
			
			$month = $values['month'];
			$year = $values['year'];
			if($month && $year) {
				$from = date($year)."-".date($month)."-01";
				$totDays =  $totDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
				$to = date($year)."-".date($month)."-".$totDays;
			}
			
			if($year && !$month) {
				$from = date($year)."-01-01";
				$to = date($year)."-12-31";
			}
			$data = array('from' => $from,'to' => $to);
			$company = $this->getCompanyService();
			$results = $this->getEmployeeService()
			                ->getTerminatedEmployeeInfoReport($company,$data); 
		} 
		$nameList = $this->getEmployeeInfoArray();
		$nameList['Termination Date'] = "terminationDate";
		$viewmodel->setVariables(array(
				'report'       => $results,
				'nameList'     => $nameList,
		));
		return $viewmodel;
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
	
	public function viewreportAction() { 
		$viewmodel = new ViewModel();
		$viewmodel->setTerminal(1);
		$request = $this->getRequest();
		$output = " "; 
		if($request->isPost()) { 
			$values = $request->getPost();
			$company = $this->getCompanyService();  
			$results = $this->getEmployeeService()
			                ->getEmployeeInfoReport($company,$values);  
		}  
		$viewmodel->setVariables(array(
				'report'       => $results,
				'nameList'     => $this->getEmployeeInfoArray(), 
		)); 
		return $viewmodel; 
	}
	
	private function getEmployeeInfoArray() {
		return array( 
				'EmployeeName'   => 'employeeName', 
				'Employee Number' =>'employeeNumber', 
				//'Position'        => 'positionName', 
				'Salary Grade'        =>'salaryGrade',
				'Job Grade'        =>'jobGrade',
				'Location'        =>'locationName', 
				'Position'        =>'positionName',
				'Department'        =>'departmentName',
				'Section'        =>'sectionName',
				'Company'        =>'companyName', 
				'Bank'        =>'bankName',
				'Account Number'        =>'accountNumber',
				'Reference Number'        =>'referenceNumber',
				'Join Date'        =>'empJoinDate',
				'Date Of Birth'        =>'empDateOfBirth',
				'Confirmation Date'        =>'confirmationDate',
				'Confirmed'        =>'confirmed',
				'Place Of Birth'        =>'placeOfBirth',
				'Gender'        =>'genderName',
				'Marital Status'        =>'maritalStatusName',
				'Religion'        =>'religionName',
				'Nationality'        =>'nationalityName',
				'Dependents'        =>'numberOfDependents',
				'State'        =>'stateName',
				'Address'        =>'empAddress',
				'Phone'        =>'empMobile',
				//'Position'        =>'empMobile',
				'Passport'        =>'empPassport',
				'license'        =>'license',
				'Extension'        =>'officeExtention',
				'Email'        =>'empEmail',
				'Employee Type'        =>'empType',
				'Skill Group'        =>'skillGroup',
				'Is Prev Contractor'        =>'isPreviousContractor',
				'isActive'        =>'isActive',
				//'isInPayroll'        =>'isInPayroll',
				'Nat Ser Status'        =>'lkpNationalService',
				'Is In Paysheet'        =>'isInPaysheet',
				//'Initial Salary'        =>'empInitialSalary', 
		); 
	}
	
	private function getCompanyService() {
		return $this->getServiceLocator()->get('company');
	}
	
	public function getReportForm() {
		$form = new MonthYear();
		//$form = new EmpMstReportForm(); 
		$form->get('submit')->setValue('View Report');  
		return $form;
	}
    
	private function getReligion() {
		return $this->getLookupService()->getReligionList(); 
	}  
	
	private function getCurrency() {
		return $this->getLookupService()->getCurrencyList();
	}
	
	private function getNationality() { 
		return $this->getLookupService()->getNationalityList();
	}
	
	private function getState() {
		return $this->getLookupService()->getStateList();  
	} 
	
	private function getEmpType() {
		return $this->getLookupService()->getEmpTypeList();  
	} 
	
	private function getEmpSalaryGrade() {
		return $this->getLookupService()->getSalaryGradeList(); 
	} 
	
	private function getEmpJobGrade() {
		return $this->getLookupService()->getJobGradeList(); 
	} 
	
	private function getEmpBank() {
		return $this->getLookupService()->getBankList(); 
	} 
	
	private function getEmpPosition() {
		return $this->getPositionService()->getVacantPositionList();
	} 
	
	private function getIsPreviousContractor() {
		return $this->getLookupService()->getYesNoList();  
	} 
	
	private function getEmpLocation() {
		return $this->getLookupService()->getLocationList();  
	} 
	
	private function getSkillGroup() { 
		return $this->getLookupService()->getSkillGroupList();  
	} 
	
	private function getCompany() {
		return $this->getLookupService()->getCompanyList();
	}
	
	private function getLookupService() {
		return $this->getServiceLocator()->get('lookupService');  
	} 
	
	private function getPositionService() {
		return $this->getServiceLocator()->get('positionService'); 
	} 
	
}