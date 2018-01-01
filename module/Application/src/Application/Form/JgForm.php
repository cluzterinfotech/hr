<?php 
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Application\Model\Religion;
use Application\Model\Jg;

class JgForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('jgForm');
		$this->setAttribute('method', 'post');
		// 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new Jg());
        
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
				'name' => 'jobGrade',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'jobGrade',
						'id' => 'jobGrade',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Job Grade*',
				),
		));
        
		
         
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Add Job Grade'
			)
		));
		
	}
}