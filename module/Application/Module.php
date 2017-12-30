<?php

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Application\Utility\FiscalYear;
use Application\Mapper\EmployeeAllowanceAmountMapper;
use Application\Utility\DateRange;
use Application\Model\AlertService;
use Application\Mapper\AlertMapper;
use Payment\Model\DateMethods;
use Employee\Mapper\PromotionMapper; 
use Payment\Model\UpdateHardship;
use Payment\Model\UpdateInitial;
use Application\Model\MailService;
use Application\Mapper\CompanyMapper;
use Application\Model\CompanyService;
use Application\Model\CheckListService;
use Application\Model\CheckListMapper;
use Application\Model\OpenCloseService;
use Application\Mapper\LookupMapper;
use Application\Model\LookupService;
use Application\Model\NonWorkingDaysService; 
use Application\Mapper\NonWorkingDaysMapper;
use Application\Model\NonPaymentDaysService;
use Application\Mapper\AttendanceMapper; 
use Application\Mapper\BankMapper;
use Application\Mapper\MailMapper;
use Application\Mapper\DepartmentMapper; 
use Application\Mapper\PolicyMapper;
use Application\Mapper\SgMapper;
use Application\Mapper\JgMapper;
use Application\Mapper\SectionMapper; 
use Application\Mapper\NationalityMapper; 
use Application\Mapper\ReligionMapper;
use Application\Mapper\FamilymembertypeMapper; 
use Application\Mapper\GlassAmountDurationMapper; 
use Application\Mapper\EmployeeIdCardMapper; 
use Application\Mapper\CurrencyMapper;
use Application\Mapper\BabyCareMapper;
use Application\Mapper\RamadanMapper;
use Application\Model\EverydayProcessService;
use Application\Mapper\AttendanceEventMapper;
use Application\Mapper\AttendanceEventDurationMapper;
use Application\Mapper\AttendanceLocGroupMapper;
use Application\Mapper\AttendanceGroupHrsMapper;
use Application\Mapper\AttendanceGroupMapper;

class Module {
	
	public function onBootstrap(MvcEvent $e) { 
		$eventManager = $e->getApplication()->getEventManager();
		$moduleRouteListener = new ModuleRouteListener();
		$moduleRouteListener->attach($eventManager); 
		$referenceParam = $e->getApplication()->getServiceManager()
						    ->get('ReferenceParameter');
		$eventManager->attach(new UpdateHardship($referenceParam)); 
		$eventManager->attach(new UpdateInitial($referenceParam));
		//$eventManager->attach(new UpdateLocation()); 
		//$eventManager->attach(new SendMailAlert()); 
		
		$eventManager->getSharedManager()
		             ->attach('Zend\Mvc\Controller\AbstractActionController','dispatch',
		             		function($e) { 
			$controller      = $e->getTarget();
			$controllerClass = get_class($controller);
			
			//$routeMatch = $e->getRouteMatch();
			//$controllerName = $routeMatch->getParam('controller');
			//$actionName = $routeMatch->getParam('action');
			//var_dump($controllerName);
			//var_dump($actionName);
			//exit;
			$moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
			$config          = $e->getApplication()->getServiceManager()->get('config');
			
			if (isset($config['module_layouts'][$moduleNamespace])) {
		        $controller->layout($config['module_layouts'][$moduleNamespace]);
			}
			
		}, 101);  	
	}
	
	public function getConfig() {
		return include __DIR__ . '/config/module.config.php';
	}
	
	public function getAutoloaderConfig() {
		return array (
				'Zend\Loader\StandardAutoloader' => array (
						'namespaces' => array (
								__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__ 
						) 
				) 
		);
	}
	
