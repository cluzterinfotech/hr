<?php

namespace Leave\Form;

use Zend\Form\Element;
use Zend\Form\Form;


class LeaveReportForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('leaveReport'); 
        // @todo revise fixed month and year values 
		$this->setAttribute('method', 'post');  
		$this->setAttribute('target','_blank');  
		
		$this->add(array(
			'name' => 'employeeLeaveReport',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'employeeLeaveReport',
				'id' => 'employeeLeaveReport',
				// 'required' => 'required',
			),
			'options' => array(
				'label' => 'Employee Name',
			),
		)); 
		
		$this->add(array(
		    'name' => 'leaveDepartment',
		    'type' => 'Zend\Form\Element\Select',
		    'attributes' => array(
		        'class' => 'leaveDepartment',
		        'id' => 'leaveDepartment',
		        // 'required' => 'required',
		    ),
		    'options' => array(
		        'label' => 'Department',
		    ),
		)); 
		
		$this->add(array(
		    'name' => 'leaveLocation',
		    'type' => 'Zend\Form\Element\Select',
		    'attributes' => array(
		        'class' => 'leaveLocation',
		        'id' => 'leaveLocation',
		        // 'required' => 'required',
		    ),
		    'options' => array(
		        'label' => 'Location',
		    ),
		));
		
		$this->add(array(
			'name' => 'leaveTypeReport',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'leaveTypeReport',
				'id' => 'leaveTypeReport',
				// 'required' => 'required',
			),
			'options' => array(
				'label' => 'Leave Type',
			),
		)); 
		
		$this->add(array( 
			'name' => 'month', 
			'type' => 'Zend\Form\Element\Select',  
			'attributes' => array (
				'class'  => 'month', 
				'id'     => 'month', 
			    //'required' => 'required', 
				//'value'  => date('m'),  
			),    
			'options' => array( 
				'label' => 'Month', 
				'value_options' => array( 
					''   => '', 
					'1'  => 'January', 
					'2'  => 'February', 
					'3'  => 'March',
					'4'  => 'April',
					'5'  => 'May',
					'6'  => 'June',
					'7'  => 'July',
					'8'  => 'August',
					'9'  => 'September',
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
					// 'required' => 'required', 
					'value'  => date('Y'), 	
				), 
				'options' => array(
					'label' => 'Year',
					//
					'value_options' => array(
						//'' => '',
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
			'name' => 'submit',
			'type' => 'Submit',
			'attributes' => array(
				'value' => 'View Report',
			),
		)); 
		
	}
}