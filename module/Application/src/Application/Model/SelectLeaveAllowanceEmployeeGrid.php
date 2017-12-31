<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class SelectLeaveAllowanceEmployeeGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Employee Leave Allowance list',
			'showPagination' => true,
			'showQuickSearch' => false,
			'showItemPerPage' => true,
			'itemCountPerPage' => 15,
			'showColumnFilters' => true 
	); 
	
	// Definition of headers 
	protected $headers = array (
			/* 'id' => array (
				'title' => 'Id',
				'width' => '50' 
			), */ 
			'employeeName' => array (
				'title' => 'Employee Name',
				'filters' => 'text' 
			),
		    'remove' => array (
					'title' => 'REMOVE'
			)/* ,
			'delete' => array (
					'title' => 'DELETE',
					'width' => '50'
			) */
	)
	// 'active' => array('title' => 'Active' , 'width' => 100 , 'filters' => array( null => 'All' , 1 => 'Active' , 0 => 'Inactive')),
	; 
	public function init() { }
	
	protected function initFilters($query) {
		
		if ($value = $this->getParamAdapter()->getValueOfFilter('employeeName')) {
			$query->where ( "employeeName like '%" . $value . "%' " );
		}
		
		$this->getHeader('remove')->getCell()->addDecorator('link', array (
				'url' => '/leaveallowance/remove/%s',
				'vars' => array (
						'id'
				),
				'txt' => 'Remove'
		)); 
		$this->getHeader('remove')->getCell()
		     ->addDecorator('class', array('class' => 'removeRow'));
		
	}
}
