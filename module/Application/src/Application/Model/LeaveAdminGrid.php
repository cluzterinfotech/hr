<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class LeaveAdminGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Leave Admin list',
			'showPagination' => true,
			'showQuickSearch' => false,
			'showItemPerPage' => true,
			'itemCountPerPage' => 10,
			'showColumnFilters' => true 
	);
	
	// Definition of headers 
	protected $headers = array (
			'id' => array (
				'title' => 'Id',
				'width' => '50' 
			),
			'employeeName' => array (
				'title' => 'Employee Name',
				'filters' => 'text' 
			),
			'leaveName' => array (
				'title' => 'Leave Type',
				'filters' => 'text' 
			),
			'leaveFromDate' => array (
				'title' => 'Leave From',
				//'filters' => 'text' 
			),'leaveToDate' => array (
				'title' => 'Leave To',
				//'filters' => 'text' 
			),
			'edit' => array (
					'title' => 'EDIT'
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
		if ($value = $this->getParamAdapter()->getValueOfFilter('employeeName')) {
			$query->where ( "employeeName like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('leaveName')) {
			$query->where ( "leaveName like '%" . $value . "%' " );
		}
		$this->getHeader('edit')->getCell()->addDecorator('link', array (
				'url' => '/leaveadmin/edit/%s',
				'vars' => array (
						'id'
				),
				'txt' => 'Edit'
		) );
		/* $this->getHeader('delete')->getCell()->addDecorator('link', array(
				'url' => '/location/delete/%s',
				'vars' => array(
						'id'
				),
				'txt' => '<span class="delete">Delete</span>'
		)); */
	}
}
