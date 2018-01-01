<?php  

namespace Employee\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Application\Entity\SalaryGradeAllowanceEntity;

class SalaryGradeAllowanceForm extends Form 
{
	public function __construct($name = null)
	{
		parent::__construct('salaryGradeAllowanceForm');
		$this->setAttribute('method', 'post');
		
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new SalaryGradeAllowanceEntity());
		
		$this->add(array(
			'name' => 'id',
			'type' => 'Zend\Form\Element\Hidden',
			'attributes' => array(
				'class' => 'sgAllowanceId',
				'id' => 'sgAllowanceId',
			),
			'options' => array(
				//'label' => 'undefined',
			),
		));
        
		$this->add(array(
			'name' => 'lkpSalaryGradeId',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class'    => 'lkpSalaryGradeId',
				'id'       => 'lkpSalaryGradeId',
				'required' => 'required',
			),
			'options' => array(
				'label'         => 'Salary Grade*',
				'value_options' => array(
		    	), 
		    ), 
		));

		$this->add(array(
			'name' => 'allowanceId',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
	    		'class' => 'allowanceId',
				'id' => 'allowanceId',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Allowance Name',
				'value_options' => array(
				),
			),
		));

		$this->add(array(
			'name' => 'amount',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'amount',
		    	'id' => 'amount',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Amount*',
			),
		)); 

		$this->add(array(
			'name' => 'isApplicableToAll',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'isApplicableToAll',
				'id' => 'isApplicableToAll',
				'required' => 'required',
	    	),
			'options' => array(
				'label' => 'Is Applicable to All',
				'value_options' => array(
				    ''  => '',
					'0' => 'No',
					'1' => 'Yes'
				),
			),
		)); 
		
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
	    		'value' => 'Add'
			)
		));
	}
}
