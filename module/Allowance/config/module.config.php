<?php 
// controller 
return array (
		'controllers' => array (
			'invokables' => array (
				'Allowance\Controller\Allowance' 
					=> 'Allowance\Controller\AllowanceController',
				'Allowance\Controller\Socialinsuranceallowance' 
				                 => 'Allowance\Controller\SocialinsuranceallowanceController',
				'Allowance\Controller\Affectedallowance'
							=> 'Allowance\Controller\AffectedallowanceController',
				'Allowance\Controller\Allowancenottohave'
							=> 'Allowance\Controller\AllowancenottohaveController',
				'Allowance\Controller\Paysheetallowance'
							=> 'Allowance\Controller\PaysheetallowanceController',
				'Allowance\Controller\Salarystructure'
							=> 'Allowance\Controller\SalarystructureController', 
				'Allowance\Controller\Quartilerating'
							=> 'Allowance\Controller\QuartileratingController',
				'Allowance\Controller\Incrementcriteria'
							=> 'Allowance\Controller\IncrementcriteriaController',
				'Allowance\Controller\Pfshare'
							=> 'Allowance\Controller\PfshareController', 
			    
			)  
		), 
		'router' => array( 
			'routes' => array( 
			    'allowance' => array( 
					'type' => 'segment', 
					'options' => array(
						'route' => '/allowance[/][:action]',
						'constraints' => array(
						    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+',
							'code' => '[0-9]+' 
						),
						'defaults' => array(
							'controller' => 'Allowance\Controller\Allowance',
							'action' => 'index' 
						) 
					) 
				),
				'siallowance' => array(
					'type' => 'segment',
					'options' => array(
						'route' => '/siallowance[/][:action][/:id]',
						'constraints' => array(
						    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+',
							'code' => '[0-9]+' 
						),
						'defaults' => array(
							'controller' => 'Allowance\Controller\Socialinsuranceallowance',
							'action' => 'index' 
						) 
					) 
				),'allowancenottohave' => array( 
					'type' => 'segment',
					'options' => array(
						'route' => '/allowancenottohave[/][:action][/:id]',
						'constraints' => array(
						    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+',
							'code' => '[0-9]+' 
						),
						'defaults' => array(
							'controller' => 'Allowance\Controller\Allowancenottohave',
							'action' => 'index' 
						) 
					) 
				),'affectedallowance' => array( 
					'type' => 'segment',
					'options' => array(
						'route' => '/affectedallowance[/][:action][/:id]',
						'constraints' => array(
						    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+',
							'code' => '[0-9]+' 
						),
						'defaults' => array(
							'controller' => 'Allowance\Controller\Affectedallowance',
							'action' => 'index' 
						) 
					) 
				),'quartilerating' => array( 
					'type' => 'segment',
					'options' => array(
						'route' => '/quartilerating[/][:action][/:id]',
						'constraints' => array(
						    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+',
							'code' => '[0-9]+' 
						),
						'defaults' => array(
							'controller' => 'Allowance\Controller\Quartilerating',
							'action' => 'index' 
						) 
					) 
				),'pfshare' => array( 
					'type' => 'segment',
					'options' => array(
						'route' => '/pfshare[/][:action][/:id]',
						'constraints' => array(
						    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+',
							'code' => '[0-9]+' 
						),
						'defaults' => array(
							'controller' => 'Allowance\Controller\Pfshare',
							'action' => 'index' 
						) 
					) 
				),'incrementcriteria' => array( 
					'type' => 'segment',
					'options' => array(
						'route' => '/incrementcriteria[/][:action][/:id]',
						'constraints' => array(
						    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+',
							'code' => '[0-9]+' 
						),
						'defaults' => array(
							'controller' => 'Allowance\Controller\Incrementcriteria', 
							'action' => 'index' 
						) 
					) 
				),'salarystructure' => array(  
					'type' => 'segment',
					'options' => array(
						'route' => '/salarystructure[/][:action][/:id]',
						'constraints' => array(
						    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+',
							'code' => '[0-9]+' 
						),
						'defaults' => array(
							'controller' => 'Allowance\Controller\Salarystructure', 
							'action' => 'index' 
						) 
					) 
				),'paysheetallowance' => array(   
					'type' => 'segment', 
					'options' => array(
						'route' => '/paysheetallowance[/][:action][/:id]',
						'constraints' => array(
						    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+',
							'code' => '[0-9]+' 
						),
						'defaults' => array(
							'controller' => 'Allowance\Controller\Paysheetallowance',
							'action' => 'index' 
						)  
					)  
				) 
			)  
		),   
		
		'view_manager' => array(
			'template_path_stack' => array(
				'allowance' => __DIR__ . '/../view' 
			),
			'strategies' => array(
				'ViewJsonStrategy' 
			) 
		) 
); 