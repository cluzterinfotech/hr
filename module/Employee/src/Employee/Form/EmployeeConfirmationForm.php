<?php 

namespace Employee\Form;

use Zend\Form\Element;
use Zend\Form\Form;

class EmployeeConfirmationForm extends Form 
{
	public function __construct($name = null)
	{
		parent::__construct('employeeConfirmationForm'); 
		$this->setAttribute('method','post'); 
		$this->setAttribute('novalidate'); 
		$this->setAttribute('autocomplete','off'); 
        
		$this->add(array(
				'name' => 'employeeNumberConfirmation',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'employeeNumberConfirmation',
						'id' => 'employeeNumberConfirmation',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Employee Name:*',
						'value_options' => array(
						),
				),
		));
        
		$this->add(array(
				'name' => 'effectiveDate',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'effectiveDate',
						'id' => 'effectiveDate',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Effective Date',
				),
		));

		$this->add(array(
				'name' => 'appliedDate',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'appliedDate',
						'id' => 'appliedDate',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Applied Date',
				),
		));
        
		$this->add(array(
				'name' => 'oldSalary',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'oldSalary',
						'id' => 'oldSalary',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Old Salary',
				),
		));

		$this->add(array(
				'name' => 'oldCola',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'oldCola',
						'id' => 'oldCola',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Old Cola',
				),
		));

		$this->add(array(
				'name' => 'adjustedAmount',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'adjustedAmount',
						'id' => 'adjustedAmount',
						'required' => 'required',
						'value'    => 0,
				),
				'options' => array(
						'label' => 'Adjusted Amount',
				),
		));
        
		$this->add(array(
				'name' => 'percentage',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'percentage',
						'id' => 'percentage',
						'required' => 'required',
						'value'    => 0,
				),
				'options' => array(
						'label' => 'Percentage (Ex:for 20% enter 1.2)',
				),
		));

		$this->add(array(
				'name' => 'confirmationNotes',
				'type' => 'Zend\Form\Element\Textarea',
				'attributes' => array(
						'class' => 'confirmationNotes',
						'id' => 'confirmationNotes',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Confirmation Notes',
				),
		));
		
		$this->add(array(
				'name' => 'submit',
				'type' => 'submit',
				'attributes' => array(
						'value' => 'Add'
				)
		)); 
        
	}
} 