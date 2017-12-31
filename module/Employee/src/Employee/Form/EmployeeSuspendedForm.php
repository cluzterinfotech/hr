<?php 

namespace Employee\Form; 

use Zend\Form\Element; 
use Zend\Form\Form; 
use Zend\Stdlib\Hydrator\ClassMethods;
use Employee\Model\EmployeeSuspend;

class EmployeeSuspendedForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('employeeSuspendedForm'); 
		$this->setAttribute('method', 'post');
		$this->setAttribute('novalidate');
		$this->setAttribute('autocomplete','off');
		$this->setHydrator(new ClassMethods(false))->setObject(new EmployeeSuspend());
		$this->add(array(
		    'name' => 'id',
		    'type' => 'Zend\Form\Element\Hidden',
		    'attributes' => array(
		        'class' => 'id',
		        'id' => 'id',
		    ),
		    'options' => array(
		        'label' => 'undefined',
		    ),
		));
		
		$this->add(array(
			'name' => 'employeeId',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'employeeId',
				'id' => 'employeeId',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Employee Name:*',
				'value_options' => array(
	    		),
			),
		));
        
		$this->add(array(
			'name' => 'suspendFrom',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'suspendFrom',
				'id' => 'suspendFrom',
				'required' => 'required',
			),
			'options' => array(
		    	'label' => 'Suspend From Date*',
			),
		));

		$this->add(array(
			'name' => 'suspendTo',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'suspendTo',
				'id' => 'suspendTo',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Suspend To Date*',
			),
		)); 
        
		$this->add(array(
			'name' => 'reason',
			'type' => 'Zend\Form\Element\Textarea',
			'attributes' => array(
				'class' => 'reason',
				'id' => 'reason',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Suspend Reason*',
			),
		)); 
		
		$this->add ( array (
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array (
				'value' => 'Add',
				'class' => 'suspendEmp',
				'id'    => 'suspendEmp',
			)
		));
        
	}
}