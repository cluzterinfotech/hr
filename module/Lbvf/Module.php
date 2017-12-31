<?php
namespace Lbvf;
 
use Lbvf\Model\PeopleManagementMapper; 
use Lbvf\Model\NominationMapper;
use Lbvf\Model\InstructionMapper;
use Lbvf\Model\AssessmentService;
use Lbvf\Model\AssessmentMapper; 

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
			'factories' => array(
				'peopleManagementMapper' => function ($sm) {
					return new PeopleManagementMapper($sm->get('sqlServerAdapter'),
							$sm->get('entityCollection'),$sm);
				},'nominationMapper' => function ($sm) {
					return new NominationMapper($sm->get('sqlServerAdapter'),
							$sm->get('entityCollection'),$sm); 
				},'instructionMapper' => function ($sm) {
					return new InstructionMapper($sm->get('sqlServerAdapter'),
							$sm->get('entityCollection'),$sm);  
				},'assessmentMapper' => function($sm) {
		    		return new AssessmentMapper($sm->get('sqlServerAdapter'),
		    				$sm->get('entityCollection'),$sm);
		    	},'assessmentService' => function($sm) { 
                	return new AssessmentService($sm->get('assessmentMapper'));      
                }, 
 
			) 
		); 
	} 
}