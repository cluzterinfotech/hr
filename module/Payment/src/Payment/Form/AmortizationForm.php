<?php 
namespace Payment\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;  
use Employee\Model\CarAmortization;

class AmortizationForm extends Form 
{ 
	public function __construct($name = null)
	{
		parent::__construct('carAmortizationForm'); 
		$this->setAttribute('method', 'post');
		// 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))
		     ->setObject(new CarAmortization());  
        
		$this->add(array(
			'name' => 'id',
			'type' => 'Zend\Form\Element\Hidden',
			'attributes' => array(
				'class' => 'positionGroupId',
				'id' => 'positionGroupId',
			),
			'options' => array(
				'label' => 'undefined',
			),
		));
        
		$this->add(array(
			'name' => 'employeeNumber',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'employeeNumber',
				'id' => 'employeeNumber',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Employee Name *', 
			),
		));  
        
		$this->add(array(
			'name' => 'paidDate', 
			'type' => 'Zend\Form\Element\Text', 
			'attributes' => array( 
				'class' => 'paidDate', 
				'id' => 'paidDate', 
				'required' => 'required', 
				//'maxLength' => 3,
			),
			'options' => array(
				'label' => 'Paid Date *', 
			),
		)); 
		
		$this->add(array(
				'name' => 'paidAmount',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'paidAmount',
						'id' => 'paidAmount',
						'required' => 'required',
						//'maxLength' => 3,
				),
				'options' => array(
						'label' => 'Paid Amount *',
				),
		));
        
		$this->add(array(
			'name' => 'numberOfMonths', 
			'type' => 'Zend\Form\Element\Text', 
			'attributes' => array( 
				'class' => 'numberOfMonths', 
				'id' => 'numberOfMonths', 
				'required' => 'required', 
				'maxLength' => 2,
			),
			'options' => array(
				'label' => 'Number Of Months *',
			),
		));   
         
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Add Car Amortization'  
			)
		));
		
	}
}