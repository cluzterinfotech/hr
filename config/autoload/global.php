<?php
/*
 * return array(
 * 'db' => array(
 * 'driver' => 'Pdo',
 * 'dsn' => 'mysql:dbname=hr;host=localhost;port:3306',
 * 'driver_options' => array(
 * PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
 * ),
 * ),
 * 'service_manager' => array(
 * 'factories' => array(
 * 'Zend\Db\Adapter\Adapter'
 * => 'Zend\Db\Adapter\AdapterServiceFactory', 
 * ),
 * ),
 * );
 */
// 10.70.1.13\petronas
return array (
		'db' => array (
			'driver' => 'pdo',
			'dsn' => 'sqlsrv:database=payrollUpgraded;Server=localhost' 
		),
		'service_manager' => array (
			'factories' => array (
				'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
				'Navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
			) 
		), 
		'module_layouts' => array(
	        'Application'    => 'layout/application.phtml',
	        'Employee'       => 'layout/employee.phtml',
			'Position'       => 'layout/position.phtml',
			'Leave'          => 'layout/Leave.phtml',
			'Payment'        => 'layout/payment.phtml',
			'Allowance'      => 'layout/allowance.phtml',
		    'Pms'            => 'layout/pms.phtml',
			'Lbvf'           => 'layout/lbvf.phtml',
        ), 
);