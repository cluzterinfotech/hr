<?php 
namespace Payment\Form;

use Zend\Form\Element;
use Zend\Form\Form;

class SpecialLoanForm extends Form 
{
	public function __construct($name = null)
	{
		parent::__construct('specialLoanForm'); 
		$this->setAttribute('method', 'post');
		$this->setAttribute('novalidate');
		$this->setAttribute('autocomplete', 'off');
        
		$this->add(array(
			'name' => 'employeeNumberSpecialLoan',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'employeeNumberSpecialLoan',
				'id' => 'employeeNumberSpecialLoan',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Employee Name:*',
				'value_options' => array(
	    		),
			),
		));

		$this->add(array(
			'name' => 'loanDate',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'loanDate',
				'id' => 'loanDate',
				'required' => 'required',
			    'Value' => date('Y-m-d'),
			),
			'options' => array(
				'label' => 'Loan Date',
			    
			),
		)); 

		$this->add(array(
			'name' => 'splLoanAmount',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'splLoanAmount',
				'id' => 'splLoanAmount',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Special Loan Amount',
			),
		)); 

		$this->add(array(
			'name' => 'numberOfMonthsSplLoanDue',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'numberOfMonthsSplLoanDue',
				'id' => 'numberOfMonthsSplLoanDue',
			    //'readOnly' => true,
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Number of Loan Due',
			),
		));
		
		$this->add(array(
			'name' => 'monthlyDue',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'monthlyDue',
				'id' => 'monthlyDue',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Due Amount',
			),
		)); 
		
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Add Special Loan', 
				'class' => 'addSpecialLoan', 
				'id'    => 'addSpecialLoan', 
			)
		)); 
        
	}
}