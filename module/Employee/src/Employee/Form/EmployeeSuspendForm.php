<?php 

namespace Employee\Form; 

use Zend\Form\Element; 
use Zend\Form\Form; 
use Zend\Stdlib\Hydrator\ClassMethods;
use Employee\Model\EmployeeSuspend;

class EmployeeSuspendForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('employeeSuspendForm'); 
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
			'name' => 'employeeNumberSuspend',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'employeeNumberSuspend',
				'id' => 'employeeNumberSuspend',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Employee Name:*',
				'value_options' => array(
	    		),
			),
		));
        
		$this->add(array(
			'name' => 'suspendFromDate',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'suspendFromDate',
				'id' => 'suspendFromDate',
				'required' => 'required',
			),
			'options' => array(
		    	'label' => 'Suspend From Date*',
			),
		));

		$this->add(array(
			'name' => 'suspendToDate',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'suspendToDate',
				'id' => 'suspendToDate',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Suspend To Date*',
			),
		)); 
        
		$this->add(array(
			'name' => 'suspendReason',
			'type' => 'Zend\Form\Element\Textarea',
			'attributes' => array(
				'class' => 'suspendReason',
				'id' => 'suspendReason',
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