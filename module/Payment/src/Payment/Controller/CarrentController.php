<?php

namespace Payment\Controller;

use Application\Form\FunctionBankMonthYear;
use Application\Form\SubmitButonForm;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CarrentController extends AbstractActionController
{
	public function indexAction()
	{   
		return new ViewModel();
	} 
	
	public function calculateAction()
	{   
		$form = $this->getForm();
		$prg = $this->prg('/carrent/calculate',true); 
		if ($prg instanceof Response ) { 
			return $prg; 
		} elseif ($prg === false) { 
			return array ('form' => $form);  
		} 
		$company = $this->getCompanyService(); 
		$form->setData($prg); 
		$dateRange = $this->getDateService();  
		$carrent = $this->getcarrentService();  
		$isAlreadyClosed = $carrent->iscarrentClosed($company,$dateRange);
		if($isAlreadyClosed) {
		    $this->flashMessenger()->setNamespace('info')
			     ->addMessage('Car Rent Already closed for current month');   
		} else { 
			$routeInfo = $this->getRouteInfo();   
			$carrent->calculate($company,$dateRange,$routeInfo);  
		    $this->flashMessenger()->setNamespace('success') 
		         ->addMessage('carrent Calculated Successfully'); 
		} 
		$this->redirect()->toRoute('carrent',array( 
				'action' => 'calculate' 
		));  
		return array(  
			'form' => $form, 
			$prg 
		);  
	}  
	
	private function getForm() { 
        $form = new SubmitButonForm();
        $form->get('submit')->setValue('Calculate carrent');
		return $form; 
	} 
	
	public function closeAction() {
				
		$form = $this->getForm();
		$form->get('submit')->setValue('Close carrent');
		$prg = $this->prg('/carrent/close', true);
		if ($prg instanceof Response ) {
			return $prg; 
		} elseif ($prg === false) {
			return array ('form' => $form);  
		} 
		$company = $this->getCompanyService(); 
		$form->setData($prg);  
		$dateRange = $this->getDateService(); 
		$carrent = $this->getcarrentService();  
		   
		$isAlreadyClosed = $carrent->iscarrentClosed($company,$dateRange);
		if($isAlreadyClosed) {
			$this->flashMessenger()->setNamespace('info')
			     ->addMessage('carrent Already closed for current month'); 
		} else {  
			// @todo  
			$routeInfo = $this->getRouteInfo(); 
			$carrent = $this->getcarrentService(); 
			$carrent->close($company,$dateRange,$routeInfo); 
			$this->flashMessenger()->setNamespace('success')
		         ->addMessage('carrent Closed Successfully'); 
		}  
		$this->redirect()->toRoute('carrent',array( 
				'action' => 'close'
		));  
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
				return $this->redirect()->toRoute('carrent');
			}
		}
		return array(
				'form' => $form,
		);
	}
	
	/*private function getPaysheetService() {
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
			$month = $values['month'];
			$year = $values['year'];
			$bank = $values['Bank'];
			$type = $values['reportType'];
			//$type = 1;
			$param = array(
					'month' => $month,
					'year' => $year,
					'bank' => $bank,
					//'year' => $year,
			); 
			$company = $this->getCompanyService();
			//$results = $this->getPaysheetService()->getPaysheetReport($param);
			if($type == 1) {
				$output = $this->getcarrentService()->getCarRentByFunction($company,$param);
				$vm = array(
						'report'            => $output,
						'name'              => array('Function' => 'sectionCode'),
						'allowance'         => array('Amount' => 'paidAmount'),
						'deduction'         => array(),
						'companyDeduction'  => array(),
						'type'              => $type,
						'param'             => $param,
				); 
				//$name = array('Function' => 'employeeName');
				 
			} elseif($type == 2) {
				$output = $this->getcarrentService()->getCarRentByBank($company,$param);
				$vm = array(
						'report'            => $output,
						'name'              => array('Employee Name' => 'employeeName'),
						'allowance'         => array('Amount' => 'allowance'),
						'deduction'         => array(), 
						'companyDeduction'  => array(
								'Account Number'   => 'accountNumber',
								'Reference Number' => 'referenceNumber',
						),
						'type'              => $type,
						'param'             => $param,
				);
			} elseif($type == 3) {
				$output = $this->getcarrentService()->getCarRentBankSummary($company,$param);
				$vm = array(
						'report'            => $output,
						'name'              => array('Bank Name' => 'bankName'),
						'allowance'         => array('Allowance' => 'allowance'),
						'deduction'         => array('Deduction' => 'deduction'),
						'companyDeduction'  => array(),
						'type'              => $type,
						'param'             => $param,
				);
			} else {
				$output = $this->getcarrentService()->getCarRentReport($param); 
				$vm = array(
						'report'            => $output,
						//'name'              => array('Employee Name' => 'employeeName'),
						//'allowance'         => $this->getPaysheetAllowanceArray(),
						//'deduction'         => $this->getPaysheetDeductionArray(),
						//'companyDeduction'  => $this->companyDeductionArray(),
						'type'              => $type,
				);
			}
		}
		// \Zend\Debug\Debug::dump($output);
		$viewmodel->setVariables($vm);
		return $viewmodel;
                                                                                
        /*$viewmodel = new ViewModel();
        $viewmodel->setTerminal(1);       
        $request = $this->getRequest();
        $output = " "; 
        
        if($request->isPost()) {
            
            $values = $request->getPost(); 
            $month = $values['month']; 
            $year = $values['year']; 
            $type = 1;
            //\Zend\Debug\Debug::dump($month);
            //\Zend\Debug\Debug::dump($values);
            //var_dump($values); 
            //\Zend\Debug\Debug::dump($month); 
            $param = array('month' => $month,'year' => $year);
            // $company = $this->getCompanyService();
            //$results = $this->getPaysheetService()->getPaysheetReport($param); 
            $output = $this->getcarrentService()->getCarRentReport($param); 
            
            
        }
        // \Zend\Debug\Debug::dump($output) ;        
        $viewmodel->setVariables(array(
            'report'            => $output, 
        ));
        return $viewmodel;  */
	} 
	
	public function successAction() {
		return new ViewModel();
	}
	
	public function policyAction() {
		
	}
	
	public function manualAction() {
	
	}
	
	public function getReportForm() {
		$form = new FunctionBankMonthYear(); 
		$form->get('Bank')
		     ->setOptions(array('value_options' => $this->getEmpBank()
		));
		$form->get('submit')->setValue('View Carrent Report');
		return $form; 
	}
	
	private function getEmpBank() {
		return $this->getLookupService()->getBankList();
	}
	
	private function getLookupService() {
		return $this->getServiceLocator()->get('lookupService');
	} 
    
	private function getcarrentService() {
		return $this->getServiceLocator()->get('carRent');
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