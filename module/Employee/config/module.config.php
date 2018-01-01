<?php  
return array (
		'controllers' => array (
			'invokables' => array ( 
				'Employee\Controller\Location' => 'Employee\Controller\LocationController',
				// 'Employee\Controller\Bank' => 'Employee\Controller\BankController',
				'Employee\Controller\SalaryGrade' => 'Employee\Controller\SalaryGradeController',				
				//'Employee\Controller\Company'  => 'Employee\Controller\CompanyController',
				'Employee\Controller\Employeelocation' => 'Employee\Controller\EmployeelocationController',
				'Employee\Controller\Promotion' => 'Employee\Controller\PromotionController',
				'Employee\Controller\Employeefixedallowance' 
				    => 'Employee\Controller\EmployeefixedallowanceController',
				'Employee\Controller\Employeeconfirmation' 
					=> 'Employee\Controller\EmployeeconfirmationController',
				'Employee\Controller\Employeesuspend'
							=> 'Employee\Controller\EmployeesuspendController',
				// 'Employee\Controller\Employee' => 'Employee\Controller\EmployeeController',
				'Employee\Controller\Telephone'
							=> 'Employee\Controller\TelephoneController',
				'Employee\Controller\Salarygradeallowance'
							=> 'Employee\Controller\SalarygradeallowanceController',
				'Employee\Controller\Positionallowance'
							=> 'Employee\Controller\PositionallowanceController',
				'Employee\Controller\Employeeinitial' 
							=> 'Employee\Controller\EmployeeinitialController',
				'Employee\Controller\Newemployee'
							=> 'Employee\Controller\NewemployeeController', 
				'Employee\Controller\Employeeinfo'
							=> 'Employee\Controller\EmployeeinfoController', 
				'Employee\Controller\Increment'
							=> 'Employee\Controller\IncrementController', 
				'Employee\Controller\Employeetermination'
							=> 'Employee\Controller\EmployeeterminationController',
				'Employee\Controller\Affiliationamount'
							=> 'Employee\Controller\AffiliationamountController',
				//'Employee\Controller\Jobgrade' => 'Employee\Controller\JobgradeController',
				'Employee\Controller\Travelinglocal' => 'Employee\Controller\TravelinglocalController', 
				'Employee\Controller\Travelingabroad' => 'Employee\Controller\TravelingabroadController', 
				'Employee\Controller\Employeerating' => 'Employee\Controller\EmployeeratingController', 
				'Employee\Controller\Splhousing' => 'Employee\Controller\SplhousingController',
				'Employee\Controller\Commonstatement' => 'Employee\Controller\CommonstatementController',
				'Employee\Controller\Allowancespecialamount' => 'Employee\Controller\AllowancespecialamountController',
			)   
		), 
		'router' => array ( 
			'routes' => array (
			    'location' => array (
					'type' => 'segment',
					'options' => array (
					    'route'       => '/location[/][:action][/:id]',
						'constraints' => array (
					    	'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id'      => '[0-9]+' 
						),
						'defaults' => array (
							'controller' => 'Employee\Controller\Location',
							'action'     => 'index' 
						) 
					) 
				),			    
			    'allowancespecialamount' => array (
					'type' => 'segment',
					'options' => array (
					    'route'       => '/allowancespecialamount[/][:action][/:id]',
						'constraints' => array (
					    	'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id'      => '[0-9]+' 
						),
						'defaults' => array (
							'controller' => 'Employee\Controller\Allowancespecialamount',
							'action'     => 'index' 
						) 
					) 
				),/*'jobgrade' => array (
					'type' => 'segment',
					'options' => array (
					    'route'       => '/jobgrade[/][:action][/:id]',
						'constraints' => array (
					    	'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id'      => '[0-9]+' 
						),
						'defaults' => array (
							'controller' => 'Employee\Controller\Jobgrade',
							'action'     => 'index' 
						) 
					) 
				),*/'commonstatement' => array (
					'type' => 'segment',
					'options' => array (
					    'route'       => '/commonstatement[/][:action][/:id]',
						'constraints' => array (
					    	'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id'      => '[0-9]+' 
						),
						'defaults' => array (
							'controller' => 'Employee\Controller\Commonstatement',
							'action'     => 'index' 
						) 
					) 
				),'employeelocation' => array (
					'type'    => 'segment',
					'options' => array (
						'route' => '/employeelocation[/][:action][/:id]',
						'constraints' => array (
							'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+'
						),
						'defaults' => array (
							'controller' => 'Employee\Controller\Employeelocation', 
							'action' => 'index'
						)
					)
				),'splhousing' => array (
					'type'    => 'segment',
					'options' => array (
						'route' => '/splhousing[/][:action][/:id]',
						'constraints' => array (
							'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+'
						),
						'defaults' => array (
							'controller' => 'Employee\Controller\Splhousing', 
							'action' => 'index'
						)
					)
				),'travelinglocal' => array (
					'type'    => 'segment',
					'options' => array (
						'route' => '/travelinglocal[/][:action][/:id]',
						'constraints' => array (
							'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+'
						),
						'defaults' => array (
							'controller' => 'Employee\Controller\Travelinglocal',  
							'action' => 'index'
						)
					)
				),'travelingabroad' => array (
					'type'    => 'segment',
					'options' => array (
						'route' => '/travelingabroad[/][:action][/:id]',
						'constraints' => array (
							'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+'
						),
						'defaults' => array (
							'controller' => 'Employee\Controller\Travelingabroad',  
							'action' => 'index'
						)
					)
				),'employeefixedallowance' => array (
					'type'    => 'segment',
					'options' => array (
						'route' => '/employeefixedallowance[/][:action][/:id][/:allowanceName]',
						'constraints' => array (
							'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+'
						),
						'defaults' => array (
							'controller' => 'Employee\Controller\Employeefixedallowance', 
							'action' => 'index'
						) 
					) 
				),'employeerating' => array ( 
					'type'    => 'segment',
					'options' => array (
						'route' => '/employeerating[/][:action][/:id]',
						'constraints' => array (
							'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+'
						),
						'defaults' => array (
							'controller' => 'Employee\Controller\Employeerating', 
							'action' => 'index' 
						) 
					) 
				),  
				/*'bank' => array (
					'type' => 'segment',
					'options' => array (
						'route' => '/bank[/][:action][/:id]',
						'constraints' => array (
							'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+' 
						),
						'defaults' => array (
							'controller' => 'Employee\Controller\Bank',
							'action' => 'index' 
						) 
					) 
				),*/ 
				'salaryGrade' => array (
					'type' => 'segment',
					'options' => array (
				    	'route' => '/salaryGrade[/][:action][/:id]',
						'constraints' => array (
							'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+' 
						),
						'defaults' => array (
							'controller' => 'Employee\Controller\SalaryGrade',
							'action' => 'index' 
						) 
					) 
				),  
				'employeetermination' => array (
					'type' => 'segment',
						'options' => array (
							'route' => '/employeetermination[/][:action][/:id]',
							'constraints' => array (
								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'id' => '[0-9]+' 
							),
							'defaults' => array (
								'controller' => 'Employee\Controller\Employeetermination',
								'action' => 'index' 
						) 
					) 
				),
				/*'company' => array (
					'type' => 'segment',
					'options' => array (
						'route' => '/company[/][:action][/:id]',
						'constraints' => array (
							'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+' 
						),
						'defaults' => array (
							'controller' => 'Employee\Controller\Company',
							'action' => 'index' 
						) 
					) 
				), */     
				'initial' => array (
					'type' => 'segment', 
					'options' => array (
						'route' => '/initial[/][:action][/:id]',
						'constraints' => array (
							'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+'
						),
						'defaults' => array (
							'controller' => 'Employee\Controller\Initial',
							'action' => 'list'
						)
					)
				), 
				'promotion' => array (
					'type' => 'segment',
					'options' => array (
						'route' => '/promotion[/][:action][/:id]',
						'constraints' => array (
							'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+'
						),
						'defaults' => array (
							'controller' => 'Employee\Controller\Promotion',
							'action' => 'list'
						)
				    )
				),'increment' => array (
					'type' => 'segment',  
					'options' => array (
						'route' => '/increment[/][:action][/:id]', 
						'constraints' => array (
							'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+'
						), 
						'defaults' => array (
							'controller' => 'Employee\Controller\Increment',
							'action' => 'calculate'
						)
					)
				),'affiliationamount' => array (
					'type' => 'segment', 
					'options' => array (
						'route' => '/affiliationamount[/][:action][/:id]',
						'constraints' => array (
							'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+'
						),
						'defaults' => array (
							'controller' => 'Employee\Controller\Affiliationamount',
							'action' => 'list'
						)
					)
				),'employeeconfirmation' => array (
					'type' => 'segment',
					'options' => array (
						'route' => '/employeeconfirmation[/][:action][/:id]',
						'constraints' => array (
						    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
						    'id' => '[0-9]+'
					    ),
					'defaults' => array (
						'controller' => 'Employee\Controller\Employeeconfirmation', 
						'action' => 'list'
					    ) 
				    ) 
			    ), 
				'employeesuspend' => array (
					'type' => 'segment',
					'options' => array (
						'route' => '/employeesuspend[/][:action][/:id]',
						'constraints' => array (
							'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+'
						),
						'defaults' => array (
							'controller' => 'Employee\Controller\Employeesuspend',
							'action' => 'list'
						)
					)
				),
				'telephone' => array (
					'type' => 'segment',
					'options' => array (
						'route' => '/telephone[/][:action][/:id]',
						'constraints' => array (
							'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+'
						),
						'defaults' => array (
							'controller' => 'Employee\Controller\Telephone',
							'action' => 'list'
						) 
					) 
				),'salarygradeallowance' => array (
					'type' => 'segment',
					'options' => array (
						'route' => '/salarygradeallowance[/][:action][/:id]',
						'constraints' => array (
							'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+'
						),
						'defaults' => array (
							'controller' => 'Employee\Controller\Salarygradeallowance',
							'action' => 'list' 
						) 
					) 
				),'positionallowance' => array (
					'type' => 'segment',
					'options' => array (
						'route' => '/positionallowance[/][:action][/:id]',
						'constraints' => array (
							'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+'
						),
						'defaults' => array (
							'controller' => 'Employee\Controller\Positionallowance',
							'action' => 'list' 
						) 
					) 
				),'employeeinitial' => array ( 
					'type'    => 'segment',
					'options' => array (
						'route' => '/employeeinitial[/][:action][/:id]',
						'constraints' => array (
							'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+'
						),
						'defaults' => array (
							'controller' => 'Employee\Controller\Employeeinitial', 
							'action' => 'index'
						)
					)
				), 'newemployee' => array ( 
					'type'    => 'segment',
					'options' => array (
						'route' => '/newemployee[/][:action][/:id]',
						'constraints' => array (
							'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+'
						),
						'defaults' => array (
							'controller' => 'Employee\Controller\Newemployee',  
							'action' => 'index' 
						) 
					) 
				),'employeeinfo' => array ( 
					'type'    => 'segment',
					'options' => array (
						'route' => '/employeeinfo[/][:action][/:id]',
						'constraints' => array (
							'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+'
						),
						'defaults' => array (
							'controller' => 'Employee\Controller\Employeeinfo',  
							'action' => 'index'  
						) 
					) 
				),    
			) 
		),  
		'view_manager' => array (
			'template_path_stack' => array (
				'employee' => __DIR__ . '/../view',
				'location' => __DIR__ . '/../view',
				'employeelocation' => __DIR__ . '/../view',
				'bank' => __DIR__ . '/../view' 
			) 
		) 
);