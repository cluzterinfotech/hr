<?php

namespace Leave\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class PublicHolidayFormValidator implements InputFilterAwareInterface 
{
	protected $inputFilter;
	
	public function setInputFilter(InputFilterInterface $inputFilter) {
		throw new \Exception( "Not used" );
	}
	
	public function getInputFilter() {
		if (! $this->inputFilter) {
			$inputFilter = new InputFilter ();
			$factory = new InputFactory ();
			
			$inputFilter->add($factory->createInput([ 
				'name' => 'holidayReason',
				'required' => true,
				'filters' => array(
					array ('name' => 'StripTags'),
					array ('name' => 'StringTrim') 
				),
				//'validators' => array () 
			]));
			
			$inputFilter->add($factory->createInput([ 
				'name' => 'fromDate',
				'required' => true,
				'filters' => array (
					array('name' => 'StripTags'),
				    array('name' => 'StringTrim') 
				),
				//'validators' => array () 
			]));  
            
			$inputFilter->add($factory->createInput([
				'name' => 'toDate',
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
			]));
            
			$inputFilter->add($factory->createInput([
				'name' => 'Notes', 
				'required' => false,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				), 
			]));
		$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
}