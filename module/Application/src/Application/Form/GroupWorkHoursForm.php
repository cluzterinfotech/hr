<?php 
namespace Application\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Application\Model\GroupWorkHours;

class GroupWorkHoursForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('GroupWorkHoursForm');
		$this->setAttribute('method', 'post');
		// 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new GroupWorkHours());
        
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
				'name' => 'locationGroup',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'locationGroup',
						'id' => 'locationGroup',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Group Name*',
				),
		));
        
		$this->add(array(
				'name' => 'eventId',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'eventId',
						'id' => 'eventId',
						'required' => 'required',
						//'maxLength' => 3,
				),
				'options' => array(
						'label' => 'Event*',
				),
		));
        
		$this->add(array(
				'name' => 'DayName',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class'    => 'DayName',
						'id'       => 'DayName',
						'required' => 'required',
						//'value' => '0',
				),
				'options' => array(
						'label' => 'Day*',
						
				),
		));
		
		$this->add(array(
		    'name' => 'Status',
		    'type' => 'Zend\Form\Element\Select',
		    'attributes' => array(
		        'class'    => 'Status',
		        'id'       => 'Status',
		        'required' => 'required',
		        
		        //'value' => '0',
		    ),
		    'options' => array(
		        'label' => 'Status*',
		        'value_options' => array(
		            'N' => 'Normal Day',
		            'H' => 'HoliDay',
		        )
		    ),
		));
		
		$this->add(array(
		    'name' => 'WorkingHours',
		    'type' => 'Zend\Form\Element\Text',
		    'attributes' => array(
		        'class'    => 'WorkingHours',
		        'id'       => 'WorkingHours',
		        'required' => 'required',
		        //'value' => '0',
		    ),
		    'options' => array(
		        'label' => 'Working Hours(HH:MM)*',
		        
		    ),
		));
		
		$this->add(array(
		    'name' => 'startTime',
		    'type' => 'Zend\Form\Element\Text',
		    'attributes' => array(
		        'class'    => 'startTime',
		        'id'       => 'startTime',
		        'required' => 'required',
		        //'value' => '0',
		    ),
		    'options' => array(
		        'label' => 'Starting Time(HH:MM)*',
		        
		    ),
		));
		
		$this->add(array(
		    'name' => 'endTime',
		    'type' => 'Zend\Form\Element\Text',
		    'attributes' => array(
		        'class'    => 'endTime',
		        'id'       => 'endTime',
		        'required' => 'required',
		        //'value' => '0',
		    ),
		    'options' => array(
		        'label' => 'Ending Time(HH:MM)*',
		        
		    ),
		));
         
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Add Bank'
			)
		));
		
	}
}