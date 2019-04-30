<?php 
namespace Employee\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class TravelingLocalFormValidator implements InputFilterAwareInterface

{
	protected $inputFilter;

	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new \Exception("Not used");
	}

	public function getInputFilter()
	{
		if (!$this->inputFilter)
		{
			$inputFilter = new InputFilter();
			$factory = new InputFactory();


			$inputFilter->add($factory->createInput([
				'name' => 'employeeNumberTravelingLocal',
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					/*array (
						'name' => 'InArray',
						'options' => array(
							'haystack' => array(0),
							'messages' => array(
								'notInArray' => 'undefined'
							),
						),
					),*/ 
				),
			]));
            
			$inputFilter->add($factory->createInput([
				'name' => 'travelingFormEmpPosition',
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					/*array (
						'name' => 'InArray',
						'options' => array(
							'haystack' => array(0),
								'messages' => array(
									'notInArray' => 'undefined'
								),
							),
					),*/ 
				),
			])); 
             
			$inputFilter->add($factory->createInput([
					'name' => 'travelingTo',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(), 
			])); 

			$inputFilter->add($factory->createInput([
					'name' => 'purposeOfTrip',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
					),
			]));

			$inputFilter->add($factory->createInput([
					'name' => 'effectiveFrom',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
					),
			]));

			$inputFilter->add($factory->createInput([
					'name' => 'effectiveTo',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
					),
			]));

			$inputFilter->add($factory->createInput([
					'name' => 'expensesRequired',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
					),
			]));

			$inputFilter->add($factory->createInput([
				'name' => 'delegatedEmployee',
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					/*array (
						'name' => 'InArray',
						'options' => array(
							'haystack' => array(0),
							'messages' => array(
								'notInArray' => 'undefined'
							), 
						),
					),*/ 
				), 
			])); 
            
			$inputFilter->add($factory->createInput([
				'name' => 'meansOfTransport',
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					/*array (
						'name' => 'InArray',
						'options' => array(
							'haystack' => array(0),
								'messages' => array(
									'notInArray' => 'undefined'
								),
							),
						),*/ 
					),
			]));
			
			$inputFilter->add($factory->createInput([
					'name' => 'text',
					'required' => 0,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
					),
			]));

			$inputFilter->add($factory->createInput([
					'name' => 'fuelLiters',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
					),
			]));
            
			$inputFilter->add($factory->createInput([
					'name' => 'classOfAirTicket',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
					),
			]));
            
			$inputFilter->add($factory->createInput([
					'name' => 'classOfHotel',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
					),
			]));

			/*$inputFilter->add($factory->createInput([
					'name' => 'expenseApproved',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
					),
			]));*/

			$inputFilter->add($factory->createInput([
					'name' => 'amount',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
					),
			]));
            
			$inputFilter->add($factory->createInput([
					'name' => 'travelingComments',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
					),
			])); 
			
			$this->inputFilter = $inputFilter; 
		}
		return $this->inputFilter; 
	}
}