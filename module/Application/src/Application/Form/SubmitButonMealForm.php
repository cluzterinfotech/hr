<?php 
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Employee\Model\Location;

class SubmitButonMealForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('SubmitButonMealForm');
		$this->setAttribute('method', 'post');
		
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new Location());
        
		$this->add ( array (
				'name' => 'submit',
				'type' => 'submit',
				'attributes' => array (
					'value' => 'Submit'
				) 
		));		 
	} 
}