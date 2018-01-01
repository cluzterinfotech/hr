<?php 
return array (
		'controllers' => array (
			'invokables' => array (
				'Payment\Controller\Payment'  => 'Payment\Controller\PaymentController',
				'Payment\Controller\Paysheet' => 'Payment\Controller\PaysheetController',
				'Payment\Controller\Advancehousing' => 'Payment\Controller\AdvancehousingController',
				// 'Payment\Controller\Employeeallowance' => 'Payment\Controller\EmployeeallowanceController',
				'Payment\Controller\Overtimenew' => 'Payment\Controller\OvertimenewController',
			    'Payment\Controller\Overtimemanual' => 'Payment\Controller\OvertimemanualController',
				'Payment\Controller\Otmeal' => 'Payment\Controller\OtmealController', 
				'Payment\Controller\Carrentposition' => 'Payment\Controller\CarrentpositionController',
				'Payment\Controller\Carrentgroup' => 'Payment\Controller\CarrentgroupController',
				'Payment\Controller\Carrent' => 'Payment\Controller\CarrentController', 
				'Payment\Controller\Leaveallowance' 
					=> 'Payment\Controller\LeaveallowanceController',
				'Payment\Controller\Finalentitlement'
							=> 'Payment\Controller\FinalentitlementController',
				'Payment\Controller\Difference'
							=> 'Payment\Controller\DifferenceController',
				'Payment\Controller\Advancesalary'
							=> 'Payment\Controller\AdvancesalaryController',
				'Payment\Controller\Personalloan'
							=> 'Payment\Controller\PersonalloanController',
			    'Payment\Controller\Specialloan'
			                => 'Payment\Controller\SpecialloanController',
				'Payment\Controller\Bonuscriteria'
							=> 'Payment\Controller\BonuscriteriaController',
				'Payment\Controller\Bonus'
							=> 'Payment\Controller\BonusController',
				'Payment\Controller\Glassallowance'
							=> 'Payment\Controller\GlassallowanceController',
				'Payment\Controller\Familymember'
							=> 'Payment\Controller\FamilymemberController',
				'Payment\Controller\Pfrefund'
							=> 'Payment\Controller\PfrefundController',
				'Payment\Controller\Pfrefundtenure'
							=> 'Payment\Controller\PfrefundtenureController',
				'Payment\Controller\Deductionoverpayment'
							=> 'Payment\Controller\DeductionoverpaymentController',
				'Payment\Controller\Amortization'
							=> 'Payment\Controller\AmortizationController',
			    'Payment\Controller\Attenjustification'
			                => 'Payment\Controller\AttenjustificationController',
			    'Payment\Controller\Repaymentadvance'
			                => 'Payment\Controller\RepaymentadvanceController',
			)  
		),   
		
		'router' => array (
			'routes' => array (
				'payment' => array (
					'type' => 'segment',
					'options' => array (
						'route' => '/payment[/][:action]',
						'constraints' => array (
							'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+',
							'code' => '[0-9]+' 
						),
						'defaults' => array (
							'controller' => 'Payment\Controller\Payment',
							'action' => 'index' 
						) 
					) 
				),
				'paysheet' => array (
					'type' => 'segment',
					'options' => array (
						'route' => '/paysheet[/][:action]',
						'constraints' => array (
							'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+',
							'code' => '[0-9]+'
						),
						'defaults' => array (
							'controller' => 'Payment\Controller\Paysheet',
							'action' => 'index'
						)
					)
				),'deductionoverpayment' => array (
					'type' => 'segment',
					'options' => array (
						'route' => '/deductionoverpayment[/][:action][/:id]',
						'constraints' => array (
							'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+',
							'code' => '[0-9]+'
						),
						'defaults' => array (
							'controller' => 'Payment\Controller\Deductionoverpayment',
							'action' => 'index'
						)
					)
				),'repaymentadvance' => array (
				    'type' => 'segment',
				    'options' => array (
				        'route' => '/repaymentadvance[/][:action][/:id]',
				        'constraints' => array (
				            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
				            'id' => '[0-9]+',
				            'code' => '[0-9]+'
				        ),
				        'defaults' => array (
				            'controller' => 'Payment\Controller\Repaymentadvance',
				            'action' => 'index'
				        )
				    )
				),'amortization' => array (
					'type' => 'segment',
					'options' => array (
						'route' => '/amortization[/][:action][/:id]',
						'constraints' => array (
							'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+',
							'code' => '[0-9]+'
						),
						'defaults' => array (
							'controller' => 'Payment\Controller\Amortization', 
							'action' => 'index'
						)
					)
				),'bonuscriteria' => array (
					'type' => 'segment',
					'options' => array (
						'route' => '/bonuscriteria[/][:action][/:id]',
						'constraints' => array (
							'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+',
							'code' => '[0-9]+'
						),
						'defaults' => array (
							'controller' => 'Payment\Controller\Bonuscriteria',
							'action' => 'index'
						)
					)
				),'attenjustification' => array (
				    'type' => 'segment',
				    'options' => array (
				        'route' => '/attenjustification[/][:action][/:id]',
				        'constraints' => array (
				            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
				            'id' => '[0-9]+',
				            'code' => '[0-9]+'
				        ),
				        'defaults' => array (
				            'controller' => 'Payment\Controller\Attenjustification',
				            'action' => 'index'
				        )
				    )
				),'familymember' => array (
					'type' => 'segment',
					'options' => array (
						'route' => '/familymember[/][:action][/:id]',
						'constraints' => array (
							'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+',
							'code' => '[0-9]+'
						),
						'defaults' => array (
							'controller' => 'Payment\Controller\Familymember',
							'action' => 'index'
						)
					)
				),'glassallowance' => array (
					'type' => 'segment',
					'options' => array (
						'route' => '/glassallowance[/][:action][/:id]',
						'constraints' => array (
							'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+',
							'code' => '[0-9]+'
						),
						'defaults' => array (
							'controller' => 'Payment\Controller\Glassallowance',
							'action' => 'index'
						)
					)
				),'bonus' => array (
					'type' => 'segment',
					'options' => array (
						'route' => '/bonus[/][:action]',
						'constraints' => array (
							'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+',
							'code' => '[0-9]+'
						),
						'defaults' => array (
							'controller' => 'Payment\Controller\Bonus',
							'action' => 'index'
						)
					)
				),'leaveallowance' => array (
					'type' => 'segment',
					'options' => array (
						'route' => '/leaveallowance[/][:action][/:id]',
						'constraints' => array (
							'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+',
							'code' => '[0-9]+'
						),
						'defaults' => array (
							'controller' => 'Payment\Controller\Leaveallowance',
							'action' => 'index'
						)
					) 
				),'advancesalary' => array (
					'type' => 'segment',
					'options' => array (
						'route' => '/advancesalary[/][:action][/:id]',
						'constraints' => array (
							'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+',
							'code' => '[0-9]+'
						),
						'defaults' => array (
							'controller' => 'Payment\Controller\Advancesalary', 
							'action' => 'index'
						)
					) 
				),'personalloan' => array (
					'type' => 'segment',
					'options' => array (
						'route' => '/personalloan[/][:action][/:id]',
						'constraints' => array (
							'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+',
							'code' => '[0-9]+'
						),
						'defaults' => array (
							'controller' => 'Payment\Controller\Personalloan', 
							'action' => 'index'
						)
					) 
				),'specialloan' => array (
				    'type' => 'segment',
				    'options' => array (
				        'route' => '/specialloan[/][:action][/:id]',
				        'constraints' => array (
				            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
				            'id' => '[0-9]+',
				            'code' => '[0-9]+'
				        ),
				        'defaults' => array (
				            'controller' => 'Payment\Controller\Specialloan', 
				            'action' => 'index'
				        )
				    )
				),'difference' => array (
					'type' => 'segment',
					'options' => array (
						'route' => '/difference[/][:action][/:id]',
						'constraints' => array (
							'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+',
							'code' => '[0-9]+'
						),
						'defaults' => array (
							'controller' => 'Payment\Controller\Difference', 
							'action' => 'index'
						)
					) 
				),'finalentitlement' => array (
					'type' => 'segment',
					'options' => array (
						'route' => '/finalentitlement[/][:action][/:id]',
						'constraints' => array (
								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'id' => '[0-9]+',
								'code' => '[0-9]+'
						), 
						'defaults' => array (
								'controller' => 'Payment\Controller\Finalentitlement',
								'action' => 'index' 
						)
					) 
				),'pfrefund' => array (
					'type' => 'segment',
					'options' => array (
						'route' => '/pfrefund[/][:action][/:id]',
						'constraints' => array (
								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'id' => '[0-9]+',
								'code' => '[0-9]+'
						), 
						'defaults' => array (
								'controller' => 'Payment\Controller\Pfrefund', 
								'action' => 'index' 
						)
					) 
				),'pfrefundtenure' => array (
					'type' => 'segment',
					'options' => array (
						'route' => '/pfrefundtenure[/][:action][/:id]',
						'constraints' => array (
								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'id' => '[0-9]+',
								'code' => '[0-9]+'
						), 
						'defaults' => array (
								'controller' => 'Payment\Controller\Pfrefundtenure', 
								'action' => 'index' 
						)
					) 
				),'carrent' => array ( 
					'type' => 'segment', 
					'options' => array (
						'route' => '/carrent[/][:action]',
						'constraints' => array (
								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'id' => '[0-9]+',
								'code' => '[0-9]+'
						),
						'defaults' => array (
								'controller' => 'Payment\Controller\Carrent',
								'action' => 'index'
						)
					)
				),
				'advancehousing' => array (
					'type' => 'segment',
					'options' => array (
						'route' => '/advancehousing[/][:action][/:id]', 
						'constraints' => array (
						    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id'     => '[0-9]+',
							'code'   => '[0-9]+'
						),
						'defaults' => array (
							'controller' => 'Payment\Controller\Advancehousing',
							'action'     => 'edit'
						)
					)
				), 
				'overtimenew' => array (
					'type' => 'segment',
					'options' => array (
				        'route' => '/overtimenew[/][:action][/:id]',
						'constraints' => array (
					    	'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
						    'id' => '[0-9]+' 
						),
						'defaults' => array (
							'controller' => 'Payment\Controller\Overtimenew',
							'action' => 'index' 
						) 
					) 
				),'overtimemanual' => array (
				    'type' => 'segment',
				    'options' => array (
				        'route' => '/overtimemanual[/][:action][/:id]',
				        'constraints' => array (
				            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
				            'id' => '[0-9]+'
				        ),
				        'defaults' => array (
				            'controller' => 'Payment\Controller\Overtimemanual',
				            'action' => 'index'
				        )
				    )
				),
			    'otmeal' => array (
					'type' => 'segment',
					'options' => array (
						'route' => '/otmeal[/][:action][/:id]',
						'constraints' => array (
						    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'id' => '[0-9]+' 
						),
						'defaults' => array (
							'controller' => 'Payment\Controller\Otmeal',
							'action' => 'index' 
						) 
					) 
				),'carrentposition' => array (
				'type' => 'segment',
				'options' => array (
				'route' => '/carrentposition[/][:action][/:id]', 
				'constraints' => array (
			    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
					'id'     => '[0-9]+',
					'code'   => '[0-9]+'
				),
				'defaults' => array (
					'controller' => 'Payment\Controller\Carrentposition',
					'action'     => 'edit'
					)
				)
			),'carrentgroup' => array (
				'type' => 'segment',
				'options' => array (
				    'route' => '/carrentgroup[/][:action][/:id]', 
				    'constraints' => array (
				        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
			            'id'     => '[0-9]+',
			   	        'code'   => '[0-9]+'
				    ),
				    'defaults' => array (
			    	    'controller' => 'Payment\Controller\Carrentgroup', 
					    'action'     => 'edit'
				    )
			    )
			),  
		) 
	),
		
	'view_manager' => array (
		'template_path_stack' => array (
			'payment' => __DIR__ . '/../view' 
		),
		'strategies' => array (
			'ViewJsonStrategy' 
		) 
	) 
);