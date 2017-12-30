<?php 

namespace Leave\Form; 

use Zend\Form\Element; 
use Zend\Form\Form; 
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;
use Leave\Model\LeaveFormEntity;

class AnnualLeaveForm extends Form 
{ 
    public function __construct($name = null) 
    {   
        parent::__construct('annualLeaveForm'); 
        $this->setAttribute('novalidate','novalidate');
        $this->setAttribute('method','post'); 
        
        $this->setHydrator(new ClassMethodsHydrator(false))
             ->setObject(new LeaveFormEntity()); 
        
        $this->add(array( 
            'name' => 'employeeId', 
            'type' => 'Zend\Form\Element\Select', 
            'attributes' => array( 
                'class' => 'employeeNameAnnualLeave', 
                'id' => 'employeeNameAnnualLeave', 
                'required' => 'required', 
            ), 
            'options' => array( 
                'label' => 'Employee Name*',
            ), 
        )); 
        
        $this->add(array( 
            'name' => 'joinDate', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'class'    => 'joinDate', 
                'id'       => 'joinDate', 
                'required' => 'required', 
            	'readOnly' => true
            ), 
            'options' => array( 
                'label' => 'Join Date*', 
            ), 
        )); 
        
        $this->add(array( 
            'name' => 'positionId', 
            'type' => 'Zend\Form\Element\Select', 
            'attributes' => array( 
                'class' => 'positionId', 
                'id' => 'positionId', 
                'required' => 'required', 
            	'readOnly' => true
            ), 
            'options' => array( 
                'label' => 'Position*', 
                /* 'value_options' => array(
                ), */
            ), 
        )); 
        
        $this->add(array( 
            'name' => 'departmentId', 
            'type' => 'Zend\Form\Element\Select', 
            'attributes' => array( 
                'class' => 'departmentId', 
                'id' => 'departmentId', 
                //'required' => 'required', 
            ), 
            'options' => array( 
                'label' => 'Department*', 
                'value_options' => array(
                ),
            ), 
        )); 
        
        $this->add(array( 
            'name' => 'locationId', 
            'type' => 'Zend\Form\Element\Select', 
            'attributes' => array( 
                'class' => 'locationId', 
                'id' => 'locationId', 
                //'required' => 'required', 
            ), 
            'options' => array( 
                'label' => 'Location*', 
                'value_options' => array(
                ),
            ), 
        )); 
        
        $this->add(array( 
            'name' => 'leaveFrom', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'class' => 'leaveFrom', 
                'id' => 'leaveFrom', 
                'required' => 'required',
            	//'readOnly' => true
            ), 
            'options' => array( 
                'label' => 'Leave From Date*', 
            	'hint'  => 'YYY-mm-dd', 
            ), 
        )); 
        
        $this->add(array( 
            'name' => 'leaveTo', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'class' => 'leaveTo', 
                'id' => 'leaveTo', 
                'required' => 'required', 
            	//'readOnly' => true
            ), 
            'options' => array( 
                'label' => 'Leave To Date*', 
            ), 
        )); 
        
        $this->add(array( 
            'name' => 'advanceRequired', 
            'type' => 'Zend\Form\Element\Select', 
            'attributes' => array( 
                'class' => 'advanceRequired', 
                'id' => 'advanceRequired', 
                'required' => 'required', 
            	'value'  => 0,
            ), 
            'options' => array( 
                'label' => 'Advance Salary Required', 
                'value_options' => array(
                	''  => '',
                	'1' => 'Yes',
                    '0' => 'No',  
                ),
            ),  
        )); 
        
        $this->add(array( 
            'name' => 'address', 
            'type' => 'Zend\Form\Element\Textarea', 
            'attributes' => array( 
                'class' => 'address', 
                'id' => 'address', 
                'required' => 'required', 
            ), 
            'options' => array( 
                'label' => 'Address On Leave', 
            ), 
        )); 
        
        $this->add(array( 
            'name' => 'delegatedPositionId', 
            'type' => 'Zend\Form\Element\Select', 
            'attributes' => array( 
                'class' => 'delegatedPositionId', 
                'id' => 'delegatedPositionId', 
                'required' => 'required', 
            ), 
            'options' => array( 
                'label' => 'Delegated Employee*', 
                'value_options' => array(
                ),
            ), 
        )); 
        
        $this->add(array( 
            'name' => 'daysEntitled', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'class' => 'daysEntitled', 
                'id' => 'daysEntitled', 
                'required' => 'required',
            	'readOnly' => true,
            ), 
            'options' => array( 
                'label' => 'Leave Days Entitled(+):', 
            ), 
        )); 
        
        $this->add(array( 
            'name' => 'outstandingBalance', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'class' => 'outstandingBalance', 
                'id' => 'outstandingBalance', 
                'required' => 'required', 
            	'readOnly' => true,
            ), 
            'options' => array( 
                'label' => 'Outstanding Balance:', 
            ), 
        )); 
        
        $this->add(array( 
            'name' => 'daysTaken', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'class' => 'daysTaken', 
                'id' => 'daysTaken', 
                'required' => 'required', 
            	'readOnly' => true,
            ), 
            'options' => array( 
                'label' => 'Days Already Taken(-):', 
            ), 
        ));  
        
        $this->add(array( 
            'name' => 'thisLeaveDays', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'class' => 'thisLeaveDays', 
                'id' => 'thisLeaveDays', 
                'required' => 'required', 
            	'readOnly' => true
            ), 
            'options' => array( 
                'label' => 'Days (This Leave)(-):', 
            ), 
        )); 
           
        $this->add(array( 
            'name' => 'revisedDays', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'class'    => 'revisedDays', 
                'id'       => 'revisedDays', 
                'required' => 'required', 
            	'readOnly' => true,
            	'value'    => 0, 
            ), 
            'options' => array( 
                'label' => 'Revise Holidays(+):', 
            ),  
        ));   
        
        $this->add(array( 
            'name' => 'remainingDays', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'class'    => 'remainingDays', 
                'id'       => 'remainingDays', 
                'required' => 'required', 
            	'readOnly' => true,
            	
            ), 
            'options' => array( 
                'label' => 'Remaining Balance:', 
            ), 
        ));  
        
        $this->add(array(
        	'name' => 'submit',
        	'type' => 'submit',
        	'attributes' => array (
        		'value' => 'Add Annual Leave'
        	)
        )); 
    } 
} 