<?php 
namespace Employee\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Employee\Model\SplHousing;

class SplHousingForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('splHousingForm');
		$this->setAttribute('method', 'post');
		// 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new SplHousing());
        
		$this->add(array(
				'name' => 'id',
				'type' => 'Zend\Form\Element\Hidden',
				'attributes' => array(
						'class' => 'locationId',
						'id' => 'locationId',
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
				'label' => 'Employee Name*',
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
						'label' => 'Amount*',
				),
		));
        
         
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Add Special Housing'
			)
		));
		
	}
}