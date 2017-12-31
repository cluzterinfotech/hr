<?php

namespace Employee\Form;

use Payment\Model\Company;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;


class CompanyForm extends Form implements InputFilterProviderInterface {
	public function __construct() {
		parent::__construct ( 'companyForm' );
		
		$this->setHydrator ( new ClassMethods () )->setObject ( new Company () );
		
		$this->add ( array (
				'name' => 'company_id',
				'type' => 'hidden' 
		) );
		
		$this->add ( array (
				'name' => 'company_name',
				'type' => 'text',
				'options' => array (
						'label' => 'Name: ' 
				),
				'attributes' => array (
						'required' => 'required' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'status',
				'type' => 'text',
				'options' => array (
						'label' => 'Status: ' 
				),
				'attributes' => array (
						'required' => 'required' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'employee_id_prefix',
				'type' => 'text',
				'options' => array (
						'label' => 'Prefix: ' 
				),
				'attributes' => array (
						'required' => 'required' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'value',
				'type' => 'text',
				'options' => array (
						'label' => 'Value: ' 
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
