<?php 

namespace Employee\Form; 
 
use Zend\Form\Element; 
use Zend\Form\Form; 
use Zend\Stdlib\Hydrator\ClassMethods;
use Employee\Model\NewEmployee;

class EmployeeInfoForm extends Form 
{ 
    public function __construct($name = null) 
    { 
        parent::__construct('employeeInfoForm'); 
        
        $this->setAttribute('method', 'post'); 
        $this->setAttribute('novalidate');
        
        $this->setHydrator(new ClassMethods(false))->setObject(new NewEmployee());  
        
        $this->add(array(
        	'name' => 'id',
        	'type' => 'Zend\Form\Element\Hidden',
        	'attributes' => array(
        		'class' => 'empId',
        		'id' => 'empId', 
        	), 
        	'options' => array(
        		'label' => 'undefined',
        	), 
        ));   
        
        $this->add(array(
        	'name' => 'empDateOfBirth',
        	'type' => 'Zend\Form\Element\Text',
        	'attributes' => array(
        		'class' => 'empDateOfBirth',
        		'id' => 'empDateOfBirth',
        		'required' => 'required',
        	),
        	'options' => array(
        		'label' => 'Date Of Birth',
        	),
        )); 
        
       $this->add(array( 
            'name' => 'maritalStatus', 
            'type' => 'Zend\Form\Element\Select', 
            'attributes' => array( 
                'class' => 'maritalStatus', 
                'id' => 'maritalStatus', 
                'required' => 'required', 
            ), 
            'options' => array( 
                'label' => 'Marital Status', 
                'value_options' => array(),
            ), 
        )); 
 
        $this->add(array( 
            'name' => 'religion', 
            'type' => 'Zend\Form\Element\Select', 
            'attributes' => array( 
                'class' => 'religion', 
                'id' => 'religion', 
                'required' => 'required', 
            ), 
            'options' => array( 
                'label' => 'Religion', 
                'value_options' => array(),
            ), 
        )); 
        
        $this->add(array( 
            'name' => 'nationality', 
            'type' => 'Zend\Form\Element\Select', 
            'attributes' => array( 
                'class' => 'nationality', 
                'id' => 'nationality', 
                'required' => 'required', 
            ), 
            'options' => array( 
                'label' => 'Nationality', 
                'value_options' => array(),
            ), 
        )); 
 
        $this->add(array( 
            'name' => 'numberOfDependents', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'class' => 'numberOfDependents', 
                'id' => 'numberOfDependents', 
                'required' => 'required', 
            ), 
            'options' => array( 
                'label' => 'Number Of Dependents', 
            ), 
        )); 
 
        $this->add(array( 
            'name' => 'state', 
            'type' => 'Zend\Form\Element\Select', 
            'attributes' => array( 
                'class' => 'state', 
                'id' => 'state', 
                'required' => 'required', 
            ), 
            'options' => array( 
                'label' => 'State', 
                'value_options' => array(),
            ), 
        ));  
        
        $this->add(array( 
            'name' => 'empAddress', 
            'type' => 'Zend\Form\Element\Textarea', 
            'attributes' => array( 
                'class'    => 'empAddress', 
                'id'       => 'empAddress', 
                'required' => 'required', 
            ),  
            'options' => array( 
            	'label' => 'Address',
            ), 
        )); 
        
        $this->add(array( 
            'name' => 'officeExtention', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'class' => 'officeExtention', 
                'id' => 'officeExtention', 
                'required' => 'required', 
            ), 
            'options' => array( 
                'label' => 'Office Extention:', 
            ), 
        )); 
         
        $this->add(array( 
            'name' => 'empMobile', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'class' => 'empMobile', 
                'id' => 'empMobile', 
            	'required' => 'required',
            ), 
            'options' => array( 
                'label' => 'Mobile :', 
            ), 
        )); 
        
        $this->add(array( 
            'name' => 'empTelephone', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'class' => 'empTelephone', 
                'id' => 'empTelephone', 
            ), 
            'options' => array( 
                'label' => 'Telephone', 
            ), 
        )); 
        
        $this->add(array( 
            'name' => 'empEmail', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'class' => 'empEmail', 
                'id' => 'empEmail', 
                'required' => 'required', 
            ), 
            'options' => array( 
                'label' => 'Email Address', 
            ), 
        )); 
 
        $this->add(array( 
            'name' => 'empPassport', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'class' => 'empPassport', 
                'id' => 'empPassport', 
                //'required' => 'required', 
            ), 
            'options' => array( 
                'label' => 'Passport', 
            ), 
        )); 
 
        $this->add(array( 
            'name' => 'license', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'class' => 'license', 
                'id' => 'license', 
                //'required' => 'required', 
            ), 
            'options' => array( 
                'label' => 'License', 
            ), 
        )); 
        
        $this->add(array( 
            'name' => 'skillGroup', 
            'type' => 'Zend\Form\Element\Select', 
            'attributes' => array( 
                'class' => 'skillGroup', 
                'id' => 'skillGroup', 
                'required' => 'required', 
            ), 
            'options' => array( 
                'label' => 'Skill Group', 
                'value_options' => array(), 
            ), 
        )); 
               
        $this->add(array(
        	'name' => 'submit',
        	'type' => 'Submit',
        	'attributes' => array(
        		'value' => 'Submit', 
        	),
        )); 
              
    } 
}