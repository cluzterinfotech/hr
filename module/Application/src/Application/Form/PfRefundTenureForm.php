<?php 
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Employee\Model\Location;

class PfRefundTenureForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('pfRefundForm');
		$this->setAttribute('method','post');
		
		$this->setAttribute('novalidate');
		//$this->setHydrator(new ClassMethods(false))->setObject(new Location());
		
		$this->add(array(
			'name' => 'employeeIdPfTen',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'employeeIdPfTen',
				'id' => 'employeeIdPfTen',
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
				'name' => 'companyShare',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'companyShare',
						'id' => 'companyShare',
						'required' => 'required',
						'readOnly' => true,
				),
				'options' => array(
						'label' => 'Company Share*',
				),
		));
		
		$this->add(array(
				'name' => 'employeeShare',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'employeeShare',
						'id' => 'employeeShare',
						'required' => 'required',
						'readOnly' => true,
				),
				'options' => array(
						'label' => 'Employee Share*',
				),
		));
		
		$this->add(array(
				'name' => 'fivePer',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'fivePer',
						'id' => 'fivePer',
						'required' => 'required',
						'readOnly' => true,
				),
				'options' => array(
						'label' => 'Five Percentage*',
				),
		));
		
		$this->add(array(
				'name' => 'optionalAmount',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'optionalAmount',
						'id' => 'optionalAmount',
						'required' => 'required',
						'readOnly' => true,
				),
				'options' => array(
						'label' => 'Optional Amount*',
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