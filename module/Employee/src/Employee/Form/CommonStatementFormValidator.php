<?php 
namespace Employee\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class CommonStatementFormValidator implements InputFilterAwareInterface 
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
					'name' => 'employeeId',
					'required' => false,
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
				'name' => 'bankId',
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					
				),
			]));
			
			$inputFilter->add($factory->createInput([
					'name' => 'stmtDate',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
								
					),
			]));
            
			$inputFilter->add($factory->createInput([
				'name' => 'Amount',
				'required' => true,
				'filters' => array(
						//array('name' => 'Digits'),
				),
				'validators' => array(
							/*array (
									'name' => 'StringLength',
									'options' => array(
											'encoding' => 'UTF-8',
											'min' => '2',
											'max' => '3',
									),
							),*/
					),
			]));
            
			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
}