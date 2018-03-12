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
use Application\Form\Year;

class BonusController extends AbstractActionController
{
	public function indexAction()
	{   
		return new ViewModel();
	}
	
	public function calculateAction()
	{   
		$form = $this->getForm();
		$prg = $this->prg('/bonus/calculate',true); 
		if ($prg instanceof Response ) { 
			return $prg; 
		} elseif ($prg === false) { 
			return array ('form' => $form); 
		} 
		$company = $this->getCompanyService(); 
		$form->setData($prg);
		$dateRange = $this->getDateService(); 
		$bonus = $this->getService(); 
		$isAlreadyClosed = 0;//$bonus->isbonusClosed($company,$dateRange);
		if($isAlreadyClosed) {
		    $this->flashMessenger()->setNamespace('info')
			     ->addMessage('bonus Already closed for current month'); 
		} else { 
			/*$employeeMapper = $this->getServiceLocator()->get('CompanyEmployeeMapper');
			$condition = array( 
					'isActive' => 1,
					'companyId' => $company->getId(),
					'isInPaysheet' => 1,
					//'employeeNumber' => 1007,
			);  
			$employeeList = $employeeMapper->fetchAll($condition);   
			//\Zend\Debug\Debug::dump($employeeList); 
			//exit; 
			$routeInfo = $this->getRouteInfo(); */   
			
		    $r = $bonus->calculate($company);  
		    
		    if($r == 0) {
		        $this->flashMessenger()->setNamespace('info')
		             ->addMessage('bonus already closed'); 
		    } else {
		        $this->flashMessenger()->setNamespace('success') 
		             ->addMessage('bonus Calculated Successfully'); 
		    }
		} 
		$this->redirect()->toRoute('bonus',array( 
				'action' => 'calculate' 
		));  
		return array(  
			'form' => $form, 
			$prg 
		);  
	}  
	
	private function getForm() {
        $form = new SubmitButonForm();
        $form->get('submit')->setValue('Calculate bonus');
		return $form;
	}
	
	public function closeAction() {
				
		$form = $this->getForm();
		$form->get('submit')->setValue('Close bonus');
		$prg = $this->prg('/bonus/close', true);
		if ($prg instanceof Response ) {
			return $prg; 
		} elseif ($prg === false) {
			return array ('form' => $form); 
		} 
		$company = $this->getCompanyService(); 
		$form->setData($prg);  
		$dateRange = $this->getDateService(); 
		$bonus = $this->getbonusService();  
		   
		$isAlreadyClosed = $bonus->isPaysheetClosed($company,$dateRange);
		if($isAlreadyClosed) {
			$this->flashMessenger()->setNamespace('info')
			     ->addMessage('bonus Already closed for current month'); 
		} else {  
			// @todo 
			$routeInfo = $this->getRouteInfo(); 
			$bonus = $this->getbonusService(); 
			$bonus->close($company,$dateRange,$routeInfo); 
			$this->flashMessenger()->setNamespace('success')
		         ->addMessage('bonus Closed Successfully'); 
		}  
		$this->redirect()->toRoute('bonus',array( 
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
				return $this->redirect()->toRoute('bonus');
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
	
	public function viewbonusreportAction() {                                                                     
	    $viewmodel = new ViewModel();
	    $viewmodel->setTerminal(1);
	    $request = $this->getRequest();
	    $output = " ";
	    if($request->isPost()) {
	        $values = $request->getPost();
	        $year = $values['year'];
	        $company = $this->getCompanyService();
	        $companyId = $company->getId();
	        $output = $this->getService()
	        ->bonusReport($year,$companyId);
	        $vm = array(
	            'report'     => $output,
	        );
	    }
	    //$output
	    //\Zend\Debug\Debug::dump($output);
	    $viewmodel->setVariables($vm);
	    return $viewmodel;
	} 
	
	public function successAction() {
		return new ViewModel();
	}
	
	public function policyAction() {
		
	}
	
	public function manualAction() {
	
	}
	
	public function getReportForm() {
		$form = new Year();  
		$form->get('submit')->setValue('View Bonus Report');
		return $form;
	}
    
	private function getService() {
		return $this->getServiceLocator()->get('bonusService');
	} 
	
	private function getPaysheetAllowanceArray() {
		return array(
				
				// 'Employee Number'  => 'employeeNumber', 
				'Initial Salary'   => 'Initial',
				'COLA'             => 'COLA',
				'Housing'          => 'Housing',
				'Transportation'   => 'Transportation',
				'Representative'   => 'Representative',
				'NatureofWork'     => 'NatureofWork', 
				'Hardship'         => 'Hardship',
				'Cashier'          => 'Cashier',
				'Airport'          => 'Airport',
				'Fitter'           => 'Fitter',
				//'Shift'            => 'Shift',
				'OtherAllowance'   => 'OtherAllowance',
				'SpecialAllowance' => 'SpecialAllowance',
				'President'        => 'President',
				'Overtime'         => 'Overtime',
				'Meal'             => 'Meal',
				
				
		);
	}
	
	public function getPaysheetDeductionArray() {
		return array( 
				'Social Insurance' => 'SocialInsurance',
				'IncomeTax'        => 'IncomeTax',
				'Zakat'            => 'Zakat',
				'Provident Fund'   => 'ProvidentFund', 
				'Zamala'           => 'Zamala',
				'Union Share'           => 'UnionShare',
				'Telephone'             => 'Telephone',
				//'Punishment'          => 'Punishment',
				'OtherDeduction'        => 'OtherDeduction',
				'KhartoumUnion'         => 'KhartoumUnion',
				'Cooperation'           => 'Cooperation',
				'AdvanceSalary'         => 'AdvanceSalary',
				'Advance Housing'       => 'AdvanceHousing',
				//'Absenteeism'         => 'Absenteeism',
				'PersonalLoan'          => 'PersonalLoan',
		); 
	}
	
	public function companyDeductionArray() {
		return array(
			'Company SI'  => 'SocialInsuranceCompany',
			'Company PF'  => 'ProvidentFundCompany',
		); 
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