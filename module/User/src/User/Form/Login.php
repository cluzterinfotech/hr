<?php

namespace User\Form;

use Zend\Form\Form;

class Login extends Form {
	public function __construct() {
		parent::__construct ("LoginForm" );
		$this->setAttribute ('method', 'post' );
		$this->setAttribute ('noValidate', 'noValidate' );
		$this->setAttribute ('autocomplete', 'off' );
		
		$this->add ( array (
				'name' => 'username',
				'attributes' => array (
						'type' => 'text',
						'id' => 'username' 
				),
				'options' => array (
						'label' => 'Username*' 
				) 
		) );
		
		$this->add(array(
				'name' => 'password',
				'attributes' => array (
						'type' => 'password',
						'id' => 'password' 
				),
				'options' => array (
						'label' => 'password*' 
				) 
		));
		
		$this->add ( array (
				'name' => 'company',
				'type' => 'Select',
				'options' => array (
						//'label' => 'Employment Type:* ', 
						/*'value_options' => array (
								'' => '',
								'1' => 'Permanent',
								'2' => 'Contractor',
								'3' => 'UnamidContractor'
						),*/
						'disable_inarray_validator' => true
				),
				'attributes' => array (
						'required' => 'required',
						'class' => 'company'
				)
		) );
		
		$this->add ( array (
				'name' => 'login',
				'attributes' => array (
						'type' => 'submit',
						'value' => 'Login',
						'id' => 'login' 
				) 
		) );
	}
}