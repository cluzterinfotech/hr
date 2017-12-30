<?php 

namespace Leave;

use Leave\Model\LeaveService;
use Leave\Mapper\LeaveFormMapper; 
use Leave\Model\ApprovalService;
use Leave\Mapper\ApprovalLevelMapper;
use Leave\Mapper\LeaveEntitlementMapper;
use Leave\Model\PublicHoliday;
use Leave\Mapper\PublicHolidayMapper;

//use Position\Model\PositionService;

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
				'leaveService' => function ($sm) { 
				    return new LeaveService($sm->get('leaveMapper'),$sm->get('approvalService'),
				    		$sm->get('userInfoService'),$sm->get('transactionDatabase'),
				    		$sm->get('mailService'),$sm->get('positionService'),
				    		$sm->get('nonWorkingDays'),$sm->get('dateMethods'),
                			$sm->get('travelingFormMapper') ,$sm
				    		);    
				},'approvalService' => function ($sm) { 
				    return new ApprovalService($sm->get('positionService'),
				    		$sm->get('approvalLevelMapper')); 
				},'approvalLevelMapper' => function ($sm) { 
				    return new ApprovalLevelMapper($sm->get('sqlServerAdapter'), 
									  $sm->get('entityCollection'),$sm);   
				},'leaveEntitlementMapper' => function ($sm) { 
				    return new LeaveEntitlementMapper($sm->get('sqlServerAdapter'), 
									  $sm->get('entityCollection'),$sm);   
				},'leaveMapper' => function ($sm) { 
				    return new LeaveFormMapper($sm->get('sqlServerAdapter'),
									  $sm->get('entityCollection'),$sm); 
				},'publicHolidayMapper' => function ($sm) { 
				    return new PublicHolidayMapper($sm->get('sqlServerAdapter'),
									  $sm->get('entityCollection'),$sm);  
				},      
			)		 
		);  
	}  
	
}