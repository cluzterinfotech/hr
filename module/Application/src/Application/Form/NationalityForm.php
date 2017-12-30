<?php 
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Application\Model\Nationality;

class NationalityForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('nationalityForm');
		$this->setAttribute('method', 'post');
		// 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new Nationality());
        
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
				'name' => 'nationalityName',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'nationalityName',
						'id' => 'nationalityName',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Nationality Name*',
				),
		));
        
		
         
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Add Nationality'
			)
		));
		
	}
}