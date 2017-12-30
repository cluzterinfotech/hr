<?php 
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Employee\Model\Location;
use Application\Model\Policy;

class AddPolicyForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('AddPolicyForm');
		$this->setAttribute('method', 'post');
		
		//$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new Policy());
		
		$this->add(array(
			'name' => 'title',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'Title',
				'id' => 'Title',
				'required' => 'required',
				
			),
			'options' => array(
				'label' => 'Title *',
			),
		));
 		$this->add(array(
			'name' => 'content',
			'type' => 'Zend\Form\Element\Textarea',
			'attributes' => array(
				'class' => 'content',
				'id' => 'content',
				'required' => 'required',
				
			),
			'options' => array(
				'label' => 'content *',
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