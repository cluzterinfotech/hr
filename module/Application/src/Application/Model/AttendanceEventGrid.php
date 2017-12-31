<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class AttendanceEventGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Attendance Event list',
			'showPagination' => true,
			'showQuickSearch' => false,
			'showItemPerPage' => true,
			'itemCountPerPage' => 10,
			'showColumnFilters' => true ,
			//'rowAction' => '/babycareexception/updateRow',
	);
	
	// Definition of headers 
	protected $headers = array (
			'id' => array (
					'title' => 'Id',
					'width' => '50' 
			),
			'eventName' => array (
					'title' => 'Event Name',
					'filters' => 'text' 
			),
			/*'startingDate' => array (
					'title' => 'Starting Date',
					//'filters' => 'text' 
			),'endingDate' => array (
					'title' => 'Ending Date',
					//'filters' => 'text' 
			),'noOfMinutes' => array (
					'title' => 'Total Minutes',
					'editable' => true
					//'filters' => 'text' 
			),*/
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
	public function init() { 
		//$this->getHeader('noOfMinutes')->getCell()->addDecorator('editable');
		//$this->getRow()->addDecorator('varattr', 
				//array('name' => 'data-row' , 'value' => '%s' , 'vars' => array('id')));
	}
	
	protected function initFilters($query) {
		if ($value = $this->getParamAdapter()->getValueOfFilter('id')) {
			$query->where ( "id like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('eventName')) {
			$query->where ( "eventName like '%" . $value . "%' " );
		}
		/*if ($value = $this->getParamAdapter()->getValueOfFilter('startingDate')) {
			$query->where ( "startingDate like '%" . $value . "%' " );
		}
		/*if ($value = $this->getParamAdapter()->getValueOfFilter('accountNumber')) {
			$query->where ( "accountNumber like '%" . $value . "%' " );
		}*/
		$this->getHeader('edit')->getCell()->addDecorator('link', array (
				'url' => '/attendanceevent/edit/%s',
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
