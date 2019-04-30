<?php 
namespace Payment\Form; 

use Zend\Form\Element; 
use Zend\Form\Form; 

class OverTimeMealForm extends Form 
{ 
    public function __construct($name = null) 
    { 
        parent::__construct('OverTimeMealForm'); //-----------
        $this->setAttribute('method','post'); 
        $this->setAttribute('novalidate','false'); 
        $this->setAttribute('autocomplete','off'); 
        
        $this->add(array(
        	'name' => 'empId',
        	'type' => 'Zend\Form\Element\Select',
        	'attributes' => array(
        		'class'    => 'empId',
        		'id'       => 'empId',
        		'required' => 'required',
        				//'value' => '0',
        	),
        	'options' => array(
        		'label' => 'Employee Name*',
        	),
        ));
        
        $this->add(array(
        		'name' => 'amount',
        		'type' => 'Zend\Form\Element\Text',
        		'attributes' => array(
        				'class'    => 'amount',
        				'id'       => 'amount',
        				'required' => 'required',
        				//'value' => '0',
        		),
        		'options' => array(
        				'label' => 'Amount  *',
        		),
        ));
    
        $this->add(array(
        	'name' => 'employeeNoMeals',
        	'type' => 'Zend\Form\Element\Text',
        	'attributes' => array(
        		'class'    => 'employeeNoMeals',
        		'id'       => 'employeeNoMeals',
        		'required' => 'required',
        		//'value' => '0',
        	),
        	'options' => array(
        		'label' => 'Number of Meals  *',
        	),
        ));
        $this->add(array( 
			'name' => 'submit', 
			'type' => 'submit', 
			'attributes' => array( 
			    'value' => 'Add Ot Meal', 
			    'class' => 'addEmployeeNoOHours', 
				'id'    => 'addEmployeeNoOHours', 
			)
		));      
    } 
} 