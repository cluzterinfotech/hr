<?php 
namespace Employee\Form;

use Zend\Form\Element;
use Zend\Form\Form;

class EmployeeForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('employeeForm'); 
		$this->setAttribute('method','post');
		// 
		$this->setAttribute('novalidate'); 
		//$this->setHydrator(new ClassMethods(false))->setObject(new EmployeeAllowance()); 
        
		$this->add(array(
			'name' => 'employeeNumber',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class'    => 'employeeNumber',
				'id'       => 'employeeNumber',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Employee Name*',
		    ), 
	    )); 
        
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'View Paysheet Details'
			)
		)); 		
	}
}