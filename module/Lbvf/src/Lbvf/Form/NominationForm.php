<?php 
namespace Lbvf\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Lbvf\Model\Nomination;

class NominationForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('nominationForm');
		$this->setAttribute('method', 'post');
		// 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new Nomination());
        
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
						'label' => 'Employee Name',
						'value_options' => array(
						),
				),
		));
		
		$this->add(array(
				'name' => 'SuperiorName',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'SuperiorName',
						'id' => 'SuperiorName',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Supervisor',
						'value_options' => array(
						),
				),
		));
		
		$this->add(array(
				'name' => 'OthSuperiorName',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'OthSuperiorName',
						'id' => 'OthSuperiorName',
						//'required' => 'required',
				),
				'options' => array(
						'label' => 'Other Supervisor',
						'value_options' => array(
						),
				),
		));
		
		$this->add(array(
				'name' => 'Subordinate01',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'Subordinate01',
						'id' => 'Subordinate01',
						//'required' => 'required',
				),
				'options' => array(
						'label' => 'Subordinate01',
						'value_options' => array(), 
				),
		)); 
		
		$this->add(array(
				'name' => 'Subordinate02',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'Subordinate02',
						'id' => 'Subordinate02',
						//'required' => 'required',
				),
				'options' => array(
						'label' => 'Subordinate02',
						'value_options' => array(),
				),
		));
		
		$this->add(array(
				'name' => 'Subordinate03',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'Subordinate03',
						'id' => 'Subordinate03',
						//'required' => 'required',
				),
				'options' => array(
						'label' => 'Subordinate03',
						'value_options' => array(),
				),
		));
		
		$this->add(array(
				'name' => 'Subordinate04',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'Subordinate04',
						'id' => 'Subordinate04',
						//'required' => 'required',
				),
				'options' => array(
						'label' => 'Subordinate04',
						'value_options' => array(),
				),
		));
		
		$this->add(array(
				'name' => 'Subordinate05',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'Subordinate05',
						'id' => 'Subordinate05',
						//'required' => 'required',
				),
				'options' => array(
						'label' => 'Subordinate05',
						'value_options' => array(),
				),
		));
		
		$this->add(array(
				'name' => 'Subordinate06',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'Subordinate06',
						'id' => 'Subordinate06',
						//'required' => 'required',
				),
				'options' => array(
						'label' => 'Subordinate06',
						'value_options' => array(),
				),
		));
		
		$this->add(array(
				'name' => 'Subordinate07',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'Subordinate07',
						'id' => 'Subordinate07',
						//'required' => 'required',
				),
				'options' => array(
						'label' => 'Subordinate07',
						'value_options' => array(),
				),
		));
		
		$this->add(array(
				'name' => 'Subordinate08',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'Subordinate08',
						'id' => 'Subordinate08',
						//'required' => 'required',
				),
				'options' => array(
						'label' => 'Subordinate08',
						'value_options' => array(),
				),
		));
		
		$this->add(array(
				'name' => 'Subordinate09',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'Subordinate09',
						'id' => 'Subordinate09',
						//'required' => 'required',
				),
				'options' => array(
						'label' => 'Subordinate09',
						'value_options' => array(),
				),
		));
		
		$this->add(array(
				'name' => 'Subordinate10',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'Subordinate10',
						'id' => 'Subordinate10',
						//'required' => 'required',
				),
				'options' => array(
						'label' => 'Subordinate10',
						'value_options' => array(),
				),
		));
		
		$this->add(array(
				'name' => 'Peers01',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'Peers01',
						'id' => 'Peers01',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Peers 01',
						'value_options' => array(),
				),
		));
		
		$this->add(array(
				'name' => 'Peers02',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'Peers02',
						'id' => 'Peers02',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Peers 02',
						'value_options' => array( ),
				),
		));
		
		$this->add(array(
				'name' => 'Peers03',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'Peers03',
						'id' => 'Peers03',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Peers 03',
						'value_options' => array( ),
				),
		));
         
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Add Nomination'
			)
		));
		
	}
}