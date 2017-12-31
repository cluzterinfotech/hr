<?php 
namespace Payment\Form;

use Zend\Form\Element;
use Zend\Form\Form;

class AdvanceSalaryForm extends Form 
{
	public function __construct($name = null)
	{
		parent::__construct('advanceSalaryForm'); 
		$this->setAttribute('method','post');
		$this->setAttribute('novalidate');
		$this->setAttribute('autocomplete', 'off');
        
		$this->add(array(
			'name' => 'employeeNumberAdvSalary',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'employeeNumberAdvSalary',
				'id' => 'employeeNumberAdvSalary',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Employee Name:*',
				'value_options' => array(
				),
			),
		));
        
		$this->add(array(
			'name' => 'advancePaidDate',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'advancePaidDate',
				'id' => 'advancePaidDate',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Advance Paid Date',
			),
		));

		$this->add(array(
			'name' => 'netPay',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'netPay',
				'id' => 'netPay',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Net Pay',
			),
		));

		$this->add(array(
			'name' => 'numberOfMonthsNetPay',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'numberOfMonthsNetPay',
				'id' => 'numberOfMonthsNetPay',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Number of Months Net Pay',
			),
		));

		$this->add(array(
			'name' => 'advanceAmount',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'advanceAmount',
				'id' => 'advanceAmount',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Advance Amount',
			),
		));

		$this->add(array(
			'name' => 'numberOfMonthsDue',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
			    'class' => 'numberOfMonthsDue',
				'id' => 'numberOfMonthsDue',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Number of Months Due',
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
				'value' => 'Add Advance Salary',
				'class' => 'addAdvanceSalary',
				'id'    => 'addAdvanceSalary',
			)
		)); 
        
	}
}