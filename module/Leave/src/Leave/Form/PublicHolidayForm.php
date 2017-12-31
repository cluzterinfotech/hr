<?php

namespace Leave\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator; 
use Leave\Model\PublicHoliday;

class PublicHolidayForm extends Form 
{
	public function __construct($name = null)
	{
		parent::__construct('publicHoliday');
		$this->setAttribute('novalidate','novalidate');
		$this->setHydrator(new ClassMethodsHydrator(false))
		     ->setObject(new PublicHoliday()); 
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
				'name' => 'holidayReason',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'holidayReason',
						'id' => 'holidayReason',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Holiday Reason',
				),
		));

		$this->add(array(
			'name' => 'fromDate',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'fromDate',
				'id' => 'fromDate',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Holiday From',
			),
		)); 
          
		$this->add(array(
			'name' => 'toDate',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class'     => 'toDate',
				'id'        => 'toDate',
				'required'  => 'required',
			),   
			'options' => array(
				'label' => 'Holiday To',
			), 
		)); 

		$this->add(array(
			'name' => 'Notes',
			'type' => 'Zend\Form\Element\TextArea',
			'attributes' => array(
				'class' => 'Notes',
				'id' => 'Notes',
				//'required' => 'required',
			),
			'options' => array(
			    'label' => 'Notes',
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