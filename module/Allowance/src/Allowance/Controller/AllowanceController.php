<?php

namespace Allowance\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
//use Allowance\Model\PaysheetCalculation;
//use Allowance\Model\AllowanceServiceFactory;
//use Allowance\Model\ParameterObject;
//use Allowance\Service\CompanyAllowanceService;
use Zend\Db\Adapter\Adapter;
//use Allowance\Service\EmployeeAllowanceService;
use Employee\Model\EmployeeInfo;
// use Allowance\Model\Basic;
class AllowanceController extends AbstractActionController {
	
	private $dbAdapter;
	
	public function indexAction() {
		/*$paysheet = new PaysheetCalculation ();
		$result = $paysheet->Execute ();
		return new ViewModel ( array (
				'result' => $result 
		) );*/
	}
	
	public function colaAction() {
		/*
		$companyAllowance = new CompanyAllowanceService();
		$basic = $companyAllowance->basic();
		\Zend\Debug\Debug::dump($basic);
		*/
		$result = "";
		
		//$employee = new EmployeeInfo()
		
		$array = array(
		    'fromDate' => '2014-10-01',
		    'toDate' => '2014-10-31',
		    'company' => '1',
		    'employee' => '1',	
		);
        
		//$parameterObject = new ParameterObject($array);
		\Zend\Debug\Debug::dump($parameterObject);
		
		$dbAdapter = $this->getDbAdapter();
		
		//$allowanceServiceFactory = new EmployeeAllowanceService($dbAdapter,$parameterObject);
		
		$allowancefac = $allowanceServiceFactory->getAllowanceFactory();
		//\Zend\Debug\Debug::dump($allowancefac);
		$allowance = $allowancefac->makeAllowanceService('hardshipservice');
		
		//$initial = $allowancefac->makeAllowanceService('initialservice');
		//echo "<br />initial : ".$initial->getAmount();
		//\Zend\Debug\Debug::dump($allowancefac);
		
		$result .= "<br/>cola : ".$allowance->getAmount(); 
		$result .= "<br />Exemption : ".$allowance->getExemptedAmount();
		$result .= "<br />Tax : ".$allowance->getTaxAmount();
		$result .= "<br />".$allowance->getTestFunction();
        
		echo $result;
		exit;
		
		return new ViewModel(array(
			'result' => $result
		));
	}
	
	public function getDbAdapter() {
		if (!$this->dbAdapter) {
			$sm = $this->getServiceLocator ();
			$this->dbAdapter = $sm->get('sqlServerAdapter');
		}
		return $this->dbAdapter;
	}
	
}