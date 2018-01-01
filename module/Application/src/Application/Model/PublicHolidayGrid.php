<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class PublicHolidayGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Public Holiday list',
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
			'holidayReason' => array (
				'title' => 'Holiday Reason',
				'filters' => 'text' 
			),'fromDate' => array (
					'title' => 'Holiday From',
					//'filters' => 'text' 
			),'toDate' => array (
					'title' => 'Holiday To',
					//'filters' => 'text' 
			),'Notes' => array (
					'title' => 'Notes',
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
		if ($value = $this->getParamAdapter()->getValueOfFilter('holidayReason')) {
			$query->where ( "holidayReason like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('fromDate')) {
			$query->where("fromDate like '%" . $value . "%' ");
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('toDate')) {
			$query->where("toDate like '%" . $value . "%' "); 
		}
		$this->getHeader('edit')->getCell()->addDecorator('link', array (
				'url' => '/publicholiday/edit/%s',
				'vars' => array (
						'id'
				),
				'txt' => 'Edit'
		));
		/* $this->getHeader('delete')->getCell()->addDecorator('link', array(
				'url' => '/location/delete/%s',
				'vars' => array(
						'id'
				),
				'txt' => '<span class="delete">Delete</span>'
		)); */
	}
}
