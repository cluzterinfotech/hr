<?php 
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Application\Model\Religion;

class ReligionForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('religionForm');
		$this->setAttribute('method', 'post');
		// 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new Religion());
        
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
				'name' => 'religionName',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'religionName',
						'id' => 'religionName',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Religion Name*',
				),
		));
        
		
         
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Add Religion'
			)
		));
		
	}
}