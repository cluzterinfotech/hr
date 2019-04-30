<?php 
namespace Payment\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods; 
use Employee\Model\CarRentPositionGroup; 

class PositionGroupForm extends Form 
{ 
	public function __construct($name = null)
	{
		parent::__construct('positionGroupForm');
		$this->setAttribute('method', 'post');
		// 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new CarRentPositionGroup());
        
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
			'name' => 'positionId',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'positionId',
				'id' => 'positionId',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Position Name *', 
			),
		));  
        
		$this->add(array(
			'name' => 'lkpCarRentGroupId', 
			'type' => 'Zend\Form\Element\Select', 
			'attributes' => array( 
				'class' => 'lkpCarRentGroupId', 
				'id' => 'lkpCarRentGroupId', 
				'required' => 'required', 
				//'maxLength' => 3,
			),
			'options' => array(
				'label' => 'Car Rent Group*',
			),
		)); 
        
		/*$this->add(array(
				'name' => 'locationStatus',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
					'class'    => 'locationStatus',
					'id'       => 'locationStatus',
					'required' => 'required',
					//'value' => '0',
				),
				'options' => array(
					'label' => 'Location Status*',
					'value_options' => array(
							''  => '',
							'1' => 'Active',
							'2' => 'InActive',
					),
				),
		));*/  
         
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Add Position Group' 
			)
		));
		
	}
}