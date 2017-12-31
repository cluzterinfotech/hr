<?php 
namespace Employee\Form;

use Zend\Form\Element;
use Zend\Form\Form;

class TravelingAbroadForm extends Form 
{
	public function __construct($name = null)
	{
		parent::__construct('employee');

		$this->setAttribute('method', 'post');
        
		$this->add(array(
				'name' => 'employeeNumberTravelingLocal',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'employeeNumberTravelingLocal',
						'id' => 'employeeNumberTravelingLocal',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Employee Name:*',
						'value_options' => array(
						),
				),
		));

		$this->add(array(
				'name' => 'travelingFormEmpPosition',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'travelingFormEmpPosition',
						'id' => 'travelingFormEmpPosition',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Employee Position',
						'value_options' => array(
						),
				),
		));

		$this->add(array(
				'name' => 'travelingTo',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'travelingTo',
						'id' => 'travelingTo',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Traveling To',
				),
		));

		$this->add(array(
				'name' => 'purposeOfTrip',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'purposeOfTrip',
						'id' => 'purposeOfTrip',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Purpose Of Trip',
				),
		));

		$this->add(array(
				'name' => 'effectiveFrom',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'effectiveFrom',
						'id' => 'effectiveFrom',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Effective From Date',
				),
		));

		$this->add(array(
				'name' => 'effectiveTo',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'effectiveTo',
						'id' => 'effectiveTo',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Effective To Date',
				),
		));

		$this->add(array(
				'name' => 'expensesRequired',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'expensesRequired',
						'id' => 'expensesRequired',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Expenses Required',
				),
		));

		$this->add(array(
				'name' => 'delegatedEmployee',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'delegatedEmployee',
						'id' => 'delegatedEmployee',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Delegated Employee',
						'value_options' => array(
						),
				),
		));

		$this->add(array(
				'name' => 'meansOfTransport',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'meansOfTransport',
						'id' => 'meansOfTransport',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Means Of Transport',
						'value_options' => array(
						),
				),
		));

		/*$this->add(array(
				'name' => 'text',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'placeholder' => 'Type something...',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Text',
				),
		));*/ 

		$this->add(array(
				'name' => 'fuelLiters',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'fuelLiters',
						'id' => 'fuelLiters',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Fuel Liters',
				),
		));

		$this->add(array(
				'name' => 'classOfAirTicket',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'classOfAirTicket',
						'id' => 'classOfAirTicket',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Class Of Air Ticket',
				),
		));

		$this->add(array(
				'name' => 'classOfHotel',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'classOfHotel',
						'id' => 'classOfHotel',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Class Of Hotel',
				),
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
						'label' => 'Advance Expenses (SDG) :',
				),
		));

		$this->add(array(
				'name' => 'amount',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'amount',
						'id' => 'amount',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Debit (030801 For SDG) :',
				),
		));

		$this->add(array(
				'name' => 'travelingComments',
				'type' => 'Zend\Form\Element\Textarea',
				'attributes' => array(
						'class' => 'travelingComments',
						'id' => 'travelingComments',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Comments :',
				),
		));
		
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Add'
			)
		));
        
	}
}