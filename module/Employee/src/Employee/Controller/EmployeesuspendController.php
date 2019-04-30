<?php

namespace Employee\Controller; 

use Application\Form\MonthYear;
use Application\Form\SubmitButonForm;
use Application\Form\SuspendFormValidator;
use Application\Model\EmployeeSuspendGrid;
use Employee\Form\EmployeeSuspendForm;
use Payment\Model\Company;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\EmployeeSuspendedGrid;
use Employee\Form\EmployeeSuspendedForm;

class EmployeesuspendController extends AbstractActionController {
    
	public function listAction() { }
	
	public function ajaxlistAction() {
		$grid = $this->getGrid();
		$grid->setAdapter($this->getDbAdapter())
		->setSource($this->getEmployeeService()->selectEmployeeSuspend())
		->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render());
	}
	
	public function deletelistAction() { }
	
	public function ajaxdellistAction() {
	    $grid = $this->getSuspendedGrid();
	    $grid->setAdapter($this->getDbAdapter())
	    ->setSource($this->getEmployeeService()->selectEmployeeSuspended())
	         ->setParamAdapter($this->getRequest()->getPost());
	    return $this->htmlResponse($grid->render());
	}
	
	public function htmlResponse($html) {
		$response = $this->getResponse();
		$response->setStatusCode(200);
		$response->setContent($html);
		return $response;
	}
	
	public function addAction()
	{
		// @todo
		//$id = (int) $this->params()->fromRoute('id',0);
		//echo json_encode($id);
		//exit;
		//var_dump($this->getEmployeeList());
		// $form = new AdvanceHousingForm();
		$form = new EmployeeSuspendForm(); 
		// $form = new EmployeeTerminationForm();
		$company = $this->getServiceLocator()->get('company');
		$companyId = $company->getId();
		$form->get('employeeNumberSuspend')
		     ->setOptions(array('value_options' =>
				$this->getEmployeeService()->employeeList($companyId)))
		;  
		/*$form->get('terminationType')
			 ->setOptions(array('value_options' =>
			    $this->getTerminationTypeList()))
		;*/
			  
		/*$form->get('oldCola')->setAttribute('readOnly',true);
		  $form->get('oldSalary')->setAttribute('readOnly',true);
		*/
		return array('form' => $form); 
		//exit; 
	} 
	
	public function deleteAction() {
	    $id = (int) $this->params()->fromRoute('id', 0);
	    if (!$id) {
	        $this->flashMessenger()->setNamespace('info')
	             ->addMessage('Employee Suspend not found,Please Add');
	        $this->redirect()->toRoute('employeesuspend', array(
	            'action' => 'add'
	        ));
	    }
	    $company = $this->getServiceLocator()->get('company');
	    $companyId = $company->getId();
	    $form = new EmployeeSuspendedForm(); 
	    $form->get('employeeId')
	         ->setOptions(array('value_options' =>
	        $this->getEmployeeService()->employeeList($companyId)))
	        ;
	    $service = $this->getEmployeeService();
	    $suspend = $service->fetchSuspendById($id);
	    //$form = $this->getForm();
	    $form->bind($suspend);
	    $form->get('submit')->setAttribute('value','Delete Employee Suspend'); 
	    $prg = $this->prg('/employeesuspend/delete/'.$id, true);
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
	        //\Zend\Debug\Debug::dump($data);
	        //exit;
	        $service->deleteSuspend($data);
	        $this->flashMessenger()->setNamespace('success')
	             ->addMessage('Employee Suspend deleted successfully');
	        $this->redirect ()->toRoute('employeesuspend',array (
	            'action' => 'deletelist'
	        ));
	    }
	    return array(
	        'form' => $form,
	        $prg
	    ); 
	} 
	
	private function getFormValidator() {
	    return new SuspendFormValidator();
	}
	
	public function approveAction() {
		$form = $this->getForm();
		$form->get('submit')->setValue('Approve Employee Suspend'); 
		$prg = $this->prg('/employeesuspend/approve', true);
		if ($prg instanceof Response ) {
			return $prg;
		} elseif ($prg === false) {
			return array('form' => $form);
		}
		$company = $this->getServiceLocator()->get('company');
		$form->setData($prg);
		$employeeService = $this->getEmployeeService();
		$res = $employeeService->applyEmployeeSuspend($company);
		$this->flashMessenger()->setNamespace('info')
		                       ->addMessage($res);
		$this->redirect()->toRoute('employeesuspend',array(
				'action' => 'add'
		));
		return array(
				'form' => $form,
				$prg
		);
	}
	
	public function removeAction()
	{
		// @todo
		$id = (int) $this->params()->fromRoute('id',0);
		$employeeService = $this->getEmployeeService();
		$employeeService->removeEmployeeSuspendBuff($id);
		// echo json_encode($id);
		exit;
	}
	
	private function getForm() {
		return new SubmitButonForm();
		//$form->get('submit')->setValue('Close Advance Housing');
		//return $form;
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
			$month = $values['month'];
			$year = $values['year'];
			$type = 1;
	
			$param = array('month' => $month,'year' => $year);
	
			//$results = $this->getPaysheetService()->getPaysheetReport($param);
			$output = $this->getPaysheetService()->getPaysheetReport($param);
			/* if($results) {
			 foreach($results as $result) {
			 $output .= $result['employeeNumber']."<br/>";
			 }
			 } else {
			 $output = "Sorry! no results found";
			}  */
	
			/* if ($type == 1) {
			 $output = $this->getPaysheetService()->getPaysheetReport($param);
			 } else if ($type == 2) {
			 $output = $this->getReportTable()->summary($values);
			 } else if ($type == 3) {
			 $output = $this->getReportTable()->byorder($values);
			 } else if ($type == 4) {
			 $output = $this->getReportTable()->bystatus($values);
			 } else if ($type == 5) {
			 $output = $this->getReportTable()->report($values,'2');
			 } else if ($type == 6) {
			 $output = $this->getReportTable()->duplicateobr($values);
			} */
	
		}
			
		$viewmodel->setVariables(array(
				'report' => $output,
				'paysheetArray'  => $this->getPaysheetAllowanceArray()
		));
	
		return $viewmodel;
	
	}
	
	private function getEmployeeService() {
		return $this->getServiceLocator()->get('employeeService');
	}
	
	private function getNotConfirmedEmployeeList(Company $company) {
		return $this->getEmployeeService()->notConfirmedEmployeeList($company);
	}
	 
	public function successAction() {
		return new ViewModel();
	}
	
	public function getoldsalarydetailsAction() {
		$employeeNumber = $this->params()->fromPost('empNumber');
		$employeeService = $this->getEmployeeService();
		$salaryInfo = $employeeService->getSalaryInfo($employeeNumber);
		echo json_encode($salaryInfo);
		exit;
	}
	 
	protected function saveemployeesuspendAction() {
		$formValues = $this->params()->fromPost('formVal');
	
		$employeeService = $this->getEmployeeService();
		$company = $this->getServiceLocator()->get('company');
		$formValues['companyId'] = $company->getId();
		//\Zend\Debug\Debug::dump($formValues);
		//exit;
		$employeeService->saveEmployeeSuspendBuff($formValues);
		//var_dump($formValues);
		exit; 
	}
	
	public function getTaxService() {
	
	}
	
	
	
	public function getReportForm() {
		$form = new MonthYear();
		$form->get('submit')->setValue('View Paysheet Report');
		return $form;
	}
	
	private function getPaysheetService() {
		return $this->getServiceLocator()->get('paysheetMapper');
	}
	
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	}
	
	private function getTerminationTypeList() {
		return $this->getLookupService()->getTerminationTypeList();
	}
	
	private function getLookupService() {
		return $this->getServiceLocator()->get('lookupService');
	}
	
	private function getGrid() {
		return new EmployeeSuspendGrid(); 
	}
	
	private function getSuspendedGrid() {
	    return new EmployeeSuspendedGrid(); 
	}
	
}