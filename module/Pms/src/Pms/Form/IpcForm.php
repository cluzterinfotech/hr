<?php

namespace Pms\Form;

use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Form\Element; 
use Zend\Form\Form; 
use Pms\Model\Manage;

class IpcForm extends Form  {
	
	public function __construct($name = null) {
	    	
		parent::__construct('ipcForm'); 
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
			    'rows' => 5, 
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
						'rows' => 5,
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
						'rows' => 4,
				),
				'options' => array(
						'label' => 'Base',
				),
		));
		
		/*$this->add(array(
				'name' => 'Obj_Desc',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'Obj_Desc',
						'id' => 'Obj_Desc',
						'rows' => 5,
				),
				'options' => array(
						'label' => 'Objective',
				),
		));*/
		
		$this->add(array(
				'name' => 'Obj_Stretch_02',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'Obj_Stretch_02',
						'id' => 'Obj_Stretch_02',
						'rows' => 4,
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
						'rows' => 4,
				),
				'options' => array(
						'label' => 'Stretch 1',
				),
		));
	    
	}
}