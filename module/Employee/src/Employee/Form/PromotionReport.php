<?php

namespace Employee\Form;

use Zend\Form\Element;
use Zend\Form\Form;


class PromotionReport extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('promotionReportForm'); 
		$this->setAttribute('method', 'post'); 
		$this->setAttribute('target','_blank'); 
		
		$this->add(array(
				'name' => 'empIdPromotion',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
					'class'    => 'empIdPromotion',
					'id'       => 'empIdPromotion',
					//'required' => 'required',
					//'readOnly' => 'readOnly',
					//'value' => '0',
				),
				'options' => array(
					'label' => 'Employee Name',
				),
		)); 
		
		$this->add(array(
				'name' => 'departmentPromotion',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
					'class'    => 'departmentPromotion',
					'id'       => 'departmentPromotion',
				),
				'options' => array(
						'label' => 'Department',
				),
		));
		
		$this->add(array(
				'name' => 'fromDate',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class'    => 'fromDate',
						'id'       => 'fromDate',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Promotion From Date*',
				),
		));
		
		$this->add(array(
				'name' => 'toDate',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class'    => 'toDate',
						'id'       => 'toDate',
						'required' => 'required', 
				),
				'options' => array(
						'label' => 'Promotion To Date*',
				),
		)); 
		
		$this->add(array(
			'name' => 'submit',
			'type' => 'Submit',
			'attributes' => array(
				'value' => 'View Promotion Report',
			),
		)); 
		 
	}
}