<?php 
namespace Leave\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods; 
use Leave\Model\LeaveAdmin;

class LeaveAdminForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('leaveAdminForm');
		$this->setAttribute('method', 'post');
		// 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new LeaveAdmin());
        
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
			'name' => 'employeeId',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'employeeId',
				'id' => 'employeeId',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Employee Name*',
			),
		));
        
		$this->add(array(
			'name' => 'LkpLeaveTypeId',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'LkpLeaveTypeId',
				'id' => 'LkpLeaveTypeId',
				'required' => 'required', 
			),
			'options' => array(
				'label' => 'Leave Type*',
			),
		));
        
		
		
		
		$this->add(array(
			'name' => 'leaveFromDate',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class'    => 'leaveFromDate',
				'id'       => 'leaveFromDate',
				'required' => 'required',
						//'value' => '0',
			),
			'options' => array(
				'label' => 'Leave From*',
			),
		));
		
		$this->add(array(
				'name' => 'leaveToDate',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class'    => 'leaveToDate',
						'id'       => 'leaveToDate',
						'required' => 'required',
						//'value' => '0',
				),
				'options' => array(
						'label' => 'Leave To*',
				),
		));
		
		$this->add(array(
				'name' => 'isLeaveAllowanceRequired',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class'    => 'isLeaveAllowanceRequired',
						'id'       => 'isLeaveAllowanceRequired',
						//'required' => 'required',
						'value' => '0',
				),
				'options' => array(
						'label' => 'Leave Allowance Required*',
						'value_options' => array(
								''  => '',
								'1' => 'Yes',
								'0' => 'No',
						),
				),
		));
		
		$this->add(array(
				'name' => 'isAdvanceSalaryRequired',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class'    => 'isAdvanceSalaryRequired',
						'id'       => 'isAdvanceSalaryRequired',
						//'required' => 'required',
						'value' => '0',
				),
				'options' => array(
						'label' => 'Leave Advance Required*',
						'value_options' => array(
								''  => '',
								'1' => 'Yes',
								'0' => 'No',
						),
				),
		));
		
		$this->add(array(
				'name' => 'daysApproved',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class'    => 'daysApproved',
						'id'       => 'daysApproved',
						'required' => 'required',
						//'value' => '0',
				),
				'options' => array(
						'label' => 'Days Approved*',
				),
		));
		
		$this->add(array(
				'name' => 'address',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class'    => 'address',
						'id'       => 'address',
						'required' => 'required',
						//'value' => '0',
				),
				'options' => array(
						'label' => 'Address*',
				),
		));
		
		$this->add(array(
				'name' => 'holidayLieu',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class'    => 'holidayLieu',
						'id'       => 'holidayLieu',
						'required' => 'required',
						'value' => '0',
				),
				'options' => array(
						'label' => 'Holiday Lieu*',
				),
		));
		
		
		
		$this->add(array(
				'name' => 'publicHoliday',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class'    => 'publicHoliday',
						'id'       => 'publicHoliday',
						'required' => 'required',
						'value' => '0',
				),
				'options' => array(
						'label' => 'Public Holiday*',
				),
		));
		
		$this->add(array(
				'name' => 'leaveYear',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class'    => 'leaveYear',
						'id'       => 'leaveYear',
						'required' => 'required',
						'value' => date('Y'),
				),
				'options' => array(
						'label' => 'Leave Year*',
				),
		));
		
		$this->add(array(
				'name' => 'leaveAddedDate',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class'    => 'leaveAddedDate',
						'id'       => 'leaveAddedDate',
						'readOnly' => true,
						'required' => 'required',
						'value' => date('Y-m-d'),
				),
				'options' => array(
						'label' => 'Added Date*',
				),
		));
         
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Add Leave'
			)
		));
		
	}
}