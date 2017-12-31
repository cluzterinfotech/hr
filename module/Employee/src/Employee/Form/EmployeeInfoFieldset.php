<?php

namespace Employee\Form;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;
use Employee\Model\EmployeeInfo;

/**
 * Description of EmployeeInfoFieldset
 *
 * @author Wol
 */
class EmployeeInfoFieldset extends Fieldset implements InputFilterProviderInterface {
	public function __construct() {
		parent::__construct ( 'bankInfo' );
		
		$this->setHydrator ( new ClassMethods () )->setObject ( new EmployeeInfo () );
		
		$this->add ( array (
				'name' => 'employee_id',
				'type' => 'text',
				'options' => array (
						'label' => 'Employee Id: ' 
				),
				'attributes' => array (
						'required' => 'required',
						'class' => 'employee_id',
						'disabled' => 'disabled' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'emp_personal_info_id',
				'type' => 'text',
				'options' => array (
						'label' => 'Personal Info Id: ' 
				),
				'attributes' => array (
						'disabled' => 'disabled',
						'class' => 'emp_personal_info_id' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'lkp_salary_grade_id',
				'type' => '\Zend\Form\Element\Select',
				'options' => array (
						'label' => 'Salary Grade: ',
						'value_options' => array (),
						'disable_inarray_validator' => true 
				),
				'attributes' => array (
						'required' => 'required',
						'class' => 'lkp_salary_grade_id' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'lkp_job_grade_id',
				'type' => '\Zend\Form\Element\Select',
				'options' => array (
						'label' => 'Job Grade: ',
						'value_options' => array (),
						'disable_inarray_validator' => true 
				),
				'attributes' => array (
						'required' => 'required',
						'class' => 'lkp_job_grade_id' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'position_id',
				'type' => '\Zend\Form\Element\Select',
				'options' => array (
						'label' => 'Position: ',
						'value_options' => array (
								'1' => 'Senior',
								'2' => 'Junior',
								'3' => 'Intern' 
						),
						'disable_inarray_validator' => true 
				),
				'attributes' => array (
						'required' => 'required',
						'class' => 'position_id' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'join_date',
				'type' => 'date',
				'options' => array (
						'label' => 'Join Date: ' 
				),
				'attributes' => array (
						'required' => 'required',
						'class' => 'join_date' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'confirmation_date',
				'type' => 'date',
				'options' => array (
						'label' => 'Confirmation Date: ' 
				),
				'attributes' => array (
						'required' => 'required',
						'class' => 'confirmation_date' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'is_confirmed',
				'type' => '\Zend\Form\Element\Checkbox',
				'options' => array (
						'label' => 'Is Confirmed',
						'checked_value' => 1,
						'unchecked_value' => 0 
				),
				'attributes' => array (
						'class' => 'is_confirmed' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'location_id',
				'type' => '\Zend\Form\Element\Select',
				'options' => array (
						'label' => 'Location: ',
						'value_options' => array (),
						'disable_inarray_validator' => true 
				),
				'attributes' => array (
						'required' => 'required',
						'class' => 'location_id' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'company_id',
				'type' => 'Hidden',
				'attributes' => array (
						'required' => 'required',
						'class' => 'company_id' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'is_active',
				'type' => '\Zend\Form\Element\Checkbox',
				'options' => array (
						'label' => 'Is Active',
						'checked_value' => 1,
						'unchecked_value' => 0 
				),
				'attributes' => array (
						'class' => 'is_active' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'initial_salary',
				'type' => 'text',
				'options' => array (
						'label' => 'Initial Salary: ' 
				),
				'attributes' => array (
						'required' => 'required',
						'class' => 'initial_salary' 
				) 
		) );
	}
	public function getInputFilterSpecification() {
		return array ()

		;
	}
}
