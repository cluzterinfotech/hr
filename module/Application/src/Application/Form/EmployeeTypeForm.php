<?php 
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Application\Model\EmployeeType;

class EmployeeTypeForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('employeeTypeForm'); 
		$this->setAttribute('method', 'post');
		// 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new EmployeeType());
        
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
				'name' => 'employeeTypeName',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'employeeTypeName',
						'id' => 'employeeTypeName',
						'required' => 'required',
						//'maxLength' => 3,
				),
				'options' => array(
						'label' => 'Employee Type Name*',
				),
		));
       
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Add Employee Type'
			)
		));
		
	}
}