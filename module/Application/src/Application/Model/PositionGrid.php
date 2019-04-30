<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class PositionGrid extends AbstractTable {
	protected $config = array (
			'name' => 'Filtering by column',
			'showPagination' => true,
			'showQuickSearch' => false,
			'showItemPerPage' => true,
			'itemCountPerPage' => 10,
			'showColumnFilters' => true 
	);
	
	// Definition of headers
	protected $headers = array (
			'positionId' => array (
					'title' => 'Id',
					'width' => '50' 
			),
			'positionName' => array (
					'title' => 'Position Name',
					'filters' => 'text' 
			),
			'positionCode' => array (
					'title' => 'Position Code',
					'filters' => 'text' 
			),
			'sectionId' => array (
					'title' => 'Section',
					'filters' => 'text' 
			) 
	)
	// 'city' => array('title' => 'City'),
	// 'active' => array('title' => 'Active' , 'width' => 100 , 'filters' => array( null => 'All' , 1 => 'Active' , 0 => 'Inactive')),
	;
	public function init() {
	}
	protected function initFilters($query) {
		if ($value = $this->getParamAdapter ()->getValueOfFilter ( 'positionId' )) {
			$query->where ( "name like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter ()->getValueOfFilter ( 'positionName' )) {
			$query->where ( "surname like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter ()->getValueOfFilter ( 'positionCode' )) {
			$query->where ( "street like '%" . $value . "%' " );
		}
		$value = $this->getParamAdapter ()->getValueOfFilter ( 'sectionId' );
		if ($value != null) {
			$query->where ( "active = '" . $value . "' " );
		}
	}
}