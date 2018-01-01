<?php  
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Employee\Model\IncrementColaPercentage; 
 
class ApplyIncrementForm extends Form
{ 
	public function __construct($name = null)
	{ 
		parent::__construct('EffectiveDateForm'); 
		$this->setAttribute('method', 'post'); 
		
		$this->setAttribute('novalidate'); 
		$this->setHydrator(new ClassMethods(false))
		     ->setObject(new IncrementColaPercentage());  
		  
		/*$this->add(array(
				'name' => 'applyeEfectiveDate',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'applyeEfectiveDate',
						'id' => 'applyeEfectiveDate',
						'required' => 'required',
						'readOnly' => true,
				),
				'options' => array(
						'label' => 'Effective Date*',
				),
		));
		
		/*$this->add(array(
			'name' => 'incColaPercentage', 
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class'    => 'incColaPercentage',
				'id'       => 'incColaPercentage',
				'required' => 'required',
				//'readOnly' => true,
				'required'  => true,
			),
			'options' => array(
				'label' => 'Cola Percentage*',
			), 
		)); */
        
		$this->add ( array (
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array (
				'value' => 'Submit'
			) 
		));		 
	} 
}