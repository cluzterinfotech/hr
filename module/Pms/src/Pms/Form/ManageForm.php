<?php

namespace Pms\Form;

use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Form\Element; 
use Zend\Form\Form; 
use Pms\Model\Manage;

class ManageForm extends Form  {
	
	public function __construct($name = null) {
	    	
		parent::__construct('manageForm');
		$this->setAttribute('noValidate','noValidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new Manage()); 
		
		$this->add(array(
			'name' => 'id',
			'type' => 'Hidden'
		));
		
		$this->add(array(
			'name' => 'Year',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'Year',
				'id' => 'Year',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Year*',
			),
		));
		
		$this->add(array(
			'name' => 'Curr_Activity',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'Curr_Activity',
				'id' => 'Curr_Activity',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Current Process*',
				/*'value_options' => array(
					''  => '',
					'0' => 'No',
					'1' => 'Yes',
				),*/ 
			),
		));
		
		$this->add(array(
			'name' => 'IPC_Notes',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'IPC_Notes',
				'id' => 'IPC_Notes',
				'required' => 'required',
				//'maxLength' => 30,
			),
			'options' => array(
				'label' => 'IPC Notes*',
			),
		));
        
		$this->add(array(
			'name' => 'Reports_Status',
			'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
					'class' => 'Reports_Status',
					'id' => 'Reports_Status',
					'required' => 'required',
				),
				'options' => array(
					'label' => 'Report Status*',	
					'value_options' => array(
						''  => '',
						'1' => 'Open Report',
						'2' => 'Close Report',
					), 
				), 
		)); 
        
	    
		$this->add(array(
			'name' => 'submit',
			'type' => 'Submit', 
			'attributes' => array (
				'value' => 'Add PMS',
				'class' => 'addPms',
				'id'    => 'addPms',
			)
		));
	}
}