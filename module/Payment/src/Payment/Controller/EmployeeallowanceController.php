<?php 
namespace Payment\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
// working with hardship as a sample
class EmployeeallowanceController extends AbstractActionController
{
	public function indexAction()
	{
        return new ViewModel();
	}
	
	/*
	 * @todo 
	 * To check is have this allowance
	 * Add this allowance to corresponding employee
	 * Calculate allowance value
	 * Remove one allowance from employee
	 * 
	 */
    
	
	public function addemployeeallowanceAction()
	{
		$companyEmployee = $this->getServiceLocator()->get('CompanyEmployeeMapper');
		
		return new ViewModel();
	}
	
	public function getEmployeeList() {
		
	}
	
	public function isHaveAllowance() {
		
	}
	
	public function addAllowance() {
		
	}
	
	public function calculateAllowanceValue() {
		
	}
	
	public function removeEmloyeeAllowance() {
		
	}
	
	
}