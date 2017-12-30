<?php 

namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Employee\Model\DifferenceEntity;

class CloseDifferenceForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('differenceForm');
		$this->setAttribute('method','post');
		
		$this->setAttribute('novalidate');
		//$this->setHydrator(new ClassMethods(false))->setObject(new DifferenceEntity());
		
		$this->add(array(
			'name' => 'diffShortDescription',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'diffShortDescription',
				'id' => 'diffShortDescription',
				'required'  => false,
				//'required' => 'required',
			), 
			'options' => array(
				'label' => 'Select Difference', 
				//'value_options' => array(
				//),
			),
		));  
		
		/*$this->add(array(
			'name' => 'diffShortDescription',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class'    => 'diffShortDescription',
				'id'       => 'diffShortDescription',
				'required' => 'required',
				//'readOnly' => true,
				'required'  => true,
			),
			'options' => array(
				'label' => 'Description:*', 
			),
		));*/ 
        
		$this->add ( array (
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array (
				'value' => 'Submit'
			) 
		));		 
	} 
}