<?php

namespace Payment;

use Payment\Service\PaysheetService;
use Application\Service\EmployeeDeductionAmountService;
use Payment\Service\SalaryDifferenceService;
use Payment\Model\IncomeTax;
use Payment\Model\Zakat;
use Payment\Model\Zamala;
use Payment\Model\Paysheet;
use Payment\Model\ColaEntry;
use Payment\Model\ReferenceParameter;
use Payment\Model\AllowanceEntry;
use Payment\Model\AllowanceSalaryGrade;
use Payment\Model\AllowancePercentage;
use Payment\Model\ColaSalaryGrade;
use Payment\Model\CompanyDeduction;
use Payment\Model\Airport;
use Payment\Model\Hardship;
use Payment\Mapper\PaysheetMapper;
use Payment\Model\Initial;
use Payment\Model\NatureOfWork;
use Payment\Model\Fitter;
use Payment\Model\Housing;
use Payment\Model\Representative;
use Payment\Model\Shift;
use Payment\Model\OtherAllowance;
use Payment\Model\SpecialAllowance;
use Payment\Model\President;
use Payment\Model\Cashier;
use Payment\Model\Company;
use Payment\Model\DateRange;
use Employee\Model\AllowanceByCalculationService;
use Payment\Model\SocialInsurance;
use Application\Persistence\TransactionDatabase;
use Payment\Model\TaxService;
use Payment\Model\AdvancePaymentService;
use Payment\Model\AdvancePaymentMapper;
use Payment\Model\CompanyAllowanceService;
use Payment\Model\Transportation;
use Payment\Model\ProvidentFund;
use Payment\Model\KhartoumUnion;
use Payment\Model\UnionShare;
use Payment\Model\OtherDeduction;
use Payment\Model\Absenteeism;
use Payment\Model\Punishment;
use Payment\Model\SocialInsuranceCompany;
use Payment\Model\ProvidentFundCompany;
use Payment\Model\OverTime;
use Payment\Model\Meal;
use Payment\Model\Cooperation;
use Payment\Model\DeductionEntry;
use Payment\Mapper\OvertimeMapper;
use Payment\Service\OvertimeService;
use Payment\Mapper\OtmealMapper;
use Payment\Service\OtmealService; 
use Payment\Model\MonthYearMapper;
use Payment\Mapper\CarRentPositionMapper;
use Payment\Mapper\CarRentGroupMapper;
use Payment\Model\LeaveAllowanceService;
use Payment\Model\LeaveAllowance;
use Payment\Mapper\LeaveAllowanceMapper;
use Payment\Model\FinalEntitlement;
use Payment\Mapper\FinalEntitlementMapper;
use Payment\Model\Difference;
use Payment\Mapper\DifferenceMapper;
use Payment\Model\CarRent;
use Payment\Mapper\CarRentMapper; 
use Payment\Mapper\BonusCriteriaMapper; 
use Payment\Mapper\GlassAllowanceMapper; 
use Payment\Mapper\FamilyMemberMapper;
use Payment\Model\PfRefundService;
use Payment\Mapper\PfRefundMapper; 
use Payment\Mapper\OverPaymentMapper;
use Payment\Mapper\CarAmortizationMapper;
use Payment\Model\OverPayment;
use Payment\Mapper\BonusMapper;
use Payment\Model\BonusService;

class Module {
    
