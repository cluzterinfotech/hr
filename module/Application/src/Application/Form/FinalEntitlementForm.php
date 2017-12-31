<?php 
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Employee\Model\Location;

class FinalEntitlementForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('SubmitForm');
		$this->setAttribute('method','post');
		
		$this->setAttribute('novalidate');
		//$this->setHydrator(new ClassMethods(false))->setObject(new Location());
		
		$this->add(array(
			'name' => 'employeeNumberFinalEntitlement',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'employeeNumberFinalEntitlement',
				'id' => 'employeeNumberFinalEntitlement',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Employee Name:*',
				//'value_options' => array(
				//),
			),
		)); 
		
		$this->add(array(
			'name' => 'employmentDate',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'employmentDate',
				'id' => 'employmentDate',
				'required' => 'required',
				'readOnly' => true,
			),
			'options' => array(
				'label' => 'Employment Date*',
			),
		)); 
		
		$this->add(array(
			'name' => 'relievingDate',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'relievingDate',
				'id' => 'relievingDate',
				'required' => 'required',
				'readOnly' => true,
			),
			'options' => array(
				'label' => 'Relieving Date*',
			),
		));
		
		$this->add(array(
			'name' => 'yearsOfService',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'yearsOfService',
				'id' => 'yearsOfService',
				'required' => 'required',
				'readOnly' => true,
			),
			'options' => array(
				'label' => 'Years Of Service(YY.MM)*',
			),
		));  
		
		$this->add(array(
		    'name' => 'nonPayDays',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'nonPayDays',
				'id' => 'nonPayDays',
				'required' => 'required',
				'readOnly' => true,
			),
			'options' => array(
				'label' => 'Non Payment Days (Excluded from service)*', 
			),
		));
		
		$this->add(array(
			'name' => 'zeroToTenAmount',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'zeroToTenAmount',
				'id' => 'zeroToTenAmount',
				'required' => 'required',
				'readOnly' => true,
			),
			'options' => array(
				'label' => 'Upto 10 years',
			),
		));
		
		$this->add(array(
			'name' => 'tenToFifteenAmount',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'tenToFifteenAmount',
				'id' => 'tenToFifteenAmount',
				'required' => 'required',
				'readOnly' => true,
			),
			'options' => array(
				'label' => '10 to 20 Years*',
			),
		)); 
		
		$this->add(array(
			'name' => 'fifteenToTwentyAmount',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'fifteenToTwentyAmount',
				'id' => 'fifteenToTwentyAmount',
				'required' => 'required',
				'readOnly' => true,
			),
			'options' => array(
				'label' => '20 to 25 Years*',
			),
		));
		
		$this->add(array(
			'name' => 'twentyToTwentyFiveAmount',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'twentyToTwentyFiveAmount',
				'id' => 'twentyToTwentyFiveAmount',
	    		'required' => 'required',
				'readOnly' => true,
			),
			'options' => array(
				'label' => '25 to 30 years*',
			),
		)); 
		
		$this->add(array(
			'name' => 'twentyFiveandAboveAmount',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'twentyFiveandAboveAmount',
				'id' => 'twentyFiveandAboveAmount',
				'required' => 'required',
				'readOnly' => true,
			),
			'options' => array(
				'label' => '30 and above*',
			),
		)); 
		
		$this->add(array(
			'name' => 'afterServiceBenefitTotal',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'afterServiceBenefitTotal',
				'id' => 'afterServiceBenefitTotal',
				'required' => 'required',
				'readOnly' => true,
			),
			'options' => array(
				'label' => 'Service Benefits*',
			),
		));
		
		$this->add(array(
			'name' => 'balanceLeaveDays',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'balanceLeaveDays',
				'id' => 'balanceLeaveDays',
				'required' => 'required',
				'readOnly' => true,
			),
			'options' => array(
				'label' => 'Balance Leave Days*',
			),
		)); 
		
		$this->add(array(
			'name' => 'leaveDaysAmount',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'leaveDaysAmount',
				'id' => 'leaveDaysAmount',
				'required' => 'required',
				'readOnly' => true,
			),
			'options' => array(
				'label' => 'Leave Days Amount(Employee)*',
			),
		)); 
		
		$this->add(array(
			'name' => 'salaryDifference',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'salaryDifference',
				'id' => 'salaryDifference',
				'required' => 'required',
				'readOnly' => true,
			),
			'options' => array(
				'label' => 'Salary Difference(Employee)*',
			),
		));
		
		$this->add(array(
			'name' => 'salaryDifferenceToCompany',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'salaryDifferenceToCompany',
				'id' => 'salaryDifferenceToCompany',
				'required' => 'required',
				'readOnly' => true,
			),
			'options' => array(
				'label' => 'Salary Difference(Company)*',
			),
		));
		
		/*$this->add(array(
			'name' => 'specialCompensation',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'specialCompensation',
				'id' => 'specialCompensation',
				'required' => 'required',
				'readOnly' => true,
			),
			'options' => array(
				'label' => 'Special Compensation(Employee)*',
			),
		));
		
		$this->add(array(
			'name' => 'specialCompensationToCompany',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'specialCompensationToCompany',
				'id' => 'specialCompensationToCompany',
				'required' => 'required',
				'readOnly' => true,
			),
			'options' => array(
				'label' => 'Special Compensation(Company)*',
			),
		));*/ 
		
		$this->add(array(
			'name' => 'carRent',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'carRent',
				'id' => 'carRent',
				'required' => 'required',
				'readOnly' => true,
			),
			'options' => array(
				'label' => 'Car Rent(Employee)*',
			),
		));
	    
		$this->add(array(
			'name' => 'carRentToCompany',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'carRentToCompany',
				'id' => 'carRentToCompany',
				'required' => 'required',
		    	'readOnly' => true,
			),
			'options' => array(
				'label' => 'Car Rent(Company)*',
			),
		)); 
		
		$this->add(array(
		    'name' => 'carLoanToCompany',
		    'type' => 'Zend\Form\Element\Text',
		    'attributes' => array(
		        'class' => 'carLoanToCompany',
		        'id' => 'carLoanToCompany',
		        'required' => 'required',
		        'readOnly' => true,
		    ),
		    'options' => array(
		        'label' => 'Car Loan(Amortization)*',
		    ),
		));
		
		$this->add(array(
		    'name' => 'splLoanToCompany',
		    'type' => 'Zend\Form\Element\Text',
		    'attributes' => array(
		        'class' => 'splLoanToCompany',
		        'id' => 'splLoanToCompany',
		        'required' => 'required',
		        'readOnly' => true,
		    ),
		    'options' => array(
		        'label' => 'Special Loan(Company)*',
		    ),
		));
		
		$this->add(array(
		    'name' => 'phoneToCompany',
		    'type' => 'Zend\Form\Element\Text',
		    'attributes' => array(
		        'class' => 'phoneToCompany',
		        'id' => 'phoneToCompany',
		        'required' => 'required',
		        'readOnly' => true,
		    ),
		    'options' => array(
		        'label' => 'Telephone(Company)*', 
		    ),
		)); 
		
		$this->add(array(
		    'name' => 'overPaymentToCompany',
		    'type' => 'Zend\Form\Element\Text',
		    'attributes' => array(
		        'class' => 'overPaymentToCompany',
		        'id' => 'overPaymentToCompany',
		        'required' => 'required',
		        'readOnly' => true,
		    ),
		    'options' => array(
		        'label' => 'Over Payment(Company)*',
		    ),
		)); 
		
		$this->add(array(
			'name' => 'leaveDaysToCompany',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'leaveDaysToCompany',
				'id' => 'leaveDaysToCompany',
				'required' => 'required',
				'readOnly' => true,
			),
			'options' => array(
				'label' => 'Leave Days Amount(Company)*', 
			),
		));
		
		$this->add(array(
			'name' => 'leaveAllowanceToEmployee',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'leaveAllowanceToEmployee',
				'id' => 'leaveAllowanceToEmployee',
				'required' => 'required',
				'readOnly' => true,
			),
			'options' => array(
				'label' => 'Leave Allowance(Employee)*',
			),
		));
		
		$this->add(array(
			'name' => 'leaveAllowanceFromEmployeeDesc',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'leaveAllowanceFromEmployeeDesc',
				'id' => 'leaveAllowanceFromEmployeeDesc',
				'required' => 'required',
				'readOnly' => true,
			),
			'options' => array(
				'label' => 'Leave Allowance From Employee(Desc)*',
			),
		));
		
		$this->add(array(
			'name' => 'leaveAllowanceFromEmployee',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'leaveAllowanceFromEmployee',
				'id' => 'leaveAllowanceFromEmployee',
				'required' => 'required',
				'readOnly' => true,
			),
			'options' => array(
				'label' => 'Leave Allowance(Company)*',
			),
		));
		
		$this->add(array(
			'name' => 'personalLoanPending',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'personalLoanPending',
				'id' => 'personalLoanPending',
				'required' => 'required',
		    	'readOnly' => true,
			),
			'options' => array(
				'label' => 'Personal Loan Pending*',
			),
		));
		
		$this->add(array(
			'name' => 'AdvanceSalaryPending',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'AdvanceSalaryPending',
				'id' => 'AdvanceSalaryPending',
				'required' => 'required',
				'readOnly' => true,
			),
			'options' => array(
				'label' => 'Advance Salary Pending*',
			),
		));
		
		$this->add(array(
			'name' => 'advanceHousingPending',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'advanceHousingPending',
				'id' => 'advanceHousingPending',
				'required' => 'required',
				'readOnly' => true,
			),
			'options' => array(
				'label' => 'Advance Housing Pending*',
			),
		));
		
		$this->add(array(
			'name' => 'lastMonthDueToCompany',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'lastMonthDueToCompany',
				'id' => 'lastMonthDueToCompany',
				'required' => 'required',
				'readOnly' => true,
			),
			'options' => array(
				'label' => 'Last Month Salary(Company)*',
			),
		)); 
		
		$this->add(array(
			'name' => 'lastMonthDueFormCompany',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'lastMonthDueFormCompany',
				'id' => 'lastMonthDueFormCompany',
				'required' => 'required',
				'readOnly' => true,
			),
			'options' => array(
				'label' => 'Last Month salary (Employee)*',
			),
		));
		
		$this->add(array(
			'name' => 'totalAllowance',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'totalAllowance',
				'id' => 'totalAllowance',
				'required' => 'required',
				'readOnly' => true,
			),
			'options' => array(
				'label' => 'Total amount to pay*',
			),
		));
		
		$this->add(array(
			'name' => 'totalDeduction',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'totalDeduction',
				'id' => 'totalDeduction',
				'required' => 'required',
				'readOnly' => true,
			),
		    'options' => array(
				'label' => 'Total amount to deduct*', 
			),
		));
		
		$this->add(array(
			'name' => 'finalAmount',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'finalAmount',
				'id' => 'finalAmount',
	    		'required' => 'required',
				'readOnly' => true,
			),
			'options' => array(
				'label' => 'Final Amount*', 
			), 
		)); 
        
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
			    'value' => 'Submit'
			) 
		));		 
	} 
}