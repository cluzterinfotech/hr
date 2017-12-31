<?php 
namespace Payment\Form;

use Zend\Form\Element;
use Zend\Form\Form;

class PersonalLoanForm extends Form 
{
	public function __construct($name = null)
	{
		parent::__construct('personalLoanForm'); 
		$this->setAttribute('method', 'post');
		$this->setAttribute('novalidate');
		$this->setAttribute('autocomplete', 'off');
        
		$this->add(array(
			'name' => 'employeeNumberPersonalLoan',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'employeeNumberPersonalLoan',
				'id' => 'employeeNumberPersonalLoan',
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
			),
			'options' => array(
				'label' => 'Loan Date',
			),
		)); 

		$this->add(array(
			'name' => 'loanAmount',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'loanAmount',
				'id' => 'loanAmount',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Personal Loan Amount',
			),
		)); 

		$this->add(array(
			'name' => 'numberOfMonthsLoanDue',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'numberOfMonthsLoanDue',
				'id' => 'numberOfMonthsLoanDue',
			    'readOnly' => true,
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Number of Months Loan Due',
			),
		));
		
		$this->add(array(
		    'name' => 'numberOfMonthsLoanAmt',
		    'type' => 'Zend\Form\Element\Text',
		    'attributes' => array(
		        'class' => 'numberOfMonthsLoanAmt',
		        'id' => 'numberOfMonthsLoanAmt',
		        'required' => 'required',
		        'value'    => 8,
		    ),
		    'options' => array(
		        'label' => 'Number of Months Basic',
		    ),
		));
		
		$this->add(array(
		    'name' => 'basic',
		    'type' => 'Zend\Form\Element\Text',
		    'attributes' => array(
		        'class' => 'basic',
		        'id' => 'basic',
		        'required' => 'required',
		        'readOnly' => true,
		        //'value'    => 8,
		    ),
		    'options' => array(
		        'label' => 'Basic',
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
				'label' => 'Monthly Due Amount',
			),
		)); 
		
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Add Personal Loan', 
				'class' => 'addPersonalLoan', 
				'id'    => 'addPersonalLoan', 
			)
		));
        
	}
}