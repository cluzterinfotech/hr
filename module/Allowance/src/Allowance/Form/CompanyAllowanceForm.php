<?php 
namespace Allowance\Form; 

use Zend\Form\Element;
use Zend\Form\Form; 
use Zend\Stdlib\Hydrator\ClassMethods; 

class CompanyAllowanceForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('companyAllowanceForm');
		$this->setAttribute('method', 'post');
		// 
		$this->setAttribute('novalidate');
		// $this->setHydrator(new ClassMethods(false))->setObject(new Location());
        
		$this->add(array(
			'name' => 'id',
			'type' => 'Zend\Form\Element\Hidden',
			'attributes' => array(
				'class' => 'siAllowanceId',
				'id' => 'siAllowanceId',
			),
			'options' => array(
				'label' => 'undefined',
			),
		));
		
		$this->add(array(
			'name' => 'allowanceId',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class'    => 'allowanceId',
				'id'       => 'allowanceId',
				'required' => 'required', 
				//'value' => '0',
			),
			'options' => array(
				'label' => 'Allowance Name*',
			),
		)); 
		
		$this->add(array(
			'name' => 'companyId',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class'    => 'companyId',
				'id'       => 'companyId',
				'required' => 'required',
				//'value' => '0',
			),
			'options' => array(
				'label' => 'Company Name*',
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