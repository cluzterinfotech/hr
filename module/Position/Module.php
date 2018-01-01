<?php

namespace Position;

use Zend\Db\ResultSet\HydratingResultSet; 
use Application\Collection\EntityCollection; 
use Employee\Mapper\LocationMapper; 
use Position\Mapper\PositionMapper;
use Position\Model\PositionService;
use Position\Mapper\PositionAllowanceMapper;
use Position\Mapper\PositionDescriptionMapper;
use Position\Mapper\PositionLevelMapper; 
use Position\Mapper\EmployeeTypeMapper;

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
			    'positionMapper' => function ($sm) {
					return new PositionMapper($sm->get('sqlServerAdapter'),
									  $sm->get('entityCollection')); 
				},'positionAllowanceMapper' => function ($sm) {
					return new PositionAllowanceMapper($sm->get('sqlServerAdapter'),
									  $sm->get('entityCollection'));  
				},'entityCollection' => function ($sm) {
					return new EntityCollection ();
				},'positionService' => function ($sm) {
					return new PositionService($sm->get('positionMapper'),
							$sm->get('positionAllowanceMapper'),$sm->get('ReferenceParameter'));  
				},'positionDescriptionMapper' => function ($sm) {
					return new PositionDescriptionMapper($sm->get('sqlServerAdapter'),
									  $sm->get('entityCollection')); 
				},'positionLevelMapper' => function ($sm) {
					return new PositionLevelMapper($sm->get('sqlServerAdapter'),
									  $sm->get('entityCollection')); 
				},'employeeTypeMapper' => function ($sm) {
					return new EmployeeTypeMapper($sm->get('sqlServerAdapter'),
									  $sm->get('entityCollection'));  
				},
			)
         ); 
	}  
}