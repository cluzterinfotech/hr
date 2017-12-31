<?php 
namespace Employee\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class EmployeeSuspendFormValidator implements InputFilterAwareInterface

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
					'name' => 'employeeNumberSuspend',
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array (
									'name' => 'InArray',
									'options' => array(
											'haystack' => array(0),
											'messages' => array(
													'notInArray' => 'undefined',
											),
									),
							),

					),
			]));

			$inputFilter->add($factory->createInput([
					'name' => 'suspendFromDate',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
					),
			]));

			$inputFilter->add($factory->createInput([
					'name' => 'suspendToDate',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
					),
			]));

			$inputFilter->add($factory->createInput([
					'name' => 'suspendReason',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
					),
			]));


		}
	}
}