<?php 

namespace Payment\Form;
 
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class BonusCriteriaFormValidator implements InputFilterAwareInterface 
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
				'name' => 'year',
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
				),
			]));
            
			$inputFilter->add($factory->createInput([
					'name' => 'ratingTwo',
					'required' => true,
					'filters' => array(
							array('name' => 'digits'),
					),
					'validators' => array(
					),
			]));
			
			$inputFilter->add($factory->createInput([
				'name' => 'ratingOne',
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array( ),
			]));
			
			$inputFilter->add($factory->createInput([
					'name' => 'ratingH3',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array( ),
			]));
			
			$inputFilter->add($factory->createInput([
					'name' => 'ratingS3',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array( ),
			]));
			
			$inputFilter->add($factory->createInput([
					'name' => 'ratingM3',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array( ),
			]));
			
			$inputFilter->add($factory->createInput([
					'name' => 'ratingFour',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array( ),
			]));
			
			
			$inputFilter->add($factory->createInput([
					'name' => 'confirmationDate',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array( ),
			]));
			
			
			$inputFilter->add($factory->createInput([
					'name' => 'declarationDate',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array( ),
			]));
			
            
			
			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
}