    public function getAutoloaderConfig() {
        return array( 
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php'
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                )
            )
        );  
    }
    
    public function getConfig() {
        return include __DIR__ . '/config/module.config.php'; 
    }
     
    public function getServiceConfig() { 
        return array(
            'factories' => array( 
            	// 'company' => 'Application\Factory\CompanyFactory',  
            	 'company' =>  function($sm) { 
            	 	$auth = $sm->get('Zend\Authentication\AuthenticationService');
            	 	$identity = $auth->getIdentity(); 
            	 	$company = new Company(); 
            	 	$company->setId($identity['company']); 
            	 	// $company->setCompanyName('Permanent'); 
            	    return $company; 
            	 }, 'dateRange' =>  function($sm) { 
            	 	// @todo replace 
            	 	// get current month and year 
            	 	$monYearMapp = $sm->get('monthYearMapper');
                    
            	 	$dateRange = $monYearMapp->getActiveMonth(
            	 			$sm->get('company')); 
            	 	// $dateRange = new DateRange($fromDate,$toDate);      
            	 	return $dateRange;   
            	 },'monthYearMapper' =>  function($sm) { 
            	 	return new MonthYearMapper($sm->get('sqlServerAdapter'),  
									  $sm->get('entityCollection'),$sm,
            	 			$sm->get('dateMethods')
            	 	); 
                 	//return new PaysheetService($sm->get('sqlServerAdapter'),  
						//			  $sm->get('entityCollection'),$sm		          
                 	//);      
                 },'paysheetService' =>  function($sm) { 
                 	return new PaysheetService($sm->get('sqlServerAdapter'),  
									  $sm->get('entityCollection'),$sm		          
                 			);     
                 },'advancePaymentMapper' =>  function($sm) { 
                 	return new AdvancePaymentMapper($sm->get('sqlServerAdapter'), 
									  $sm->get('entityCollection'),$sm);   
                 },'advancePaymentService' =>  function($sm) { 
                 	return new AdvancePaymentService($sm->get('advancePaymentMapper'),
                 			$sm->get('ReferenceParameter'));   
                 },'taxService' =>  function($sm) { 
                 	return new TaxService(); 
                 },'differenceService' =>  function($sm) { 
                 	return new SalaryDifferenceService($sm->get('sqlServerAdapter'),
                 			$sm->get('entityCollection'),$sm
                 	); 
                 },'EmployeeDeductionAmountService' =>  function($sm) {
                 	return new EmployeeDeductionAmountService($sm->get('sqlServerAdapter'),
									  $sm->get('entityCollection'),$sm                 			          
                 	); 
                 },'CompanyDeduction' => function($sm) { 
                 	return new CompanyDeduction($sm->get('sqlServerAdapter'), 
                 	    $sm->get('entityCollection'),$sm); 
                 },'companyAllowance' => function($sm) { 
                 	return new CompanyAllowanceService(
                 			    $sm->get('sqlServerAdapter'),
                 			    $sm->get('entityCollection'),$sm
                 			);  
                 },'paysheetMapper' => function($sm) { 
                 	return new PaysheetMapper($sm->get('sqlServerAdapter'), 
                 			$sm->get('entityCollection'),$sm); 
                 },'Paysheet' => function($sm) {  
                 	return new Paysheet($sm->get('ReferenceParameter'));  
                 	// return new Paysheet($sm);   
                 },'transactionDatabase' =>  function($sm) { 
                 	return new TransactionDatabase($sm->get('sqlServerAdapter')); 
                 },'ReferenceParameter' => function($sm) { 
                 	
                 	return new ReferenceParameter(
                 			new AllowanceEntry($sm->get('sqlServerAdapter'),
                 			    $sm->get('entityCollection'),$sm), 
                 			new AllowanceSalaryGrade(),
                 			new AllowancePercentage(),
                 			$sm->get('companyAllowance'),
                 			$sm,
                 			$sm->get('sqlServerAdapter'),
                 			$sm->get('entityCollection'),
                 			$sm->get('CompanyDeduction'),
                 			$sm->get('transactionDatabase'),
                 			$sm->get('DeductionEntry') 
                 	); 
                 	
                 },'DeductionEntry' => function($sm) { 
                 	return new DeductionEntry($sm->get('sqlServerAdapter'),
                 			    $sm->get('entityCollection'),$sm); 
                 },'Initial' => function($sm) { 
                 	return new Initial($sm->get('ReferenceParameter'));  
                 },'ColaEntry' => function($sm) { 
                 	return new ColaEntry($sm->get('ReferenceParameter')); 
                 },'ColaSalaryGrade' => function($sm) { 
                 	return new ColaSalaryGrade($sm->get('ReferenceParameter'));  
                 },'Cashier' => function($sm) { 
                 	return new Cashier($sm->get('ReferenceParameter'));  
                 },'Airport' => function($sm) { 
                 	return new Airport($sm->get('ReferenceParameter'));  
                 },'Hardship' => function($sm) {
                 	return new Hardship($sm->get('ReferenceParameter'));
                 },'NatureOfWork' => function($sm) {
                 	return new NatureOfWork($sm->get('ReferenceParameter')); 
                 },'Fitter' => function($sm) {
                 	return new Fitter($sm->get('ReferenceParameter')); 
                 },'Housing' => function($sm) {
                 	return new Housing($sm->get('ReferenceParameter')); 
                 },'Representative' => function($sm) {
                 	return new Representative($sm->get('ReferenceParameter')); 
                 },'Shift' => function($sm) {
                 	return new Shift($sm->get('ReferenceParameter')); 
                 },'OtherAllowance' => function($sm) {
                 	return new OtherAllowance($sm->get('ReferenceParameter'));
                 },'SpecialAllowance' => function($sm) {
                 	return new SpecialAllowance($sm->get('ReferenceParameter'));
                 },'President' => function($sm) {
                 	return new President($sm->get('ReferenceParameter'));
                 },'Transportation' => function($sm) {
                 	return new Transportation($sm->get('ReferenceParameter'));
                 },	
                 
                 'Overtime' => function($sm) {
                 	return new OverTime($sm->get('ReferenceParameter'));
                 },'Meal' => function($sm) {
                 	return new Meal($sm->get('ReferenceParameter'));
                 }, 
                 
                 'IncomeTax' => function($sm) {
                 	return new IncomeTax($sm->get('ReferenceParameter')); 
                 },'SocialInsurance' => function($sm) {
                 	return new SocialInsurance($sm->get('ReferenceParameter')); 
                 },'OverPayment' => function($sm) {
                 	return new OverPayment($sm->get('ReferenceParameter')); 
                 },'Zakat' => function($sm) {
                 	return new Zakat($sm->get('ReferenceParameter')); 
                 },'Zamala' => function($sm) {
                 	return new Zamala($sm->get('ReferenceParameter')); 
                 },'UnionShare' => function($sm) {
                 	return new UnionShare($sm->get('ReferenceParameter')); 
                 },'ProvidentFund' => function($sm) {
                 	return new ProvidentFund($sm->get('ReferenceParameter'));
                 },'KhartoumUnion' => function($sm) {
                 	return new KhartoumUnion($sm->get('ReferenceParameter'));
                 },'OtherDeduction' => function($sm) {
                 	return new OtherDeduction($sm->get('ReferenceParameter')); 
                 },'Absenteeism' => function($sm) {
                 	return new Absenteeism($sm->get('ReferenceParameter'));
                 },'Punishment' => function($sm) {
                 	return new  Punishment($sm->get('ReferenceParameter')); 
                 },'SocialInsuranceCompany' => function($sm) {
                 	return new SocialInsuranceCompany($sm->get('ReferenceParameter')); 
                 },'ProvidentFundCompany' => function($sm) {
                 	return new ProvidentFundCompany($sm->get('ReferenceParameter'));
                 },'Cooperation' => function($sm) {
                 	return new Cooperation($sm->get('ReferenceParameter'));
                 }, 
                 'overtimeMapper' => function ($sm) {
                     return new OvertimeMapper($sm->get('sqlServerAdapter'),
                        $sm->get('entityCollection')); 
                 },'overtimeService' => function ($sm) {
					    return new OvertimeService($sm->get('leaveMapper'),$sm->get('approvalService'),
				    		$sm->get('userInfoService'),$sm->get('transactionDatabase'),
				    		$sm->get('mailService'),$sm->get('positionService'),
				    		$sm->get('nonWorkingDays'),$sm->get('dateMethods'),
					        $sm->get('travelingFormMapper'),$sm->get('pmsFormMapper'),$sm); 
				 },'otmealMapper' => function ($sm) {
                     return new OtmealMapper($sm->get('sqlServerAdapter'), 
                         $sm->get('entityCollection')); 
                 },'otmealService' => function ($sm) {
					 return new OtmealService($sm->get('otmealMapper')); 
				 },'carRentPositionMapper' => function ($sm) {
					 return new CarRentPositionMapper($sm->get('sqlServerAdapter'),
                 			    $sm->get('entityCollection'),$sm); 
				 },'carRentGroupMapper' => function ($sm) {
				     return new CarRentGroupMapper($sm->get('sqlServerAdapter'),
                 			    $sm->get('entityCollection'),$sm);  
					 //return new CarRentPositionMapper($sm->get('sqlServerAdapter'),
                 			    //$sm->get('entityCollection'),$sm); 
				 },'leaveAllowanceService' => function ($sm) {
					 return new LeaveAllowance($sm->get('ReferenceParameter')); 
				 },'leaveAllowanceMapper' => function ($sm) {
					 return new LeaveAllowanceMapper($sm->get('sqlServerAdapter'),
                 			    $sm->get('entityCollection'),$sm); 
				 },'finalEntitlementService' => function ($sm) {
					 return new FinalEntitlement($sm->get('ReferenceParameter'));  
				 },'finalEntitlementMapper' => function ($sm) { 
					 return new FinalEntitlementMapper($sm->get('sqlServerAdapter'),
                 			    $sm->get('entityCollection'),$sm);  
				 },'differenceService' => function ($sm) {
					 return new Difference($sm->get('ReferenceParameter'));   
				 },'differenceMapper' => function ($sm) {
					 return new DifferenceMapper($sm->get('sqlServerAdapter'),
                 			    $sm->get('entityCollection'),$sm);    
				 },'carRent' => function ($sm) {
					 return new CarRent($sm->get('ReferenceParameter'));   
				 },'carRentMapper' => function ($sm) {
					 return new CarRentMapper($sm->get('sqlServerAdapter'),
                 			    $sm->get('entityCollection'),$sm);     
				 },'amortizationMapper' => function ($sm) {
					 return new CarAmortizationMapper($sm->get('sqlServerAdapter'),
                 			    $sm->get('entityCollection'),$sm);      
				 }, 'bonusCriteriaMapper' => function ($sm) {
					 return new BonusCriteriaMapper($sm->get('sqlServerAdapter'),
                 			    $sm->get('entityCollection'),$sm);     
				 },'glassAllowanceMapper' => function ($sm) {
					 return new GlassAllowanceMapper($sm->get('sqlServerAdapter'),
                 			    $sm->get('entityCollection'),$sm);     
				 },'familyMemberMapper' => function ($sm) {
					 return new FamilyMemberMapper($sm->get('sqlServerAdapter'),
                 			    $sm->get('entityCollection'),$sm);     
				 },'pfRefundService' => function ($sm) {
					 return new PfRefundService($sm->get('ReferenceParameter'));   
				 },'pfRefundMapper' => function ($sm) { 
					 return new PfRefundMapper($sm->get('sqlServerAdapter'),
                 			    $sm->get('entityCollection'),$sm);  
				 },'overPaymentMapper' => function ($sm) { 
					 return new OverPaymentMapper($sm->get('sqlServerAdapter'),
                 			    $sm->get('entityCollection'),$sm);  
				 },'bonusMapper' => function($sm) {
				     return new BonusMapper($sm->get('sqlServerAdapter'),
				         $sm->get('entityCollection'),$sm);
				 },'bonusService' => function ($sm) {
				     return new BonusService($sm->get('ReferenceParameter'));
				 }, 
            ) 
        );   
    } 
}
