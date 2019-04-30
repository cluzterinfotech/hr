<?php 
namespace Payment\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods; 
use Employee\Model\CarRentPositionGroup; 
use Employee\Model\CarRentLkpGroup;

class PositionGroupLkpForm extends Form 
{ 
	public function __construct($name = null)
	{
		parent::__construct('positionGroupLkpForm');
		$this->setAttribute('method', 'post');
		// 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))
		     ->setObject(new CarRentLkpGroup()); 
        
		$this->add(array(
			'name' => 'id',
			'type' => 'Zend\Form\Element\Hidden',
			'attributes' => array(
				'class' => 'positionGroupId',
				'id' => 'positionGroupId',
			),
			'options' => array(
				'label' => 'undefined',
			),
		));
        
		$this->add(array(
			'name' => 'groupName',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'groupName',
				'id' => 'groupName',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Group Name *', 
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
			'name' => 'Notes', 
			'type' => 'Zend\Form\Element\Text', 
			'attributes' => array( 
				'class' => 'Notes', 
				'id' => 'Notes', 
				'required' => 'required', 
				//'maxLength' => 3,
			),
			'options' => array(
				'label' => 'Notes *',
			),
		));  
         
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Add Car Rent Group' 
			)
		));
		
	}
}