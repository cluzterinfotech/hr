<?php 

namespace Employee\Form;

use Zend\Form\Element;
use Zend\Form\Form;

class EmployeeRatingForm extends Form 
{
	public function __construct($name = null)
	{
		parent::__construct('employeeRatingForm'); 
		$this->setAttribute('method','post'); 
		$this->setAttribute('novalidate'); 
		$this->setAttribute('autocomplete','off'); 
        
		$this->add(array(
			'name' => 'employeeNumberRating',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'employeeNumberRating',
				'id' => 'employeeNumberRating',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Employee Name:*',
				'value_options' => array(
	    		),
			),
		));
        
		$this->add(array(
			'name' => 'rating',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class'    => 'rating',
				'id'       => 'rating',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Rating*',
			), 
		));  
		
		$this->add(array(
			'name' => 'ratingYear',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class'    => 'ratingYear',
				'id'       => 'ratingYear',
				'required' => 'required',
				'readOnly' => true,
				'value'    => date('Y')
			),
			'options' => array(
				'label' => 'Year *',
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