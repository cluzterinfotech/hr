<?php

/**
 * Description of Form
 *
 * @author AlkhatimVip
 */
namespace Position\Form;

use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Form\Form;
use Position\Model\PositionLevel;
use Zend\InputFilter\InputFilterProviderInterface;

class LevelForm extends Form implements InputFilterProviderInterface {
	public function __construct($name = null) {
		parent::__construct ( $name );
		
		$this->setHydrator ( new ClassMethods () )->setObject ( new PositionLevel () );
		
		$this->add ( array (
				'name' => 'id',
				'type' => 'Hidden' 
		) );
		
		$this->add ( array (
				'name' => 'position_level_id',
				'type' => 'Text',
				'attributes' => array (
						'readonly' => true 
				) 
		) );
		
		$this->add ( array (
				'name' => 'level_name',
				'type' => 'Text',
				'attributes' => array (
						'required' => 'required' 
				),
				'filters' => array (
						array (
								'name' => 'StripTags' 
						),
						array (
								'name' => 'StringTrim' 
						) 
				) 
		) );
		
		$this->add ( array (
				'name' => 'level_sequence',
				'type' => 'Text',
				'attributes' => array (
						'required' => 'required' 
				),
				'filters' => array (
						array (
								'name' => 'StripTags' 
						),
						array (
								'name' => 'StringTrim' 
						) 
				) 
		) );
		
		$this->add ( array (
				'name' => 'submit',
				'type' => 'Submit' 
		) );
	}
	public function getInputFilterSpecification() {
		return array (
				'level_name' => array (
						'required' => 'true' 
				),
				'level_sequence' => array (
						'required' => 'true' 
				) 
		);
	}
}