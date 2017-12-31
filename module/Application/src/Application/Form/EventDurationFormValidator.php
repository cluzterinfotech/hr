<?php 
namespace Application\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class EventDurationFormValidator implements InputFilterAwareInterface 
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
				'name' => 'eventId',
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