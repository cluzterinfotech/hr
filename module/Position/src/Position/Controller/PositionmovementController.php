<?php

namespace Position\Controller;

use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Payment\Model\Company;
use Payment\Model\DateRange;
use Application\Form\EffectiveDateForm;
use Application\Form\MonthYear; 
use Employee\Mapper\EmployeeService;
use Application\Model\AdvanceHousingGrid;
use Position\Form\PositionMovementForm;
use Application\Model\EmployeeNewPositionGrid;
use Employee\Form\SubmitButonFormValidator; 

class PositionmovementController extends AbstractActionController {
	
	public function listAction() { }
	
	public function ajaxlistAction() {
		$grid = $this->getGrid();  
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getPositionService()->getPositionMovementList() )
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
		// $id = (int) $this->params()->fromRoute('id',0); 
		// echo json_encode($id);
		// exit;
		// var_dump($this->getEmployeeList()); 
		$form = new PositionMovementForm(); 
		$form->get('employeeNumberPosition') 
		     ->setOptions(array('value_options' => $this->getEmployeeList())) 
		   //->setAttribute('readOnly', true) 
		;
		$form->get('employeeExistingPosition')
		     ->setOptions(array('value_options' => $this->getPositionList()))
		     //->setAttribute('readOnly', true)
		;
		$form->get('employeeNewPosition')
		     ->setOptions(array('value_options' => $this->getPositionList()))
		   //->setAttribute('readOnly', true)
		;
		
		return array('form' => $form);
		//exit;
	}
	
	public function removeAction()
	{
		// @todo
		$id = (int) $this->params()->fromRoute('id',0);
		$positionService = $this->getPositionService();
		$positionService->removePositionMovement($id);
		//echo json_encode($id);
		exit; 
	}
	
	public function calcAction()
	{   
		$form = $this->getForm();
		$prg = $this->prg('/paysheet/calculate', true);
		if ($prg instanceof Response ) {
			return $prg;
		} elseif ($prg === false) {
			return array ('form' => $form);
		}
		$company = $this->getServiceLocator()->get('company');
		$form->setData($prg);
		$dateRange = $this->getServiceLocator()->get('dateRange');
		$paysheet = $this->getServiceLocator()->get('Paysheet'); 
		$isAlreadyClosed = $paysheet->isPaysheetClosed($company,$dateRange);
		if($isAlreadyClosed) {
		    $this->flashMessenger()->setNamespace('info')
			     ->addMessage('Paysheet Already closed for current month');
		} else {
			$employeeMapper = $this->getServiceLocator()->get('CompanyEmployeeMapper');
			$employeeList = $employeeMapper->fetchAll(); 
			$paysheet->calculate($employeeList,$company,$dateRange); 
		    $this->flashMessenger()->setNamespace('success') 
		         ->addMessage('Paysheet Calculated Successfully'); 
		} 
		$this->redirect()->toRoute('paysheet',array(
				'action' => 'calculate'
		));  
		return array(
			'form' => $form,
			$prg
		);  
	} 
	
	private function getForm() {
        $form = new EffectiveDateForm();
		$form->get('effectiveDate')->setLabel('Staff Movement Effective Date*');
		$form->get('submit')->setValue('Apply Movement');
		return $form;
	}
	
	private function getFormValidator() { 
		return new SubmitButonFormValidator(); 
	} 
	
	public function getcurrentpositionAction() {
	    $employeeNumber = $this->params()->fromPost('empNumber');
	    $positionService = $this->getPositionService(); 
	    $position = $positionService->getPositionIdByEmpId($employeeNumber);
	    $empInfo = array(
	        'position'     => $position
	    );
	    echo json_encode($empInfo);
	    exit;
	}
	
	public function applyAction() { 
		$form = $this->getForm();
		$prg = $this->prg('/positionmovement/apply', true);
		if ($prg instanceof Response ) {
			return $prg;
		} elseif ($prg === false) {
			return array ('form' => $form);
		}
		$service = $this->getPositionService(); 
		$company = $this->getServiceLocator()->get('company'); 
		$formValidator = $this->getFormValidator();
		$form->setInputFilter($formValidator->getInputFilter()); 
		$form->setData($prg); 
		if ($form->isValid()) {
			$data = $form->getData();
			$effectiveDate = $data->getEffectiveDate(); 
			//\Zend\Debug\Debug::dump($effectiveDate); 
			//exit;  
			// @todo company also have to be added  
			// @todo rename checkForMismatchPosition with applymovement  
			$message = $service->applyCurrentPositionMovement($effectiveDate,$company);    
			if($message == "success") {  
				$this->flashMessenger()->setNamespace('success')
				     ->addMessage('Position movement applied successfully'); 
				$this->redirect()->toRoute('positionmovement',array(
						'action' => 'apply'
				));
			} else {  
				$this->flashMessenger()->setNamespace('error') 
				     ->addMessage('Unable to apply staff Movement! '.$message);  
				$this->redirect()->toRoute('positionmovement',array( 
						'action' => 'apply' 
				)); 
			}
		}
		
		return array(
				'form' => $form,
				$prg
		); 
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
		return $this->getServiceLocator()->get('employeeMapper');
	}
	
	private function getEmployeeList() {
		$company = $this->getServiceLocator()->get('company');
		$companyId = $company->getId();
		return $this->getEmployeeService()->employeeList($companyId);
	}
	
	
	private function getPositionService() {
		return $this->getServiceLocator()->get('positionService');
	}
	
	public function successAction() {
		return new ViewModel();
	}
	    
	public function getadvancehousingdetailsAction() {
		$employeeNumber = $this->params()->fromPost('empNumber');
		$noOfMonths = $this->params()->fromPost('noOfMonth');
		$advanceService = $this->getAdvanceHousingService();
		$housingInfo = $advanceService->getadvancehousingdetails($employeeNumber,$noOfMonths);
		echo json_encode($housingInfo); 
		exit; 
	} 
	
	protected function getAdvanceHousingService() {
		return $this->serviceLocator->get('advancePaymentService');
	}
	
	protected function savepositionmovementAction() {
        
		$formValues = $this->params()->fromPost('formVal'); 
		$positionService = $this->getPositionService();
		//$currentPositionId = $positionService->getPositionIdByEmpId();
		$data = array(
			'employeeId'         => $formValues['employeeNumberPosition'],
			'positionId'         => $formValues['employeeNewPosition'],
		    'currentPositionId'  => $formValues['employeeExistingPosition'],
		);
		$info = $positionService->savePositionMovement($data);  
		if(!$info) {  
			echo 0;   
			exit;   
		}   
		echo 1;   
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
	
	private function getGrid() {
		return new EmployeeNewPositionGrid(); 
	}
	
	private function getPositionList() {
		return $this->getPositionService()->getPositionList();  
	}
	
	
}