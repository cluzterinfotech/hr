<?php 
namespace Payment\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods; 
use Employee\Model\OverPaymentEntity;  

class DeductionOverpaymentForm extends Form 
{ 
	public function __construct($name = null)
	{
		parent::__construct('deductionOverpaymentForm');
		$this->setAttribute('method', 'post');
		
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new OverPaymentEntity());
        
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
			'name' => 'amount', 
			'type' => 'Zend\Form\Element\Text', 
			'attributes' => array( 
				'class' => 'amount', 
				'id' => 'amount', 
				'required' => 'required', 
				//'maxLength' => 3,
			),
			'options' => array(
				'label' => 'Amount(Total)*',
			),
		));
		
		$this->add(array(
		    'name' => 'numberOfMonthsDed',
		    'type' => 'Zend\Form\Element\Text',
		    'attributes' => array(
		        'class' => 'numberOfMonthsDed',
		        'id' => 'numberOfMonthsDed',
		        'required' => 'required',
		        //'maxLength' => 3,
		    ),
		    'options' => array(
		        'label' => 'Number of Months to Deduct*',
		    ),
		));
        
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Add Over Payment' 
			)
		));
		
	}
}