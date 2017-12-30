<?php 
namespace Payment\Controller;

use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Payment\Model\Company;
use Payment\Model\DateRange;
use Payment\Model\Paysheet;
use Payment\Model\Person; 
use Application\Form\SubmitButonForm;
use Application\Form\CloseDifferenceForm; 
use Application\Form\DifferenceForm;
use Employee\Form\DifferenceFormValidator;

class DifferenceController extends AbstractActionController
{
	public function indexAction()
	{   
		return new ViewModel();
	}
	
	public function calculateAction()
	{   
		$form = $this->getForm();
		$prg = $this->prg('/difference/calculate',true); 
		if ($prg instanceof Response ) { 
			return $prg; 
		} elseif ($prg === false) { 
			return array ('form' => $form); 
		} 
		$formValidator = $this->getFormValidator(); 
		$form->setInputFilter($formValidator->getInputFilter());
		$form->setData($prg);
		$company = $this->getCompanyService(); 
		$form->setData($prg);
		$routeInfo = $this->getRouteInfo(); 
		//$dateRange = $this->getDateService(); 
		$difference = $this->getDifferenceService();  
		if ($form->isValid()) { 
			$data = $form->getData();   
			
			$difference->calculate($data,$company,$routeInfo);   
			$this->flashMessenger()->setNamespace('success')
			     ->addMessage('Difference Calculated Successfully'); 
			$this->redirect ()->toRoute('difference',array (
					'action' => 'calculate'
			)); 
		} 
		return array(
				'form' => $form,
				$prg
		); 
		
		/*$employeeMapper = $this->getServiceLocator()
		                         ->get('CompanyEmployeeMapper');
		// @todo get that month paysheet employee 
		$condition = array( 
			'isActive' => 1,
			'companyId' => $company->getId(),
			'isInPaysheet' => 1,
					//'employeeNumber' => 1007,
		);  
		$employeeList = $employeeMapper->fetchAll($condition);   
		//\Zend\Debug\Debug::dump($employeeList); 
		//exit; 
		  
			
		$difference->calculate($employeeList,$company,$dateRange,$routeInfo);  
		$this->flashMessenger()->setNamespace('success') 
		     ->addMessage('Difference Calculated Successfully'); 
		// }  
		$this->redirect()->toRoute('difference',array( 
			'action' => 'calculate' 
		));  
		return array(  
			'form' => $form, 
			$prg 
		);*/   
	}  
	
	private function getForm() {
        $form = new DifferenceForm(); 
        $company = $this->getServiceLocator()->get('company');
        //$form->get('employeeNumberDifference')
             //->setOptions(array('value_options' =>
        		//$this->activeEmployeeList($company)))
        		//->setAttribute('readOnly', true)
        //;
        $form->get('submit')->setValue('Calculate Difference'); 
		return $form; 
	} 
	
	private function getCloseForm() {
		$form = new CloseDifferenceForm(); 
		$company = $this->getServiceLocator()->get('company');
		$form->get('diffShortDescription')
		     ->setOptions(array('value_options' => $this->activeDifferenceList($company)))
		//->setAttribute('readOnly', true)
		;
		$form->get('submit')->setValue('Close Difference');
		return $form;
	}
	
