<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class RamadanAttendanceGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Ramadan Attendance Duration list',
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
			'Reason' => array (
					'title' => 'Reason',
					'filters' => 'text' 
			),
			'startingDate' => array (
					'title' => 'Starting Date',
					'filters' => 'text' 
			),'endingDate' => array (
					'title' => 'Ending Date',
					//'filters' => 'text' 
			),'noOfMinutes' => array (
					'title' => 'Total Minutes',
					//'filters' => 'text' 
			),'edit' => array (
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
		if ($value = $this->getParamAdapter()->getValueOfFilter('Reason')) {
			$query->where ( "Reason like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('startingDate')) {
			$query->where ( "startingDate like '%" . $value . "%' " );
		}
		/*if ($value = $this->getParamAdapter()->getValueOfFilter('accountNumber')) {
			$query->where ( "accountNumber like '%" . $value . "%' " );
		}*/
		$this->getHeader('edit')->getCell()->addDecorator('link', array (
				'url' => '/ramadanexception/edit/%s',
				'vars' => array (
						'id'
				),
				'txt' => 'Edit'
		));  
	}
}
