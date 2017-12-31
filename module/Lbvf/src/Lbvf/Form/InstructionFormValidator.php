<?php 
namespace Lbvf\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class InstructionFormValidator implements InputFilterAwareInterface 
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
					'name' => 'LbvfName',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
					),
			]));
			
			$inputFilter->add($factory->createInput([
					'name' => 'DeadLine',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
					),
			]));
			
			$inputFilter->add($factory->createInput([
					'name' => 'DeadLineAssessment',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
					),
			]));
			
			$inputFilter->add($factory->createInput([
					'name' => 'NominationEndorsement',
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
					'name' => 'AllowAssess',
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
					'name' => 'AllowReport',
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
					'name' => 'Status',
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
			
			/*$inputFilter->add($factory->createInput([
					'name' => 'Notes',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
					),
			]));*/
			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
}