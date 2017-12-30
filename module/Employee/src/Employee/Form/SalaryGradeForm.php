<?php

namespace Employee\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;
use Employee\Model\SalaryGrade;

/**
 *
 * @author Wol
 */
class SalaryGradeForm extends Form implements InputFilterProviderInterface {
	public function __construct() {
		parent::__construct ( 'salaryGradeForm' );
		
		$this->setHydrator ( new ClassMethods () )->setObject ( new SalaryGrade () );
		
		$this->add ( array (
				'name' => 'lkp_salary_grade_id',
				'type' => 'hidden' 
		) );
		
		$this->add ( array (
				'name' => 'salary_grade',
				'type' => 'text',
				'options' => array (
						'label' => 'Salary Grade: ' 
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
				'salary_grade' => array (
						'required' => true 
				) 
		);
	}
}