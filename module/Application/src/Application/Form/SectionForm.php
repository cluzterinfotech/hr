<?php 
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Application\Model\Department;
use Application\Model\Section;

class SectionForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('sectionForm');
		$this->setAttribute('method', 'post');
		// 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new Section());
        
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
				'name' => 'sectionName',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'sectionName',
						'id' => 'sectionName',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Section Name*',
				),
		));
        
		$this->add(array(
				'name' => 'sectionCode',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'sectionCode',
						'id' => 'sectionCode',
						'required' => 'required',
						//'maxLength' => 3,
				),
				'options' => array(
						'label' => 'Section Code*',
				),
		));
        
		
		
		$this->add(array(
				'name' => 'department',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class'    => 'department',
						'id'       => 'department',
						'required' => 'required',
						//'value' => '0',
				),
				'options' => array(
						'label' => 'Department *',
		
				),
		));
		
         
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Add Section'
			)
		));
		
	}
}