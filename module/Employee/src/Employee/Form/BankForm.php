<?php

namespace Employee\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;
use Employee\Model\Bank;

class BankForm extends Form implements InputFilterProviderInterface {
	public function __construct() {
		parent::__construct ( 'bankForm' );
		
		$this->setHydrator ( new ClassMethods () )->setObject ( new Bank () );
		
		$this->add ( array (
				'name' => 'lkp_bank_id',
				'type' => 'hidden' 
		) );
		
		$this->add ( array (
				'name' => 'bank_name',
				'type' => 'text',
				'options' => array (
						'label' => 'Name: ' 
				),
				'attributes' => array (
						'required' => 'required' 
				) 
		) );
		$this->add ( array (
				'name' => 'branch',
				'type' => 'text',
				'options' => array (
						'label' => 'Branch: ' 
				),
				'attributes' => array (
						'required' => 'required' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'account_number',
				'type' => 'text',
				'options' => array (
						'label' => 'Account Number: ' 
				),
				'attributes' => array (
						'required' => 'required' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'submit',
				'type' => 'submit',
				'attributes' => array (
						'value' => 'Add' 
				) 
		) );
	}
	public function getInputFilterSpecification() {
		return array (
				'bank_name' => array (
						'required' => true 
				),
				'branch' => array (
						'required' => true 
				),
				'account_number' => array (
						'required' => true 
				) 
		);
	}
}