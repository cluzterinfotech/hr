<?php 
namespace Position\Form; 

use Zend\Form\Element; 
use Zend\Form\Form; 

class PositionMovementForm extends Form 
{ 
    public function __construct($name = null) 
    { 
        parent::__construct('positionMovementForm'); 
        $this->setAttribute('method','post'); 
        $this->setAttribute('novalidate'); 
        $this->setAttribute('autocomplete','off'); 
        
        $this->add(array(
        		'name' => 'employeeNumberPosition',
        		'type' => 'Zend\Form\Element\Select',
        		'attributes' => array(
        				'class'    => 'employeeNumberPosition',
        				'id'       => 'employeeNumberPosition',
        				'required' => 'required',
        				//'value' => '0',
        		),
        		'options' => array(
        				'label' => 'Employee Name*',
        		),
        ));
        
        $this->add(array(
            'name' => 'employeeExistingPosition',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'class'    => 'employeeExistingPosition',
                'id'       => 'employeeExistingPosition',
                'required' => 'required',
                //'readOnly' => true,
                //'value' => '0',
            ),
            'options' => array(
                'label' => 'Current Position Name *',
            ),
        ));
        
        $this->add(array(
        	'name' => 'employeeNewPosition',
        	'type' => 'Zend\Form\Element\Select',
        	'attributes' => array(
        		'class'    => 'employeeNewPosition',
        		'id'       => 'employeeNewPosition',
        		'required' => 'required',
        		//'value' => '0',
        	),
        	'options' => array(
        		'label' => 'New Position Name *',
        	),
        ));
        
        $this->add(array( 
			'name' => 'submit', 
			'type' => 'submit', 
			'attributes' => array( 
			    'value' => 'Add New Employee Position', 
			    'class' => 'addEmployeeNewPosition', 
				'id'    => 'addEmployeeNewPosition', 
			)
		));      
    } 
} 