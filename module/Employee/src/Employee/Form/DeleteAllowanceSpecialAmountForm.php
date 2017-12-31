<?php  

namespace Employee\Form; 

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class DeleteAllowanceSpecialAmountForm extends Form 
{
	public function __construct($name = null)
	{
		parent::__construct('allowanceSpecialAmountForm');
		$this->setAttribute('method', 'post'); 
		$this->setAttribute('novalidate'); 
		// $this->setHydrator(new ClassMethods(false))
		//      ->setObject(new EmployeeLocation()); 
        
		$this->add(array(
			'name' => 'employeeNumberAllowance',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class'    => 'employeeNumberAllowance',
				'id'       => 'employeeNumberAllowance',
				'required' => 'required',
			),
			'options' => array(
				'label'         => 'Employee Name : *', 
				'value_options' => array( ), 
		    ),  
		));  
        
		$this->add(array(
			'name' => 'oldAmount',
			'type' => 'Zend\Form\Element\Number',
			'attributes' => array(
				'class' => 'oldAmount',
				'id' => 'oldAmount',
				'required' => 'required',
				//'maxLength' => 3,
			),
			'options' => array(
				'label' => 'Old Amount : *',
			),
		)); 
		
		$this->add(array(
			'name' => 'newAmount',
			'type' => 'Zend\Form\Element\Number',
			'attributes' => array(
				'class'     => 'newAmount',
				'id'        => 'newAmount',
				'required'  => 'required',
				//'maxLength' => 3, 
			),
			'options' => array(
				'label' => 'New Amount : *',
			),
		)); 
		
		$this->add(array(
		    'name' => 'effectiveDate',
		    'type' => 'Zend\Form\Element\Text',
		    'attributes' => array(
		        'class'     => 'effectiveDate',
		        'id'        => 'effectiveDate',
		        'required'  => 'required',
		        //'maxLength' => 3,
		    ),
		    'options' => array(
		        'label' => 'Effective Date : *',
		    ),
		)); 
		
		$this->add(array(
		    'name' => 'allowanceId',
		    'type' => 'Zend\Form\Element\Select',
		    'attributes' => array(
		        'class'    => 'allowanceId',
		        'id'       => 'allowanceId',
		        'required' => 'required',
		    ),
		    'options' => array(
		        'label'         => 'allowance Name : *',
		        'value_options' => array( ),
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