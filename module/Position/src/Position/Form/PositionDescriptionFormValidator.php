<?php

namespace Position\Form;

use Zend\InputFilter\Factory as InputFactory; 
use Zend\InputFilter\InputFilter; 
use Zend\InputFilter\InputFilterAwareInterface; 
use Zend\InputFilter\InputFilterInterface; 

class PositionDescriptionFormValidator implements InputFilterAwareInterface
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
				'name' => 'positionId',
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(),
			]));
            
			$inputFilter->add($factory->createInput([
				'name' => 'JobPurpose',
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(),
			]));
            
			/*$inputFilter->add($factory->createInput([
				'name' => 'shortDescription',
				'required' => true,
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
			]));*/ 
		}
		$this->inputFilter = $inputFilter;
		return $this->inputFilter;
	}
}