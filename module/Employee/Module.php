<?php

namespace Employee;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Stdlib\Hydrator\ClassMethods;
use Employee\Model\Location;
use Employee\Model\LocationTable;
use Employee\Model\Bank;
use Employee\Model\BankTable;
use Employee\Model\JobGrade;
use Employee\Model\JobGradeTable;
use Employee\Model\SalaryGrade;
use Employee\Model\SalaryGradeTable;
use Employee\Model\CompanyTable;
use Employee\Model\BankInfo;
use Employee\Model\BankInfoTable;
use Employee\Model\PersonalInfo;
use Employee\Model\PersonalInfoTable;
use Employee\Model\EmployeeInfo;
use Employee\Model\EmployeeInfoTable;
use Employee\Model\FormTransaction;
use Employee\Model\FormTransactionTable;
use Employee\Model\History;
use Employee\Model\Admin;
use Application\Mapper\CompanyEmployeeMapper;
use Application\Mapper\PersonMapper;
use Employee\Mapper\EmployeeLocationMapper;
use Employee\Mapper\EmployeeMapper;
use Employee\Mapper\SplHousingMapper; 
use Employee\Model\AllowanceByCalculationService;
use Employee\Mapper\EmployeeService;
use Employee\Mapper\CommonStatementMapper; 
use Employee\Model\PromotionService;
use Employee\Model\SalaryGradeValueService;
use Employee\Model\IncrementService;
use Application\Mapper\SalaryGradeMapper;
use Employee\Model\EmployeeAllowanceService;
use Employee\Mapper\EmployeeAllowanceMapper;
use Employee\Mapper\IncrementMapper;
use Employee\Mapper\EmployeeDeductionMapper;
use Employee\Model\EmployeeDeductionService;
use Application\Persistence\TransactionDatabase;
use Employee\Mapper\LocationService; 
use Employee\Mapper\LocationMapper;
use Employee\Mapper\TravelingFormMapper; 
use Employee\Model\TravelingService; 
use Employee\Model\AffiliationService;
use Employee\Model\AffiliationMapper;



class Module {
	
	public function getAutoloaderConfig() {
		return array (
				'Zend\Loader\ClassMapAutoloader' => array (
						__DIR__ . '/autoload_classmap.php' 
				),
				'Zend\Loader\StandardAutoloader' => array (
						'namespaces' => array (
								__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__ 
						) 
				) 
		); 
	} 
	
	public function getConfig() {
		return include __DIR__ . '/config/module.config.php';
	} 
	
	public function getServiceConfig() {
		return array ( 
			'factories' => array (
				'CompanyEmployeeMapper' => function ($sm) {
				    return new CompanyEmployeeMapper($sm->get('sqlServerAdapter'), 
						$sm->get('entityCollection'),$sm, new PersonMapper($sm->get('sqlServerAdapter'), 
						$sm->get('entityCollection'),$sm));
				},'EmployeeLocationMapper' => function ($sm) {
					return new EmployeeLocationMapper($sm->get('sqlServerAdapter'), 
                 	    $sm->get('entityCollection'),$sm); 
				},'EmployeeAllowanceMapper' => function ($sm) {
					return new EmployeeAllowanceMapper($sm->get('sqlServerAdapter'), 
                	    $sm->get('entityCollection'),$sm);   
				},'employeeMapper' => function ($sm) { 
					return new EmployeeMapper($sm->get('sqlServerAdapter'),
							$sm->get('entityCollection'),$sm); 
				},'allowanceByCalculationService' => function ($sm) { 
					return new AllowanceByCalculationService($sm->get('ReferenceParameter')); 
					// return new EmployeeMapper($sm->get('sqlServerAdapter'),$sm->get('entityCollection'));
				},'employeeService' => function ($sm) { 
					return new EmployeeService($sm->get('ReferenceParameter'),  
							$sm->get('employeeMapper'));    
				},'promotionService' => function ($sm) { 
					return new PromotionService($sm->get('ReferenceParameter')); 
				},'salaryGradeValueService' => function ($sm) { 
					return new SalaryGradeValueService($sm->get('ReferenceParameter')); 
				},'transactionDatabase' => function ($sm) { 
					return new TransactionDatabase($sm->get('sqlServerAdapter'));  
				},'EmployeeAllowanceService' => function ($sm) { 
					return new EmployeeAllowanceService($sm->get('EmployeeAllowanceMapper'),
							$sm->get('transactionDatabase'),$sm);  
				},'employeeDeductionMapper' => function ($sm) { 
					return new EmployeeDeductionMapper($sm->get('sqlServerAdapter'),
							$sm->get('entityCollection'),$sm); 
				},'employeeDeductionService' => function ($sm) { 
					return new EmployeeDeductionService($sm->get('employeeDeductionMapper'),
							$sm->get('transactionDatabase'),$sm);  
				},'locationService' => function($sm) {  
                 	return new LocationService($sm->get('ReferenceParameter'),
                 			$sm->get('locationMapper'),$sm->get('EmployeeLocationMapper'));   
                },'locationMapper' => function($sm) { 
                 	return new LocationMapper($sm->get('sqlServerAdapter'), 
                    $sm->get('entityCollection'),$sm); 
                },'affiliationService' => function($sm) {  
                 	return new AffiliationService($sm->get('ReferenceParameter'),
                 			$sm->get('affiliationMapper'));    
                },'affiliationMapper' => function($sm) { 
                 	return new AffiliationMapper($sm->get('sqlServerAdapter'), 
                    $sm->get('entityCollection'),$sm);  
                },'travelingService' => function($sm) {  
                	return new TravelingService( 
                			$sm->get('leaveMapper'),$sm->get('approvalService'),
				    		$sm->get('userInfoService'),$sm->get('transactionDatabase'),
				    		$sm->get('mailService'),$sm->get('positionService'),
				    		$sm->get('nonWorkingDays'),$sm->get('dateMethods'),
                			$sm->get('travelingFormMapper'),$sm);  
                 	// return new AffiliationService();    
                },'travelingFormMapper' => function($sm) { 
                	return new TravelingFormMapper($sm->get('sqlServerAdapter'), 
                    $sm->get('entityCollection'),$sm);   
                },'incrementMapper' => function($sm) { 
                	return new IncrementMapper($sm->get('sqlServerAdapter'), 
                    $sm->get('entityCollection'),$sm);     
                },'incrementService' => function ($sm) { 
					return new IncrementService($sm->get('ReferenceParameter'),$sm->get('incrementMapper'));  
				}, 'splHousingMapper' => function($sm) { 
                	return new SplHousingMapper($sm->get('sqlServerAdapter'), 
                    $sm->get('entityCollection'),$sm);     
                },'commonStatementMapper' => function($sm) { 
                	return new CommonStatementMapper($sm->get('sqlServerAdapter'), 
                    $sm->get('entityCollection'),$sm);     
                },
			) 
		);  
	} 
} 