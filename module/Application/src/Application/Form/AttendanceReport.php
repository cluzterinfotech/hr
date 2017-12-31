<?php

namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;


class AttendanceReport extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('attendanceReportForm'); 
		$this->setAttribute('method', 'post'); 
		$this->setAttribute('target','_blank'); 
		
		$this->add(array(
				'name' => 'empIdAttendance',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
					'class'    => 'empIdAttendance',
					'id'       => 'empIdAttendance',
					//'required' => 'required',
					//'readOnly' => 'readOnly',
					//'value' => '0',
				),
				'options' => array(
					'label' => 'Employee Name',
				),
		)); 
		
		$this->add(array(
				'name' => 'departmentAttendance',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
					'class'    => 'departmentAttendance',
					'id'       => 'departmentAttendance',
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
						'label' => 'Attendance From Date*',
				),
		));
		
		$this->add(array(
				'name' => 'toDate',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class'    => 'otToDate',
						'id'       => 'otToDate',
						'required' => 'required', 
				),
				'options' => array(
						'label' => 'Attendance To Date*',
				),
		)); 
		
		$this->add(array(
				'name' => 'fromTime',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class'    => 'fromTime',
						'id'       => 'fromTime',
						//'required' => 'required',
				),
				'options' => array(
						'label' => 'Starting Time(greater or equal)(HH:MM)',
				),
		));
		$this->add(array(
				'name' => 'toTime',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class'    => 'toTime',
						'id'       => 'toTime',
						//'required' => 'required',
				),
				'options' => array(
						'label' => 'Ending Time(lesser or equal)(HH:MM)',
				),
		));
		
		$this->add(array(
				'name' => 'noAttendanceReason',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class'    => 'noAttendanceReason',
						'id'       => 'noAttendanceReason',
						//'required' => 'required',
						//'readOnly' => 'readOnly',
						//'value' => '0',
				),
				'options' => array(
						'label' => 'Abscent Reason',
				),
		));
		
		$this->add(array(
				'name' => 'reportType',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class'    => 'reportType',
						'id'       => 'reportType',
						//'required' => 'required',
						//'readOnly' => 'readOnly',
						//'value' => '0',
				),
				'options' => array(
					'value_options' => array(
						' '   => ' ',
						'1'  => 'Justified Report',
						'2'  => 'Not Justified Report(Abscent/Late Entry)',
						//'3'  => 'Complete Report'
					),
					'label' => 'Report Type',
				),
		));
		
		$this->add(array(
				'name' => 'locationAttendance',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class'    => 'locationAttendance',
						'id'       => 'locationAttendance',
				),
				'options' => array(
						'label' => 'Location',
				),
		));
		
		$this->add(array(
			'name' => 'submit',
			'type' => 'Submit',
			'attributes' => array(
				'value' => 'View Attendance Report',
			),
		)); 
		 
	}
}