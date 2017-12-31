<?php
return array (
	'acl' => array (
		'roles' => array (
			'guest' => null,
				'order' => 'guest',
				'print' => 'guest',
				'claim' => 'guest', 
				'admin' => array (
					'order',
					'claim',
					'print' 
				) 
			), 
			'resources' => array (
				'allow' => array (
					'User\Controller\User' => array (
						'all' => 'guest' 
					),
					'Coupons\Controller\Order' => array (
						'notallowed' => 'guest',
						'all' => 'order' 
					),
					'Coupons\Controller\Print' => array (
						'search' => 'order',
						'all' => 'print' 
					),
					'Coupons\Controller\Claim' => array (
						// 'all' => 'admin',
						'all' => 'claim' 
					),
					'Master\Controller\Customer' => array (
						'all' => 'admin' 
					),
					'Coupons\Controller\Admcontrol' => array (
						'all' => 'admin',
						'remamount' => 'order' 
					),
					'Coupons\Controller\Rorder' => array (
						'all' => 'admin' 
					) 
				),
				'deny' => array (
					'Coupons\Controller\Admcontrol' => array (
						'all' => 'guest' 
					),
					'Coupons\Controller\Order' => array (
						'all' => 'guest' 
					),
					'Coupons\Controller\Print' => array (
						'all' => 'guest' 
					),
					'Coupons\Controller\Claim' => array (
						'all' => 'guest' 
					),
					'Master\Controller\Customer' => array (
						'all' => 'guest' 
					),
					'Coupons\Controller\Admcontrol' => array (
						'all' => 'guest' 
					),
					'Coupons\Controller\Rorder' => array (
						'all' => 'guest' 
					) 
				) 
			) 
		) 
);