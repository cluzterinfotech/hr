<?php 
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Application\Model\GlassAmountDuration;

class GlassAmountDurationForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('glassAmountDurationForm');
		$this->setAttribute('method', 'post');
		// 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new GlassAmountDuration());
        
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
				'name' => 'amount',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'amount',
						'id' => 'amount',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Amount*', 
				),
		));
		
		$this->add(array(
				'name' => 'durationInYears',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'durationInYears',
						'id' => 'durationInYears',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Duration In Years*',
				),
		));
        
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Add Glass Amount Duration'
			)
		));
		
	}
}