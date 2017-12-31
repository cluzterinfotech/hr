<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class EmployeeConfirmationGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Employee Confirmation list',
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
			'effectiveDate' => array (
				'title' => 'Effective Date',
				'filters' => 'text' 
			),
			'appliedDate' => array (
					'title' => 'Added Date',
					//'filters' => 'text'
			),
			'oldSalary' => array (
					'title' => 'Old Salary',
					//'filters' => 'text'
			),
			'adjustedAmount' => array (
					'title' => 'New Salary',
					//'filters' => 'text'
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
		/*if ($value = $this->getParamAdapter()->getValueOfFilter('id')) {
			$query->where ( "e.id like '%" . $value . "%' " );
		}*/
		if ($value = $this->getParamAdapter()->getValueOfFilter('employeeName')) {
			$query->where ( "employeeName like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('effectiveDate')) {
			$query->where ( "effectiveDate like '%" . $value . "%' " );
		}
		$this->getHeader('remove')->getCell()->addDecorator('link', array (
				'url' => '/employeeconfirmation/remove/%s',
				'vars' => array (
						'id'
				),
				'txt' => 'Remove'
		)); 
		$this->getHeader('remove')->getCell()
		     ->addDecorator('class', array('class' => 'removeRow'));
		/* $this->getHeader('delete')->getCell()->addDecorator('link', array(
				'url' => '/location/delete/%s',
				'vars' => array(
						'id'
				),
				'txt' => '<span class="delete">Delete</span>'
		)); */
	}
}
