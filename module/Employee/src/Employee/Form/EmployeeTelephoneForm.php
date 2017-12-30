<?php 

namespace Employee\Form;

use Zend\Form\Element;
use Zend\Form\Form;

class EmployeeTelephoneForm extends Form 
{
	public function __construct($name = null)
	{
		parent::__construct('employeeTelephoneForm'); 
		$this->setAttribute('method','post'); 
		$this->setAttribute('novalidate'); 
		$this->setAttribute('autocomplete','off'); 
        
		$this->add(array(
			'name' => 'employeeNumberTelephone',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'employeeNumberTelephone',
				'id' => 'employeeNumberTelephone',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Employee Name:*',
				'value_options' => array(
	    		),
			),
		));
		
		$this->add(array(
				'name' => 'empNumber',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'empNumber',
						'id' => 'empNumber',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Employee Number',
				),
		));
        
		$this->add(array(
			'name' => 'phoneNumber',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'phoneNumber',
				'id' => 'phoneNumber',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Phone Number',
			),
		)); 
		
		/*$this->add(array(
				'name' => 'phoneAmount',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'phoneAmount',
						'id' => 'phoneAmount',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Phone Amount',
				),
		));
		
		$this->add(array(
			'name' => 'phoneDeductionMstId',
			'type' => 'Zend\Form\Element\Hidden',
			'attributes' => array(
				'class'    => 'phoneDeductionMstId',
				'id'       => 'phoneDeductionMstId',
				'required' => 'required',
			),
			'options' => array(
				//'label' => 'Phone Amount', 
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
