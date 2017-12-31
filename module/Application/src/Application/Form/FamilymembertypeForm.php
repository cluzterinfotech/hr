<?php 
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Application\Model\FamilyMemberType;

class FamilymembertypeForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('familyMemberTypeForm');
		$this->setAttribute('method', 'post');
		// 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new FamilyMemberType());
        
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
				'name' => 'memberTypeName',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'memberTypeName',
						'id' => 'memberTypeName',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Family Member Type(Ex: Son,Daughter...)*', 
				),
		));
        
		
         
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Add Family Member Type'
			)
		));
		
	}
}