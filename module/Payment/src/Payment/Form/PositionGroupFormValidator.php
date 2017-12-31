<?php 
namespace Payment\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class PositionGroupFormValidator implements InputFilterAwareInterface 
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
				'name' => 'positionId', 
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array(
			    		'name' => 'StringLength',
						'options' => array(
					    	//'encoding' => 'UTF-8',
							//'min' => '3',
							//'max' => '25',
						),
					),
				),
			]));
            
			$inputFilter->add($factory->createInput([
					'name' => 'lkpCarRentGroupId',
					'required' => true,
					//'filters' => array(
							//array('name' => 'Digits'),
					//),
					'validators' => array(
						array (
							'name' => 'StringLength',
							'options' => array(
								//'encoding' => 'UTF-8',
								//'min' => '2',
								//'max' => '3',
							),
						),
					),
			]));
            
			/*$inputFilter->add($factory->createInput([
				'name' => 'locationStatus',
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array (
						'name' => 'InArray',
						'options' => array(
							'haystack' => array(0,1,2),
							'messages' => array(
							'notInArray' => 'undefined'
						)
					),
				),
			),
			]));*/ 
			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
}