<?php 
namespace Position\Form; 

use Zend\Form\Element; 
use Zend\Form\Form; 

class DelegationForm extends Form 
{ 
    public function __construct($name = null) 
    { 
        parent::__construct('delegationForm'); 
        $this->setAttribute('method','post'); 
        $this->setAttribute('novalidate'); 
        $this->setAttribute('autocomplete','off'); 
        
        $this->add(array(
        		'name' => 'employeeId',
        		'type' => 'Zend\Form\Element\Select',
        		'attributes' => array(
        				'class'    => 'employeeId',
        				'id'       => 'employeeId',
        				'required' => 'required',
        				//'value' => '0',
        		),
        		'options' => array(
        				'label' => 'Employee Name*',
        		),
        ));
        
        $this->add(array(
        	'name' => 'delegatedEmployeeId',
        	'type' => 'Zend\Form\Element\Select',
        	'attributes' => array(
        		'class'    => 'delegatedEmployeeId',
        		'id'       => 'delegatedEmployeeId',
        		'required' => 'required',
        		//'value' => '0',
        	),
        	'options' => array(
        		'label' => 'Delegated Employee Name *', 
        	),
        )); 
        
        $this->add(array(
        		'name' => 'delegatedFrom',
        		'type' => 'Zend\Form\Element\Text',
        		'attributes' => array(
        				'class' => 'delegatedFrom',
        				'id' => 'delegatedFrom',
        				'required' => 'required',
        				//'readOnly' => true
        		),
        		'options' => array(
        				'label' => 'Delegated From Date*',
        				'hint'  => 'YYY-mm-dd',
        		),
        ));
        
        $this->add(array(
        		'name' => 'delegatedTo',
        		'type' => 'Zend\Form\Element\Text',
        		'attributes' => array(
        				'class' => 'delegatedTo',
        				'id' => 'delegatedTo',
        				'required' => 'required',
        				//'readOnly' => true
        		),
        		'options' => array(
        				'label' => 'Delegated To Date*',
        		),
        ));
        
        $this->add(array( 
			'name' => 'submit', 
			'type' => 'submit', 
			'attributes' => array( 
			    'value' => 'Add New Delegation', 
			    'class' => 'addDelegation', 
				'id'    => 'addDelegation', 
			)
		));      
    } 
} 