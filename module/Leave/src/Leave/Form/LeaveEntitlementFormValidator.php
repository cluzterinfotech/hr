<?php

namespace Leave\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class LeaveEntitlementFormValidator implements InputFilterAwareInterface 
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
				'name' => 'yearsOfService',
				'required' => true,
				'filters' => array(
					array ('name' => 'StripTags'),
					array ('name' => 'StringTrim') 
				),
				//'validators' => array () 
			]));
			
			$inputFilter->add($factory->createInput([ 
				'name' => 'numberOfDays',
				'required' => true,
				'filters' => array (
					array('name' => 'StripTags'),
				    array('name' => 'StringTrim') 
				),
				//'validators' => array () 
			]));  
            
			$inputFilter->add($factory->createInput([
				'name' => 'companyId',
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
			]));
            
			$inputFilter->add($factory->createInput([
				'name' => 'LkpLeaveType',
				'required' => true,
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