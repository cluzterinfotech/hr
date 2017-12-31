<?php 
namespace Payment\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods; 
use Employee\Model\FamilyMember; 

class FamilyMemberForm extends Form 
{ 
	public function __construct($name = null)
	{
		parent::__construct('familyMemberFormForm');
		$this->setAttribute('method', 'post');
		// 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new FamilyMember());
        
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
			'name' => 'employeeId',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'employeeId',
				'id' => 'employeeId',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Employee Name *', 
			),
		));  
        
		$this->add(array(
			'name' => 'memberTypeId', 
			'type' => 'Zend\Form\Element\Select', 
			'attributes' => array( 
				'class' => 'memberTypeId', 
				'id' => 'memberTypeId', 
				'required' => 'required', 
				//'maxLength' => 3,
			),
			'options' => array(
				'label' => 'Member Type*',
			),
		)); 
        
		$this->add(array(
				'name' => 'memberName',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
					'class'    => 'memberName',
					'id'       => 'memberName',
					'required' => 'required',
					//'value' => '0',
				),
				'options' => array(
					'label' => 'Member Name*',
				),
		));  
         
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Add Family Member' 
			)
		));
		
	}
}