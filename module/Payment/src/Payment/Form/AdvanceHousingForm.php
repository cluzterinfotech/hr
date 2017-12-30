<?php 

namespace Payment\Form; 

use Zend\Form\Element; 
use Zend\Form\Form; 

class AdvanceHousingForm extends Form 
{ 
    public function __construct($name = null) 
    { 
        parent::__construct('advanceHousingForm'); 
        $this->setAttribute('method', 'post'); 
        $this->setAttribute('novalidate');
        $this->setAttribute('autocomplete', 'off');
        
        $this->add(array(
        		'name' => 'employeeNumberHousing',
        		'type' => 'Zend\Form\Element\Select',
        		'attributes' => array(
        				'class'    => 'employeeNumberHousing',
        				'id'       => 'employeeNumberHousing',
        				'required' => 'required',
        				//'value' => '0',
        		),
        		'options' => array(
        				'label' => 'Employee *',
        		),
        ));
        
        $this->add(array( 
            'name' => 'advanceHousingFromDate', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'class' => 'advanceHousingFromDate', 
                'id' => 'advanceHousingFromDate', 
                'required' => 'required',
            	'readOnly' => true, 
            ), 
            'options' => array( 
                'label' => 'From Date*', 
            ), 
        )); 
 
        $this->add(array( 
            'name' => 'numberOfMonthsHousing', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'class' => 'numberOfMonthsHousing', 
                'id' => 'numberOfMonthsHousing', 
                'required' => 'required',
            	'maxLength' => 2, 
            ), 
            'options' => array( 
                'label' => 'Number Of Months Housing*', 
            ), 
        )); 
        
        $this->add(array( 
            'name' => 'housingAmount', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'class' => 'housingAmount', 
                'id' => 'housingAmount', 
                'required' => 'required',
            	'readOnly' => true,
            ), 
            'options' => array( 
                'label' => 'Advance Housing Amount *', 
            ), 
        )); 
        
        $this->add(array( 
            'name' => 'housingTax', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'class' => 'housingTax', 
                'id' => 'housingTax', 
                'required' => 'required', 
            	'readOnly' => true,
            ), 
            'options' => array( 
                'label' => 'Tax Amount*', 
            ), 
        )); 
        
        $this->add(array( 
            'name' => 'housingNetAmount', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'class' => 'housingNetAmount', 
                'id' => 'housingNetAmount', 
                'required' => 'required', 
            	'readOnly' => true,
            ), 
            'options' => array( 
                'label' => 'Net Amount*', 
            ), 
        )); 
        
        $this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
			    'value' => 'Add Advance Housing',
			    'class' => 'addAdvanceHousing',
				'id'    => 'addAdvanceHousing',
			)
		));      
    } 
} 