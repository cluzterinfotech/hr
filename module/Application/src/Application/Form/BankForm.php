<?php 
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Application\Model\Bank;

class BankForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('bankForm');
		$this->setAttribute('method', 'post');
		// 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new Bank());
        
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
				'name' => 'bankName',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'bankName',
						'id' => 'bankName',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Bank Name*',
				),
		));
        
		$this->add(array(
				'name' => 'branch',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'branch',
						'id' => 'branch',
						'required' => 'required',
						//'maxLength' => 3,
				),
				'options' => array(
						'label' => 'Branch*',
				),
		));
        
		$this->add(array(
				'name' => 'accountNumber',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class'    => 'accountNumber',
						'id'       => 'accountNumber',
						'required' => 'required',
						//'value' => '0',
				),
				'options' => array(
						'label' => 'Account Number*',
						
				),
		));
         
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Add Bank'
			)
		));
		
	}
}