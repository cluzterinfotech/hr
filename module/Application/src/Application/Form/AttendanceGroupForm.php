<?php 
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Application\Model\Bank;
use Application\Model\AttendanceGroup;

class AttendanceGroupForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('AttendanceGroupForm');
		$this->setAttribute('method', 'post');
		// 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new AttendanceGroup());
        
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
				'name' => 'groupName',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'groupName',
						'id' => 'groupName',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Group Name*',
				),
		));
         
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Add Attendance Group'
			)
		));
		
	}
}