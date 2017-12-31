<?php

namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;


class FunctionBankMonthYear extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('functionBankMonthYear');
        // @todo revise fixed month and year values
		$this->setAttribute('method', 'post'); 
		$this->setAttribute('target','_blank'); 
		
		
		
		$this->add(array(
			'name' => 'month',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'month',
				'id' => 'month',
				//'required' => 'required',
				'value'  => date('m'), 
			),
			'options' => array(
				'label' => 'Month',
				'value_options' => array(
					''   => '',
					'01'  => 'January',
					'02'  => 'February',
					'03'  => 'March',
					'04'  => 'April',
					'05'  => 'May',
					'06'  => 'June',
					'07'  => 'July',
					'08'  => 'August',
					'09'  => 'September',
					'10' => 'October',
					'11' => 'November',
					'12' => 'December',
				),
			),
		));

		$this->add(array(
				'name' => 'year',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'year',
						'id' => 'year',
						//'required' => 'required',
						'value'  => date('Y'),
						
				),
				'options' => array(
						'label' => 'Year',
						//
						'value_options' => array(
								'' => '',
								'2008' => '2008',
								'2009' => '2009',
								'2010' => '2010',
								'2011' => '2011',
								'2012' => '2012',
								'2013' => '2013',
								'2014' => '2014',
								'2015' => '2015',
								'2016' => '2016',
								'2017' => '2017',
								'2018' => '2018',
								'2019' => '2019',
								'2020' => '2020',
								'2021' => '2021',
								'2022' => '2022',
								'2023' => '2023',
								'2024' => '2024',
								'2025' => '2025',
						),
				),
	    )); 
		
		$this->add(array(
			'name' => 'Bank',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'Bank',
				'id' => 'Bank',
				'required' => false,
			),
			'options' => array(
				'label' => 'Bank',
				'value_options' => array(),
			),
		));
		
		$this->add(array(
			'name' => 'reportType',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'reportType',
				'id' => 'reportType',
				'required' => false,
			),
			'options' => array(
				'label' => 'Report Type',
				'value_options' => array(
						'' => '',
						'1' => 'By Function',
						'2' => 'By Bank',
						'3' => 'Bank Summary',
				),
		    ),
		)); 
		
		$this->add(array(
			'name' => 'submit',
			'type' => 'Submit',
			'attributes' => array(
				'value' => 'View Report',
			),
		)); 
		
	}
}