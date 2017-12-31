<?php 

namespace Employee\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Employee\Model\AnnivInc;

class AnnivIncrementForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('annivIncrementForm'); 
		$this->setAttribute('method','post'); 
		
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new AnnivInc());
		
		$this->add(array(
			'name' => 'id',
			'type' => 'Zend\Form\Element\Hidden',
			'attributes' => array(
				'class' => 'annivId',
				'id' => 'annivId',
			),
			'options' => array(
				'label' => 'undefined',
			),
		));
		
		$this->add(array(
			'name' => 'employeeId',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'employeeId',
				'id' => 'employeeId',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Employee Name:*',
			),
		));  
		
		$this->add(array(
			'name' => 'oldAmount',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'oldAmount',
				'id' => 'oldAmount',
				'required' => 'required',
				'readOnly' => true, 
			),
			'options' => array(
				'label' => 'Old Initial : *',
			),
		)); 
		
		$this->add(array(
			'name' => 'newAmount',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class'     => 'newAmount',
				'id'        => 'newAmount',
				'required'  => 'required',
			    //'maxLength' => 3,
			),
			'options' => array(
				'label' => 'New Initial : *',
			),
		));
                 
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array (
				'value' => 'Add Promotion',
				'class' => 'addPromotion',
				'id'    => 'addPromotion',
			)
		));	
			
	}
}