<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class OutstandingBalanceGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Leave Outstanding Balance List',
			'showPagination' => true,
			'showQuickSearch' => false,
			'showItemPerPage' => true,
			'itemCountPerPage' => 10,
			'showColumnFilters' => true 
	);
	
	// Definition of headers
	protected $headers = array (
			/*'id' => array (
			    'title' => 'Id',
				'width' => '50' 
			),*/
			'employeeName' => array (
					'title' => 'Employee Name',
					'filters' => 'text'
			),
			/*'employeeId' => array (
					'title' => 'Employee Number',
					'filters' => 'text' 
			),*/ 
			'balanceDays' => array (
					'title' => 'Number Of Days',
					'filters' => 'text' 
			),
			/*'edit' => array (
					'title' => 'Approve Form'
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
		if ($value = $this->getParamAdapter()->getValueOfFilter('balanceDays')) {
			$query->where ( "balanceDays like '%" . $value . "%' " );
		}
		/*if ($value = $this->getParamAdapter()->getValueOfFilter('leaveTo')) {
			$query->where ( "leaveTo like '%" . $value . "%' " );
		}
		$this->getHeader('edit')->getCell()->addDecorator('link', array (
				'url' => '/annualleave/approve/%s',
				'vars' => array (
						'id'
				),
				'txt' => 'Approve'
		));*/
		/* $this->getHeader('delete')->getCell()->addDecorator('link', array(
				'url' => '/location/delete/%s',
				'vars' => array(
						'id'
				),
				'txt' => '<span class="delete">Delete</span>'
		)); */
	}
}    