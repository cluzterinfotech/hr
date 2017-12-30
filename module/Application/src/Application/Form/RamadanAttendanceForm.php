<?php 
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods; 
use Application\Model\RamadanAttendance;

class RamadanAttendanceForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('ramadanAttendanceForm');
		$this->setAttribute('method', 'post'); 
		// 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new RamadanAttendance());
        
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
				'name' => 'Reason',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'Reason',
						'id' => 'Reason',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Reason(Ex: Ramadan/Winter)*',
				),
		));
        
		$this->add(array(
				'name' => 'startingDate',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'startingDate',
						'id' => 'startingDate',
						'required' => 'required',
						//'maxLength' => 3,
				),
				'options' => array(
						'label' => 'Starting Date*',
				),
		));
        
		$this->add(array(
				'name' => 'endingDate',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class'    => 'endingDate',
						'id'       => 'endingDate',
						'required' => 'required',
						//'value' => '0',
				),
				'options' => array(
						'label' => 'Ending Date*',
						
				),
		));
		
		$this->add(array(
				'name' => 'noOfMinutes',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class'    => 'noOfMinutes',
						'id'       => 'noOfMinutes',
						'required' => 'required',
						//'value' => '0',
				),
				'options' => array(
						'label' => 'Total Minutes(Exempted)*',
		
				),
		));
         
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Add Time Exception'
			)
		));
		
	}
}