<?php 
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Application\Model\Bank;
use Payment\Model\Company;
use Application\Model\Sg;

class SgForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('salGradeForm');
		$this->setAttribute('method', 'post');
		// 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new Sg());
        
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
				'name' => 'salaryGrade',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'salaryGrade',
						'id' => 'salaryGrade',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Salary Grade*',
				),
		));
        
         
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Add Salary Grade'
			)
		));
		
	}
}