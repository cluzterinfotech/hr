<?php 
namespace Employee\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Employee\Model\CommonStatement;

class CommonStatementForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('commonStatementForm');
		$this->setAttribute('method', 'post');
		// 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new CommonStatement());
        
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
				//'required' => 'required',
			),
			'options' => array(
				'label' => 'Employee Name',
			),
		));
        
		$this->add(array(
				'name' => 'bankId',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'bankId',
						'id' => 'bankId',
						'required' => 'required',
						//'maxLength' => 3,
				),
				'options' => array(
						'label' => 'Bank*',
				),
		));
		
		$this->add(array(
				'name' => 'stmtDate',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'stmtDate',
						'id' => 'stmtDate',
						'required' => 'required',
						//'maxLength' => 3,
				),
				'options' => array(
						'label' => 'Statement Date',
				),
		));
		
		$this->add(array(
				'name' => 'Amount',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'Amount',
						'id' => 'Amount',
						'required' => 'required',
						//'maxLength' => 3,
				),
				'options' => array(
						'label' => 'Amount*',
				),
		));
		
		$this->add(array(
				'name' => 'Notes',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'Notes',
						'id' => 'Notes',
						//'required' => 'required',
						//'maxLength' => 3,
				),
				'options' => array(
						'label' => 'Notes',
				),
		));
		
		$this->add(array(
				'name' => 'headerSerial',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'headerSerial',
						'id' => 'headerSerial',
						//'required' => 'required',
						//'maxLength' => 3,
				),
				'options' => array(
						'label' => 'Header Serial',
				),
		));
        
         
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Add Special Housing'
			)
		));
		
	}
}