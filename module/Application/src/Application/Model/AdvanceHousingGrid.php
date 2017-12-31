<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class AdvanceHousingGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Advance Housing List', 
			'showPagination' => true,
			'showQuickSearch' => false,
			'showItemPerPage' => true,
			'itemCountPerPage' => 10, 
			'showColumnFilters' => true 
	); 
	
	// Definition of headers 
	protected $headers = array (
			/*'id' => array (
					'title' => 'Remove',
					'width' => '50' 
			),*/ 
			'employeeName' => array (
					'title' => 'Employee Name',
					'filters' => 'text' 
			),
			'advanceFromDate' => array (
					'title' => 'Advance From',
					//'filters' => 'text' 
			),
			'totalMonths' => array (
					'title' => 'Total Months',
					'filters' => 'text'
			),
			'advanceAmount' => array (
					'title' => 'Amount ',
					'filters' => 'text'
			),
			'taxAmount' => array (
					'title' => 'Tax ',
					//'filters' => 'text'
			),
			'netAmount' => array (
					'title' => 'Net ',
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
		if ($value = $this->getParamAdapter()->getValueOfFilter('id')) {
			$query->where ( "id like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('employeeId')) {
			$query->where ( "employeeId like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('totalMonths')) {
			$query->where ( "totalMonths like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('advanceAmount')) {
			$query->where ( "advanceAmount like '%" . $value . "%' " );
		}
		
		$this->getHeader('remove')->getCell()->addDecorator('link', array (
				'url' => '/advancehousing/remove/%s',
				'vars' => array (
						'id'
				),
				'txt' => 'Remove'
		)); 
		$this->getHeader('remove')->getCell()
		     ->addDecorator('class', array('class' => 'removeAdvanceHousing')); 
		/* $this->getHeader('delete')->getCell()->addDecorator('link', array(
				'url' => '/location/delete/%s',
				'vars' => array(
						'id'
				),
				'txt' => '<span class="delete">Delete</span>'
		)); */
	}
} 