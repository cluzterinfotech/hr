<?php 
namespace Payment\Form; 

use Zend\Form\Element; 
use Zend\Form\Form; 

class OverTimeBatchMealForm extends Form 
{ 
    public function __construct($name = null) 
    { 
        parent::__construct('OverTimeBatchMealForm'); //set form name here
        $this->setAttribute('method','post'); 
        $this->setAttribute('novalidate','false'); 
        $this->setAttribute('autocomplete','off'); 
        
        $this->add(array(
        		'name' => 'month',
        		'type' => 'Zend\Form\Element\Select',
        		'attributes' => array(
        				'class'    => 'month',
        				'id'       => 'month',
        				'required' => 'required',
                                      //  'type' => 'Hidden',
        				//'value' => '0',
                                     // 'disabled' => 'disabled'
//                             'visible'    => 'hidden' 
        		),
        		'options' => array(
        				'label' => 'Select Month*',
                            //123456
                            //  'style' => 'display:none;',
                                         'value_options' => array(
                                        date('F')=> date('F'),
//                                      'January' => 'January',
//                                      'February' => 'February',
//                                      'March' => 'March',
//                                      'April' => 'April',
//                                      'May' => 'May',
//                                      'June' => 'June' ,
//                                      'July' => 'July',
//                                      'August' => 'August',
//                                      'September' => 'September',
//                                      'October' => 'October',
//                                      'November' => 'November' ,
//                                       'December' => 'December' ,  
                                  )
        		),
        ));
        
        
     /*   $this->add(array(
        	'name' => 'overtimeDate',
        	'type' => 'Zend\Form\Element\Text',
        	'attributes' => array(
        		'class'    => 'overtimeDate',
        		'id'       => 'overtimeDate',
        		'required' => 'required',
        		//'value' => '0',
        	),
        	'options' => array(
        		'label' => 'Date *',
        	),
        ));
        */
        $this->add(array(
        	'name' => 'preparedBy',
        	'type' => 'Zend\Form\Element\Select',
        	'attributes' => array(
        		'class'    => 'preparedBy',
        		'id'       => 'preparedBy',
        		'required' => 'required',
        		//'value' => '0',
        	),
        	'options' => array(
        		'label' => 'Prepared By:*',
                      'value_options' => array(
                                      '122' => 'Manal Ismail',
                                      '211' => 'Ahmed Salah '     
                                  )
        	),
        ));
        
          $this->add(array(
        	'name' => 'approvedBy',
        	'type' => 'Zend\Form\Element\Select',
        	'attributes' => array(
        		'class'    => 'approvedBy',
        		'id'       => 'approvedBy',
        		'required' => 'required',
        		//'value' => '0',
        	),
        	'options' => array(
        		'label' => 'Approve By: *',
                    'value_options' => array(
                                      '122' => 'Manal Ismail',
                                      '211' => 'Ahmed Salah '  ,   
                                  )
        	),
        ));
        $this->add(array(
             'name' => 'companyId',
             'type' => 'Zend\Form\Element\Select',
             'attributes' => array(
                     'class'    => 'companyId',
                     'id'       => 'companyId',
                     'required' => 'required',
                     //'value' => '0',
             ),
             'options' => array(
                     'label' => 'Company: *',
                 'value_options' => array(
                                      '1' => 'Permenant',
                                      '2' => 'Contractor',
                                      '3' => 'UN Project'     
                                  )
             ),
     ));
          
         
        $this->add(array( 
			'name' => 'submit', 
			'type' => 'submit', 
			'attributes' => array( 
			    'value' => 'Open New Batch', 
			    'class' => 'opennewbatch', 
				'id'    => 'opennewbatch', 
			)
		));      
    } 
} 