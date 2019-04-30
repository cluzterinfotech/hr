<?php 
namespace Payment\Form; 

use Zend\Form\Element; 
use Zend\Form\Form; 
use Payment\Model\OvertimeEntity;
use Zend\Stdlib\Hydrator\ClassMethods; 

class OverTimeManualForm extends Form 
{ 
    public function __construct($name = null) 
    {   
        parent::__construct('OverTimeManualForm');   
        $this->setAttribute('method','post');   
        $this->setAttribute('novalidate','false');    
        $this->setAttribute('autocomplete','off');   
        
        $this->setHydrator(new ClassMethods(false))->setObject(new OvertimeEntity());
        
        $this->add(array(
        	'name' => 'id',
        	'type' => 'Zend\Form\Element\Hidden',
        	'attributes' => array(
        		'class'    => 'otId',
       			'id'       => 'otId',
       			//'required' => 'required',
     			//'readOnly' => 'readOnly',
      			//'value' => '0',
       		),
      		'options' => array(
       			//'label' => 'Employee Name*',
         	),
        ));
        
        $this->add(array( 
        	'name' => 'empIdOvertimeManual', 
        	'type' => 'Zend\Form\Element\Select', 
        	'attributes' => array( 
        		'class'    => 'empIdOvertimeManual', 
        		'id'       => 'empIdOvertimeManual', 
        		'required' => 'required', 
        		//'readOnly' => 'readOnly',  
        		//'value' => '0', 
        	), 
        	'options' => array( 
       			'label' => 'Employee Name*', 
        	),  
        ));  
        
        $this->add(array(
        	'name' => 'employeeNoNOHours',
        	'type' => 'Zend\Form\Element\Text',
        	'attributes' => array(
        		'class'    => 'employeeNoNOHours',
        		'id'       => 'employeeNoNOHours',
        		'required' => 'required',
        		//'value' => '0',
        	),
        	'options' => array(
        		'label' => 'Normal OT Hrs*',
        	),
        )); 
        
        $this->add(array(
        	'name' => 'employeeNoHOHours',
        	'type' => 'Zend\Form\Element\Text',
        	'attributes' => array(
        		'class'    => 'employeeNoHOHours',
        		'id'       => 'employeeNoHOHours',
        		'required' => 'required',
        		//'value' => '0',
        	),
        	'options' => array(
        		'label' => 'Holiday OT Hrs*',
        	),
        )); 
        
        $this->add(array(
        	'name' => 'numberOfMeals',
        	'type' => 'Zend\Form\Element\Text',
        	'attributes' => array(
        		'class'    => 'numberOfMeals',
        		'id'       => 'numberOfMeals',
        		'required' => 'required',
        		//'value' => '0',
        	),
        	'options' => array(
        		'label' => 'No. of Meals*',
        	),
        ));
        
        /*$this->add(array(
        		'name' => 'otFromDate',
        		'type' => 'Zend\Form\Element\Text',
        		'attributes' => array(
        				'class'    => 'otFromDate',
        				'id'       => 'otFromDate',
        				'required' => 'required',
        				//'value' => '0',
        		),
        		'options' => array(
        				'label' => 'Over Time From Date*',
        		),
        ));
        
        $this->add(array(
        		'name' => 'otToDate',
        		'type' => 'Zend\Form\Element\Text',
        		'attributes' => array(
        				'class'    => 'otToDate',
        				'id'       => 'otToDate',
        				'required' => 'required',
        				//'value' => '0',
        		),
        		'options' => array(
        				'label' => 'Over Time To Date*',
        		),
        )); */
        
        $this->add(array(
        		'name' => 'month',
        		'type' => 'Zend\Form\Element\Select',
        		'attributes' => array(
        				'class' => 'month',
        				'id' => 'month',
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
        				//'required' => 'required',
        				//'value'  => date('Y'),
        
        		),
        		'options' => array(
        				'label' => 'Year',
        				//
        				'value_options' => array(
        						'' => '',
        						//'2016' => '2016',
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
			'type' => 'submit', 
			'attributes' => array( 
			    'value' => 'Add Monthly Overtime', 
			    //'class' => 'addEmployeeNoOHours', 
				//'id'    => 'addEmployeeNoOHours', 
			)
		));      
    } 
} 