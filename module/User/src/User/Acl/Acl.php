<?php 

namespace User\Acl;

use Zend\Permissions\Acl\Acl as ZendAcl, 
    Zend\Permissions\Acl\Role\GenericRole as Role, 
    Zend\Permissions\Acl\Resource\GenericResource as Resource;

class Acl extends ZendAcl {
	
	const DEFAULT_ROLE = 'guest';
	
	public function __construct() { 
		$this->_addRoles()->_addResources(); 
	}
	
	protected function _addRoles() { 
		$this->addRole(new Role('guest'));	
		$parents = array (
				'guest' 
		);  
		$this->addRole(new Role('employee'),$parents);
		$employee = array('employee');
		//$this->addRole(new Role('hrmanager'),$employee); 
		//$hrmanager = array('hrmanager');
		//$this->addRole(new Role('admin'),$hrmanager); 
		
		$this->addRole(new Role('89'),$parents);
		$planning = array('89');
		$this->addRole(new Role('120'),$planning);
		$service = array('116');
		// 145 HR admin
		$this->addRole(new Role('145'),$employee);
		// 116 HR service
		$this->addRole(new Role('116'),$employee);
		
		$this->addRole(new Role('1'),$parents);
		
		/*
		 * $printClaim = array('print', 'claim', 'report');
		 * $reportClaim = array('claim', 'report');
		 * $this->addRole(new Role('reportclaim'), $reportClaim);
		 * $this->addRole(new Role('printclaim'), $printClaim);
		 */
		return $this; 
	} 
	
