<?php

namespace Employee\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;
use Employee\Model\JobGrade;

/**
 *
 * @author Wol
 */
class JobGradeForm extends Form implements InputFilterProviderInterface {
	public function __construct() {
		parent::__construct ( 'jobGradeForm' );
		
		$this->setHydrator ( new ClassMethods () )->setObject ( new JobGrade () );
		
		$this->add ( array (
				'name' => 'lkp_job_grade_id',
				'type' => 'hidden' 
		) );
		
		$this->add ( array (
				'name' => 'job_grade_id',
				'type' => 'text',
				'options' => array (
						'label' => 'Job Grade: ' 
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
				'job_grade_id' => array (
						'required' => true 
				) 
		);
	}
}