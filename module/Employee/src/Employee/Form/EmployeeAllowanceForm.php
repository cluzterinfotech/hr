<?php 
namespace Employee\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Employee\Model\Location;
use Employee\Model\EmployeeLocation;
use Employee\Model\EmployeeAllowance;

class EmployeeAllowanceForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('EmployeeLocationForm');
		$this->setAttribute('method', 'post');
		// 
		$this->setAttribute('novalidate'); 
		$this->setHydrator(new ClassMethods(false))->setObject(new EmployeeAllowance()); 
        
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
				'class'    => 'employeeNumber',
				'id'       => 'employeeNumber',
				'required' => 'required',
				//'value' => '0',
			),
			'options' => array(
				'label' => 'Employee *',
				/* 'value_options' => array(
	    		''  => '',
				'1' => 'Active',
				'2' => 'InActive',
			), */
		    ), 
	    )); 
        
		$this->add(array(
			'name' => 'amount',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class'    => 'amount',
				'id'       => 'amount',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Amount*',
			),
		)); 
		
		$this->add(array(
			'name' => 'effectiveDate',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class'    => 'effectiveDate',
				'id'       => 'effectiveDate',
				'required' => 'required',
				'readOnly' => true
			),
			'options' => array(
				'label' => 'Effective Date*',
			),
		));
		
		$this->add(array(
			'name' => 'allowanceNameText',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class'    => 'allowanceNameText',
				'id'       => 'allowanceNameText',
				'required' => 'required',
				//'value' => '0',
			),
			'options' => array(
				'label' => 'Allowance Name*',
				/* 'value_options' => array(
				 ''  => '',
				'1' => 'Active',
				'2' => 'InActive',
	    		), */
			),
		));
		
		/*$this->add(array(
			'name' => 'allowanceNameText',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class'    => 'allowanceNameText',
				'id'       => 'allowanceNameText',
				'required' => 'required',
				'readOnly' => true
			),
			'options' => array(
				'label' => 'Allowance Name :',
			),
		)); */
        
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Add'
			)
		)); 		
	}
}