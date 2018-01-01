<?php

namespace Payment\Controller;

use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Payment\Model\Company;
use Payment\Model\DateRange;
use Payment\Model\Paysheet;
use Payment\Model\Person; 
use Application\Form\SubmitButonForm;
use Application\Form\MonthYear;
use Application\Form\FinalEntitlementForm;

class FinalentitlementController extends AbstractActionController
{
	public function indexAction()
	{   
		return new ViewModel();
	}
	
	public function calculateAction()
	{   
		$form = $this->getForm();
		$form->get('submit')->setValue('Save Final Entitlement');
		$prg = $this->prg('/finalentitlement/calculate',true); 
		if ($prg instanceof Response ) { 
			return $prg; 
		} elseif ($prg === false) { 
			return array ('form' => $form); 
		} 
		$company = $this->getCompanyService();  
		$form->setData($prg);
		$dateRange = $this->getDateService(); 
		$feService = $this->getFinalEntitlementService(); 
		
		if ($form->isValid()) {
			$data = $form->getData();
			$empId = $data['employeeNumberFinalEntitlement']; 
			$isAlreadyClosed = $feService->isAlreadyClosed($empId);
			if($isAlreadyClosed) {
			    $this->flashMessenger()->setNamespace('info')
				     ->addMessage('Final Entitlement Already closed for this employee'); 
			} else { 
				$routeInfo = $this->getRouteInfo();   
				$feService->calculate($empId,$routeInfo);   
			    $this->flashMessenger()->setNamespace('success') 
			         ->addMessage('Final Entitlement Calculated Successfully'); 
			} 
			$this->redirect()->toRoute('finalentitlement',array( 
				'action' => 'calculate' 
			));  
		} 
		return array(  
			'form' => $form, 
			$prg 
		);  
	}  
	
	private function getForm() { 
        $form = new FinalEntitlementForm(); 
        $company = $this->getServiceLocator()->get('company');
        $form->get('employeeNumberFinalEntitlement')
             ->setOptions(array('value_options' =>
        		$this->notTakenFEEmployeeList($company)))
        		//->setAttribute('readOnly', true)
        ; 
		return $form;
	}    
	
	public function closeAction() { 
				
		$form = $this->getForm(); 
		$form->get('submit')->setValue('Close Final Entitlement');
		$prg = $this->prg('/finalentitlement/close', true);
		if ($prg instanceof Response ) {
			return $prg; 
		} elseif ($prg === false) {
			return array ('form' => $form); 
		} 
		$company = $this->getCompanyService(); 
		$form->setData($prg);  
		$dateRange = $this->getDateService(); 
		$paysheet = $this->getFinalEntitlementService();  
		   
		$isAlreadyClosed = $paysheet->isPaysheetClosed($company,$dateRange);
		if($isAlreadyClosed) {
			$this->flashMessenger()->setNamespace('info')
			     ->addMessage('Final Entitlement Already closed for this employee'); 
		} else {  
			// @todo 
			$routeInfo = $this->getRouteInfo(); 
			$paysheet = $this->getFinalEntitlementService(); 
			$paysheet->close($company,$dateRange,$routeInfo); 
			$this->flashMessenger()->setNamespace('success')
		         ->addMessage('Final Entitlement Closed Successfully'); 
		}  
		$this->redirect()->toRoute('finalentitlement',array( 
				'action' => 'close'
		)); 
		return array( 
				'form' => $form, 
				$prg 
		); 
	} 
	
	public function reportAction() {
		
		$form = $this->getForm();
		$form->get('submit')->setValue('View Report'); 
		$request = $this->getRequest();
		if ($request->isPost()) { 
			$form->setData($request->getPost());
			if ($form->isValid()) {
				return $this->redirect()->toRoute('finalentitlement'); 
			}
		}
		return array(
				'form' => $form,
		);  
	} 
	 
	/*private function getFinalEntitlementService() {
		return $this->getServiceLocator()->get('Paysheet'); 
	}*/
	
	private function getCompanyService() {
	   return $this->getServiceLocator()->get('company'); 
    }
    
    private function getDateService() {
        return $this->getServiceLocator()->get('dateRange');
    } 
	
	public function viewreportAction() {                                                                     
        $viewmodel = new ViewModel();
        $viewmodel->setTerminal(1);       
        $request = $this->getRequest();
        $output = " "; 
        if($request->isPost()) {
            
            $values = $request->getPost(); 
            $empId = $values['employeeNumberFinalEntitlement']; 
            $type = 1;
            $param = array('empId' => $empId); 
            $output = $this->getFinalEntitlementService()->getPaysheetReport($param); 
        }
        // \Zend\Debug\Debug::dump($output) ;        
        $viewmodel->setVariables(array(
            'report'            => $output,
        	'name'              => array('Employee Name' => 'employeeName'), 
        ));
        return $viewmodel;  
	} 
	
	private function getEmployeeService() { 
		return $this->getServiceLocator()->get('employeeService');
	} 
	
	private function notTakenFEEmployeeList(Company $company) {
		return $this->getEmployeeService()->notTakenFEEmployeeList($company);
	}
	 
	public function successAction() {
		return new ViewModel();
	}
	
	public function policyAction() {
		
	}
	
	public function manualAction() {
	
	}
	
	public function getentitlementdetailsAction() {
		$empId = $this->params()->fromPost('empNumber');
		$service = $this->getFinalEntitlementService(); 
		$res = $service->getFeDetails($empId);
		//\Zend\Debug\Debug::dump($res);
		//exit; 
		echo json_encode($res); 
		exit; 
	}
	
	/*public function getReportForm() {
		$form = new MonthYear(); 
		$form->get('submit')->setValue('View Final Entitlement Report');
		return $form;
	}*/ 
    
	private function getFinalEntitlementService() {
		return $this->getServiceLocator()->get('finalEntitlementService');
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
	
}