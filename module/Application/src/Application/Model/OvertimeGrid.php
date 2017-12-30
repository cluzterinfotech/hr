<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class OvertimeGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Overtime List', 
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
			),'month' => array (
				'title' => 'Month', 
				'filters' => 'text'
			),'year' => array (
				'title' => 'Year',  
				//'filters' => 'text'
			),  
			'edit' => array (
				'title' => 'EDIT'
			), 
			/*'delete' => array (
				'title' => 'DELETE',
				'width' => '50' 
			)*/ 
	) 
	// 'active' => array('title' => 'Active' , 'width' => 100 , 'filters' => array( null => 'All' , 1 => 'Active' , 0 => 'Inactive')),
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
        
		$this->getHeader('edit')->getCell()->addDecorator('link', array (
				'url' => '/overtimenew/edit/%s', 
				'vars' => array (
						'id'
				),
				'txt' => 'Edit/Update'
		));  
		$this->getHeader('edit')->getCell()
		     ->addDecorator('class', array('class' => 'editOvertime')); 
		 
	}
} 
