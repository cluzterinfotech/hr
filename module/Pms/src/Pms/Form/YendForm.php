<?php

namespace Pms\Form;

use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Form\Element; 
use Zend\Form\Form; 
use Pms\Model\Manage;

class YendForm extends Form  {
	
	public function __construct($name = null) {
	    	
		parent::__construct('yendForm'); 
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
			'name' => 'Rating',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'Rating',
				'id' => 'Rating',
				//'readOnly' => true,
				//'rows' => 2,
			),
				'options' => array(
						'label' => 'Rating',
				),
		));
		
		$this->add(array(
				'name' => 'Result',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'Result',
						'id' => 'Result',
						'rows' => 4,
				),
				'options' => array(
						'label' => 'Result',
				),
		));
		
		$this->add(array(
				'name' => 'Impact',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'Impact',
						'id' => 'Impact',
						'rows' => 4,
				),
				'options' => array(
						'label' => 'Impact',
				),
		));
		
		$this->add(array(
				'name' => 'Challenges',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'Challenges',
						'id' => 'Challenges',
						'rows' => 4,
				),
				'options' => array(
						'label' => 'Challenges',
				),
		));
        
		$this->add(array(
				'name' => 'Effort',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'Effort',
						'id' => 'Effort',
						'rows' => 4,
				),
				'options' => array(
						'label' => 'Effort',
				),
		));
	    
	}
}