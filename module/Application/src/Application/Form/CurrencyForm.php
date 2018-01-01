<?php 
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Application\Model\Currency;

class CurrencyForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('currencyForm');
		$this->setAttribute('method', 'post');
		// 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new Currency());
        
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
				'name' => 'currencyName',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'currencyName',
						'id' => 'currencyName',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Currency Name*',
				),
		));
        
		
         
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Add Currency'
			)
		));
		
	}
}