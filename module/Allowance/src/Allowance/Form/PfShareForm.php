<?php 
namespace Allowance\Form; 

use Zend\Form\Element; 
use Zend\Form\Form; 
use Zend\Stdlib\Hydrator\ClassMethods; 
use Allowance\Model\PfShare; 

class PfShareForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('pfShareForm');
		$this->setAttribute('method','post'); 
		// 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new PfShare());
        
		$this->add(array(
			'name' => 'id',
			'type' => 'Zend\Form\Element\Hidden',
			'attributes' => array(
				'class' => 'incCriteriaId',
				'id' => 'incCriteriaId',
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
				//'value'    => date('Y'),
			),
			'options' => array(
				'label' => 'Employee Name*',
					'value_options' => array(),
			),
		));
        
		$this->add(array(
			'name' => 'employeeShare',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'employeeShare',
				'id' => 'employeeShare',
				'required' => 'required',
				//'maxLength' => 3,
			),
			'options' => array(
				'label' => 'Employee Share*',
			),
		));
        
		$this->add(array(
			'name' => 'companyShare',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'companyShare',
				'id' => 'companyShare',
				'required' => 'required',
				//'maxLength' => 3,
			),
	    	'options' => array(
				'label' => 'Company Share*',
			),
		)); 
		
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Update'
			)
		));
		
	}
}