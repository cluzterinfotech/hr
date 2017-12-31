<?php 
namespace Application\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class BabyCareFormValidator implements InputFilterAwareInterface 
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
					
				),
			]));
            
			$inputFilter->add($factory->createInput([
					'name' => 'startingDate',
					'required' => true,
					'filters' => array(
							//array('name' => 'Digits'),
					),
					'validators' => array(
							
					),
			]));
			
			$inputFilter->add($factory->createInput([
					'name' => 'endingDate',
					'required' => false,
					'filters' => array(
							//array('name' => 'Digits'),
					),
					'validators' => array(
								
					),
			]));
			
			$inputFilter->add($factory->createInput([
					'name' => 'noOfMinutes',
					'required' => false,
					'filters' => array(
							//array('name' => 'Digits'),
					),
					'validators' => array(
			
					),
			]));
			
			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
}