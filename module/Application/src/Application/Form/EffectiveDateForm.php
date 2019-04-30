<?php 
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Employee\Model\EffectiveDate;

class EffectiveDateForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('EffectiveDateForm');
		$this->setAttribute('method', 'post'); 
		
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new EffectiveDate());
		
		$this->add(array(
				'name' => 'effectiveDate', 
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class'    => 'effectiveDate',
						'id'       => 'effectiveDate',
						'required' => 'required',
						'readOnly' => true,
						'required'  => true,
				),
				'options' => array(
						'label' => 'Effective Date*',
				),
		));
        
		$this->add ( array (
				'name' => 'submit',
				'type' => 'submit',
				'attributes' => array (
					'value' => 'Submit'
				) 
		));		 
	} 
}