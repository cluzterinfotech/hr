<?php

namespace Employee\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Employee\Form\BankInfoForm;
use Employee\Form\InfoForm;
use Employee\Form\EmployeeInfoForm;
use Employee\Form\PersonalInfoForm;

class EmployeeController extends AbstractActionController {
	private $bankInfoTable;
	private $personalInfoTable;
	private $employeeInfoTable;
	private $history;
	private $bankTable;
	private $companyTable;
	private $salaryGradeTable;
	private $formTransactionTable;
	private $jobGradeTable;
	private $locationTable;
	private $admin;
	public function indexAction() {
	}
	public function addAction() {
		$form = new InfoForm ();
		
		$pending = $this->getFormTransactionTable ()->isPending ( 'addEmployee' );
		
		if (! $pending) {
			// Fetch Admin info
			$company = $this->getAdmin ()->getCompany ();
			// Fetch Options
			$banks = $this->getBankTable ()->fetchAllArrayNorm ();
			$locations = $this->getLocationTable ()->fetchAllArrayNorm ();
			$salaryGrade = $this->getSalaryGradeTable ()->fetchAllArrayNorm ();
			$jobGrade = $this->getJobGradeTable ()->fetchAllArrayNorm ();
			
			// Set Options
			$form->get ( 'bank_info' )->get ( 'lkp_bank_id' )->setValueOptions ( $banks );
			$form->get ( 'employee_info' )->get ( 'location_id' )->setValueOptions ( $locations );
			$form->get ( 'employee_info' )->get ( 'lkp_salary_grade_id' )->setValueOptions ( $salaryGrade );
			$form->get ( 'employee_info' )->get ( 'lkp_job_grade_id' )->setValueOptions ( $jobGrade );
			$form->get ( 'employee_info' )->get ( 'company_id' )->setValue ( $company );
			
			$request = $this->getRequest ();
			if ($request->isPost ()) {
				
				$form->setData ( $request->getPost () );
				if ($form->isValid ()) {
					$data = $form->getData ();
					// Load history object
					$history = $this->getHistoryObject ();
					
					$bank = $data->getBankInfo ();
					
					// Inject history object into objects
					$bank->setHistory ( $history );
					
					// Save Bank Info
					$bank->setEmpPersonalInfoId ( $id );
					$this->getBankInfoTable ()->saveBankHistoryInfo ( $bank );
				} else {
					echo "Invalid";
					$messages = $form->getMessages ();
				}
			}
		}
		return array (
				'form' => $form,
				'pending' => $pending 
		);
	}
	public function savePersonalInfoAction() {
		$form = new PersonalInfoForm ();
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				$personal = $form->getData ();
				// Load history object
				$history = $this->getHistoryObject ();
				// Inject history object into objects
				$personal->setHistory ( $history );
				
				// Begin form transactions, set possible actions
				$this->getFormTransactionTable ()->beginFormTransaction ( 'addEmployee' );
				$this->getFormTransactionTable ()->addExpectedAction ( 'addPersonalInfo' );
				$this->getFormTransactionTable ()->addExpectedAction ( 'addEmployeeInfo' );
				$this->getFormTransactionTable ()->addExpectedAction ( 'addBankInfo' );
				
				// Save Employee Info
				if ($this->getPersonalInfoTable ()->savePersonalHistoryInfo ( $personal )) {
					$id = $this->getPersonalInfoTable ()->getLastId ();
					// Since save was successful we can confirm the form transactions
					$this->getFormTransactionTable ()->confirmFormTransactions ( $id );
					$this->getFormTransactionTable ()->completedAction ( 'addPersonalInfo' );
					
					$message = array (
							'valid' => true,
							'success' => true,
							'personalId' => $id 
					);
				} else {
					$message = array (
							'valid' => true,
							'success' => false 
					);
				}
			} else {
				$message = array (
						'valid' => false,
						'success' => false 
				);
			}
		}
		$response = $this->getResponse ();
		$response->setContent ( \Zend\Json\Json::encode ( $message ) );
		return $response;
	}
	public function saveEmployeeInfoAction() {
		$form = new EmployeeInfoForm ();
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				$employee = $form->getData ();
				// Load history object
				$history = $this->getHistoryObject ();
				// Inject history object into objects
				$employee->setHistory ( $history );
				$this->getFormTransactionTable ()->beginFormTransaction ( 'addEmployee' );
				// Save Employee Info
				$this->getEmployeeInfoTable ()->saveEmployeeHistoryInfo ( $employee );
				
				// Set action as complete
				$id = $employee->getEmpPersonalInfoId ();
				$this->getFormTransactionTable ()->confirmFormTransactions ( $id );
				$this->getFormTransactionTable ()->completedAction ( 'addEmployeeInfo' );
				$message = array (
						'valid' => true,
						'success' => true 
				);
			} else {
				$message = array (
						'valid' => false,
						'success' => false 
				);
			}
		}
		$response = $this->getResponse ();
		$response->setContent ( \Zend\Json\Json::encode ( $message ) );
		return $response;
	}
	public function bankInfoIndexAction() {
		$info = $this->getBankInfoTable ()->fetchAll ();
		
		return array (
				'info' => $info 
		);
	}
	public function editBankInfoAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id == 0) {
			$this->redirect ()->toRoute ( 'employee' );
		}
		
		$info = $this->getBankInfoTable ()->fetchBankInfo ( $id );
		$form = new BankInfoForm ();
		$form->bind ( $info );
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				$data = $form->getData ();
				
				$history = $this->getHistoryObject ();
				// Inject history object into bank
				$data->setHistory ( $history );
				\Zend\Debug\Debug::dump ( $data );
				// \Zend\Debug\Debug::dump($bank);
				$this->getBankInfoTable ()->saveBankHistoryInfo ( $bank );
			} else {
				echo "Invalid";
				$messages = $form->getMessages ();
				// \Zend\Debug\Debug::dump($messages);
			}
		}
		
		return array (
				'form' => $form 
		);
	}
	public function testAction() {
		$id = $this->getPersonalInfoTable ()->getNextPersonalInfoId ();
		echo $id;
	}
	public function pendingBankInfoAction() {
		$pending = $this->getBankInfoTable ()->fetchAllPending ();
		
		return array (
				'pending' => $pending 
		);
	}
	public function approveBankInfoAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id == 0) {
			$this->redirect ()->toRoute ( 'employee' );
		}
		
		$this->getBankInfoTable ()->approve ( $id );
		$this->redirect ()->toRoute ( 'employee' );
	}
	public function rejectBankInfoAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id == 0) {
			$this->redirect ()->toRoute ( 'employee' );
		}
		
		$this->getBankInfoTable ()->reject ( $id );
		$this->redirect ()->toRoute ( 'employee' );
	}
	public function pendingPersonalInfoAction() {
		$pending = $this->getPersonalInfoTable ()->fetchAllPending ();
		
		return array (
				'pending' => $pending 
		);
	}
	public function approvePersonalInfoAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id == 0) {
			$this->redirect ()->toRoute ( 'employee' );
		}
		
		$this->getPersonalInfoTable ()->approve ( $id );
		$this->redirect ()->toRoute ( 'employee' );
	}
	public function rejectPersonalInfoAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id == 0) {
			$this->redirect ()->toRoute ( 'employee' );
		}
		
		$this->getPersonalInfoTable ()->reject ( $id );
		$this->redirect ()->toRoute ( 'employee' );
	}
	public function personalInfoIndexAction() {
		$info = $this->getPersonalInfoTable ()->fetchAll ();
		
		return array (
				'info' => $info 
		);
	}
	public function pendingEmployeeInfoAction() {
		$pending = $this->getEmployeeInfoTable ()->fetchAllPending ();
		
		return array (
				'pending' => $pending 
		);
	}
	public function approveEmployeeInfoAction() {
		$id = $this->params ()->fromRoute ( 'id', 0 );
		if ($id == 0) {
			// $this->redirect()->toRoute('employee');
		}
		
		$this->getEmployeeInfoTable ()->approve ( $id );
		$this->redirect ()->toRoute ( 'employee' );
	}
	public function rejectEmployeeInfoAction() {
		$id = $this->params ()->fromRoute ( 'id', 0 );
		if ($id == 0) {
			$this->redirect ()->toRoute ( 'employee' );
		}
		
		$this->getEmployeeInfoTable ()->reject ( $id );
		$this->redirect ()->toRoute ( 'employee' );
	}
	public function employeeInfoIndexAction() {
		$info = $this->getEmployeeInfoTable ()->fetchAll ();
		
		return array (
				'info' => $info 
		);
	}
	public function getBankInfoTable() {
		if (! $this->bankInfoTable) {
			$sm = $this->getServiceLocator ();
			$this->bankInfoTable = $sm->get ( 'Employee\Model\BankInfoTable' );
		}
		return $this->bankInfoTable;
	}
	public function getPersonalInfoTable() {
		if (! $this->personalInfoTable) {
			$sm = $this->getServiceLocator ();
			$this->personalInfoTable = $sm->get ( 'Employee\Model\PersonalInfoTable' );
		}
		return $this->personalInfoTable;
	}
	public function getEmployeeInfoTable() {
		if (! $this->employeeInfoTable) {
			$sm = $this->getServiceLocator ();
			$this->employeeInfoTable = $sm->get ( 'Employee\Model\EmployeeInfoTable' );
		}
		return $this->employeeInfoTable;
	}
	public function getHistoryObject() {
		if (! $this->history) {
			$sm = $this->getServiceLocator ();
			$this->history = $sm->get ( 'Employee\Model\History' );
		}
		return $this->history;
	}
	public function getJobGradeTable() {
		if (! $this->jobGradeTable) {
			$sm = $this->getServiceLocator ();
			$this->jobGradeTable = $sm->get ( 'Employee\Model\JobGradeTable' );
		}
		return $this->jobGradeTable;
	}
	public function getLocationTable() {
		if (! $this->locationTable) {
			$sm = $this->getServiceLocator ();
			$this->locationTable = $sm->get ( 'Employee\Model\LocationTable' );
		}
		return $this->locationTable;
	}
	public function getSalaryGradeTable() {
		if (! $this->salaryGradeTable) {
			$sm = $this->getServiceLocator ();
			$this->salaryGradeTable = $sm->get ( 'Employee\Model\SalaryGradeTable' );
		}
		return $this->salaryGradeTable;
	}
	public function getCompanyTable() {
		if (! $this->companyTable) {
			$sm = $this->getServiceLocator ();
			$this->companyTable = $sm->get ( 'Employee\Model\CompanyTable' );
		}
		return $this->companyTable;
	}
	public function getBankTable() {
		if (! $this->bankTable) {
			$sm = $this->getServiceLocator ();
			$this->bankTable = $sm->get ( 'Employee\Model\BankTable' );
		}
		return $this->bankTable;
	}
	public function getFormTransactionTable() {
		if (! $this->formTransactionTable) {
			$sm = $this->getServiceLocator ();
			$this->formTransactionTable = $sm->get ( 'Employee\Model\FormTransactionTable' );
		}
		return $this->formTransactionTable;
	}
	public function getAdmin() {
		if (! $this->admin) {
			$sm = $this->getServiceLocator ();
			$this->admin = $sm->get ( 'Employee\Model\Admin' );
		}
		return $this->admin;
	}
}