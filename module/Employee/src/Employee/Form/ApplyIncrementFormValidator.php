<?php 
namespace Employee\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class ApplyIncrementFormValidator implements InputFilterAwareInterface 
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
			/*$inputFilter->add($factory->createInput([
				'name' => 'applyeEfectiveDate',
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(), 
		    ])); 
            
			/*$inputFilter->add($factory->createInput([
				'name' => 'incColaPercentage',  
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array (
						'name' => 'float', 
					),
				),
			])); */
			$this->inputFilter = $inputFilter; 
		}
		return $this->inputFilter; 
	}
}