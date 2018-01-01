<?php 
namespace Payment\Form;

use Zend\Form\Element;
use Zend\Form\Form;

class SelectLeaveAllowanceEmployeeForm extends Form

{
	public function __construct($name = null)
	{
		parent::__construct('selectEmployeeLeaveAllowanceForm');
        
		$this->setAttribute('method','post');  
		$this->setAttribute('noValidate');
        
		$this->add(array(
			'name' => 'employeeNumberLeaveAllowance',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'employeeNumberLeaveAllowance',
				'id' => 'employeeNumberLeaveAllowance',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Employee Name:*',
				//'value_options' => array(
			    //),
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