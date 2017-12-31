<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class AttendanceGroupGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Attendance Group list',
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
			),'groupName' => array (
					'title' => 'Group',
					'filters' => 'text' 
			),/*'dayNameFull' => array (
			    'title' => 'Day',
			    //'filters' => 'text'
			),'startTime' => array (
			    'title' => 'Starting Time',
			    //'filters' => 'text'
			),'endTime' => array (
			    'title' => 'Ending Time',
			    //'filters' => 'text'
			),'Status' => array (
			    'title' => 'Day Status',
			    //'filters' => 'text'
			),*/'edit' => array (
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
		if ($value = $this->getParamAdapter()->getValueOfFilter('groupName')) {
			$query->where ( "groupName like '%" . $value . "%' " );
		}
		/*if ($value = $this->getParamAdapter()->getValueOfFilter('branch')) {
			$query->where ( "branch like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('accountNumber')) {
			$query->where ( "accountNumber like '%" . $value . "%' " );
		}*/
		$this->getHeader('edit')->getCell()->addDecorator('link', array (
				'url' => '/attendancegroup/edit/%s',
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
