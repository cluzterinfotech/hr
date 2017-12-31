<?php
return array (
		'controllers' => array (
			'invokables' => array (
				'Position\Controller\Position'     => 'Position\Controller\PositionController',
				'Position\Controller\Delegation'   => 'Position\Controller\DelegationController',
				//'Position\Controller\Department'   => 'Position\Controller\DepartmentController',
				//'Position\Controller\Section'      => 'Position\Controller\SectionController',
				//'Position\Controller\Positiongrid' => 'Position\Controller\PositiongridController',
				//'Position\Controller\Level'        => 'Position\Controller\LevelController',
				'Position\Controller\Positionlevel'  => 'Position\Controller\PositionlevelController',
				'Position\Controller\Employeetype'  => 'Position\Controller\EmployeetypeController',
				'Position\Controller\Positionmovement' 
					=> 'Position\Controller\PositionmovementController',
				'Position\Controller\Positiondescription'    
					 => 'Position\Controller\PositiondescriptionController',
			) 
		),
		'router' => array (
			'routes' => array (
			    'position' => array (
						'type' => 'segment',
						'options' => array (
							'route' => '/position[/][:action][/:id]',
							'constraints' => array (
								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'id' => '[0-9]+' 
							),
							'defaults' => array (
								'controller' => 'Position\Controller\Position',
								'action' => 'index' 
							) 
						) 
					),'positiondescription' => array (
						'type' => 'segment',
						'options' => array (
							'route' => '/positiondescription[/][:action][/:id]',
							'constraints' => array (
								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'id' => '[0-9]+' 
							),
							'defaults' => array (
								'controller' => 'Position\Controller\Positiondescription',
								'action' => 'index' 
							) 
						) 
					),'positionlevel' => array (
						'type' => 'segment',
						'options' => array (
							'route' => '/positionlevel[/][:action][/:id]',
							'constraints' => array (
								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'id' => '[0-9]+' 
							),
							'defaults' => array (
								'controller' => 'Position\Controller\Positionlevel',
								'action' => 'index' 
							) 
						) 
					),'employeetype' => array (
						'type' => 'segment',
						'options' => array (
							'route' => '/employeetype[/][:action][/:id]',
							'constraints' => array (
								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'id' => '[0-9]+' 
							),
							'defaults' => array (
								'controller' => 'Position\Controller\Employeetype',
								'action' => 'index' 
							) 
						) 
					),
					'positiongrid' => array (
							'type' => 'segment',
							'options' => array (
									'route' => '/positiongrid[/][:action][/:id]',
									'constraints' => array (
											'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
											'id' => '[0-9]+' 
									),
									'defaults' => array (
											'controller' => 'Position\Controller\Positiongrid',
											'action' => 'grid' 
									) 
							) 
					),
						
					'delegation' => array (
						'type' => 'segment',
						'options' => array (
							'route' => '/delegation[/][:action][/:id]',
							'constraints' => array (
									'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
									'id' => '[0-9]+' 
							),
							'defaults' => array (
									'controller' => 'Position\Controller\Delegation',
									'action' => 'add' 
							) 
						) 
					),
						
					/*'department' => array (
						'type' => 'segment',
						'options' => array (
							'route' => '/department[/][:action][/:id]',
							'constraints' => array (
									'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
									'id' => '[0-9]+' 
							),
							'defaults' => array (
									'controller' => 'Position\Controller\Department',
									'action' => 'index' 
							) 
						) 
					),
						
					'section' => array (
							'type' => 'segment',
							'options' => array (
									'route' => '/section[/][:action][/:id]',
									'constraints' => array (
											'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
											'id' => '[0-9]+' 
									),
									'defaults' => array (
											'controller' => 'Position\Controller\Section',
											'action' => 'index' 
									) 
							) 
					),*/'level' => array (
						'type' => 'segment',
						'options' => array (
							'route' => '/level[/][:action][/:id]',
							'constraints' => array (
							'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+' 
						),
						'defaults' => array (
							'controller' => 'Position\Controller\Level',
							'action'     => 'index' 
						) 
					) 
				),'positionmovement' => array ( 
						'type' => 'segment',
						'options' => array (
							'route' => '/positionmovement[/][:action][/:id]',
							'constraints' => array (
							'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+' 
						),
						'defaults' => array (
							'controller' => 'Position\Controller\Positionmovement',
							'action'     => 'index' 
						) 
					) 
				)   
			) 
		), 
		'view_manager' => array (
			'template_path_stack' => array (
				'position' => __DIR__ . '/../view' 
			),
			'strategies' => array (
				'ViewJsonStrategy' 
			) 
		) 
); 