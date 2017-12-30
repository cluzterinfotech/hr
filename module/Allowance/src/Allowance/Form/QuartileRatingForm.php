<?php 
namespace Allowance\Form; 

use Zend\Form\Element; 
use Zend\Form\Form; 
use Zend\Stdlib\Hydrator\ClassMethods; 
use Allowance\Model\QuartileRating; 

class QuartileRatingForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('quartileRatingForm');
		$this->setAttribute('method','post'); 
		// 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new QuartileRating());
        
		$this->add(array(
			'name' => 'id',
			'type' => 'Zend\Form\Element\Hidden',
			'attributes' => array(
				'class' => 'incCriteriaId',
				'id' => 'incCriteriaId',
			),
			'options' => array(
				'label' => 'undefined',
			),
		));
		
		$this->add(array(
			'name' => 'Rating',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'Year',
				'id' => 'Year',
				'required' => 'required',
				//'value'    => date('Y'),
			),
			'options' => array(
				'label' => 'Increment Year*',
					'value_options' => array(
							'' => '', 
							'1' => '1',
							'2' => '2',
							'3' => '3',
							'h3' => 'h3',
							'm3' => 'm3',
							's3' => 's3',
							'4' => '4',
							
					),
			),
		));
        
		$this->add(array(
			'name' => 'quartileOne',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'quartileOne',
				'id' => 'quartileOne',
				'required' => 'required',
				//'maxLength' => 3,
			),
			'options' => array(
				'label' => 'Quartile One*',
			),
		));
        
		$this->add(array(
			'name' => 'quartileTwo',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'quartileTwo',
				'id' => 'quartileTwo',
				'required' => 'required',
				//'maxLength' => 3,
			),
	    	'options' => array(
				'label' => 'Quartile Two%*',
			),
		)); 
		
		$this->add(array(
			'name' => 'quartileThree',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'quartileThree',
				'id' => 'quartileThree',
				'required' => 'required',
				//'maxLength' => 3,
			),
			'options' => array(
				'label' => 'Quartile Three%*',
			),
		));
		
		$this->add(array(
			'name' => 'quartileFour',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'quartileFour',
				'id' => 'quartileFour',
				'required' => 'required',
				//'maxLength' => 3,
			),
			'options' => array(
				'label' => 'Quartile Four%*', 
			),
		));
		
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Add Increment Criteria'
			)
		));
		
	}
}