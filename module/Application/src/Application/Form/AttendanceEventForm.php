<?php 
namespace Application\Form;

use Application\Model\AttendanceEvent;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class AttendanceEventForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('attendanceEventForm');
		$this->setAttribute('method', 'post'); 
		// 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new AttendanceEvent());
        
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
				'name' => 'eventName',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'eventName',
						'id' => 'eventName',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Event Name*',
				),
		));
             
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Add Employee Baby Care'
			)
		));
	}
}