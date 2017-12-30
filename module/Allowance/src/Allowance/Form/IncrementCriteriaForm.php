<?php 
namespace Allowance\Form; 

use Zend\Form\Element; 
use Zend\Form\Form; 
use Zend\Stdlib\Hydrator\ClassMethods; 
use Allowance\Model\IncrementCriteria; 

class IncrementCriteriaForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('incrementCriteriaForm');
		$this->setAttribute('method','post'); 
		// 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new IncrementCriteria());
        
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
			'name' => 'Year',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'Year',
				'id' => 'Year',
				'required' => 'required',
				'value'    => date('Y'),
			),
			'options' => array(
				'label' => 'Increment Year*',
					'value_options' => array(
							'' => '', 
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
							'2026' => '2026',
							'2027' => '2027',
							'2028' => '2028',
							'2029' => '2029',
							'2030' => '2030',
					),
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
				'label' => 'Join Date(on or Before)*',
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
				'label' => 'Confirmation Date(on or Before)*',
			),
		)); 
		
		$this->add(array(
			'name' => 'incrementFrom',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'incrementFrom',
				'id' => 'incrementFrom',
		    	'required' => 'required',
						//'maxLength' => 3,
			),
			'options' => array(
				'label' => 'Increment From Date*',
			),
		));
		
		$this->add(array(
			'name' => 'incrementTo',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'incrementTo',
				'id' => 'incrementTo',
				'required' => 'required',
				//'maxLength' => 3,
			),
			'options' => array(
				'label' => 'Increment To Date*',
			),
		));
		
		$this->add(array(
			'name' => 'colaPercentage',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'colaPercentage',
				'id' => 'colaPercentage',
				'required' => 'required',
				//'maxLength' => 3,
			),
			'options' => array(
				'label' => 'Cola %*', 
			),
		));
		
		$this->add(array(
			'name' => 'incrementAveragePercentage',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'incrementAveragePercentage',
				'id' => 'incrementAveragePercentage',
				'required' => 'required',
				//'maxLength' => 3,
			),
			'options' => array(
				'label' => 'Increment Average %*',
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