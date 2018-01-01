<?php 
namespace Employee\Form; 

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Employee\Model\Location;

class SubmitForm extends Form 
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
				),
				'options' => array(
						'label' => 'Location Working Hours*',
				),
		));
        
		$this->add(array(
				'name' => 'locationStatus',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class'    => 'locationStatus',
						'id'       => 'locationStatus',
						'required' => 'required',
						//'value' => '0',
				),
				'options' => array(
						'label' => 'Location Status*',
						'value_options' => array(
								''  => '',
								'1' => 'Active',
								'2' => 'InActive',
						),
				),
		));
         
		$this->add ( array (
				'name' => 'submit',
				'type' => 'submit',
				'attributes' => array (
						'value' => 'Add'
				)
		));		
	}
}