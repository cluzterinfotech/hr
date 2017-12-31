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
use Application\Form\PfRefundTenureForm;

class PfrefundtenureController extends AbstractActionController
{
	public function indexAction()
	{   
		return new ViewModel();
	}
	
	public function calculateAction()
	{   
		$form = $this->getForm();
		$form->get('submit')->setValue('Save PF Refund');
		$prg = $this->prg('/pfrefundtenure/calculate',true); 
		if ($prg instanceof Response ) { 
			return $prg; 
		} elseif ($prg === false) { 
			return array ('form' => $form); 
		} 
		$company = $this->getCompanyService();  
		$form->setData($prg);
		$dateRange = $this->getDateService(); 
		$feService = $this->getService(); 
		
		if ($form->isValid()) {
			$data = $form->getData();
			$empId = $data['employeeNumberFinalEntitlement']; 
			$isAlreadyClosed = $feService->isAlreadyClosed($empId);
			if($isAlreadyClosed) {
			    $this->flashMessenger()->setNamespace('info')
				     ->addMessage('PF Refund Already closed for this employee'); 
			} else { 
				$routeInfo = $this->getRouteInfo();   
				$feService->calculate($empId,$routeInfo);   
			    $this->flashMessenger()->setNamespace('success') 
			         ->addMessage('PF Refund Calculated Successfully'); 
			} 
			$this->redirect()->toRoute('pfrefundtenure',array( 
				'action' => 'calculate' 
			));  
		} 
		return array(  
			'form' => $form, 
			$prg 
		);  
	}  
	
	private function getForm() { 
        $form = new PfRefundTenureForm(); 
        $company = $this->getServiceLocator()->get('company');
        $form->get('employeeIdPfTen')
             ->setOptions(array('value_options' =>
        		$this->notTakenFEEmployeeList($company)))
        		//->setAttribute('readOnly', true)
        ; 
		return $form;
	}    
	
	public function closeAction() { 
				
		$form = $this->getForm(); 
		$form->get('submit')->setValue('Close PF Refund');
		$prg = $this->prg('/pfrefundtenure/close', true);
		if ($prg instanceof Response ) {
			return $prg; 
		} elseif ($prg === false) {
			return array ('form' => $form); 
		} 
		$company = $this->getCompanyService(); 
		$form->setData($prg);  
		$dateRange = $this->getDateService(); 
		$paysheet = $this->getService();  
		   
		$isAlreadyClosed = $paysheet->isPaysheetClosed($company,$dateRange);
		if($isAlreadyClosed) {
			$this->flashMessenger()->setNamespace('info')
			     ->addMessage('PF Refund Already closed for this employee'); 
		} else {  
			// @todo 
			$routeInfo = $this->getRouteInfo(); 
			$paysheet = $this->getService(); 
			$paysheet->close($company,$dateRange,$routeInfo); 
			$this->flashMessenger()->setNamespace('success')
		         ->addMessage('PF Refund Closed Successfully'); 
		}  
		$this->redirect()->toRoute('pfrefundtenure',array( 
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
				return $this->redirect()->toRoute('pfrefundtenure'); 
			}
		}
		return array(
				'form' => $form,
		);  
	} 
	 
	/*private function getService() {
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
            $output = $this->getService()->getPaysheetReport($param); 
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
	    $companyId = $company->getId(); 
	    return $this->getEmployeeService()->employeeList($companyId); 
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
		$service = $this->getService(); 
		$res = $service->getFeDetails($empId);
		echo json_encode($res); 
		exit; 
	}
	
	/*public function getReportForm() {
		$form = new MonthYear(); 
		$form->get('submit')->setValue('View PF Refund Report');
		return $form;
	}*/ 
    
	private function getService() {
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