	protected function _addResources() {
		
		$this->addResource('User\Controller\User')
		     ->addResource('Application\Controller\Index')
		     ->addResource('Application\Controller\Bank')
		     ->addResource('Application\Controller\Policymanual') 
		     ->addResource('Application\Controller\Department')
		     ->addResource('Application\Controller\Babycareexception')
		     ->addResource('Application\Controller\Attendanceevent') 
		     ->addResource('Application\Controller\Attendanceeventduration')
		     ->addResource('Application\Controller\Attendancelocgroup')
		     ->addResource('Application\Controller\Employeephoto')
		     ->addResource('Application\Controller\Attendancegrpworkhrs')
		     ->addResource('Application\Controller\Attendancegroup')
		     ->addResource('Application\Controller\Ramadanexception')
		     ->addResource('Application\Controller\Company')
		     ->addResource('Application\Controller\Sg')
		     ->addResource('Application\Controller\Jg')
		     ->addResource('Application\Controller\Nationality')
		     ->addResource('Application\Controller\Religion')
		     ->addResource('Application\Controller\Currency')
		     ->addResource('Application\Controller\Section')
		     ->addResource('Lbvf\Controller\Instruction')
		     ->addResource('Lbvf\Controller\Peoplemanagement')
		     ->addResource('Lbvf\Controller\Nomination')
		     ->addResource('Lbvf\Controller\Endorsement')
		     ->addResource('Lbvf\Controller\Assessment')
		     ->addResource('Application\Controller\Familymembertype')
		     ->addResource('Application\Controller\Glassamount')
		     ->addResource('Application\Controller\Usercompanyposition')
		     ->addResource('Position\Controller\Position')
		     ->addResource('Position\Controller\Positiondescription')
		     ->addResource('Employee\Controller\Location')
		     ->addResource('Employee\Controller\Splhousing')
		     ->addResource('Employee\Controller\Commonstatement')
		     ->addResource('Employee\Controller\Allowancespecialamount')
		     ->addResource('Employee\Controller\Jobgrade')
		     ->addResource('Application\Controller\Attendance')
		     ->addResource('Application\Controller\Employeeidcard')
		     ->addResource('Employee\Controller\Employeelocation')
		     ->addResource('Employee\Controller\Travelinglocal')
		     ->addResource('Employee\Controller\Travelingabroad')
		     ->addResource('Employee\Controller\Employeefixedallowance')
		     ->addResource('Employee\Controller\Employeeconfirmation')
		     ->addResource('Employee\Controller\Employeetermination')
		     ->addResource('Application\Controller\alert') 
		     ->addResource('Employee\Controller\Employeesuspend') 
		     ->addResource('Employee\Controller\Employee')
		     ->addResource('Payment\Controller\Paysheet')
		     ->addResource('Payment\Controller\Advancehousing')
		     ->addResource('Payment\Controller\Repaymentadvance')
		     ->addResource('Payment\Controller\Advancesalary')
		     ->addResource('Payment\Controller\Deductionoverpayment')
		     ->addResource('Payment\Controller\Personalloan')
		     ->addResource('Payment\Controller\Specialloan')
		     ->addResource('Payment\Controller\Leaveallowance')
		     ->addResource('Payment\Controller\Bonuscriteria')
		     ->addResource('Payment\Controller\Bonus')
		     ->addResource('Payment\Controller\Glassallowance')
		     ->addResource('Payment\Controller\Familymember')
		     ->addResource('Payment\Controller\Attenjustification')
		     ->addResource('Leave\Controller\Annualleave')
		     ->addResource('Leave\Controller\Leaveadmin')
		     ->addResource('Leave\Controller\Entitlementannualleave')
		     ->addResource('Leave\Controller\Publicholiday')
		     ->addResource('Employee\Controller\Promotion')
		     ->addResource('Position\Controller\Delegation')
		     ->addResource('Position\Controller\Positionmovement')
		     ->addResource('Position\Controller\Positionlevel')
		     ->addResource('Position\Controller\Employeetype')
		     ->addResource('Application\Controller\Openclose')
		     ->addResource('Allowance\Controller\Socialinsuranceallowance')
		     ->addResource('Allowance\Controller\Allowancenottohave')
		     ->addResource('Allowance\Controller\Affectedallowance')
		     ->addResource('Employee\Controller\Telephone')
		     ->addResource('Employee\Controller\Salarygradeallowance')
		     ->addResource('Employee\Controller\Positionallowance')
		     ->addResource('Employee\Controller\Employeeinitial') 
		     ->addResource('Employee\Controller\Increment')
		     ->addResource('Employee\Controller\Employeerating')
		     ->addResource('Payment\Controller\Overtimenew')
		     ->addResource('Payment\Controller\Overtimemanual')
		     ->addResource('Payment\Controller\Otmeal')
		     ->addResource('Payment\Controller\Carrent')
		     ->addResource('Employee\Controller\Newemployee')
		     ->addResource('Employee\Controller\Employeeinfo') 
		     ->addResource('Employee\Controller\Affiliationamount')
		     ->addResource('Payment\Controller\Carrentposition')
		     ->addResource('Payment\Controller\Carrentgroup')
		     ->addResource('Payment\Controller\Amortization') 
		     ->addResource('Payment\Controller\Difference')
		     ->addResource('Payment\Controller\Finalentitlement')
		     ->addResource('Payment\Controller\Pfrefund') 
		     ->addResource('Payment\Controller\Pfrefundtenure')
		     ->addResource('Allowance\Controller\Paysheetallowance')
		     ->addResource('Allowance\Controller\Salarystructure') 
		     ->addResource('Allowance\Controller\Quartilerating')
		     ->addResource('Allowance\Controller\Pfshare')
		     ->addResource('Allowance\Controller\Incrementcriteria')
		     ->addResource('Application\Controller\Checklist')
		     ->addResource('Pms\Controller\Manage')
		     ->addResource('Pms\Controller\Pmsform')
		     ->addResource('Pms\Controller\Myrform')
		     ->addResource('Pms\Controller\Yendform')
		;                          
		
		$this->allow(null,'User\Controller\User')
		     ->allow(null,'Application\Controller\Index')
		     ->allow(null,'Employee\Controller\Travelinglocal') 
		     ->allow(null,'Employee\Controller\Travelingabroad')
		     
		     ->allow('89','Position\Controller\Position')
		     ->allow('89','Employee\Controller\Location')
		     ->allow('89','Employee\Controller\Jobgrade')
		     ->allow('89','Employee\Controller\Employeelocation')
		     ->allow('89','Employee\Controller\Employeeconfirmation')
		     ->allow('89','Employee\Controller\Employeetermination')
		     ->allow('89','Employee\Controller\Employeesuspend')
		     ->allow('89','Employee\Controller\Promotion')
		     ->allow('89','Employee\Controller\Salarygradeallowance')
		     ->allow('89','Employee\Controller\Positionallowance')
		     ->allow('89','Employee\Controller\Employeeinitial')
		     ->allow('89','Employee\Controller\Newemployee')
		     ->allow('89','Position\Controller\Positionmovement')
		     ->allow('89','Employee\Controller\Employeerating') 
		     // 116 Hr Service 
		      	
		     ->allow('89','Application\Controller\Attendance')
		     ->allow('89','Application\Controller\Employeeidcard') 
		     ->allow('89','Payment\Controller\Carrentposition')
		     ->allow('89','Payment\Controller\Carrentgroup')
		     ->allow('89','Payment\Controller\Carrent')
		     ->allow('89','Payment\Controller\Leaveallowance')
		     ->allow('89','Payment\Controller\Difference')
		     ->allow('89','Payment\Controller\Finalentitlement')
		     ->allow('89','Payment\Controller\Advancesalary')
		     ->allow('89','Payment\Controller\Overtimenew')
		     ->allow('89','Payment\Controller\Otmeal')
		     ->allow('89','Payment\Controller\Paysheet')
		     ->allow('89','Employee\Controller\Telephone')
		     ->allow('89','Leave\Controller\Entitlementannualleave')
		     ->allow('89','Leave\Controller\Annualleave')
		      
		     //->allow('hrmanager','Employee\Controller\Affiliationamount')
		     //->allow('hrmanager','Employee\Controller\Employeefixedallowance')
		     //->allow('hrmanager','Allowance\Controller\Paysheetallowance')
		     //->allow('hrmanager','Employee\Controller\Increment')
		     //->allow('hrmanager','Allowance\Controller\Socialinsuranceallowance')
		     //->allow('hrmanager','Allowance\Controller\Allowancenottohave')
		     //->allow('hrmanager','Allowance\Controller\Affectedallowance')
		     //->allow('hrmanager','Application\Controller\Attendance')
		     
		   /*->allow('hrmanager','Position\Controller\Position')  
		     ->allow('hrmanager','Application\Controller\Index') 
		     ->allow('hrmanager','Employee\Controller\Location') 
		     ->allow('hrmanager','Employee\Controller\Jobgrade') 
		     ->allow('hrmanager','Application\Controller\Attendance')
		     ->allow('hrmanager','Employee\Controller\Employeelocation')
		     ->allow('hrmanager','Employee\Controller\Affiliationamount')
		     ->allow('hrmanager','Payment\Controller\Advancesalary') 
		     ->allow('hrmanager','Employee\Controller\Employeefixedallowance')
		     ->allow('hrmanager','Employee\Controller\Employeeconfirmation')
		     ->allow('hrmanager','Employee\Controller\Employeetermination') 
		     ->allow('hrmanager','Employee\Controller\Employeesuspend')
		     ->allow('hrmanager','Allowance\Controller\Paysheetallowance') 
		     ->allow('hrmanager','Employee\Controller\Promotion')
		     ->allow('hrmanager','Employee\Controller\Increment')
		     ->allow('hrmanager','Position\Controller\Positionmovement')
		     ->allow('hrmanager','Allowance\Controller\Socialinsuranceallowance')
		     ->allow('hrmanager','Allowance\Controller\Allowancenottohave')
		     ->allow('hrmanager','Allowance\Controller\Affectedallowance')
		     ->allow('hrmanager','Employee\Controller\Telephone')
		     ->allow('hrmanager','Employee\Controller\Salarygradeallowance') 
		     ->allow('hrmanager','Employee\Controller\Positionallowance')
		     ->allow('hrmanager','Employee\Controller\Employeeinitial') 
		     ->allow('hrmanager','Payment\Controller\Overtimenew')
		     ->allow('hrmanager','Payment\Controller\Otmeal')
		     ->allow('hrmanager','Leave\Controller\Entitlementannualleave') 
		     ->allow('hrmanager','Employee\Controller\Newemployee') 
		     ->allow('hrmanager','Payment\Controller\Carrentposition')
		     ->allow('hrmanager','Payment\Controller\Carrentgroup')
		     ->allow('hrmanager','Payment\Controller\Carrent')
		     ->allow('hrmanager','Payment\Controller\Leaveallowance')
		     ->allow('hrmanager','Payment\Controller\Difference') 
		     ->allow('hrmanager','Payment\Controller\Finalentitlement')*/
		;          
		     http://hrnew/paysheet/payslip
		$this->allow('1'); 
		
	    //$this->deny('1', 'Employee\Controller\Allowancespecialamount');
		$this->allow(null, 'Payment\Controller\Paysheet','payslip');
		//$this->deny('1', 'Leave\Controller\Annualleave','list');
		//$this->deny('1', 'Payment\Controller\Advancehousing','getadvancehousingdetails');
		//$this->deny('admin', 'Employee\Controller\Promotion','getpromotiondetails');
		
		return $this; 
	}
}