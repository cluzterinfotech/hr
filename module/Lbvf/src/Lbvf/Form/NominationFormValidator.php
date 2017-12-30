<?php 
namespace Lbvf\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class NominationFormValidator implements InputFilterAwareInterface 
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
					'validators' => array(), 
			]));
			
			$inputFilter->add($factory->createInput([
					'name' => 'SuperiorName',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(),
			]));
			
			$inputFilter->add($factory->createInput([
					'name' => 'OthSuperiorName',
					'required' => false,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(),
			]));
			
			$inputFilter->add($factory->createInput([
					'name' => 'Subordinate01',
					'required' => false,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(),
			]));
			
			$inputFilter->add($factory->createInput([
					'name' => 'Subordinate02',
					'required' => false,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(),
			]));
			
			$inputFilter->add($factory->createInput([
					'name' => 'Subordinate03',
					'required' => false,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(),
			]));
			
			$inputFilter->add($factory->createInput([
					'name' => 'Subordinate04',
					'required' => false,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(),
			]));
			
			$inputFilter->add($factory->createInput([
					'name' => 'Subordinate05',
					'required' => false,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(),
			]));
			
			$inputFilter->add($factory->createInput([
					'name' => 'Subordinate06',
					'required' => false,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(),
			]));
			
			$inputFilter->add($factory->createInput([
					'name' => 'Subordinate07',
					'required' => false,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(),
			]));
			
			$inputFilter->add($factory->createInput([
					'name' => 'Subordinate08',
					'required' => false,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(),
			]));
			
			$inputFilter->add($factory->createInput([
					'name' => 'Subordinate09',
					'required' => false,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(),
			]));
			
			$inputFilter->add($factory->createInput([
					'name' => 'Subordinate10',
					'required' => false,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(),
			]));
			
			$inputFilter->add($factory->createInput([
					'name' => 'Peers01',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(),
			]));
			
			$inputFilter->add($factory->createInput([
					'name' => 'Peers02',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(),
			]));
			
			$inputFilter->add($factory->createInput([
					'name' => 'Peers03',
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