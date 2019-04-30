<?php 
namespace Allowance\Form; 

use Zend\Form\Element; 
use Zend\Form\Form; 
use Zend\Stdlib\Hydrator\ClassMethods;  
use Allowance\Model\SalaryStructure;

class SalaryStructureForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('salaryStructureForm');
		$this->setAttribute('method','post'); 
		// 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new SalaryStructure());
        
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
			'name' => 'salaryGradeId',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'salaryGradeId',
				'id' => 'salaryGradeId',
				'required' => 'required',
				//'value'    => date('Y'),
			),
			'options' => array(
				'label' => 'Salary Grade*',
					/*'value_options' => array(
							'' => '', 
							'1' => '1',
							'2' => '2',
							'3' => '3',
							'h3' => 'h3',
							'm3' => 'm3',
							's3' => 's3',
							'4' => '4',	
					),*/
			),
		));
        
		$this->add(array(
			'name' => 'minValue',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'minValue',
				'id' => 'minValue',
				'required' => 'required',
				//'maxLength' => 3,
			),
			'options' => array(
				'label' => 'Min Value*',
			),
		));
        
		$this->add(array(
			'name' => 'midValue',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'midValue',
				'id' => 'midValue',
				'required' => 'required',
				//'maxLength' => 3,
			),
	    	'options' => array(
				'label' => 'Mid Value%*',
			),
		)); 
		
		$this->add(array(
			'name' => 'maxValue',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'maxValue',
				'id' => 'maxValue',
				'required' => 'required',
				//'maxLength' => 3,
			),
			'options' => array(
				'label' => 'Max Value%*',
			),
		));
		
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Update Salary Structure'
			)
		));
		
	}
}