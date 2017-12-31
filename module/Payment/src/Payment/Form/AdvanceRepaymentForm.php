<?php 

namespace Payment\Form; 

use Zend\Form\Form;

class AdvanceRepaymentForm extends Form 
{ 
    public function __construct($name = null) 
    { 
        parent::__construct('advanceRepaymentForm'); 
        $this->setAttribute('method', 'post'); 
        $this->setAttribute('novalidate');
        $this->setAttribute('autocomplete', 'off');
        
        $this->add(array(
        		'name' => 'employeeIdRepayment',
        		'type' => 'Zend\Form\Element\Select',
        		'attributes' => array(
        				'class'    => 'employeeIdRepayment',
        				'id'       => 'employeeIdRepayment',
        				'required' => 'required',
        				//'value' => '0',
        		),
        		'options' => array(
        				'label' => 'Employee *',
        		),
        ));
        
        $this->add(array(
            'name' => 'advanceType',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'class'    => 'advanceType',
                'id'       => 'advanceType',
                'required' => 'required',
                //'value' => '0',
            ),
            'options' => array(
                'label' => 'Advance Type *',
                'value_options' => array(
                    ''               => '',
                    'AdvanceSalary'  => 'Advance Salary',
                    'PersonalLoan'   => 'Personal Loan',
                    'OverPayment'    => 'Over Payment',
                    //'AdvanceHousing' => 'Advance Housing',
                ),
            ),
        ));
        
        $this->add(array( 
            'name' => 'monthsPending', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'class' => 'monthsPending', 
                'id' => 'monthsPending', 
                'required' => 'required',
            	'readOnly' => true, 
            ), 
            'options' => array( 
                'label' => 'Pending Months*', 
            ), 
        )); 
 
        $this->add(array( 
            'name' => 'monthsPaying', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'class' => 'monthsPaying', 
                'id' => 'monthsPaying', 
                'required' => 'required',
            	'maxLength' => 3, 
            ), 
            'options' => array( 
                'label' => 'Paying for Total Months*', 
            ), 
        )); 
        
        $this->add(array(
            'name' => 'monthlyDue',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'monthlyDue',
                'id' => 'monthlyDue',
                'required' => 'required',
                'readOnly' => true,
            ),
            'options' => array(
                'label' => 'Monthly Due *',
            ),
        ));
        
        $this->add(array( 
            'name' => 'amountPending', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'class' => 'amountPending', 
                'id' => 'amountPending', 
                'required' => 'required',
            	'readOnly' => true,
            ), 
            'options' => array( 
                'label' => 'Total Pending Amount *', 
            ), 
        )); 
        
        $this->add(array( 
            'name' => 'amountPaying', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'class' => 'amountPaying', 
                'id' => 'amountPaying', 
                'required' => 'required', 
            	'readOnly' => true,
            ), 
            'options' => array( 
                'label' => 'Amount Paying*', 
            ), 
        )); 
        
        $this->add(array( 
            'name' => 'notes', 
            'type' => 'Zend\Form\Element\TextArea', 
            'attributes' => array( 
                'class' => 'notes', 
                'id' => 'notes', 
                'required' => 'required', 
            	//'readOnly' => true,
            ), 
            'options' => array( 
                'label' => 'Notes', 
            ), 
        )); 
        
        $this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
			    'value' => 'Add Repayment',
			    'class' => 'addRepayment',
				'id'    => 'addRepayment',
			)
		));      
    } 
} 