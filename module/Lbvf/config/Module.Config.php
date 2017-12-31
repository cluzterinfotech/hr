<?php  
return array (
		'controllers' => array (
			'invokables' => array (
				'Lbvf\Controller\Instruction' 
				        => 'Lbvf\Controller\InstructionController', 
				'Lbvf\Controller\Peoplemanagement'
						=> 'Lbvf\Controller\PeoplemanagementController',
				'Lbvf\Controller\Nomination'
						=> 'Lbvf\Controller\NominationController',
				'Lbvf\Controller\Endorsement'
						=> 'Lbvf\Controller\EndorsementController',
				'Lbvf\Controller\Assessment'
						=> 'Lbvf\Controller\AssessmentController',
			)  
		), 
		'router' => array( 
			'routes' => array( 
			    'instruction' => array( 
					'type' => 'segment', 
					'options' => array(
						'route' => '/instruction[/][:action][/:id]',
						'constraints' => array(
						    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+',
							'code' => '[0-9]+' 
						),
						'defaults' => array(
							'controller' => 'Lbvf\Controller\Instruction',
							'action' => 'index' 
						) 
					) 
				),'peoplemanagement' => array( 
					'type' => 'segment', 
					'options' => array(
						'route' => '/peoplemanagement[/][:action][/:id]',
						'constraints' => array(
						    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+',
							'code' => '[0-9]+' 
						),
						'defaults' => array(
							'controller' => 'Lbvf\Controller\Peoplemanagement',
							'action' => 'list' 
						) 
					) 
				),'nomination' => array( 
					'type' => 'segment', 
					'options' => array(
						'route' => '/nomination[/][:action][/:id]',
						'constraints' => array(
						    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+',
							'code' => '[0-9]+' 
						),
						'defaults' => array(
							'controller' => 'Lbvf\Controller\Nomination', 
							'action' => 'list' 
						) 
					) 
				),'endorsement' => array( 
					'type' => 'segment', 
					'options' => array(
						'route' => '/endorsement[/][:action][/:id]',
						'constraints' => array(
						    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+',
							'code' => '[0-9]+' 
						),
						'defaults' => array(
							'controller' => 'Lbvf\Controller\Endorsement',   
							'action' => 'list' 
						) 
					) 
				),'assessment' => array( 
					'type' => 'segment',  
					'options' => array(
						'route' => '/assessment[/][:action][/:empId][/:assesId]',
						'constraints' => array(
						    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+',
							'code' => '[0-9]+' 
						),
						'defaults' => array(
							'controller' => 'Lbvf\Controller\Assessment',   
							'action' => 'list' 
						) 
					) 
				),
				
			)  
		),   
		
		'view_manager' => array(
			'template_path_stack' => array(
				'lbvf' => __DIR__ . '/../view' 
			),
			'strategies' => array(
				'ViewJsonStrategy' 
			) 
		) 
); 