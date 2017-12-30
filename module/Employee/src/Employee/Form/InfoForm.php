<?php

namespace Employee\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;
use Employee\Model\BankInfo;
use Employee\Model\Info;

/**
 *
 * @author Wol
 */
class InfoForm extends Form implements InputFilterProviderInterface {
	public function __construct() {
		parent::__construct ( 'InfoForm' );
		$this->setHydrator ( new ClassMethods () )->setObject ( new Info () );
		
		$this->add ( array (
				'name' => 'bank_info',
				'type' => 'Employee\Form\BankInfoFieldset' 
		) );
		
		$this->add ( array (
				'name' => 'personal_info',
				'type' => 'Employee\Form\PersonalInfoFieldset' 
		) );
		
		$this->add ( array (
				'name' => 'employee_info',
				'type' => 'Employee\Form\EmployeeInfoFieldset' 
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