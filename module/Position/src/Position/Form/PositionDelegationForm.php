<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Form
 *
 * @author AlkhatimVip
 */
namespace Position\Form;

use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Form\Form;
use Position\Model\PositionDelegation;
use Zend\InputFilter\InputFilterProviderInterface;

class PositionDelegationForm extends Form implements InputFilterProviderInterface {
	public function __construct($name = null) {
		parent::__construct ( $name );
		
		$this->setHydrator ( new ClassMethods () )->setObject ( new PositionDelegation () );
		
		$this->add ( array (
				'name' => 'id',
				'type' => 'Hidden' 
		) );
		
		$this->add ( array (
				'name' => 'position_id',
				'type' => 'Select',
				'attributes' => array (
						'required' => 'required' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'delegated_position_id',
				'type' => 'Select',
				'attributes' => array (
						'required' => 'required' 
				),
				'options' => array (
						'disable_inarray_validator' => true 
				) 
		) );
		
		$this->add ( array (
				'name' => 'from_date',
				'type' => 'Text',
				'attributes' => array (
						'required' => 'required' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'to_date',
				'type' => 'Text',
				'attributes' => array (
						'required' => 'required' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'submit',
				'type' => 'Submit' 
		) );
	}
	public function getInputFilterSpecification() {
		return array (
				'position_id' => array (
						'required' => 'true' 
				),
				'delegated_position_id' => array (
						'required' => 'true' 
				),
				'to_date' => array (
						'required' => 'true' 
				),
				'from_date' => array (
						'required' => 'true' 
				) 
		);
	}
}