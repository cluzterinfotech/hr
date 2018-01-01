<?php

namespace Leave\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator; 
use Leave\Model\AnnualLeaveEntitlement;

class LeaveEntitlementForm extends Form 
{
	public function __construct($name = null)
	{
		parent::__construct('leave');
		$this->setAttribute('novalidate','novalidate');
		$this->setHydrator(new ClassMethodsHydrator(false))
		     ->setObject(new AnnualLeaveEntitlement()); 
		$this->setAttribute('method','post');

		$this->add(array(
			'name' => 'id',
			'type' => 'Zend\Form\Element\Hidden',
			'attributes' => array(
				'class' => 'id',
	    		'id' => 'id',
				'value' => 'id',
			),
			'options' => array(
				'label' => 'undefined',
			),
		));

		$this->add(array(
			'name' => 'yearsOfService',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'yearsOfService',
				'id' => 'yearsOfService',
				'required' => 'required',
				'maxLength' => 2,
			),
			'options' => array(
				'label' => 'Years Of Service',
			),
		)); 
          
		$this->add(array(
			'name' => 'numberOfDays',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class'     => 'numberOfDays',
				'id'        => 'numberOfDays',
				'required'  => 'required',
				'maxLength' => 3,
			),   
			'options' => array(
				'label' => 'Number Of Days',
			), 
		)); 

		$this->add(array(
			'name' => 'companyId',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'companyId',
				'id' => 'companyId',
				'required' => 'required',
			),
			'options' => array(
			    'label' => 'Company',
			    'value_options' => array(
			    ),
			),
		));

		$this->add(array(
			'name' => 'LkpLeaveType',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
	    		'class' => 'LkpLeaveType',
				'id' => 'LkpLeaveType',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Leave Type',
				'value_options' => array(
			    ),
			),
		));
		
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Submit'
			)
		)); 
        
	}
} 