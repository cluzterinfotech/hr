<?php 
namespace Payment\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods; 
use Payment\Model\GlassAllowance;

class GlassAllowanceForm extends Form 
{ 
	public function __construct($name = null)
	{
		parent::__construct('glassAllowanceForm');
		$this->setAttribute('method', 'post');
		// 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))
		     ->setObject(new GlassAllowance()); 
        
		$this->add(array(
			'name' => 'id',
			'type' => 'Zend\Form\Element\Hidden',
			'attributes' => array(
				'class' => 'glassAllowanceId',
				'id' => 'glassAllowanceId',
			),
			'options' => array(
				'label' => 'undefined',
			),
		));
        
		$this->add(array(
			'name' => 'familyMemberId',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'familyMemberId',
				'id' => 'familyMemberId',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Family Member *', 
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
				'label' => 'Amount *',
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
				'name' => 'fromDate',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'fromDate',
						'id' => 'fromDate',
						'required' => 'required',
						//'maxLength' => 3,
				),
				'options' => array(
						'label' => 'Starting Date *',
				),
		));
         
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Add Glass Allowance' 
			)
		));
		
	}
}