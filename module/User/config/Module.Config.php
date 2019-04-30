<?php 
return array (
		'controllers' => array (
			'invokables' => array (
				'User\Controller\User' => 'User\Controller\UserController' 
			),
			'factories' => array (
				'User\Controller\User' => function ($sm) {
					$commservice = new \User\Service\CommonServiceFactory ();
					$commservice->setController ( '\User\Controller\UserController' );
					return $commservice->createService ( $sm );
				} 
			) 
		),
		'controller_plugins' => array (
			'invokables' => array (
				'userAuthentication' => 'User\Controller\Plugin\UserAuthentication' 
			) 
		),
    /* 'router' => array(
      'routes' => array(
      'user' => array(
      'type' => 'Zend\Mvc\Router\Http\Literal',
      'options' => array(
      'route'    => '/login',
      'defaults' => array(
      'controller' => 'user',
      'action'     => 'login',
      )
      )
      )
      )
      ), */

    'router' => array (
		'routes' => array (
			/*'user' => array (
				'type' => 'segment',
				'options' => array (
					'route'       => '/user[/][:action]',
					'constraints' => array (
						'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
						'id'      => '[0-9]+'
					),
					'defaults' => array (
						'controller' => 'User\Controller\User',
						'action' => 'login'
					)
				)
			)*/ 
			'user' => array (
				'type' => 'Zend\Mvc\Router\Http\Literal',
	    		'options' => array (
					'route' => '/',
					'defaults' => array (
						'controller' => 'User\Controller\User',
						'action' => 'login' 
					) 
				) 
			), 'logout' => array (
				'type' => 'Zend\Mvc\Router\Http\Literal',
	    		'options' => array (
					'route' => '/logout',
					'defaults' => array (
						'controller' => 'User\Controller\User',
						'action' => 'logout' 
					) 
				) 
			), 
			/*'user' => array (
				'type' => 'Literal',
					'options' => array (
						'route' => '/',
							'defaults' => array (
								'__NAMESPACE__' => 'User\Controller',
								'controller' => 'user',
								'action' => 'login' 
							) 
						),
						'may_terminate' => true,
		    			'child_routes' => array (
							'default' => array (
								'type' => 'Segment',
								'options' => array (
									'route' => '/[:action]',
									'constraints' => array (
										'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
										'action' => '[a-zA-Z][a-zA-Z0-9_-]*' 
									),
									'defaults' => array () 
								) 
							) 
						) 
					) */
				) 
		),
		'view_manager' => array (
				'template_path_stack' => array (
						'user' => __DIR__ . '/../view' 
				) 
		),
		'service_factory' => array (
				'invokables' => array (
						'User\Model\TrackTable' => 'User\Model\TrackTable' 
				) 
		),
		'service_manager' => array (
				'aliases' => array (
						'Zend\Authentication\AuthenticationService' => 'my_auth_service' 
				),
				'invokables' => array (
						'my_auth_service' => 'Zend\Authentication\AuthenticationService' 
				) 
		),
		'di' => array (
				'instance' => array (
						'alias' => array (
								'user' => 'User\Controller\UserController' 
						),
						'user' => array (
								'parameters' => array (
										'broker' => 'Zend\Mvc\Controller\PluginManager' 
								) 
						),
						'User\Event\Authentication' => array (
								'parameters' => array (
										'userAuthenticationPlugin' => 'User\Controller\Plugin\UserAuthentication',
										'aclClass' => 'User\Acl\Acl' 
								) 
						),
				/* 'Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter' => array (
						'parameters' => array (
								'userAuthenticationPlugin' => 'User\Controller\Plugin\UserAuthentication',
								'aclClass' => 'User\Acl\Acl'
						)
				), */
	            /*
	            'User\Acl\Acl' => array(
	                'parameters' => array(
	                    'config' => include __DIR__ . '/acl.config.php'
	                ),
	            ),
	             * 
	             */
	            'User\Controller\Plugin\UserAuthentication' => array (
								'parameters' => array (
										'authAdapter' => 'Zend\Authentication\Adapter\DbTable' 
								) 
						) 
				) 
		) 
);