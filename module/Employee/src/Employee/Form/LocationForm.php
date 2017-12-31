<?php 
namespace Employee\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Employee\Model\Location;

class LocationForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('LocationForm');
		$this->setAttribute('method', 'post');
		// 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new Location());
        
		$this->add(array(
				'name' => 'id',
				'type' => 'Zend\Form\Element\Hidden',
				'attributes' => array(
						'class' => 'locationId',
						'id' => 'locationId',
				),
				'options' => array(
						'label' => 'undefined',
				),
		));
        
		$this->add(array(
				'name' => 'locationName',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'locationName',
						'id' => 'locationName',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Location Name*',
				),
		));
        
		$this->add(array(
				'name' => 'overtimeHour',
				'type' => 'Zend\Form\Element\Number',
				'attributes' => array(
						'class' => 'overtimeHour',
						'id' => 'overtimeHour',
						'required' => 'required',
						'maxLength' => 3,
				),
				'options' => array(
						'label' => 'Location Working Hours*',
				),
		));
		
        
		$this->add(array(
				'name' => 'isHaveHardship',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class'    => 'isHaveHardship',
						'id'       => 'isHaveHardship',
						'required' => 'required',
						//'value' => '0',
				),
				'options' => array(
						'label' => 'Is Have Hardship Allowance(In this Location)*',
						'value_options' => array(
								''  => '',
								'0' => 'No',
								'1' => 'Yes',
						),
				),
		));
         
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Add Location'
			)
		));
		
	}
}