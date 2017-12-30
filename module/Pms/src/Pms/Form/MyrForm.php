<?php

namespace Pms\Form;

use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Form\Element; 
use Zend\Form\Form; 
use Pms\Model\Manage;

class MyrForm extends Form  {
	
	public function __construct($name = null) {
	    	
		parent::__construct('myrForm'); 
		$this->setAttribute('noValidate','noValidate');
		// $this->setHydrator(new ClassMethods(false))->setObject(new Manage());  
		
		$this->add(array(
			'name' => 'ipcids',
			'type' => 'Zend\Form\Element\Hidden',
			'attributes' => array(
				'readOnly' => true,
				'id' => 'ipcids',
			),
		));
		
		$this->add(array(
			'name' => 'Obj_Desc',
			'type' => 'Zend\Form\Element\TextArea',
			'attributes' => array(
				'class' => 'Obj_Desc',
				'id' => 'Obj_Desc',
				'readOnly' => true,
			    'rows' => 3, 
			),
			'options' => array(
				'label' => 'Objective',
			),
		));
		
		$this->add(array(
				'name' => 'Obj_Weightage',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'Obj_Weightage',
						'id' => 'Obj_Weightage',
						'readOnly' => true,
						'maxLength' => 2,
						//'width' => '3px',
				),
				'options' => array(
						'label' => 'Weightage',
				),
		));
		
		$this->add(array(
				'name' => 'Obj_PI',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'Obj_PI',
						'id' => 'Obj_PI',
						'readOnly' => true,
			            'rows' => 3, 
				),
				'options' => array(
						'label' => 'Performance Indicator',
				),
		));
		
		$this->add(array(
				'name' => 'Obj_Base',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'Obj_Base',
						'id' => 'Obj_Base',
						'readOnly' => true,
			            'rows' => 3, 
				),
				'options' => array(
						'label' => 'Base',
				),
		));
        		
		$this->add(array(
				'name' => 'Obj_Stretch_02',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'Obj_Stretch_02',
						'id' => 'Obj_Stretch_02',
						'readOnly' => true,
			            'rows' => 2,
				),
				'options' => array(
						'label' => 'Stretch 2',
				),
		));
		
		$this->add(array(
				'name' => 'Obj_Stretch_01',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'Obj_Stretch_01',
						'id' => 'Obj_Stretch_01',
						'readOnly' => true,
			            'rows' => 2,
				),
				'options' => array(
						'label' => 'Stretch 1',
				),
		));
		
		$this->add(array(
				'name' => 'Myr_Result',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'Myr_Result',
						'id' => 'Myr_Result',
						'rows' => 4,
				),
				'options' => array(
						'label' => 'Result',
				),
		));
		
		$this->add(array(
				'name' => 'Myr_Gap',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'Myr_Gap',
						'id' => 'Myr_Gap',
						'rows' => 4,
				),
				'options' => array(
						'label' => 'Gap',
				),
		));
		
		$this->add(array(
				'name' => 'Myr_Action_Plan',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'Myr_Action_Plan',
						'id' => 'Myr_Action_Plan',
						'rows' => 4,
				),
				'options' => array(
						'label' => 'Action Plan',
				),
		));
		
		
		
		$this->add(array(
				'name' => 'Myr_Superior_Comments',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'Myr_Superior_Comments',
						'id' => 'Myr_Superior_Comments',
						'rows' => 4,
				),
				'options' => array(
						'label' => 'Supervisor Comments',
				),
		));
	    
	}
}