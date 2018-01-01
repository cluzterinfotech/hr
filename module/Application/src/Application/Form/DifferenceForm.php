<?php 

namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Employee\Model\DifferenceEntity;

class DifferenceForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('differenceForm');
		$this->setAttribute('method','post');
		
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new DifferenceEntity());
		
		$this->add(array(
			'name' => 'differenceFromDate',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class'    => 'differenceFromDate',
				'id'       => 'differenceFromDate',
				'required' => 'required',
	    		'readOnly' => true,
				'required'  => true,
			),
			'options' => array(
				'label' => 'Difference From Date:*',
			),
		));
		
		$this->add(array(
			'name' => 'differenceToDate',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class'    => 'differenceToDate',
				'id'       => 'differenceToDate',
		    	'required' => 'required',
				'readOnly' => true,
				'required'  => true,
			),
			'options' => array(
				'label' => 'Difference To Date:*', 
			),
		));
		
		/*$this->add(array(
			'name' => 'employeeNumberDifference',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'employeeNumberDifference',
				'id' => 'employeeNumberDifference',
				'required'  => false,
				//'required' => 'required',
			),
			'options' => array(
				'label' => 'Employee Name:(optional)',
				//'value_options' => array(
				//),
			),
		)); */ 
		
		$this->add(array(
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