<?php

namespace Employee\Form;

use Zend\Form\Element;
use Zend\Form\Form;


class MismatchReportForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('mismatchReportForm'); 
		$this->setAttribute('method', 'post'); 
		$this->setAttribute('target','_blank');  
		
		$this->add(array(
				'name' => 'empIdMismatch',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
					'class'    => 'empIdMismatch',
					'id'       => 'empIdMismatch',
					//'required' => 'required',
					//'readOnly' => 'readOnly',
					//'value' => '0',
				),
				'options' => array(
					'label' => 'Employee Name',
				),
		)); 
		
		$this->add(array(
				'name' => 'departmentMismatch',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
					'class'    => 'departmentMismatch',
					'id'       => 'departmentMismatch',
				),
				'options' => array(
						'label' => 'Department',
				),
		));
		
		$this->add(array(
				'name' => 'mismatchJobGrade',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
					'class'    => 'mismatchJobGrade',
					'id'       => 'mismatchJobGrade',
				),
				'options' => array(
						'label' => 'Job Grade', 
				),
		)); 
		
		$this->add(array(
			'name' => 'submit',
			'type' => 'Submit',
			'attributes' => array(
				'value' => 'View Mismatch Report',
			),
		)); 
		 
	}
}