<?php
namespace Employee\Controller; 


use Zend\Mvc\Controller\AbstractActionController; 
use Application\Model\TelephoneDeductionGrid;
use Zend\View\Model\ViewModel;
use Payment\Model\Company;
use Payment\Model\DateRange;
use Application\Form\SubmitButonForm;
use Application\Form\MonthYear;
use Employee\Mapper\EmployeeService;
use Employee\Form\EmployeeTelephoneForm;
use Employee\Form\UploadPhoneForm;

class TelephoneController extends AbstractActionController {
    
	public function listAction() { }
	
	public function ajaxlistAction() {
		$grid = $this->getGrid();
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getService()->selectEmployeeTelephone()) 
		     ->setParamAdapter($this->getRequest()->getPost()); 
		return $this->htmlResponse($grid->render());
	}
	
	public function htmlResponse($html) { 
		$response = $this->getResponse(); 
		$response->setStatusCode(200);
		$response->setContent($html);
		return $response;
	}
	
	public function calculateAction()
	{
		// @todo 
		//$id = (int) $this->params()->fromRoute('id',0);
		//echo json_encode($id);
		//exit;
		//var_dump($this->getEmployeeList());
		// $form = new AdvanceHousingForm();
		
		$form = new EmployeeTelephoneForm();
		$form->get('employeeNumberTelephone')
		     ->setOptions(array('value_options' => $this->employeeList()))
		//->setAttribute('readOnly', true)
		;  
		return array('form' => $form); 
		//exit; 
	}
	
	public function getPaysheetLastMonth() {
		$dateRange = $this->getDateService(); 
		$from = $dateRange->getFromDate();
		$lastMon = strtotime('-1 month',strtotime($from)); 
		return date("Y-m-d",$lastMon);
	}
	
	public function alreadyclosedAction() { } 
	
	public function uploadphoneAction() { 
		// check is already closed (previous month date and this company )
		$form = new UploadPhoneForm(); 
		$request = $this->getRequest ();  
		$prg = $this->prg('/telephone/uploadphone', true);
		if ($prg instanceof Response ) {
			return $prg;
		} elseif ($prg === false) {
			return array ('form' => $form);
		}
		//echo "test";
		//\Zend\Debug\Debug::dump($request->isPost());
		
		//exit;
		if ($request->isPost()) {
		    //echo "request is post";
		    //exit; 
		    $closed = 0; 
			try {
				$this->getDbTransaction()->beginTransaction();
				$company = $this->getCompanyService();
				$companyId = $company->getId();
				$lastMonth = $this->getPaysheetLastMonth();
				$row = $this->getService()->isPhoneClosed($companyId,$lastMonth);
				//if($row != 0) {
					if($row == 0) {
						// remove existing one
						$this->getService()->removeUnclosedPhone($companyId,$lastMonth); 
					} elseif ($row['isClosed'] == 1) {
						$closed = 1; 
						$this->flashMessenger()->setNamespace('info')
						     ->addMessage('Phone Deduction already closed');
						$this->redirect()->toRoute('telephone',array (
								'action' => 'alreadyclosed'
						));
					}
				//}
				//\Zend\Debug\Debug::dump($closed);
				//exit; 
				if(!$closed) {
				$post = array_merge_recursive($request->getPost()->toArray(),$request->getFiles()->toArray());
				$form->setData($post);
				if ($form->isValid()) {
				    $notSuccessful = 0; 
					$data = $form->getData ();
					$fileName = $data ['phoneFile'] ['name'];
					$chkExt = explode ( ".", $fileName );
					if (strtolower ( $chkExt [1] ) == "csv") {
						$tempPath = $data ['phoneFile'] ['tmp_name'];
						if (($handle = fopen ( $tempPath, "r" )) !== FALSE) {
							$c = 1;
							while ( ($data = fgetcsv($handle,150,",")) !== FALSE) {
							    //\Zend\Debug\Debug::dump($data); 
							    //exit; 
								$val1 = $data[0];
								$employeeId = $this->getService()->getEmployeeIdByPhone($val1); 
								if ($val1 && $employeeId) {
								    //\Zend\Debug\Debug::dump($val1); 
								    //\Zend\Debug\Debug::dump($employeeId);
								    //exit; 
									$mst = array(
											'employeeId'       => $employeeId, 
											'isClosed'         => 0,
											'deuStartingDate'  => $lastMonth,
											'companyId'        => $companyId,
									); 
									//\Zend\Debug\Debug::dump($mst);
                                    $mstId = $this->getService()->insertPhoneMst($mst); 
                                    $dtls = array(
											'mstId'                => $mstId,
											'dueAmount'            => $data['5'],
											//'deductionDate'        => 
											'paidStatus'           => 0,
											//'dueCurrentCalcStatus' => 
                                    ); 
                                    //\Zend\Debug\Debug::dump($dtls);
                                    //exit;
                                    $this->getService()->insertPhoneDtls($dtls);  
								} else {
								    $notSuccessful = 1; 
								    $this->flashMessenger()->setNamespace('info')
								         ->addMessage('Unable to upload, some employee phone number does not exist');
								    $this->redirect()->toRoute('telephone',array (
								        'action' => 'alreadyclosed'
								    ));
								    break; 
								}
							}
							if(!$notSuccessful) {
							    $this->getCheckListService()->checkListlog($this->getRouteInfo()); 
							    $this->getDbTransaction()->commit();
							    fclose($handle);
							    $this->flashMessenger()->setNamespace('success')
							         ->addMessage('Phone Deduction Uploaded Successfully');
							}
							// exit ();
						} else {
							echo "Unable to open file";
						}
						// exit;
					} else {
						echo "File format is not csv";
					}
					// \Zend\Debug\Debug::dump($data);
				}
				}
			} catch ( \Exception $e ) {
				$this->getDbTransaction()->rollBack();
				throw $e;
			}
				
			$this->redirect()->toRoute('telephone',array (
					'action' => 'uploadphone'
			));
			//exit (); 
		}
		return array (
				'form' => $form,$prg
		);
	}   
	
	public function insertPhone(array $attendanceArray) {
        $this->getService()->insertPhone($attendanceArray); 
	}
	
	private function getCompanyService() {
		return $this->serviceLocator->get('company');  
	}
	
	private function getCheckListService() {
	    return $this->serviceLocator->get('checkListService'); 
	} 
	
	private function getCloseForm() {
		$form = new SubmitButonForm();
		$form->get('submit')->setValue('Close Phone Deduction');
		return $form;
	}
	
	public function closephoneAction() {
		$form = $this->getCloseForm();
		$prg = $this->prg('/telephone/closephone', true);
		if ($prg instanceof Response ) {
			return $prg;
		} elseif ($prg === false) {
			return array ('form' => $form);
		} 
		$company = $this->getCompanyService();
		$companyId = $company->getId();
		$lastMonth = $this->getPaysheetLastMonth();
		$row = $this->getService()->isPhoneClosed($companyId,$lastMonth);
		//\Zend\Debug\Debug::dump($row); 
		//echo "outside";
		//exit; 
		//if($row != 0) {
			if($row == 0) { 
			    //echo "Here"; 
			    //exit; 
			    $this->getService()->close($company,$lastMonth,$this->getRouteInfo()); 
				$this->flashMessenger()->setNamespace('info')
				     ->addMessage('Phone Deduction closed successfully'); 
				$this->redirect()->toRoute('telephone',array('action'=>'closephone'));     
			} else { 
				$this->flashMessenger()->setNamespace('info')
				     ->addMessage('Phone Deduction already closed'); 
				$this->redirect()->toRoute('telephone',array (
						'action' => 'alreadyclosed'
				));  
			}
		//}  
		$this->redirect()->toRoute('telephone',array('action'=>'closephone')); 
		return array(
				'form' => $form,
				$prg
		); 
	} 
	
	public function removeAction()
	{
		// @todo
		$id = (int) $this->params()->fromRoute('id',0);
		$deductionService = $this->getService();
		$deductionService->removeEmployeePhoneDeduction($id);
		//$employeeService = $this->getEmployeeService();
		//$employeeService->removeEmployeeConfirmation($id);
		//echo json_encode($id);
		
		exit;
	} 
	
	private function getRouteInfo() {
		return array(
		    'controller' => $this->getEvent()
				->getRouteMatch()
				->getParam('controller','index'),
			'action'   => $this->getEvent()
				->getRouteMatch()
				->getParam('action','index'),
		); 
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
			$output = $this->getPaysheetService()->getPaysheetReport($param);
			
		}
		 
		$viewmodel->setVariables(array(
				'report' => $output,
				'paysheetArray'  => $this->getPaysheetAllowanceArray()
		)); 
	
		return $viewmodel;
	
	}
	
	private function getService() {
		return $this->getServiceLocator()->get('employeeDeductionService');
	}
	
	private function getEmployeeService() {
		return $this->getServiceLocator()->get('employeeService');
	}
	
	private function employeeList() {
		$company = $this->getCompanyService(); 
		$companyId = $company->getId();
		return $this->getEmployeeService()->employeeList($companyId); 
	}   
	
	private function getDateService() {
		return $this->getServiceLocator()->get('dateRange'); 
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
    	
	protected function saveemployeetelephoneAction() {
	
		$formValues = $this->params()->fromPost('formVal');
		$deductionService = $this->getService();
		$company = $this->serviceLocator->get('company'); 
		$deductionService->saveEmployeeDeduction($formValues,$company); 
		//$employeeService = $this->getEmployeeService();
		//$employeeService->saveEmployeeConfirmation($formValues);
		//\Zend\Debug\Debug::dump($formValues);
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
	
	public function getDbTransaction() {
		return $this->serviceLocator->get ( 'transactionDatabase' );
	} 
	
	private function getGrid() {
		return new TelephoneDeductionGrid(); 
	}
	
}