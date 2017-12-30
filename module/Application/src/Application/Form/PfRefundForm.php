<?php 
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Employee\Model\Location;

class PfRefundForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('pfRefundForm');
		$this->setAttribute('method','post');
		
		$this->setAttribute('novalidate');
		//$this->setHydrator(new ClassMethods(false))->setObject(new Location());
		
		$this->add(array(
			'name' => 'employeeIdPf',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'employeeIdPf',
				'id' => 'employeeIdPf',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Employee Name:*',
				//'value_options' => array(), 
			),
		)); 
		
		$this->add(array(
			'name' => 'refundDate',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'refundDate',
				'id' => 'refundDate',
				'required' => 'required',
				//'readOnly' => true,
			),
			'options' => array(
				'label' => 'Refund Date*',
			),
		));  
		
		$this->add(array(
			'name' => 'refundAmount',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'refundAmount',
				'id' => 'refundAmount',
				'required' => 'required',
				'readOnly' => true,
			),
			'options' => array(
				'label' => 'Refund Amount*',
			),
		));  
		
		$this->add(array(
			'name' => 'chequeNo',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'chequeNo',
				'id' => 'chequeNo',
				'required' => 'required',
				//'readOnly' => true,
			),
			'options' => array(
				'label' => 'Cheque No.*',
			),
		));
		
		$this->add(array(
		    'name' => 'refundFrom',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'refundFrom',
				'id' => 'refundFrom',
				'required' => 'required',
				'readOnly' => true,
			),
			'options' => array(
				'label' => 'Refund From*', 
			),
		));
		
		$this->add(array(
		    'name' => 'refundTo',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'refundTo',
				'id' => 'refundTo',
				'required' => 'required',
				//'readOnly' => true,
			),
			'options' => array(
				'label' => 'Refund To*', 
			),
		));
	    
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
			    'value' => 'Submit'
			) 
		));		 
	} 
}