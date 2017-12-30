<?php
return array ( 
		'modules' => array (	
		        'Allowance',
				'Application',
				'Position',
				'Employee',
				'Payment',
				'User',
				'Leave', 
			    'Pms',
				'Lbvf',
				//'AssetManager',
				/*'Allowance',
				'Employee',
				'ZfTable',
				'ZfcBase' */
				//'ZendDeveloperTools'  
		),  
		'module_listener_options' => array ( 
				'module_paths' => array (
						'./module',
						'./vendor' 
				), 
				'config_glob_paths' => array (
						'config/autoload/{,*.}{global,local}.php' 
				) 
		)
);