<?php  

namespace Employee\Form; 

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class UpdateInitialForm extends Form 
{
	public function __construct($name = null)
	{
		parent::__construct('updateInitialForm');
		$this->setAttribute('method', 'post'); 
		$this->setAttribute('novalidate'); 
		// $this->setHydrator(new ClassMethods(false))
		//      ->setObject(new EmployeeLocation()); 
        
		$this->add(array(
			'name' => 'employeeNumberInitial',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class'    => 'employeeNumberInitial',
				'id'       => 'employeeNumberInitial',
				'required' => 'required',
			),
			'options' => array(
				'label'         => 'Employee Name : *', 
				'value_options' => array( ), 
		    ),  
		));  
        
		$this->add(array(
			'name' => 'oldInitial',
			'type' => 'Zend\Form\Element\Number',
			'attributes' => array(
				'class' => 'oldInitial',
				'id' => 'oldInitial',
				'required' => 'required',
				//'maxLength' => 3,
			),
			'options' => array(
				'label' => 'Old Initial : *',
			),
		)); 
		
		$this->add(array(
			'name' => 'newInitial',
			'type' => 'Zend\Form\Element\Number',
			'attributes' => array(
				'class'     => 'newInitial',
				'id'        => 'newInitial',
				'required'  => 'required',
				//'maxLength' => 3, 
			),
			'options' => array(
				'label' => 'New Initial : *',
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