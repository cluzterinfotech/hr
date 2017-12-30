<?php 
namespace Leave\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class LeaveAdminFormValidator implements InputFilterAwareInterface 
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
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					
				),
			]));
            
			$inputFilter->add($factory->createInput([
				'name' => 'LkpLeaveTypeId',
				'required' => true,
				'filters' => array(
					//array('name' => 'Digits'),
				),
				'validators' => array(),
			]));
			
			$inputFilter->add($factory->createInput([
					'name' => 'leaveFromDate',
					'required' => true,
					'filters' => array(
							//array('name' => 'Digits'),
					),
					'validators' => array(),
			]));
			
			$inputFilter->add($factory->createInput([
					'name' => 'leaveToDate',
					'required' => true,
					'filters' => array(
							//array('name' => 'Digits'),
					),
					'validators' => array(),
			]));
            
			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
}