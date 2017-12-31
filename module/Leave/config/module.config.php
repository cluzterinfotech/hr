<?php
return array (
		'controllers' => array (
			'invokables' => array (
				'Leave\Controller\Annualleave' 
					=> 'Leave\Controller\AnnualleaveController',
				'Leave\Controller\Entitlementannualleave'
					=> 'Leave\Controller\EntitlementannualleaveController',
				'Leave\Controller\Leaveadmin'
							=> 'Leave\Controller\LeaveadminController',
				'Leave\Controller\Publicholiday'
							=> 'Leave\Controller\PublicholidayController',
			) 
		),    
		'router' => array(
			'routes' => array(
				'annualleave' => array(
					'type' => 'segment',
					'options' => array(
						'route' => '/annualleave[/][:action][/:id]',
						'constraints' => array(
							'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+' 
						), 
						'defaults' => array(
							'controller' => 'Leave\Controller\Annualleave',
							'action' => 'index' 
						)  
					) 
				),'leaveadmin' => array(
					'type' => 'segment',
					'options' => array(
						'route' => '/leaveadmin[/][:action][/:id]',
						'constraints' => array(
							'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+' 
						), 
						'defaults' => array(
							'controller' => 'Leave\Controller\Leaveadmin',
							'action' => 'index' 
						)  
					) 
				),
				'entitlementannualleave' => array(
					'type' => 'segment', 
					'options' => array(
						'route' => '/entitlementannualleave[/][:action][/:id]',
						'constraints' => array(
							'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+' 
						),
						'defaults' => array(
							'controller' => 'Leave\Controller\Entitlementannualleave',
							'action' => 'index' 
						) 
					) 
				),'publicholiday' => array(
					'type' => 'segment', 
					'options' => array(
						'route' => '/publicholiday[/][:action][/:id]',
						'constraints' => array(
							'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+' 
						),
						'defaults' => array(
							'controller' => 'Leave\Controller\Publicholiday', 
							'action' => 'index' 
						) 
					) 
				), 	
			) 
		), 
		'view_manager' => array(
			'template_path_stack' => array(
				'leave' => __DIR__ . '/../view' 
			) 
		),
		/*'asset_manager' => array(
			'resolver_configs' => array(
				'paths' => array(
					'Leave' => __DIR__ . '/../public',
				),
			),
		),
		'asset_manager' => array(
            'resolver_configs' => array(
                'paths' => array(
                		'leave' => __DIR__ . '/../assets',
                ),
            ),
        )*/
); 