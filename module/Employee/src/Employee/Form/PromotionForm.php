<?php 

namespace Employee\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Employee\Model\Promotion;

class PromotionForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('promotionForm'); 
		$this->setAttribute('method','post'); 
		
		$this->setAttribute('novalidate');
		//$this->setHydrator(new ClassMethods(false))->setObject(new Promotion());
		
		$this->add(array(
			'name' => 'employeeNumberPromo',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'employeeNumberPromo',
				'id' => 'employeeNumberPromo',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Employee Name:*',
			),
		));
		//
		$this->add(array(
			'name' => 'oldSalaryGrade',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'oldSalaryGrade',
				'id' => 'oldSalaryGrade',
				'required' => 'required',
				'readOnly' => true,
			),
			'options' => array(
				'label' => 'Old Salary Grade:*',
			),
		));
		
		$this->add(array(
			'name' => 'oldInitial',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'oldInitial',
				'id' => 'oldInitial',
				'required' => 'required',
				'readOnly' => true,
			),
			'options' => array(
				'label' => 'Old Initial Salary:*',
			),
		));
		
		$this->add(array(
			'name' => 'tenPercentage',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'tenPercentage',
				'id' => 'tenPercentage',
				'required' => 'required',
				'readOnly' => true,
			),
			'options' => array(
				'label' => 'Ten Percentge:*',
			),
		));
		
		$this->add(array(
			'name' => 'maxQuartileOne',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'maxQuartileOne',
				'id' => 'maxQuartileOne',
				'required' => 'required',
				'readOnly' => true,
			),
			'options' => array(
				'label' => 'Max Quartile 1:*',
			),
		));
		
		$this->add(array(
			'name' => 'difference',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'difference',
		    	'id' => 'difference',
				'required' => 'required',
				'readOnly' => true,
			),
			'options' => array(
				'label' => 'Difference(Ini+10% -Max Quartile):*',
			),
		));
		
		$this->add(array(
			'name' => 'incrementPercentage',
			'type' => 'Zend\Form\Element\Text', 
			'attributes' => array(
				'class' => 'incrementPercentage',
				'id' => 'incrementPercentage',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Increment Percentage:*',
			),
		));
		
		$this->add(array(
			'name' => 'promoSalaryGrade',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'promoSalaryGrade',
				'id' => 'promoSalaryGrade',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Promoted Salary Grade :*',
			),
		));
		
		$this->add(array(
			'name' => 'promotedInitial',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'promotedInitial',
				'id' => 'promotedInitial',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Promoted Initial Salary :*',
			),
		));
		
		$this->add(array(
			'name' => 'togglePromoOption',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'togglePromoOption',
				'id' => 'togglePromoOption',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Toggle Options:*',
				'value_options' => array(
						//''  => '', 
						'1' => 'Salary + 10% of mid value',
						'2' => 'Max Quartile One',
				)
			),
		)); 
                 
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array (
				'value' => 'Add Promotion',
				'class' => 'addPromotion',
				'id'    => 'addPromotion',
			)
		));	
			
	}
}