<?php
namespace Allowance;

use Application\Collection\EntityCollection;
use Allowance\Model\AllowanceMapper;
use Allowance\Model\AllowanceService;
use Allowance\Model\SalaryGradeMapper;
use Allowance\Model\SalaryGradeService;
use Allowance\Model\PfShareMapper; 

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
		    	'allowanceMapper' => function($sm) {
		    		return new AllowanceMapper($sm->get('sqlServerAdapter'),
		    				$sm->get('entityCollection'),$sm);
		    	},  
                'allowanceService' =>  function($sm) { 
                    return new AllowanceService($sm->get('allowanceMapper')); 
                }, 
                'salaryGradeMapper' =>  function($sm) {
                	return new SalaryGradeMapper($sm->get('sqlServerAdapter'),
		    				$sm->get('entityCollection'),$sm);
                },
                'salaryGradeService' =>  function($sm) {
                	return new SalaryGradeService($sm->get('ReferenceParameter'),
                			$sm->get('salaryGradeMapper')); 
                },'pfShareMapper' =>  function($sm) {
                	return new PfShareMapper($sm->get('sqlServerAdapter'),
		    				$sm->get('entityCollection'),$sm);
                },     
            )	 
		); 
	}
}