<?php 
namespace Application\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Application\Model\LocationGroup;

class LocationGroupForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('LocationGroupForm');
		$this->setAttribute('method', 'post');
		// 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new LocationGroup());
        
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
				'name' => 'locationId',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'locationId',
						'id' => 'locationId',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Location Name*',
				),
		));
        
		$this->add(array(
				'name' => 'attendanceGroupId',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'attendanceGroupId',
						'id' => 'attendanceGroupId',
						'required' => 'required',
						//'maxLength' => 3,
				),
				'options' => array(
						'label' => 'Attendance Group*',
				),
		));
        
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Add Location Group'
			)
		));
		
	}
}