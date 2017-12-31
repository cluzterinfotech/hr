<?php 
namespace Lbvf\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Lbvf\Model\PeopleManagement; 

class PeopleManagementForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('peopleManagementForm');
		$this->setAttribute('method', 'post');
		// 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new PeopleManagement());
        
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
				'name' => 'employeeNumber',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'employeeNumber',
						'id' => 'employeeNumber',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Employee Name*',
				),
		));
        
		$this->add(array(
			'name' => 'Role01',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'Role01',
				'id' => 'Role01',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Role (For Event 01) :',
				'value_options' => array(),
			),
		));
		
		$this->add(array(
			'name' => 'duration01',
			'type' => 'Zend\Form\Element\Textarea',
			'attributes' => array(
				'class' => 'duration01',
				'id' => 'duration01',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Duration:',
			),
		));
		
		$this->add(array(
			'name' => 'lOI01',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'lOI01',
				'id' => 'lOI01',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Level Of Involvement',
				'value_options' => array(),
		    ),
		));
		
		$this->add(array(
			'name' => 'content01',
			'type' => 'Zend\Form\Element\Textarea',
			'attributes' => array(
				'class' => 'content01',
				'id' => 'content01',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'People Management/ Staff Involvement :',
			),
		)); 
		
		
		$this->add(array(
				'name' => 'Role02',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'Role02',
						'id' => 'Role02',
						//'required' => 'required',
				),
				'options' => array(
						'label' => 'Role (For Event 02) :',
						'value_options' => array(),
				),
		));
		
		$this->add(array(
				'name' => 'duration02',
				'type' => 'Zend\Form\Element\Textarea',
				'attributes' => array(
						'class' => 'duration02',
						'id' => 'duration02',
						//'required' => 'required',
				),
				'options' => array(
						'label' => 'Duration:',
				),
		));
		
		$this->add(array(
				'name' => 'lOI02',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'lOI02',
						'id' => 'lOI02',
						//'required' => 'required',
				),
				'options' => array(
						'label' => 'Level Of Involvement',
						'value_options' => array(),
				),
		));
		
		$this->add(array(
				'name' => 'content02',
				'type' => 'Zend\Form\Element\Textarea',
				'attributes' => array(
						'class' => 'content02',
						'id' => 'content02',
						//'required' => 'required',
				),
				'options' => array(
						'label' => 'People Management/ Staff Involvement :',
				),
		));
		
		$this->add(array(
				'name' => 'Role03',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'Role03',
						'id' => 'Role03',
						//'required' => 'required',
				),
				'options' => array(
						'label' => 'Role (For Event 03) :',
						'value_options' => array(),
				),
		));
		
		$this->add(array(
				'name' => 'duration03',
				'type' => 'Zend\Form\Element\Textarea',
				'attributes' => array(
						'class' => 'duration03',
						'id' => 'duration03',
						//'required' => 'required',
				),
				'options' => array(
						'label' => 'Duration:',
				),
		));
		
		$this->add(array(
				'name' => 'lOI03',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'lOI03',
						'id' => 'lOI03',
						//'required' => 'required',
				),
				'options' => array(
						'label' => 'Level Of Involvement',
						'value_options' => array(),
				),
		));
		
		$this->add(array(
				'name' => 'content03',
				'type' => 'Zend\Form\Element\Textarea',
				'attributes' => array(
						'class' => 'content03',
						'id' => 'content03',
						//'required' => 'required',
				),
				'options' => array(
						'label' => 'People Management/ Staff Involvement :',
				),
		));
         
		$this->add(array(
				'name' => 'Role04',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'Role04',
						'id' => 'Role04',
						//'required' => 'required',
				),
				'options' => array(
						'label' => 'Role (For Event 04) :',
						'value_options' => array(),
				),
		));
		
		$this->add(array(
				'name' => 'duration04',
				'type' => 'Zend\Form\Element\Textarea',
				'attributes' => array(
						'class' => 'duration04',
						'id' => 'duration04',
						//'required' => 'required',
				),
				'options' => array(
						'label' => 'Duration:',
				),
		));
		
		$this->add(array(
				'name' => 'lOI04',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'lOI04',
						'id' => 'lOI04',
						//'required' => 'required',
				),
				'options' => array(
						'label' => 'Level Of Involvement',
						'value_options' => array(),
				),
		));
		
		$this->add(array(
				'name' => 'content04',
				'type' => 'Zend\Form\Element\Textarea',
				'attributes' => array(
						'class' => 'content04',
						'id' => 'content04',
						//'required' => 'required',
				),
				'options' => array(
						'label' => 'People Management/ Staff Involvement :',
				),
		));
		
		$this->add(array(
				'name' => 'Role05',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'Role05',
						'id' => 'Role05',
						//'required' => false,
				),
				'options' => array(
						'label' => 'Role (For Event 05) :',
						'value_options' => array(),
				),
		));
		
		$this->add(array(
				'name' => 'duration05',
				'type' => 'Zend\Form\Element\Textarea',
				'attributes' => array(
						'class' => 'duration05',
						'id' => 'duration05',
						//'required' => 'required',
				),
				'options' => array(
						'label' => 'Duration:',
				),
		));
		
		$this->add(array(
				'name' => 'lOI05',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'lOI05',
						'id' => 'lOI05',
						//'required' => 'required',
				),
				'options' => array(
						'label' => 'Level Of Involvement',
						'value_options' => array(),
				),
		));
		
		$this->add(array(
				'name' => 'content05',
				'type' => 'Zend\Form\Element\Textarea',
				'attributes' => array(
						'class' => 'content05',
						'id' => 'content05',
						//'required' => 'required',
				),
				'options' => array(
						'label' => 'People Management/ Staff Involvement :',
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