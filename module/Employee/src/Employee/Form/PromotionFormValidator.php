<?php 
namespace Employee\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class PromotionFormValidator implements InputFilterAwareInterface 
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
				'name' => 'employeeNumber',
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
				    array('name' => 'StringTrim'),
				),
				'validators' => array(
					array (
						'name' => 'InArray',
						'options' => array(
							'haystack' => array(0),
								'messages' => array(
								    'notInArray' => 'undefined'
								),
							),
						),
	
					),
			]));
	        
			$inputFilter->add($factory->createInput([
				'name' => 'oldSalaryGrade',
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array (
						'name' => 'int',
					),
				),
			]));
	        
			$inputFilter->add($factory->createInput([
				'name' => 'oldInitial',
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array (
						'name' => 'int'
					),
				),
			]));
	        
			$inputFilter->add($factory->createInput([
				'name' => 'tenPercentage',
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array (
					    'name' => 'int',
					),
				),
			]));
	
			$inputFilter->add($factory->createInput([
				'name' => 'maxQuartileOne',
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array (
						'name' => 'digits',
					),
				),
			]));
	
			$inputFilter->add($factory->createInput([
				'name' => 'difference',
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array (
						'name' => 'digits',
					),
				),
			]));
	
			$inputFilter->add($factory->createInput([
				'name' => 'incrementPercentage',
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array (
						'name' => 'digits',
					),	
				),
			]));
	
			$inputFilter->add($factory->createInput([
				'name' => 'promoSalaryGrade',
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array (
						'name' => 'InArray',
						'options' => array(
							'haystack' => array(0),
							'messages' => array(
								'notInArray' => 'undefined'
							),
						),
					),
                ),
			]));
	
			$inputFilter->add($factory->createInput([
				'name' => 'number',
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array (
						'name' => 'digits',
					),
				),
			]));
	
			$inputFilter->add($factory->createInput([
				'name' => 'togglePromoOption',
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array (
						'name' => 'InArray',
						'options' => array(
							'haystack' => array(0),
							'messages' => array(
								'notInArray' => 'undefined'
							),
						),
					),
				),
			]));
	
	
		}
	}
}