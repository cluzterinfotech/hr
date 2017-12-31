<?php 
namespace Payment\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;  
use Payment\Model\BonusCriteria;

class BonusCriteriaForm extends Form 
{ 
	public function __construct($name = null)
	{
		parent::__construct('bonusCriteriaForm');
		$this->setAttribute('method', 'post');
		// 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))
		     ->setObject(new BonusCriteria()); 
        
		$this->add(array(
			'name' => 'id',
			'type' => 'Zend\Form\Element\Hidden',
			'attributes' => array(
				'class' => 'bonusCriteriaId',
				'id' => 'bonusCriteriaId',
			),
			'options' => array(
				'label' => 'undefined',
			),
		)); 
		
		$this->add(array(
			'name' => 'year',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'year',
				'id' => 'year',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Year *', 
				'value_options' => array(
					'' => '',
					'2008' => '2008',
					'2009' => '2009',
					'2010' => '2010',
					'2011' => '2011',
					'2012' => '2012',
					'2013' => '2013',
					'2014' => '2014',
					'2015' => '2015',
					'2016' => '2016',
					'2017' => '2017',
					'2018' => '2018',
			    	'2019' => '2019',
					'2020' => '2020',
					'2021' => '2021',
					'2022' => '2022',
					'2023' => '2023',
					'2024' => '2024',
					'2025' => '2025',
				),
			),
		));  
        
		$this->add(array(
			'name' => 'ratingOne', 
			'type' => 'Zend\Form\Element\Text', 
			'attributes' => array( 
				'class' => 'ratingOne', 
				'id' => 'ratingOne', 
				'required' => 'required', 
				//'maxLength' => 3,
			),
			'options' => array(
				'label' => 'Rating 01 *',
			),
		)); 
        
		$this->add(array(
			'name' => 'ratingTwo', 
			'type' => 'Zend\Form\Element\Text', 
			'attributes' => array( 
				'class' => 'ratingTwo', 
				'id' => 'ratingTwo', 
				'required' => 'required', 
				//'maxLength' => 3,
			),
			'options' => array(
				'label' => 'Rating 02 *',
			),
		));  
		
		$this->add(array(
				'name' => 'ratingH3',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'ratingH3',
						'id' => 'ratingH3',
						'required' => 'required',
						//'maxLength' => 3,
				),
				'options' => array(
						'label' => 'Rating H3 *',
				),
		));
		
		$this->add(array(
				'name' => 'ratingS3',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'ratingS3',
						'id' => 'ratingS3',
						'required' => 'required',
						//'maxLength' => 3,
				),
				'options' => array(
						'label' => 'Rating S3 *',
				),
		));
		
		$this->add(array(
				'name' => 'ratingM3',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'ratingM3',
						'id' => 'ratingM3',
						'required' => 'required',
						//'maxLength' => 3,
				),
				'options' => array(
						'label' => 'Rating M3 *',
				),
		));
         
		$this->add(array(
				'name' => 'ratingFour',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'ratingFour',
						'id' => 'ratingFour',
						'required' => 'required',
						//'maxLength' => 3,
				),
				'options' => array(
						'label' => 'Rating 04 *',
				),
		));
		
		$this->add(array(
				'name' => 'joinDate',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'joinDate',
						'id' => 'joinDate',
						'required' => 'required',
						//'maxLength' => 3,
				),
				'options' => array(
						'label' => 'Join Date Before *',
				),
		));
		
		$this->add(array(
				'name' => 'confirmationDate',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'confirmationDate',
						'id' => 'confirmationDate',
						'required' => 'required',
						//'maxLength' => 3,
				),
				'options' => array(
						'label' => 'Confirmation Date Before *',
				),
		));
		
		$this->add(array(
				'name' => 'declarationDate',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'declarationDate',
						'id' => 'declarationDate',
						'required' => 'required',
						//'maxLength' => 3,
				),
				'options' => array(
						'label' => 'Declaration Date Before *',
				),
		));
		
		$this->add(array(
				'name' => 'bonusFrom',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'bonusFrom',
						'id' => 'bonusFrom',
						'required' => 'required',
						//'maxLength' => 3,
				),
				'options' => array(
						'label' => 'Bonus From *',
				),
		));

		$this->add(array(
				'name' => 'bonusTo',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'bonusTo',
						'id' => 'bonusTo',
						'required' => 'required',
						//'maxLength' => 3,
				),
				'options' => array(
						'label' => 'Bonus To *',
				),
		));
		
		$this->add(array(
				'name' => 'bonusType',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'bonusType',
						'id' => 'bonusType',
						'required' => 'required',
						//'maxLength' => 3,
				),
				'options' => array(
						'label' => 'Bonus Type *',
						'value_options' => array( 
								'1' => 'Number Of Months',
								'0' => 'In Percentage',
						)
				),
		));
		
		
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Add Bonus Criteria' 
			)
		));
		
	}
}