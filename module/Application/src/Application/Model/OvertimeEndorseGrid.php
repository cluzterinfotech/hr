<?php 

namespace Application\Model;

use ZfTable\AbstractTable;

class OvertimeEndorseGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Overtime Endorse List', 
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
			),'overtimeStatus' => array (
				'title' => 'Status',  
				//'filters' => 'text'
			),'startingDate' => array (
				'title' => 'Starting Date', 
				//'filters' => 'text'
			),'endingDate' => array (
				'title' => 'Ending Date', 
				//'filters' => 'text'
			), 
			'endorse' => array (
				'title' => 'Endorse'
			), 
			'reject' => array (
				'title' => 'Reject',
				'width' => '50' 
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
		if ($value = $this->getParamAdapter()->getValueOfFilter('month')) {
			$query->where ( "month like '%" . $value . "%' " );
		}
        if ($value = $this->getParamAdapter()->getValueOfFilter('year')) {
			$query->where ( "year like '%" . $value . "%' " );
		}
		
		$this->getHeader('endorse')->getCell()->addDecorator('link', array (
				'url' => '/overtimenew/approvehr/%s',
				'vars' => array (
						'id'
				),
				'txt' => 'Endorse'
		)); 
		$this->getHeader('endorse')->getCell()
		     ->addDecorator('class', array('class' => 'approveHrOvertime')); 
        
		$this->getHeader('reject')->getCell()->addDecorator('link', array (
				'url' => '/overtimenew/rejecthr/%s', 
				'vars' => array (
						'id'
				),
				'txt' => 'Reject'
		));   
		$this->getHeader('reject')->getCell()
		     ->addDecorator('class', array('class' => 'rejectHrOvertime'));  
	}   
}   