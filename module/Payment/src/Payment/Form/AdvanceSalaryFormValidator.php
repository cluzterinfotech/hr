<?php
namespace Payment\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class AdvanceSalaryValidator implements InputFilterAwareInterface 
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
					'name' => 'employeeNumberAdvSalary',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							/* array (
									'name' => 'InArray',
									'options' => array(
											'haystack' => array(0)
											'messages' => array(,
													'notInArray' => 'undefined'
											),
									),
							), */ 
					),
			]));

			$inputFilter->add($factory->createInput([
					'name' => 'advancePaidDate',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
					),
			]));

			$inputFilter->add($factory->createInput([
					'name' => 'netPay',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
					),
			]));

			$inputFilter->add($factory->createInput([
					'name' => 'numberOfMonthsNetPay',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
					),
			]));

			$inputFilter->add($factory->createInput([
					'name' => 'advanceAmount',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
					),
			]));

			$inputFilter->add($factory->createInput([
					'name' => 'numberOfMonthsDue',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
					),
			]));
            
			$inputFilter->add($factory->createInput([
					'name' => 'monthlyDue',
					'required' => true,
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