<?php  
return array (
	'router' => array (
		'routes' => array (
			'home' => array (
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => array (
					'route' => '/index',
					'defaults' => array (
						'controller' => 'Application\Controller\Index',
						'action'     => 'dashboard' 
					) 
				) 
			),'employeeallowanceamount' => array (
				'type' => 'segment', 
				'options' => array (
					'route' => '/employeeallowanceamount[/][:action][/:id]',
					'constraints' => array (
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
		                'id' => '[0-9]+'
					),
					'defaults' => array (
						'controller' => 'Application\Controller\Employeeallowanceamount',
						'action' => 'index' 
					)
				)
			),'familymembertype' => array (
				'type' => 'segment', 
				'options' => array (
					'route' => '/familymembertype[/][:action][/:id]',
					'constraints' => array (
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
		                'id' => '[0-9]+'
					),
					'defaults' => array (
						'controller' => 'Application\Controller\Familymembertype',
						'action' => 'index' 
					)
				)
			),'employeephoto' => array (
			    'type' => 'segment',
			    'options' => array (
			        'route' => '/employeephoto[/][:action][/:id]',
			        'constraints' => array (
			            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
			            'id' => '[0-9]+'
			        ),
			        'defaults' => array (
			            'controller' => 'Application\Controller\Employeephoto',
			            'action' => 'index'
			        )
			    )
			),'glassamount' => array (
				'type' => 'segment', 
				'options' => array (
					'route' => '/glassamount[/][:action][/:id]',
					'constraints' => array (
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
		                'id' => '[0-9]+'
					),
					'defaults' => array (
						'controller' => 'Application\Controller\Glassamount',
						'action' => 'index' 
					)
				)
			),'attendance' => array (
				'type' => 'segment',
				'options' => array (
					'route' => '/attendance[/][:action][/:id]',
					'constraints' => array (
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
		                'id' => '[0-9]+'
					),
					'defaults' => array (
						'controller' => 'Application\Controller\Attendance',
						'action' => 'uploadattendance' 
					)
				)
			),'ramadanexception' => array (
				'type' => 'segment',
				'options' => array (
					'route' => '/ramadanexception[/][:action][/:id]',
					'constraints' => array (
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
		                'id' => '[0-9]+'
					),
					'defaults' => array (
						'controller' => 'Application\Controller\Ramadanexception',
						'action' => 'index' 
					)
				)
			),'babycareexception' => array (
				'type' => 'segment',
				'options' => array (
					'route' => '/babycareexception[/][:action][/:id]',
					'constraints' => array (
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
		                'id' => '[0-9]+'
					),
					'defaults' => array (
						'controller' => 'Application\Controller\Babycareexception',
						'action' => 'index' 
					)
				)
			),'attendanceevent' => array (
				'type' => 'segment',
				'options' => array (
					'route' => '/attendanceevent[/][:action][/:id]',
					'constraints' => array (
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
		                'id' => '[0-9]+'
					),
					'defaults' => array (
						'controller' => 'Application\Controller\Attendanceevent',
						'action' => 'index' 
					)
				)
			),'attendanceeventduration' => array (
			    'type' => 'segment',
			    'options' => array (
			        'route' => '/attendanceeventduration[/][:action][/:id]',
			        'constraints' => array (
			            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
			            'id' => '[0-9]+'
			        ),
			        'defaults' => array (
			            'controller' => 'Application\Controller\Attendanceeventduration',
			            'action' => 'index'
			        )
			    )
			),'attendancelocgroup' => array (
			    'type' => 'segment',
			    'options' => array (
			        'route' => '/attendancelocgroup[/][:action][/:id]',
			        'constraints' => array (
			            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
			            'id' => '[0-9]+'
			        ),
			        'defaults' => array (
			            'controller' => 'Application\Controller\Attendancelocgroup',
			            'action' => 'index'
			        )
			    )
			),'attendancegrpwrkhrs' => array (
			    'type' => 'segment',
			    'options' => array (
			        'route' => '/attendancegrpwrkhrs[/][:action][/:id]',
			        'constraints' => array (
			            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
			            'id' => '[0-9]+'
			        ),
			        'defaults' => array (
			            'controller' => 'Application\Controller\Attendancegrpworkhrs',
			            'action' => 'index'
			        )
			    )
			),'attendancegroup' => array (
			    'type' => 'segment',
			    'options' => array (
			        'route' => '/attendancegroup[/][:action][/:id]',
			        'constraints' => array (
			            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
			            'id' => '[0-9]+'
			        ),
			        'defaults' => array (
			            'controller' => 'Application\Controller\Attendancegroup',
			            'action' => 'index'
			        )
			    )
			),'employeeidcard' => array (
				'type' => 'segment',
				'options' => array (
					'route' => '/employeeidcard[/][:action][/:id]',
					'constraints' => array (
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
		                'id' => '[0-9]+'
					),
					'defaults' => array (
						'controller' => 'Application\Controller\Employeeidcard',
						'action' => 'index' 
					)
				)
			),'checklist' => array (
				'type' => 'segment',
				'options' => array (
					'route' => '/checklist[/][:action][/:id]',
					'constraints' => array (
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
		                'id' => '[0-9]+'
					),
					'defaults' => array (
						'controller' => 'Application\Controller\Checklist',
						'action' => 'index' 
					)
				)
			),'bank' => array (
				'type' => 'segment',
				'options' => array (
					'route' => '/bank[/][:action][/:id]',
					'constraints' => array (
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
		                'id' => '[0-9]+'
					),
					'defaults' => array (
						'controller' => 'Application\Controller\Bank',
						'action' => 'index' 
					)
				)
			),'policymanual' => array (
				'type' => 'segment',
				'options' => array (
					'route' => '/policymanual[/][:action][/:id]',
					'constraints' => array (
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
		                'id' => '[0-9]+'
					),
					'defaults' => array (
						'controller' => 'Application\Controller\Policymanual',
						'action' => 'index' 
					)
				)
			),'alert' => array (
			    'type' => 'segment',
			    'options' => array (
			        'route' => '/alert[/][:action][/:id]',
			        'constraints' => array (
			            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
			            'id' => '[0-9]+'
			        ),
			        'defaults' => array (
			            'controller' => 'Application\Controller\alert',
			            'action' => 'index'
			        )
			    )
			),'department' => array (
				'type' => 'segment',
				'options' => array (
					'route' => '/department[/][:action][/:id]',
					'constraints' => array (
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
		                'id' => '[0-9]+'
					),
					'defaults' => array (
						'controller' => 'Application\Controller\Department',
						'action' => 'index' 
					)
				)
			),'company' => array (
				'type' => 'segment',
				'options' => array (
					'route' => '/company[/][:action][/:id]',
					'constraints' => array (
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
		                'id' => '[0-9]+'
					),
					'defaults' => array (
						'controller' => 'Application\Controller\Company',
						'action' => 'index' 
					)
				)
			),'sg' => array (
				'type' => 'segment',
				'options' => array (
					'route' => '/sg[/][:action][/:id]',
					'constraints' => array (
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
		                'id' => '[0-9]+'
					),
					'defaults' => array (
						'controller' => 'Application\Controller\Sg',
						'action' => 'index' 
					)
				)
			),'jg' => array (
				'type' => 'segment',
				'options' => array (
					'route' => '/jg[/][:action][/:id]',
					'constraints' => array (
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
		                'id' => '[0-9]+'
					),
					'defaults' => array (
						'controller' => 'Application\Controller\Jg',
						'action' => 'index' 
					)
				)
			),'section' => array (
				'type' => 'segment',
				'options' => array (
					'route' => '/section[/][:action][/:id]',
					'constraints' => array (
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
		                'id' => '[0-9]+'
					),
					'defaults' => array (
						'controller' => 'Application\Controller\Section',
						'action' => 'index' 
					)
				)
			),'nationality' => array (
				'type' => 'segment',
				'options' => array (
					'route' => '/nationality[/][:action][/:id]',
					'constraints' => array (
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
		                'id' => '[0-9]+'
					),
					'defaults' => array (
						'controller' => 'Application\Controller\Nationality',
						'action' => 'index' 
					)
				)
			),'religion' => array (
				'type' => 'segment',
				'options' => array (
					'route' => '/religion[/][:action][/:id]',
					'constraints' => array (
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
		                'id' => '[0-9]+'
					),
					'defaults' => array (
						'controller' => 'Application\Controller\Religion',
						'action' => 'index' 
					)
				)
			),'currency' => array (
				'type' => 'segment',
				'options' => array (
					'route' => '/currency[/][:action][/:id]',
					'constraints' => array (
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
		                'id' => '[0-9]+'
					),
					'defaults' => array (
						'controller' => 'Application\Controller\Currency',
						'action' => 'index' 
					)
				)
			),'usercompanyposition' => array (
				'type' => 'segment',
				'options' => array (
					'route' => '/usercompanyposition[/][:action][/:id]',
					'constraints' => array (
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
		                'id' => '[0-9]+'
					),
					'defaults' => array (
						'controller' => 'Application\Controller\Usercompanyposition',
						'action' => 'index' 
					)
				)
			),
			'unabletoprepare' => array (
				'type' => 'segment',
				'options' => array (
					'route' => '/unabletoprepare',
					'constraints' => array (
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
		                'id' => '[0-9]+'
					),
					'defaults' => array (
						'controller' => 'Application\Controller\Index',
						'action' => 'unabletoprepare' 
					)
				)
			),'info' => array( 
				'type' => 'segment',
				'options' => array (
					'route' => '/info', 
					'constraints' => array (
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*', 
		                'id' => '[0-9]+' 
					), 
					'defaults' => array ( 
						'controller' => 'Application\Controller\Info',
						'action' => 'nothavepermission' 
					)
				)
			),'openclose' => array( 
				'type' => 'segment',
				'options' => array (
					'route' => '/openclose[/][:action]', 
					'constraints' => array (
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*', 
		                'id' => '[0-9]+' 
					), 
					'defaults' => array ( 
						'controller' => 'Application\Controller\Openclose',
						'action' => 'openclosemonth'  
					) 
				) 
			),'application' => array(  
				'type' => 'Literal', 
				'options' => array( 
					'route' => '/application',
					'defaults' => array( 
						'__NAMESPACE__' => 'Application\Controller',
						'controller' => 'Index',
						'action'     => 'dashboard' 
					) 
				), 
				'may_terminate' => true,
				'child_routes' => array (
				'default' => array (
					'type' => 'Segment',
					'options' => array (
						'route' => '/[:controller[/:action]]',
						'constraints' => array (
							'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
							'action' => '[a-zA-Z][a-zA-Z0-9_-]*' 
						),
							'defaults' => array () 
					) 
				) 
			)), 
         ) 
      ),
	  'service_manager' => array(
	      'abstract_factories' => array(
	          'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
		      'Zend\Log\LoggerAbstractServiceFactory' 
		  ),
		  'aliases' => array(
			  'translator' => 'MvcTranslator' 
		  ) 
	  ),
	  'translator' => array (
	      'locale' => 'en_US',
		  'translation_file_patterns' => array (
		      array(
			      'type' => 'gettext',
				  'base_dir' => __DIR__ . '/../language',
				  'pattern' => '%s.mo' 
			  ) 
		   ) 
		),
		'controllers' => array(
			'invokables' => array(
				'Application\Controller\Index' => 'Application\Controller\IndexController', 
				'Application\Controller\Test' => 'Application\Controller\TestController', 
				'Application\Controller\Employeeallowanceamount' 
					=> 'Application\Controller\EmployeeallowanceamountController',
				'Application\Controller\Info' => 'Application\Controller\InfoController',
				'Application\Controller\Openclose' => 'Application\Controller\OpencloseController',
				'Application\Controller\Attendance' => 'Application\Controller\AttendanceController',
				'Application\Controller\Employeeidcard' 
					=> 'Application\Controller\EmployeeidcardController',
				'Application\Controller\Checklist'
							=> 'Application\Controller\ChecklistController',
				'Application\Controller\Bank'
							=> 'Application\Controller\BankController',
				'Application\Controller\Policymanual'
							=> 'Application\Controller\PolicymanualController',
			    'Application\Controller\alert'
			                => 'Application\Controller\alertController',
				'Application\Controller\Department'
							=> 'Application\Controller\DepartmentController',
				'Application\Controller\Company'
							=> 'Application\Controller\CompanyController',
				'Application\Controller\Sg'
							=> 'Application\Controller\SgController',
				'Application\Controller\Jg'
							=> 'Application\Controller\JgController',
				'Application\Controller\Section'
							=> 'Application\Controller\SectionController',
				'Application\Controller\Nationality'
							=> 'Application\Controller\NationalityController',
				'Application\Controller\Religion'
							=> 'Application\Controller\ReligionController',
				'Application\Controller\Currency'
							=> 'Application\Controller\CurrencyController',
				'Application\Controller\Familymembertype'
							=> 'Application\Controller\FamilymembertypeController',
				'Application\Controller\Glassamount'
							=> 'Application\Controller\GlassamountController',
				'Application\Controller\Usercompanyposition'
							=> 'Application\Controller\UsercompanypositionController',
				'Application\Controller\Babycareexception'
							=> 'Application\Controller\BabycareexceptionController',
				'Application\Controller\Ramadanexception'
							=> 'Application\Controller\RamadanexceptionController',
				'Application\Controller\Attendanceevent'
							=> 'Application\Controller\AttendanceeventController',
			    'Application\Controller\Attendanceeventduration'
			                => 'Application\Controller\AttendanceeventdurationController',
			    'Application\Controller\Attendancelocgroup'
			                => 'Application\Controller\AttendancelocgroupController',
			    'Application\Controller\Attendancegrpworkhrs'
			                => 'Application\Controller\AttendancegrpworkhrsController',
			    'Application\Controller\Attendancegroup'
			                => 'Application\Controller\AttendancegroupController',
			    'Application\Controller\Employeephoto'
			                => 'Application\Controller\EmployeephotoController',
			)  
		),  
		'view_manager' => array(
			'display_not_found_reason' => true,
			'display_exceptions' => true,
			'doctype' => 'HTML5',
			'not_found_template' => 'error/404',
			'exception_template' => 'error/index',
			'template_map' => array (
				'layout/layout' => __DIR__ . '/../view/layout/application.phtml',
				'partial/breadcrumbs' => __DIR__ . '/../view/partial/breadcrumb.phtml',
				'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
				'error/404' => __DIR__ . '/../view/error/404.phtml',
				'error/index' => __DIR__ . '/../view/error/index.phtml' 
			),
			'template_path_stack' => array (
				__DIR__ . '/../view' 
			) 
		), 
		'view_helpers' => array(
			'invokables'=> array(
				'reportHelper' => 'Application\View\Helper\ReportHelper',
				'genReportHelper' => 'Application\View\Helper\EmployeeReportHelper',
				'leaveAllowanceReportHelper' 
					=> 'Application\View\Helper\LeaveAllowanceReportHelper',
				'carRentReportHelper'
							=> 'Application\View\Helper\CarRentReportHelper',
				'payslipHelper'
							=> 'Application\View\Helper\PayslipHelper',
				'empBankReportHelper'
							=> 'Application\View\Helper\EmpBankReportHelper',
			    'generalgrosshelper'
			                => 'Application\View\Helper\GeneralGrossHelper',
			)
		),  
		// Placeholder for console routes 
		'console' => array (
			'router' => array (
				'routes' => array () 
			) 
		),  
); 