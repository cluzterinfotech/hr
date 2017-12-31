<?php 
namespace Lbvf\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Lbvf\Model\Instruction;

class InstructionForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('instructionForm');
		$this->setAttribute('method', 'post');
		// 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new Instruction());
        
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
				'name' => 'LbvfName',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'LbvfName',
						'id' => 'LbvfName',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'LBVF Name',
				),
		));
		
		$this->add(array(
				'name' => 'DeadLine',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'DeadLine',
						'id' => 'DeadLine',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Deadline Nomination & Endorsement:*',
				),
		));
		
		$this->add(array(
				'name' => 'DeadLineAssessment',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'DeadLineAssessment',
						'id' => 'DeadLineAssessment',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Deadline Assessment:*',
				),
		));
		
		$this->add(array(
				'name' => 'NominationEndorsement',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'NominationEndorsement',
						'id' => 'NominationEndorsement',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Open Nomination & Endorsement:*',
						'value_options' => array(
							''  => '',
							'1' => 'Yes',
							'0' => 'No',
						),
				),
		));
		
		$this->add(array(
				'name' => 'AllowAssess',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'AllowAssess',
						'id' => 'AllowAssess',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Open Assessment:*',
						'value_options' => array(
							''  => '',
							'1' => 'Yes',
							'0' => 'No',
						),
				),
		));
		
		$this->add(array(
				'name' => 'AllowReport',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'AllowReport',
						'id' => 'AllowReport',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Open Report:*',
						'value_options' => array(
							''  => '',
							'1' => 'Yes',
							'0' => 'No',
						),
				),
		));
		
		$this->add(array(
				'name' => 'Status',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'Status',
						'id' => 'Status',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'LBVF Status:*',
						'value_options' => array(
							''  => '',
							'1' => 'Active', 
							'0' => 'Closed', 
						),
				),
		)); 
		
		$this->add(array(
				'name' => 'Notes',
				'type' => 'Zend\Form\Element\Textarea',
				'attributes' => array(
						'class' => 'Notes',
						'id' => 'Notes',
						//'required' => 'required',
				),
				'options' => array(
					'label' => 'General Notes for Employees:',
				),
		));  
         
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Add Instruction'
			)
		));
		
	}
}