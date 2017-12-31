<?php

namespace Position\Form;

use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Form\Element; 
use Zend\Form\Form; 
use Position\Model\Position;

class PositionForm extends Form  {
	
	public function __construct($name = null) {
	    	
		parent::__construct('positionForm');
		$this->setAttribute('noValidate','noValidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new Position()); 
		
		$this->add(array(
			'name' => 'id',
			'type' => 'Hidden'
		));
		
		$this->add(array(
			'name' => 'positionName',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'positionName',
				'id' => 'positionName',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Position Title *',
			),
		));
		
		$this->add(array(
			'name' => 'organisationLevel',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'organisationLevel',
				'id' => 'organisationLevel',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Organisation Level*',
				'value_options' => array(
					''  => '',
					'0' => 'No',
					'1' => 'Yes',
				),
			),
		));
        
		$this->add(array(
			'name' => 'positionLocation',
			'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
					'class' => 'positionLocation',
					'id' => 'positionLocation',
					'required' => 'required',
				),
				'options' => array(
					'label' => 'Position Location*',	
					'value_options' => array(
					), 
				), 
		)); 
		
		$this->add(array(
		    'name' => 'jobGradeId',
		    'type' => 'Zend\Form\Element\Select',
		    'attributes' => array(
		        'class' => 'jobGradeId',
		        'id' => 'jobGradeId',
		        'required' => 'required',
		    ),
		    'options' => array(
		        'label' => 'Job Grade*',
		        'value_options' => array(),
		    ),
		)); 
        		
		$this->add(array(
			'name' => 'shortDescription',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'shortDescription',
				'id' => 'shortDescription',
				//'required' => 'required',
				'maxLength' => 30,
			),
			'options' => array(
				'label' => 'Short Description', 
			), 
		)); 
		
		$this->add(array(
			'name' => 'section',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'section',
				'id' => 'section',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Section*',
		    	'value_options' => array(
			    ),
		    ),
		)); 
		
		$this->add(array(
			'name' => 'reportingPosition',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'reportingPosition',
				'id' => 'reportingPosition',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Reporting Position*',
				'value_options' => array(
			    ),
			),
		)); 
		
		$this->add(array(
		    'name' => 'status',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'status',
				'id' => 'status',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Position Status*',
				'value_options' => array(
					//''  => '',
					'1' => 'Active',
					'0' => 'Inactive',
				),
			),
		));
	    
		$this->add(array(
			'name' => 'submit',
			'type' => 'Submit', 
			'attributes' => array (
				'value' => 'Add Position',
				'class' => 'addPromotion',
				'id'    => 'addPromotion',
			)
		));
	}
}