<?php 
return array (
	'controllers' => array (
		'invokables' => array (
			'Pms\Controller\Manage'  => 'Pms\Controller\ManageController',
			'Pms\Controller\Pmsform'  => 'Pms\Controller\PmsformController',
			'Pms\Controller\Myrform'  => 'Pms\Controller\MyrformController',
			'Pms\Controller\Yendform'  => 'Pms\Controller\YendformController',
		) 
	),
	'router' => array (
		'routes' => array (
		    'manage' => array (
				'type' => 'segment',
				'options' => array (
			    	'route' => '/manage[/][:action][/:id]',
					'constraints' => array (
			    		'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'id' => '[0-9]+' 
					),
					'defaults' => array (
						'controller' => 'Pms\Controller\Manage', 
						'action' => 'index' 
					) 
				) 
			),'pmsform' => array (
				'type' => 'segment',
				'options' => array (
			    	'route' => '/pmsform[/][:action][/:id]',
					'constraints' => array (
			    		'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'id' => '[0-9]+' 
					),
					'defaults' => array (
						'controller' => 'Pms\Controller\Pmsform', 
						'action' => 'index' 
					) 
				) 
			),'myrform' => array (
				'type' => 'segment',
				'options' => array (
			    	'route' => '/myrform[/][:action][/:id]',
					'constraints' => array (
			    		'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'id' => '[0-9]+' 
					),
					'defaults' => array (
						'controller' => 'Pms\Controller\Myrform', 
						'action' => 'index' 
					) 
				) 
			),'yendform' => array (
				'type' => 'segment',
				'options' => array (
			    	'route' => '/yendform[/][:action][/:id]',
					'constraints' => array (
			    		'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'id' => '[0-9]+' 
					),
					'defaults' => array (
						'controller' => 'Pms\Controller\Yendform', 
						'action' => 'index' 
					) 
				) 
			),
			 
		) 
	), 
		'view_manager' => array (
			'template_path_stack' => array (
				'pms' => __DIR__ . '/../view' 
			),
			'strategies' => array (
				'ViewJsonStrategy' 
			) 
		) 
); 