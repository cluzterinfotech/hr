<?php 

namespace Application\Model;

use ZfTable\AbstractTable;

class OvertimeApproveGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Overtime Approval List', 
			'showPagination' => true,
			'showQuickSearch' => false,
			'showItemPerPage' => true,
			'itemCountPerPage' => 10, 
			'showColumnFilters' => true,
			//'showExportToCSV ' => true
	);
	
	// Definition of headers 
	protected $headers = array ( 
            'employeeName' => array (
			    'title' => 'Employee Name',
				'filters' => 'text' 
			),
			'employeeNoNOHours' => array (
				'title' => 'NormalHrs',
				//'filters' => 'text' 
			),        
			'employeeNoHOHours' => array (
				'title' => 'HolidayHrs', 
				//'filters' => 'text'
			),'numberOfMeals' => array (
				'title' => 'Total Meals', 
				//'filters' => 'text'
			),/*'startingDate' => array (
				'title' => 'OT From Date',  
				//'filters' => 'text'
			),'endingDate' => array (
				'title' => 'OT To Date', 
				//'filters' => 'text'
			),/*'year' => array (
				'title' => 'Year',  
				'filters' => 'text'
			),*/  
			'approve' => array (
				'title' => 'Approve/Reject'
			), 
			'view' => array (
				'title' => 'View Details',
				//'width' => '50' 
			)  
	) 
	// 'active' => array('title' => 'Active' , 'width' => 100 , 
	//'filters' => array( null => 'All' , 1 => 'Active' , 0 => 'Inactive')),
	;  
	public function init() { }
	
	protected function initFilters($query) {
		
		if ($value = $this->getParamAdapter()->getValueOfFilter('employeeName')) {
			$query->where ( "employeeName like '%" . $value . "%' " );
		}
		/*if ($value = $this->getParamAdapter()->getValueOfFilter('month')) {
			$query->where ( "month like '%" . $value . "%' " );
		}
        if ($value = $this->getParamAdapter()->getValueOfFilter('year')) {
			$query->where ( "year like '%" . $value . "%' " );
		}*/
		
		$this->getHeader('approve')->getCell()->addDecorator('link', array (
				'url' => '/overtimebyemp/approvesup/%s',
				'vars' => array (
						'id'
				),
				'txt' => 'Approve / Reject'
		)); 
		$this->getHeader('approve')->getCell()
		     ->addDecorator('class', array('class' => 'approveOvertime'));
        
		/*$this->getHeader('reject')->getCell()->addDecorator('link', array (
				'url' => '/overtimenew/rejectsup/%s', 
				'vars' => array (
						'id'
				),
				'txt' => 'Reject'
		));   
		$this->getHeader('reject')->getCell()
		     ->addDecorator('class', array('class' => 'rejectOvertime'));*/  
	}   
}   