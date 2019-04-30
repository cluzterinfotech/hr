<?php

namespace Employee\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;
use Employee\Model\BankInfo;

/**
 *
 * @author Wol
 */
class BankInfoForm extends Form implements InputFilterProviderInterface {
	public function __construct() {
		parent::__construct ( 'bankInfoForm' );
		
		$this->setHydrator ( new ClassMethods () )->setObject ( new BankInfo () );
		
		$this->add ( array (
				'name' => 'id',
				'type' => 'hidden' 
		) );
		
		$this->add ( array (
				'name' => 'emp_personal_info_id',
				'type' => 'text',
				'options' => array (
						'label' => 'Employee Id: ' 
				),
				'attributes' => array (
						'required' => 'required' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'lkp_bank_id',
				'type' => '\Zend\Form\Element\Select',
				'options' => array (
						'label' => 'Bank: ',
						'value_options' => array (),
						'empty_option' => 'Select a bank',
						'disable_inarray_validator' => true 
				),
				'attributes' => array (
						'required' => 'required',
						'class' => 'lkp_bank_id' 
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
		return array ()

		;
	}
}