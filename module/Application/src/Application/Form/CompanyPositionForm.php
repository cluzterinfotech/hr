<?php 
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Application\Model\Bank;
use Payment\Model\CompanyPosition;

class CompanyPositionForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('companyPositionForm');
		$this->setAttribute('method', 'post');
		// 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new CompanyPosition());
        
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
			'name' => 'positionId',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'positionId',
				'id' => 'positionId',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Position Name*',
			),
		));
		
		$this->add(array(
			'name' => 'companyId',
			'type' => 'Zend\Form\Element\Select', 
			'attributes' => array(
				'class' => 'companyId',
				'id' => 'companyId',
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
				'value' => 'Add Company Position'
			)
		));
		
	}
}