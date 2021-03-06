<?php 
namespace Employee\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class AnnivIncrementFormValidator implements InputFilterAwareInterface 
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
			
			$inputFilter = new InputFilter();
			$factory = new InputFactory(); 
			$inputFilter->add($factory->createInput([
				'name' => 'employeeId',
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(), 
		    ])); 
			
			$inputFilter->add($factory->createInput([
				'name' => 'oldAmount',
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(),
			]));
			
			$inputFilter->add($factory->createInput([
				'name' => 'newAmount',
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