<?php 
namespace Employee\Form;

use Zend\Form\Element;
use Zend\Form\Form;

class EmployeeTerminationForm extends Form

{
	public function __construct($name = null)
	{
		parent::__construct('employeeTerminationForm');
        
		$this->setAttribute('method','post'); 
        
		$this->add(array(
			'name' => 'employeeNumberTermination',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'employeeNumberTermination',
				'id' => 'employeeNumberTermination',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Employee Name:*',
				//'value_options' => array(
			    //),
			),
		));

		$this->add(array(
			'name' => 'terminationType',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'terminationType',
				'id' => 'terminationType',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Termination Type',
				'value_options' => array(
	    		),
		    ),
		));

		$this->add(array(
			'name' => 'terminationDate',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'terminationDate',
				'id' => 'terminationDate',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Termination Date',
			),
		)); 
		
		/*$this->add(array(
			'name' => 'terminationNotes',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'terminationNotes',
				'id' => 'terminationNotes',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Termination Date',
			), 
		));*/
        
		$this->add(array(
		    'name' => 'terminationNotes',
			'type' => 'Zend\Form\Element\Textarea',
			'attributes' => array(
				'class' => 'terminationNotes',
				'id' => 'terminationNotes',
				'required' => 'required',
			),
			'options' => array(
			    'label' => 'Termination Notes',
			),
		));
        
		$this->add ( array (
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array (
				'value' => 'Add',
				 
			)
		));
	}
}