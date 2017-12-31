<?php 
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Application\Model\Department;

class DepartmentForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('deptForm');
		$this->setAttribute('method', 'post');
		// 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new Department());
        
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
				'name' => 'departmentName',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'departmentName',
						'id' => 'departmentName',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Department Name*',
				),
		));
        
		$this->add(array(
				'name' => 'deptFunctionCode',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'deptFunctionCode',
						'id' => 'deptFunctionCode',
						'required' => 'required',
						//'maxLength' => 3,
				),
				'options' => array(
						'label' => 'Function Code*',
				),
		));
        
		$this->add(array(
				'name' => 'noOfWorkDays',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class'    => 'noOfWorkDays',
						'id'       => 'noOfWorkDays',
						'required' => 'required',
						//'value' => '0',
				),
				'options' => array(
						'label' => 'Working Days',
						
				),
		));
		
		$this->add(array(
				'name' => 'deptAssistantPositionId',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class'    => 'deptAssistantPositionId',
						'id'       => 'deptAssistantPositionId',
						//'required' => 'required',
						//'value' => '0',
				),
				'options' => array(
						'label' => 'Department Assistant',
		
				),
		));
		
		$this->add(array(
				'name' => 'workHoursPerDay',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class'    => 'workHoursPerDay',
						'id'       => 'workHoursPerDay',
						'required' => 'required',
						//'value' => '0',
				),
				'options' => array(
						'label' => 'Working Hours*',
		
				),
		));
         
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Add Department'
			)
		));
		
	}
}