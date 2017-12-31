<?php 
namespace Employee\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Employee\Model\Location;
use Employee\Model\EmployeeLocation;

class AllowanceListForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('AllowanceListForm');
		$this->setAttribute('method', 'post');
		$this->setAttribute('novalidate');
		//$this->setHydrator(new ClassMethods(false))->setObject(new EmployeeLocation());
        	
		$this->add(array(
				'name' => 'allowanceName',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
					'class'    => 'allowanceName',
					'id'       => 'allowanceName',
					'required' => 'required', 
				),
				'options' => array(
					'label' => 'Allowance List *',
				), 
		)); 
        		
	}
}