<?php 
namespace Lbvf\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class PeopleManagementFormValidator implements InputFilterAwareInterface 
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
					/*array(
			    		'name' => 'StringLength',
						'options' => array(
					    	'encoding' => 'UTF-8',
							'min' => '3',
							'max' => '25',
						),
					),*/ 
				), 
			])); 
            
			$inputFilter->add($factory->createInput([
					'name' => 'Role01',
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							/*array (
									'name' => 'InArray',
									'options' => array(
											'haystack' => array(0),
											'messages' => array(
													'notInArray' => 'undefined'
											),
									),
							),*/
			
					),
			]));
			
			$inputFilter->add($factory->createInput([
					'name' => 'duration01',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							/*array (
									'name' => 'StringLength',
									'options' => array(
											'encoding' => 'UTF-8',
											'min' => '2',
											'max' => '500',
									),
							),*/
					),
			]));
			
			$inputFilter->add($factory->createInput([
					'name' => 'lOI01',
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							/*array (
									'name' => 'InArray',
									'options' => array(
											'haystack' => array(0),
											'messages' => array(
													'notInArray' => 'undefined'
											),
									),
							),*/ 
			
					),
			]));
			
			$inputFilter->add($factory->createInput([
					'name' => 'content01',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
					),
			]));
			
			
			
			
			
			
			$inputFilter->add($factory->createInput([
					'name' => 'Role02',
					'required' => false,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(),
			]));
				
			$inputFilter->add($factory->createInput([
					'name' => 'duration02',
					'required' => false,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(),
			]));
				
			$inputFilter->add($factory->createInput([
					'name' => 'lOI02',
					'required' => false,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(),
			]));
				
			$inputFilter->add($factory->createInput([
					'name' => 'content02',
					'required' => false,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array( ),
			]));
			
			
			$inputFilter->add($factory->createInput([
					'name' => 'Role03',
					'required' => false,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(),
			]));
			
			$inputFilter->add($factory->createInput([
					'name' => 'duration03',
					'required' => false,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(),
			]));
			
			$inputFilter->add($factory->createInput([
					'name' => 'lOI03',
					'required' => false,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(),
			]));
			
			$inputFilter->add($factory->createInput([
					'name' => 'content03',
					'required' => false,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array( ),
			]));
			
			$inputFilter->add($factory->createInput([
					'name' => 'Role04',
					'required' => false,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(),
			]));
				
			$inputFilter->add($factory->createInput([
					'name' => 'duration04',
					'required' => false,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(),
			]));
				
			$inputFilter->add($factory->createInput([
					'name' => 'lOI04',
					'required' => false,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(),
			]));
				
			$inputFilter->add($factory->createInput([
					'name' => 'content04',
					'required' => false,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array( ),
			]));
			
			$inputFilter->add($factory->createInput([
					'name' => 'Role05',
					'required' => false,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(),
			]));
				
			$inputFilter->add($factory->createInput([
					'name' => 'duration05',
					'required' => false,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(),
			]));
				
			$inputFilter->add($factory->createInput([
					'name' => 'lOI05',
					'required' => false,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(),
			]));
				
			$inputFilter->add($factory->createInput([
					'name' => 'content05',
					'required' => false,
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