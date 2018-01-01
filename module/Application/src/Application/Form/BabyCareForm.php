<?php 
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods; 
use Application\Model\BabyCare;

class BabyCareForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('babyCareForm');
		$this->setAttribute('method', 'post'); 
		// 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new BabyCare());
        
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
				'name' => 'employeeNumber',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'employeeNumber',
						'id' => 'employeeNumber',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Employee Name*',
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
		    'name' => 'startingTime',
		    'type' => 'Zend\Form\Element\Text',
		    'attributes' => array(
		        'class' => 'startingTime',
		        'id' => 'startingTime',
		        'required' => 'required',
		        //'maxLength' => 3,
		    ),
		    'options' => array(
		        'label' => 'Starting Time*',
		    ),
		));
		
		$this->add(array(
		    'name' => 'endingTime',
		    'type' => 'Zend\Form\Element\Text',
		    'attributes' => array(
		        'class'    => 'endingTime',
		        'id'       => 'endingTime',
		        'required' => 'required',
		        //'value' => '0',
		    ),
		    'options' => array(
		        'label' => 'Ending Time*', 
		        
		    ),
		));
		
		/*$this->add(array(
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
		));*/
         
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Add Employee Baby Care'
			)
		));
		
	}
}