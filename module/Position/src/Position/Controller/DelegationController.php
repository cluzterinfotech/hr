<?php

namespace Position\Controller; 

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Payment\Model\Company;
use Application\Form\EffectiveDateForm;
use Position\Form\DelegationForm;
use Application\Model\EmployeeDelegationGrid;
use Employee\Form\SubmitButonFormValidator; 

class DelegationController extends AbstractActionController {
	
	public function listAction() { }
	
	public function ajaxlistAction() {
		$grid = $this->getGrid();  
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getPositionService()->getDelegationList() )
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
		$company = $this->getServiceLocator()->get('company');
		$companyId = $company->getId();
		$form = new DelegationForm(); 
		$form->get('employeeId') 
		     ->setOptions(array('value_options' => $this->getEmployeeList($companyId))) 
		   //->setAttribute('readOnly', true) 
		; 
		$form->get('delegatedEmployeeId')
		     ->setOptions(array('value_options' => $this->getEmployeeList($companyId)))
		   //->setAttribute('readOnly', true)
		;  
		return array('form' => $form);
		//exit;
	}
	
	public function removeAction()
	{   
		$id = (int) $this->params()->fromRoute('id',0);
		$positionService = $this->getPositionService();
		$positionService->removeDelegation($id);
		//echo json_encode($id);
		exit; 
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
	
	/*public function viewreportAction() {                                                                        
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
	}*/
	
	private function getEmployeeService() {
		return $this->getServiceLocator()->get('employeeMapper');
	}
	
	private function getEmployeeList($companyId) {
		return $this->getEmployeeService()->employeeList($companyId);
	}
	
	private function getPositionService() {
		return $this->getServiceLocator()->get('positionService');
	}
	
	public function successAction() {
		return new ViewModel();
	}
    	
	protected function savedelegationAction() { 
		$formValues = $this->params()->fromPost('formVal'); 
		$positionService = $this->getPositionService(); 
		$data = array(
			'employeeId'          => $formValues['employeeId'],
			'delegatedEmployeeId' => $formValues['delegatedEmployeeId'],
			'delegatedFrom'       => $formValues['delegatedFrom'],
			'delegatedTo'         => $formValues['delegatedTo'], 
		); 
		$info = $positionService->saveDelegation($data);  
		if(!$info) {  
			echo 0;   
			exit;   
		}   
		echo 1;   
		exit;    
	}   
    
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	}
	
	private function getGrid() {
		return new EmployeeDelegationGrid(); 
	}
	
	private function getPositionList() {
		return $this->getPositionService()->getPositionList();  
	}
	
}