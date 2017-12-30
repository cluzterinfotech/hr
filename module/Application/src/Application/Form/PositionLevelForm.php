<?php 
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Application\Model\PositionLevel;

class PositionLevelForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('positionLevelForm'); 
		$this->setAttribute('method', 'post');
		// 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new PositionLevel());
        
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
				'name' => 'levelName',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'levelName',
						'id' => 'levelName',
						'required' => 'required',
						//'maxLength' => 3,
				),
				'options' => array(
						'label' => 'Level Name*',
				),
		));
        
		
		
		$this->add(array(
				'name' => 'levelSequence',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class'    => 'levelSequence',
						'id'       => 'levelSequence',
						'required' => 'required',
						//'value' => '0',
				),
				'options' => array(
						'label' => 'level Sequence *',
		
				),
		));
		
         
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Add Level'
			)
		));
		
	}
}