	public function getServiceConfig() {
		return array(
             'factories' => array(  
                 'fiscalYear' =>  function($sm) {
                 	return new FiscalYear(); 
                 }, 
                 'dateMethods' =>  function($sm) { 
                 	return new DateMethods(); 
                 }, 
                 'EmployeeAllowanceAmountMapper' =>  function($sm) {
                 	return new EmployeeAllowanceAmountMapper($sm->get('sqlServerAdapter'),
									  $sm->get('entityCollection'),$sm);
                 },
                 'promotionMapper' =>  function($sm) {
                 	return new PromotionMapper($sm->get('sqlServerAdapter'),
									  $sm->get('entityCollection'),$sm); 
                 },'eventDurationMapper' =>  function($sm) {
                     return new AttendanceEventDurationMapper($sm->get('sqlServerAdapter'),
                         $sm->get('entityCollection'),$sm);
                 },'attendnanceLocGroupMapper' =>  function($sm) {
                     return new AttendanceLocGroupMapper($sm->get('sqlServerAdapter'),
                         $sm->get('entityCollection'),$sm);
                 },'attendnanceGroupHrsMapper' =>  function($sm) {
                     return new AttendanceGroupHrsMapper($sm->get('sqlServerAdapter'),
                         $sm->get('entityCollection'),$sm);
                 },'attendnanceGroupMapper' =>  function($sm) {
                     return new AttendanceGroupMapper($sm->get('sqlServerAdapter'),
                         $sm->get('entityCollection'),$sm);
                 },'openCloseService' =>  function($sm) {
                     return new OpenCloseService($sm->get('userInfoService'), 
                     $sm->get('mailService'),$sm->get('checkListService'),
                     		$sm->get('ReferenceParameter'));   
                 }, 
                 'mailService' =>  function($sm) { 
                 	return new MailService($sm->get('mailMapper'));  
                 },'mailMapper' => function($sm) {
		    		return new MailMapper($sm->get('sqlServerAdapter'),
		    				$sm->get('entityCollection'),$sm);
                 },'alertService' =>  function($sm) {
                     return new AlertService($sm->get('alertMapper'));
                 },'alertMapper' => function($sm) {
                     return new AlertMapper($sm->get('sqlServerAdapter'),
                         $sm->get('entityCollection'),$sm);
                 },
                 'companyMapper' => function($sm) {
		    		return new CompanyMapper($sm->get('sqlServerAdapter'),
		    				$sm->get('entityCollection'),$sm);
		    	}, 
                'companyService' =>  function($sm) { 
                    return new CompanyService($sm->get('companyMapper')); 
                },'checkListService' => function($sm) { 
					return new CheckListService($sm->get('userInfoService'),
							$sm->get('positionService'),$sm,
							$sm->get('checkListMapper')); 
				},'checkListMapper' => function($sm) { 
					return new CheckListMapper( 
							$sm->get('sqlServerAdapter'), 
		    				$sm->get('entityCollection'),$sm); 
				},'lookupMapper' => function($sm) {  
					return new LookupMapper( 
							$sm->get('sqlServerAdapter'), 
		    				$sm->get('entityCollection'),$sm);  
				},'lookupService' => function($sm) {  
					return new LookupService($sm->get('lookupMapper'));  
				},'nonWorkingDays' => function ($sm) { 
				    return new NonWorkingDaysService($sm->get('lookupService'));    
				},'NonWorkingDaysMapper' => function ($sm) { 
				    return new NonWorkingDaysMapper($sm->get('sqlServerAdapter'),
		    				$sm->get('entityCollection'),$sm);    
				},'NonPaymentDaysService' => function ($sm) { 
				    return new NonPaymentDaysService($sm->get('lookupService'));      
				},'attendanceMapper' => function($sm) {  
					return new AttendanceMapper( 
							$sm->get('sqlServerAdapter'), 
		    				$sm->get('entityCollection'),$sm);  
				}, 'bankMapper' => function($sm) {  
					return new BankMapper( 
							$sm->get('sqlServerAdapter'), 
		    				$sm->get('entityCollection'),$sm);   
				},'PolicyMapper' => function($sm) {
				    return new PolicyMapper(
				        $sm->get('sqlServerAdapter'),
				        $sm->get('entityCollection'),$sm);
				},'employeeIdCardMapper' => function($sm) {  
					return new EmployeeIdCardMapper( 
							$sm->get('sqlServerAdapter'), 
		    				$sm->get('entityCollection'),$sm);  
				},
				'departmentMapper' => function($sm) {  
					return new DepartmentMapper( 
							$sm->get('sqlServerAdapter'), 
		    				$sm->get('entityCollection'),$sm);   
				},'babyCareMapper' => function($sm) {  
					return new BabyCareMapper( 
							$sm->get('sqlServerAdapter'), 
		    				$sm->get('entityCollection'),$sm);   
				},'attendanceEventMapper' => function($sm) {  
					return new AttendanceEventMapper( 
							$sm->get('sqlServerAdapter'), 
		    				$sm->get('entityCollection'),$sm);   
				},'ramadanMapper' => function($sm) {  
					return new RamadanMapper( 
							$sm->get('sqlServerAdapter'), 
		    				$sm->get('entityCollection'),$sm);   
				},'sgMapper' => function($sm) {
		    		return new SgMapper($sm->get('sqlServerAdapter'),
		    				$sm->get('entityCollection'),$sm);
		    	},'sectionMapper' => function($sm) {
		    		return new SectionMapper($sm->get('sqlServerAdapter'),
		    				$sm->get('entityCollection'),$sm);
		    	},'nationalityMapper' => function($sm) {
		    		return new NationalityMapper($sm->get('sqlServerAdapter'),
		    				$sm->get('entityCollection'),$sm);
		    	},'religionMapper' => function($sm) {
		    		return new ReligionMapper($sm->get('sqlServerAdapter'),
		    				$sm->get('entityCollection'),$sm);
		    	},'currencyMapper' => function($sm) {
		    		return new CurrencyMapper($sm->get('sqlServerAdapter'),
		    				$sm->get('entityCollection'),$sm);
		    	},'jobGradeMapper' => function($sm) {
		    		return new JgMapper($sm->get('sqlServerAdapter'),
		    				$sm->get('entityCollection'),$sm);
		    	},'familymembertypeMapper' => function($sm) {
		    		return new FamilymembertypeMapper($sm->get('sqlServerAdapter'),
		    				$sm->get('entityCollection'),$sm);
		    	},'glassAmountMapper' => function($sm) {
		    		return new GlassAmountDurationMapper($sm->get('sqlServerAdapter'),
		    				$sm->get('entityCollection'),$sm);
		    	},'everydayProcessService' => function($sm) {
		    		return new EverydayProcessService(
		    				$sm->get('leaveMapper'),$sm->get('approvalService'),
		    				$sm->get('userInfoService'),$sm->get('transactionDatabase'),
		    				$sm->get('mailService'),$sm->get('positionService'),
		    				$sm->get('nonWorkingDays'),$sm->get('dateMethods'),
		    				$sm->get('travelingFormMapper') ,$sm
		    				); 
		    	}, 
              ),   
            'aliases' => array( 
				'sqlServerAdapter' => 'Zend\Db\Adapter\Adapter'  
			)  
		);  
	} 
} 
