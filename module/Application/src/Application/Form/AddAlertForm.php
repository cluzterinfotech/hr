<?php 
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Employee\Model\Location;
use Application\Model\Alert;

class AddAlertForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('AddAlertForm');
		$this->setAttribute('method', 'post');
		
		//$this->setAttribute('novalidate');
		//$this->setHydrator(new ClassMethods(false))->setObject(new Alert());
		
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
		    'name' => 'alertId',
		    'type' => 'Zend\Form\Element\Select',
		    'attributes' => array(
		        'class'    => 'alertId',
		        'id'       => 'alertId',
		        'required' => 'required',
		    ),
		    'options' => array(
		        'label'         => 'Alert Type*',
		        'value_options' => array(
		        ),
		    ),
		));
		
		$this->add(array(
		    'name' => 'positionId',
		    'type' => 'Zend\Form\Element\Select',
		    'attributes' => array(
		        'class'    => 'positionId',
		        'id'       => 'positionId',
		        'required' => 'required',
		    ),
		    'options' => array(
		        'label'         => 'Position Name*',
		        'value_options' => array(
		        ),
		    ),
		));
		
		$this->add(array(
		    'name' => 'formula',
		    'type' => 'Zend\Form\Element\Text',
		    'attributes' => array(
		        'class'    => 'formula',
		        'id'       => 'formula',
		        'required' => 'required',
		    ),
		    'options' => array(
		        'label'         => 'Days Befor*',
		        'value_options' => array(
		        ),
		    ),
		));		
		$this->add(array(
		    'name' => 'isCC',
		    'type' => 'Zend\Form\Element\Select',
		    'attributes' => array(
		        'class'    => 'isCC',
		        'id'       => 'isCC',
		        'required' => 'required',
		    ),
		    'options' => array(
		        'label'         => 'IS CC ? *',
		        'value_options' => array(
		        ),
		    ),
		)); 
		$this->add ( array (
				'name' => 'submit',
				'type' => 'submit',
				'attributes' => array (
					'value' => 'Submit'
				) 
		));		 
	} 
}