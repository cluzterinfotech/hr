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
 *
 */
return array (
		'db' => array (
				'driver' => 'pdo',
				
				// 'UID' => 'sa',
				// 'PWD' => '123456',
				'dsn' => 'sqlsrv:database=payrollUpgraded;Server=10.70.1.13' 
		),
		'service_manager' => array (
				'factories' => array (
						'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory' 
				) 
		) 
);