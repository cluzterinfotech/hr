<?php  

namespace Employee\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Application\Entity\PositionAllowanceEntity;

class PositionAllowanceForm extends Form 
{
	public function __construct($name = null)
	{
		parent::__construct('positionAllowanceForm');
		$this->setAttribute('method', 'post');
		
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new PositionAllowanceEntity());
        
		$this->add(array(
			'name' => 'id',
			'type' => 'Zend\Form\Element\Hidden',
			'attributes' => array(
				'class' => 'positionAllowanceId',
				'id' => 'positionAllowanceId',
			),
			'options' => array(
				//'label' => 'undefined',
			),
		));
		
		$this->add(array(
			'name' => 'positionName',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class'    => 'positionName',
				'id'       => 'positionName',
				'required' => 'required',
			),
			'options' => array(
				'label'         => 'Position Name*',
				'value_options' => array(
		    	), 
		    ), 
		)); 

		$this->add(array(
			'name' => 'positionAllowanceName',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
	    		'class' => 'positionAllowanceName',
				'id' => 'positionAllowanceName',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Allowance Name',
				'value_options' => array(
				),
			),
		));
		
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
	    		'value' => 'Add'
			)
		));
	}
}
