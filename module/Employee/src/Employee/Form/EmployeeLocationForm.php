<?php 
namespace Employee\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Employee\Model\Location;
use Employee\Model\EmployeeLocation;

class EmployeeLocationForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('EmployeeLocationForm');
		$this->setAttribute('method', 'post');
		// 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new EmployeeLocation());
        
		$this->add(array(
				'name' => 'id',
				'type' => 'Zend\Form\Element\Hidden',
				'attributes' => array(
					'class' => 'id',
					'id' => 'id',
				),
				'options' => array(
					'label' => 'undefined',
				),
		));
        	
		$this->add(array(
				'name' => 'employeeNumber',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
					'class'    => 'employeeNumber',
					'id'       => 'employeeNumber',
					'required' => 'required',
					//'value' => '0',
				),
				'options' => array(
					'label' => 'Employee *',
					/* 'value_options' => array(
	    					''  => '',
							'1' => 'Active',
							'2' => 'InActive',
					), */
				), 
		)); 
        
		$this->add(array(
			'name' => 'empLocation',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class'    => 'empLocation',
				'id'       => 'empLocation',
				'required' => 'required',
				//'value' => '0',
			),
			'options' => array(
				'label' => 'Location *',
				/* 'value_options' => array(
		           ''  => '',
				   '1' => 'Active',
    			   '2' => 'InActive',
				),*/
			),
		)); 
		
		$this->add(array(
			'name' => 'effectiveDate',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class'    => 'effectiveDate',
				'id'       => 'effectiveDate',
				'required' => 'required',
				//'readOnly' => true
			),
			'options' => array(
				'label' => 'Effective Date*',
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