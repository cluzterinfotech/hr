<?php

namespace Position\Form;

use Zend\InputFilter\Factory as InputFactory; 
use Zend\InputFilter\InputFilter; 
use Zend\InputFilter\InputFilterAwareInterface; 
use Zend\InputFilter\InputFilterInterface; 

class PositionFormValidator implements InputFilterAwareInterface
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
				'name' => 'positionName',
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(),
			]));
            
			$inputFilter->add($factory->createInput([
				'name' => 'organisationLevel',
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(),
			]));
			
			$inputFilter->add($factory->createInput([
					'name' => 'positionLocation',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(),
			]));
			
			$inputFilter->add($factory->createInput([
			    'name' => 'jobGradeId',
			    'required' => true,
			    'filters' => array(
			        array('name' => 'StripTags'),
			        array('name' => 'StringTrim'),
			    ),
			    'validators' => array(),
			]));
			
			$inputFilter->add($factory->createInput([
				'name' => 'shortDescription',
				'required' => false,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(),
			]));  
            
			$inputFilter->add($factory->createInput([
				'name' => 'section',
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(),
			]));
            
			$inputFilter->add($factory->createInput([
				'name' => 'reportingPosition',
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(), 
			]));
            
			$inputFilter->add($factory->createInput([
				'name' => 'status',
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array( ),
			]));
		}
		$this->inputFilter = $inputFilter;
		return $this->inputFilter;
	}
}