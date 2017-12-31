<?php

namespace Application\Controller;

use Application\Form\SubmitButonForm;
use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Helper\ViewModel;

class OpencloseController extends AbstractActionController {
	
	public function indexAction() {
		return new ViewModel();
	} 
	
	public function openclosemonthAction()
	{ 
		$form = $this->getForm();
		$form->get('submit')->setValue('Close Month');
		$prg = $this->prg('/openclose/openclosemonth',true); 
		if ($prg instanceof Response ) { 
			return $prg; 
		} elseif ($prg === false) { 
			return array ('form' => $form);  
		} 
		$form->setData($prg); 
		
		$company = $this->getServiceLocator()->get('company'); 
		$dateRange = $this->getServiceLocator()->get('dateRange'); 
		$openCloseService = $this->getServiceLocator()->get('opencloseservice'); 
		// is month closed 
		$isAlreadyClosed = 0; // $openCloseService->isPendingProcessInMonth($company,$dateRange);  
		if($isAlreadyClosed) {  
			$this->flashMessenger()->setNamespace('info') 
			     ->addMessage('Unable to close current month'); 
			$this->redirect()->toRoute('openclose',array( 
					'action' => 'openclosemonth' 
			));  
		} else { 
			$openCloseService->closeMonth($company,$dateRange); 
			
			$this->flashMessenger()->setNamespace('success')
			     ->addMessage('Month closed and new month opened successfully');
			$this->redirect()->toRoute('openclose',array(
					'action' => 'success'
			)); 
		} 
		
		return array(
				'form' => $form,
				$prg
		); 
	}
	
	public function opencloseyearAction()
	{ 
		$form = $this->getForm(); 
		$form->get('submit')->setValue('Close Year');
		$prg = $this->prg('/openclose/opencloseyear',true);
		if ($prg instanceof Response ) { 
			return $prg; 
		} elseif ($prg === false) { 
			return array ('form' => $form); 
		} 
		
		$form->setData($prg);
		
		$company = $this->getServiceLocator()->get('company');
		$dateRange = $this->getServiceLocator()->get('dateRange');
		$paysheet = $this->getServiceLocator()->get('Paysheet');
		
		$isAlreadyClosed = 1;//$paysheet->isPaysheetClosed($company,$dateRange);
		if($isAlreadyClosed) {
			$this->flashMessenger()->setNamespace('info')
			     ->addMessage('Unable to close current year!');
			$this->redirect()->toRoute('openclose',array(
					'action' => 'opencloseyear'
			));
		} else {
			
			$employeeMapper = $this->getServiceLocator()->get('CompanyEmployeeMapper');
			$employeeList = $employeeMapper->fetchAll();
			$paysheet->calculate($employeeList,$company,$dateRange);
			
			$this->flashMessenger()->setNamespace('success')
			     ->addMessage('Year closed and new year opened successfully');
			$this->redirect()->toRoute('openclose',array(
					'action' => 'opencloseyear'
			));
		}
		 
		return array(
				'form' => $form,
				$prg
		); 
	} 
	
	private function getForm() { 
		return new SubmitButonForm(); 
		//return $form; 
	} 
    
	public function successAction() {
		return new ViewModel();
	}
    	
	public function getOpenCloseService() {
		return $this->getServiceLocator()->get('openCloseService');  
	}
	
	/*
	   select * 
       from sys.objects 
       where (type = 'U' or type = 'P') 
       and modify_date > dateadd(m, -3, getdate()) 
       order by modify_date desc
	 */
	 
} 