	public function closeAction() {
				
		$form = $this->getCloseForm();
		$form->get('submit')->setValue('Close difference');
		$prg = $this->prg('/difference/close', true);
		if ($prg instanceof Response ) { 
			return $prg; 
		} elseif ($prg === false) { 
			return array ('form' => $form); 
		} 
		$company = $this->getCompanyService(); 
		$form->setData($prg);  
		// $dateRange = $this->getDateService(); 
		$difference = $this->getDifferenceService();  
		$routeInfo = $this->getRouteInfo(); 
		if ($form->isValid()) { 
			$data = $form->getData(); 
			$description = $data['diffShortDescription']; 
			//\Zend\Debug\Debug::dump($data); 
			//exit;   
			$res =  $difference->close($company,$description,$routeInfo); 
		    $this->flashMessenger()->setNamespace('success')
                 ->addMessage($res);  
		    $this->redirect()->toRoute('difference',array( 
				'action' => 'close' 
		    )); 
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
				return $this->redirect()->toRoute('difference');
			}
		}
		return array(
				'form' => $form,
		);
	}
	
	/*private function getDifferenceService() {
		return $this->getServiceLocator()->get('Paysheet'); 
	}*/
	
	private function getEmployeeService() {
		return $this->getServiceLocator()->get('employeeService');
	}
    	 
	private function activeEmployeeList(Company $company) {
		return $this->getEmployeeService()->notTakenFEEmployeeList($company);
	} 
	
	private function getCompanyService() {
	   return $this->getServiceLocator()->get('company'); 
    }
    
    private function activeDifferenceList(Company $company) {
    	return $this->getDifferenceService()->differenceDescription($company);
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
            $shortDesc = $values['diffShortDescription']; 
            //$year = $values['year']; 
            $type = 1;
            //\Zend\Debug\Debug::dump($month);
            //\Zend\Debug\Debug::dump($values);
            //var_dump($values);
            //\Zend\Debug\Debug::dump($month);
            $param = array('diffShortDescription' => $shortDesc);
            $company = $this->getCompanyService();
            //$results = $this->getDifferenceService()->getPaysheetReport($param); 
            $output = $this->getDifferenceService()->getDifferenceReport($company,$param); 
            /* if($results) {
            	foreach($results as $result) {
            		$output .= $result['employeeNumber']."<br/>";
            	}
            } else {
            	$output = "Sorry! no results found";
            }  */
            
            /* if ($type == 1) {
                $output = $this->getDifferenceService()->getPaysheetReport($param); 
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
        // \Zend\Debug\Debug::dump($output) ;        
        $viewmodel->setVariables(array(
            'report'            => $output,
        	'name'              => array('Employee Name' => 'employeeName'),
         	'allowance'         => $this->getPaysheetAllowanceArray(),
        	'deduction'         => $this->getPaysheetDeductionArray(),
        	'companyDeduction'  => $this->companyDeductionArray() 
        ));
        return $viewmodel; 
	} 
	
	public function successAction() {
		return new ViewModel(); 
	}
	
	public function policyAction() {
	    	//  $this->acceptableViewModelSelector()
	}
	
	public function manualAction() {
	
	}
	
	public function getReportForm() {
		$form = new CloseDifferenceForm(); 
		$company = $this->getServiceLocator()->get('company');
		$form->get('diffShortDescription')
		     ->setOptions(array('value_options' => $this->activeDifferenceList($company)))
		//->setAttribute('readOnly', true)
		;
		$form->get('submit')->setValue('View Report');
		return $form;
	}
    
	private function getDifferenceService() {
		return $this->getServiceLocator()->get('differenceService'); 
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
				'LeaveAllowance'   => 'LeaveAllowance', 
				//'Eid'              => 'Eid', 
				
				
				
		);
	}
	
	public function getPaysheetDeductionArray() {
		return array( 
				'Social Insurance' => 'SocialInsurance',
				'IncomeTax'        => 'IncomeTax',
				'Zakat'            => 'Zakat',
				'Provident Fund'   => 'ProvidentFund', 
				'Zamala'           => 'Zamala',
				'Union Share'      => 'UnionShare',
				'Telephone'        => 'Telephone',
				//'Punishment'     => 'Punishment',
				'OtherDeduction'   => 'OtherDeduction',
				'KhartoumUnion'    => 'KhartoumUnion',
				'Cooperation'           => 'Cooperation',
				//'AdvanceSalary'         => 'AdvanceSalary',
				//'Advance Housing'       => 'AdvanceHousing',
				//'Absenteeism'         => 'Absenteeism',
				//'PersonalLoan'          => 'PersonalLoan',
		); 
	}
	
	private function getFormValidator() {
		return new DifferenceFormValidator(); 
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