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
        
        $this->addRole(new Role('adminService'),$employee);
        $adminService = array('adminService');
        
        $this->addRole(new Role('planning'),$employee);
        $planning = array('planning');
        
        $this->addRole(new Role('payroll'),$employee);
        $payroll = array('payroll');                
         
        $this->addRole(new Role('planningmg'),$planning);
        $planningmg = array('planningmg');
                
        
        $this->addRole(new Role('hrmanager'),$employee);
        $hrmanager = array('hrmanager');
        
        $this->addRole(new Role('admin'),$hrmanager);
        
       /* $this->addRole(new Role('34'),$parents);
        $planning = array('34');
        $this->addRole(new Role('120'),$planning);*/
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
        ->addResource('Application\Controller\alert')
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
        ->addResource('Payment\Controller\Overtimebyemp')
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
        /** Employee Role */
        ->allow('employee','Employee\Controller\Travelinglocal')
        ->deny('employee','Employee\Controller\Travelinglocal' , 'reportadmin')
        ->deny('employee','Employee\Controller\Travelinglocal' , 'listadmin')
        
        ->deny('employee','Employee\Controller\Travelingabroad' )
        // Paysheet
        ->allow('employee','Payment\Controller\Paysheet' , 'payslip' )
        ->allow('employee','Payment\Controller\Paysheet' , 'generalgross')
        ->allow('employee','Payment\Controller\Paysheet' , 'viewgross')
        ->allow('employee','Payment\Controller\Paysheet' , 'viewpayslip')
        
        ->allow('employee','Employee\Controller\Promotion' , 'report')
        
        ->allow('employee','Employee\Controller\Newemployee' , 'updateinfo')
        ->allow('employee','Employee\Controller\Newemployee' , 'changepassword')
        ->allow('employee','Employee\Controller\Employeeinfo' , 'updateinfo')
        /* over Time And Attendence */
        ->allow('employee','Payment\Controller\Overtimebyemp' , 'add')
        ->allow('employee','Payment\Controller\Overtimebyemp' , 'approve')
        ->allow('employee','Payment\Controller\Overtimebyemp' , 'ajaxlist')
        ->allow('employee','Payment\Controller\Overtimebyemp' , 'approvelist')
        
        ->allow('employee','Payment\Controller\Attenjustification' , 'add')
        ->allow('employee','Payment\Controller\Attenjustification' , 'ajaxlist')
        ->allow('employee','Payment\Controller\Attenjustification' , 'approve')
        
        ->allow('employee','Application\Controller\Attendance' , 'report')
        ->allow('employee','Application\Controller\Attendance' , 'viewreport')
        /*Leaves */
        ->allow('employee','Leave\Controller\Annualleave' , 'add')
        ->allow('employee','Leave\Controller\Annualleave' , 'list')
        ->allow('employee','Leave\Controller\Annualleave' , 'ajaxlist')
        ->allow('employee','Leave\Controller\Annualleave' , 'report')
        ->allow('employee','Leave\Controller\Annualleave' , 'viewreport')
        
        /* PLANNING *********/
        ->allow('planning','Employee\Controller\Newemployee' , 'add')
        ->allow('planning','Employee\Controller\Newemployee' , 'list')
        ->allow('planning','Employee\Controller\Newemployee' , 'ajaxlistnew')
        ->allow('planning','Employee\Controller\Newemployee' , 'listexisting')
        ->allow('planning','Employee\Controller\Newemployee' , 'ajaxlistexisting')
        ->allow('planning','Employee\Controller\Newemployee' , 'report')
         ->allow('planning','Employee\Controller\Newemployee' , 'editexisting')
         ->allow('planning','Employee\Controller\Newemployee' , 'viewreport')
       
        ->allow('planning','Employee\Controller\Newemployee' , 'terminatedreport')
        ->allow('planning','Employee\Controller\Newemployee' , 'viewterminatedreport')
        ->allow('planning','Application\Controller\Employeephoto' , 'upload')
        
         ->allow('planning','Application\Controller\Policymanual' )
         ->allow('planning','Application\Controller\Bank' )   
         ->allow('planning','Application\Controller\Company')
         ->allow('planning','Application\Controller\Usercompanyposition' )
         ->allow('planning','Application\Controller\Sg' )
         ->allow('planning','Application\Controller\Jg' )
         ->allow('planning','Application\Controller\Nationality' )       
         ->allow('planning','Application\Controller\Religion' ) 
         ->allow('planning','Application\Controller\Currency')
         ->allow('planning','Employee\Controller\Promotion' )  
         ->deny('planning','Employee\Controller\Promotion' ,'applypromotion' )  
                                    
         ->allow('planning','Position\Controller\Position' )  
         ->allow('planning','Application\Controller\Section' )  
         ->allow('planning','Application\Controller\Department' )  
         ->allow('planning','Employee\Controller\Location' )  
         ->allow('planning','Position\Controller\Positionmovement' )  
         ->allow('planning','Position\Controller\Positiondescription' )  
         ->allow('planning','Position\Controller\Positionlevel' )  
         ->allow('planning','Position\Controller\Employeetype' )  
         ->allow('planning','Position\Controller\Delegation' )  
         
         ->allow('planning','Lbvf\Controller\Instruction' )  
         ->allow('planning','Lbvf\Controller\Peoplemanagement' )  
         ->allow('planning','Lbvf\Controller\Nomination' )  
         ->allow('planning','Lbvf\Controller\Assessment' )  
         
         ->allow('planning','Pms\Controller\Manage')
         ->allow('planning','Pms\Controller\Pmsform')
         ->allow('planning','Pms\Controller\Myrform')
         ->allow('planning', 'Pms\Controller\Yendform')
         
         ->allow('planning', 'Employee\Controller\Employeeconfirmation' , 'index') 
         
         ->allow('planning', 'Employee\Controller\Employeesuspend' , 'add')   
         ->allow('planning', 'Employee\Controller\Employeesuspend' , 'deletelist')  
         ->allow('planning', 'Employee\Controller\Employeesuspend' , 'report')  
         ->allow('planning', 'Employee\Controller\Employeesuspend' , 'ajaxlist')  
         ->allow('planning', 'Employee\Controller\Employeesuspend' , 'ajaxdellist')  
         
         ->allow('planning', 'Employee\Controller\Employeetermination' , 'ajaxlist')
         ->allow('planning', 'Employee\Controller\Employeetermination' , 'add')
         ->allow('planning', 'Employee\Controller\Employeetermination' , 'terminatedreport')   
         ->allow('planning', 'Employee\Controller\Employeetermination' , 'viewterminatedreport')   

         ->allow('planning', 'Application\Controller\alert')   
         
         /* planningmg*/
        ->allow('planningmg','Employee\Controller\Newemployee' , 'approve')
        ->allow('planningmg', 'Employee\Controller\Employeesuspend' , 'approve')
        ->allow('planningmg', 'Employee\Controller\Employeetermination' , 'approve') 
        ->allow('planningmg','Employee\Controller\Promotion' ,'applypromotion' )
        
        
        /*** PayRoll **/
        
         ->allow('payroll','Employee\Controller\Employeeconfirmation')
         ->allow('payroll','Employee\Controller\Employeeinitial')
         ->allow('payroll','Employee\Controller\Allowancespecialamount')
         ->allow('payroll','Employee\Controller\Employeeconfirmation')
         ->allow('payroll','Employee\Controller\Employeefixedallowance')
         ->allow('payroll','Employee\Controller\Telephone')
         ->allow('payroll','Payment\Controller\Deductionoverpayment')
         ->allow('payroll','Employee\Controller\Salarygradeallowance')
         ->allow('payroll','Employee\Controller\Positionallowance')
         ->allow('payroll','Allowance\Controller\Affectedallowance')
         ->allow('payroll','Allowance\Controller\Paysheetallowance')
         ->allow('payroll','Payment\Controller\Overtimebyemp')
         ->allow('payroll','Application\Controller\Babycareexception')
         ->allow('payroll','Application\Controller\Babycareexception')
         ->allow('payroll','Application\Controller\Attendanceevent')
         ->allow('payroll','Application\Controller\Attendanceeventduration')
         ->allow('payroll','Application\Controller\Attendancegroup')
         ->allow('payroll','Application\Controller\Attendancelocgroup')
         ->allow('payroll','Application\Controller\Attendancegrpworkhrs')
         ->allow('payroll','Payment\Controller\Overtimebyemp')
         ->allow('payroll','Leave\Controller\Annualleave')
         ->allow('payroll','Leave\Controller\Entitlementannualleave')
         ->allow('payroll','Leave\Controller\Leaveadmin')
         ->allow('payroll','Position\Controller\Delegation')
         ->allow('payroll','Payment\Controller\Overtimemanual')
         ->allow('payroll','Application\Controller\Attendance')
         ->allow('payroll','Application\Controller\Openclose')
         ->allow('payroll','Application\Controller\Checklist')
         ->allow('payroll','Payment\Controller\Paysheet')
         ->allow('payroll','Payment\Controller\Leaveallowance')
         ->allow('payroll','Payment\Controller\Carrentposition')
         ->allow('payroll','Payment\Controller\Carrentgroup')
         ->allow('payroll','Payment\Controller\Carrent')
         ->allow('payroll','Payment\Controller\Glassallowance')
         ->allow('payroll','Payment\Controller\Familymember')
         ->allow('payroll','Application\Controller\Familymembertype')
         ->allow('payroll','Application\Controller\Glassamount')
         ->allow('payroll','Payment\Controller\Amortization')
         ->allow('payroll','Payment\Controller\Difference')
         ->allow('payroll','Payment\Controller\Advancehousing')
         ->allow('payroll','Payment\Controller\Advancesalary')
         ->allow('payroll','Payment\Controller\Personalloan')
         ->allow('payroll','Payment\Controller\Repaymentadvance')
         ->allow('payroll','Payment\Controller\Finalentitlement')
         ->allow('payroll','Payment\Controller\Bonuscriteria')
         ->allow('payroll','Payment\Controller\Bonus')
         ->allow('payroll','Payment\Controller\Pfrefund')
         ->allow('payroll','Payment\Controller\Pfrefundtenure')
         ->allow('payroll','Allowance\Controller\Pfshare')
         ->allow('payroll','Employee\Controller\Employeerating')
         ->allow('payroll','Allowance\Controller\Incrementcriteria')
         ->allow('payroll','Allowance\Controller\Quartilerating')
         ->allow('payroll','Allowance\Controller\Salarystructure')
         ->allow('payroll','Employee\Controller\Increment')
      
        
       /*->allow('employee','Payment\Controller\Attenjustification' , 'add')
         ->allow('employee','Payment\Controller\Attenjustification' , 'add')
         ->allow('employee','Payment\Controller\Attenjustification' , 'add')
         ->allow('employee','Payment\Controller\Attenjustification' , 'add')*/
        /** Employee Role 
        ->allow('adminService','Position\Controller\Position')
        ->allow('adminService','Employee\Controller\Location')
        ->allow('adminService','Employee\Controller\Jobgrade')
        ->allow('adminService','Employee\Controller\Employeelocation')
        ->allow('adminService','Employee\Controller\Employeeconfirmation')
        ->allow('adminService','Employee\Controller\Employeetermination')
        ->allow('adminService','Employee\Controller\Employeesuspend')
        ->allow('adminService','Employee\Controller\Promotion')
        ->allow('adminService','Employee\Controller\Salarygradeallowance')
        ->allow('adminService','Employee\Controller\Positionallowance')
        ->allow('adminService','Employee\Controller\Employeeinitial')
        ->allow('adminService','Employee\Controller\Newemployee')
        ->allow('adminService','Position\Controller\Positionmovement')
        ->allow('adminService','Employee\Controller\Employeerating')*/
        // 116 Hr Service
        
        ->allow('116','Application\Controller\Attendance')
        ->allow('116','Application\Controller\Employeeidcard')
        ->allow('116','Payment\Controller\Carrentposition')
        ->allow('116','Payment\Controller\Carrentgroup')
        ->allow('116','Payment\Controller\Carrent')
        ->allow('116','Payment\Controller\Leaveallowance')
        ->allow('116','Payment\Controller\Difference')
        ->allow('116','Payment\Controller\Finalentitlement')
        ->allow('116','Payment\Controller\Advancesalary')
        ->allow('116','Payment\Controller\Overtimebyemp')
        ->allow('116','Payment\Controller\Otmeal')
        ->allow('116','Payment\Controller\Paysheet')
        ->allow('116','Employee\Controller\Telephone')
        ->allow('116','Leave\Controller\Entitlementannualleave')
        ->allow('116','Leave\Controller\Annualleave')
        
        ->allow('hrmanager','Employee\Controller\Affiliationamount')
        ->allow('hrmanager','Employee\Controller\Employeefixedallowance')
        ->allow('hrmanager','Allowance\Controller\Paysheetallowance')
        ->allow('hrmanager','Employee\Controller\Increment')
        ->allow('hrmanager','Allowance\Controller\Socialinsuranceallowance')
        ->allow('hrmanager','Allowance\Controller\Allowancenottohave')
        ->allow('hrmanager','Allowance\Controller\Affectedallowance')
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
        
        $this->allow('1');
        $this->allow('hrmanager');
        
        //$this->deny('1', 'Employee\Controller\Allowancespecialamount');
        //$this->deny('1', 'Leave\Controller\Annualleave','list');
        //$this->deny('1', 'Payment\Controller\Advancehousing','getadvancehousingdetails');
        //$this->deny('admin', 'Employee\Controller\Promotion','getpromotiondetails');
        return $this;
    }
}//--=_mixed 003147984325820F_=--