<?php 
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Employee\Model\IdCard;

class IdCardForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('idCardForm');
		$this->setAttribute('method', 'post');
		// 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new IdCard());
        
		$this->add(array(
			'name' => 'id',
			'type' => 'Zend\Form\Element\Hidden',
			/*'attributes' => array(
				'class' => 'idCardId',
				'id' => 'idCardId',
			),*/
			/*'options' => array(
				'label' => 'undefined',
			),*/ 
		));
        
		$this->add(array(
			'name' => 'employeeIdIdCard',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'employeeIdIdCard',
				'id' => 'employeeIdIdCard', 
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Employee Name*',
			),
		));
        
		$this->add(array(
			'name' => 'idCard',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'idCard',
				'id' => 'idCard',
				'required' => 'required',
				//'maxLength' => 3,
			),
			'options' => array(
				'label' => 'Id Card*',
			),
		));
        
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Add Employee Id Card'
			)
		));
		
	}
}