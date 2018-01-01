<?php 
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Application\Model\Bank;
use Payment\Model\Company;

class CompanyForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('companyForm');
		$this->setAttribute('method', 'post');
		// 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new Company());
        
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
				'name' => 'companyName',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'companyName',
						'id' => 'companyName',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Company Name*',
				),
		));
        
         
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Add Company'
			)
		));
		
	}
}