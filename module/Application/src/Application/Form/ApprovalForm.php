<?php   
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Application\Model\TravelAppFormLocal;  
use Zend\Stdlib\Hydrator\ClassMethods; 

class ApprovalForm extends Form {
	
	public function __construct($name = null)
	{   
		parent::__construct('approvalForm'); 
		$this->setAttribute('method','post');
		$this->setAttribute('noValidate','noValidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new TravelAppFormLocal());
		
		$this->add(array(
			'name' => 'id',
			'type' => 'Zend\Form\Element\Hidden'
		)); 
		 
		$this->add(array(
			'name' => 'expenseApproved',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'expenseApproved',
				'id' => 'expenseApproved',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Expenses Approved'
			),
		)); 
        
		$this->add(array(
			'name' => 'approvalType',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'approvalType',
				'id' => 'approvalType',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Approval Type',
				'value_options' => array (
						''    => '',
						'1'   => 'Approve',
						'0'   => 'Reject'
			    ),
    	    ),
	    )); 
		
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array (
				'value' => 'Submit'
			)
		));
        
	}
}