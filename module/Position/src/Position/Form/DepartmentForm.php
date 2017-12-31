<?php

/**
 * Description of Form
 *
 * @author AlkhatimVip
 */
namespace Position\Form;

use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Form\Form;
use Position\Model\Department;
use Zend\InputFilter\InputFilterProviderInterface;

class DepartmentForm extends Form implements InputFilterProviderInterface {
	public function __construct($name = null) {
		parent::__construct ( $name );
		
		$this->setHydrator ( new ClassMethods () )->setObject ( new Department () );
		
		$this->add ( array (
				'name' => 'id',
				'type' => 'Hidden' 
		) );
		
		$this->add ( array (
				'name' => 'department_id',
				'type' => 'Text',
				'attributes' => array (
						'readonly' => true 
				) 
		) );
		
		$this->add ( array (
				'name' => 'department_name',
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
				'name' => 'dept_function_code',
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
				'name' => 'no_of_work_days',
				'type' => 'Text' 
		) );
		
		$this->add ( array (
				'name' => 'dept_assistant_position_id',
				'type' => 'Select' 
		) );
		
		$this->add ( array (
				'name' => 'work_hours_per_day',
				'type' => 'Text',
				'validators' => array (
						array (
								'name' => 'Float' 
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
				'department_name' => array (
						'required' => 'true' 
				),
				'dept_function_code' => array (
						'required' => 'true' 
				) 
		);
	}
}