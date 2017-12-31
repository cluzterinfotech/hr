<?php

namespace Employee\Form;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;
use Employee\Model\PersonalInfo;

/**
 * Description of PersonalInfoFieldset
 *
 * @author Wol
 */
class PersonalInfoFieldset extends Fieldset implements InputFilterProviderInterface {
	public function __construct() {
		parent::__construct ( 'bankInfo' );
		
		$this->setHydrator ( new ClassMethods () )->setObject ( new PersonalInfo () );
		
		$this->add ( array (
				'name' => 'emp_personal_info_id',
				'type' => 'hidden',
				'attributes' => array (
						'class' => 'emp_personal_info_id' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'employee_name',
				'type' => 'text',
				'options' => array (
						'label' => 'Name: ' 
				),
				'attributes' => array (
						'required' => 'required',
						'class' => 'employee_name' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'date_of_birth',
				'type' => 'date',
				'options' => array (
						'label' => 'Date of Birth: ' 
				),
				'attributes' => array (
						'required' => 'required',
						'class' => 'date_of_birth' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'place_of_birth',
				'type' => 'text',
				'options' => array (
						'label' => 'Place of Birth: ' 
				),
				'attributes' => array (
						'required' => 'required',
						'class' => 'place_of_birth' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'gender',
				'type' => '\Zend\Form\Element\Radio',
				'options' => array (
						'label' => 'Gender: ',
						'value_options' => array (
								'0' => 'Male',
								'1' => 'female' 
						) 
				),
				'attributes' => array (
						'class' => 'gender',
						'value' => '0' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'lkp_marital_status_id',
				'type' => '\Zend\Form\Element\Select',
				'options' => array (
						'label' => 'Marital Status: ',
						'value_options' => array (
								'1' => 'Married',
								'2' => 'Engaged',
								'3' => 'Unmarried' 
						),
						'disable_inarray_validator' => true 
				),
				'attributes' => array (
						'required' => 'required',
						'class' => 'lkp_marital_status_id' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'lkp_religion_id',
				'type' => '\Zend\Form\Element\Select',
				'options' => array (
						'label' => 'Religion: ',
						'value_options' => array (
								'1' => 'Christian',
								'2' => 'Muslim',
								'3' => 'None' 
						),
						'disable_inarray_validator' => true 
				),
				'attributes' => array (
						'required' => 'required',
						'class' => 'lkp_religion_id' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'lkp_nationality_id',
				'type' => '\Zend\Form\Element\Select',
				'options' => array (
						'label' => 'Nationality: ',
						'value_options' => array (
								'1' => 'Sudanese',
								'2' => 'Eritrean',
								'3' => 'Kenyan' 
						),
						'disable_inarray_validator' => true 
				),
				'attributes' => array (
						'required' => 'required',
						'class' => 'lkp_nationality_id' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'lkp_state_id',
				'type' => '\Zend\Form\Element\Select',
				'options' => array (
						'label' => 'State: ',
						'value_options' => array (
								'1' => 'Khartoum',
								'2' => 'North Kordufan',
								'3' => 'Jazeera' 
						),
						'disable_inarray_validator' => true 
				),
				'attributes' => array (
						'required' => 'required',
						'class' => 'lkp_state_id' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'address',
				'type' => 'text',
				'options' => array (
						'label' => 'Address: ' 
				),
				'attributes' => array (
						'required' => 'required',
						'class' => 'address' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'phone',
				'type' => 'text',
				'options' => array (
						'label' => 'Phone: ' 
				),
				'attributes' => array (
						'required' => 'required',
						'class' => 'phone' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'mobile',
				'type' => 'text',
				'options' => array (
						'label' => 'Mobile: ' 
				),
				'attributes' => array (
						'required' => 'required',
						'class' => 'mobile' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'passport_number',
				'type' => 'text',
				'options' => array (
						'label' => 'Passport Number: ' 
				),
				'attributes' => array (
						'required' => 'required',
						'class' => 'passport_number' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'no_of_children',
				'type' => 'text',
				'options' => array (
						'label' => 'Number of Children: ' 
				),
				'attributes' => array (
						'required' => 'required',
						'class' => 'no_of_children' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'driving_licence',
				'type' => 'text',
				'options' => array (
						'label' => 'Driving Licence : ' 
				),
				'attributes' => array (
						'class' => 'driving_licence' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'lkp_national_service',
				'type' => '\Zend\Form\Element\Select',
				'options' => array (
						'label' => 'National Service: ',
						'value_options' => array (
								'1' => 'Completed',
								'2' => 'In Progress',
								'3' => 'Incomplete' 
						),
						'disable_inarray_validator' => true 
				),
				'attributes' => array (
						'required' => 'required',
						'class' => 'lkp_national_service' 
				) 
		) );
	}
	public function getInputFilterSpecification() {
		return array ()

		;
	}
}
