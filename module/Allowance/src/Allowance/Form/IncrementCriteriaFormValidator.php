<?php 
namespace Allowance\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class IncrementCriteriaFormValidator implements InputFilterAwareInterface 
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
				'name' => 'Year',
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(),
			]));
			
			$inputFilter->add($factory->createInput([
				'name' => 'joinDate',
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(),
			]));
			
			$inputFilter->add($factory->createInput([
				'name' => 'confirmationDate',
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(),
			]));
				
			$inputFilter->add($factory->createInput([
				'name' => 'incrementFrom',
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(),
			]));
			
			$inputFilter->add($factory->createInput([
				'name' => 'incrementTo',
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(),
			])); 
				
			$inputFilter->add($factory->createInput([
				'name' => 'colaPercentage',
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
		    	),
				'validators' => array(),
			]));
				
			$inputFilter->add($factory->createInput([
				'name' => 'incrementAveragePercentage',
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(),
			])); 
			
			$this->inputFilter = $inputFilter;
			
		}
		return $this->inputFilter;
	}
}