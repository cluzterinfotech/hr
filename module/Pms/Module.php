<?php 

namespace Pms;

use Zend\Db\ResultSet\HydratingResultSet; 
use Application\Collection\EntityCollection; 
use Pms\Mapper\ManageMapper; 
use Pms\Mapper\PmsFormMapper; 
use Pms\Model\PmsFormService;

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
			    'manageMapper' => function ($sm) { 
				    return new ManageMapper($sm->get('sqlServerAdapter'),
									  $sm->get('entityCollection'),$sm); 
				},'pmsFormMapper' => function ($sm) { 
				    return new PmsFormMapper($sm->get('sqlServerAdapter'),
									  $sm->get('entityCollection'),$sm); 
				},'pmsFormService' => function ($sm) { 
				    return new PmsFormService(
				        $sm->get('leaveMapper'),$sm->get('approvalService'),
				        $sm->get('userInfoService'),$sm->get('transactionDatabase'),
				        $sm->get('mailService'),$sm->get('positionService'),
				        $sm->get('nonWorkingDays'),$sm->get('dateMethods'),
				        $sm->get('travelingFormMapper'),$sm->get('pmsFormMapper'),$sm
				    );     
				},
			)
         ); 
	}  
}