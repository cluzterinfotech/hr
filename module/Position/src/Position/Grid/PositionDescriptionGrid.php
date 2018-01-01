<?php

namespace Position\Grid;

use ZfTable\AbstractTable;

class PositionDescriptionGrid extends AbstractTable {
	protected $config = array (
			'name' => 'Position Description List',
			'showPagination' => true,
			'showQuickSearch' => false,
			'showItemPerPage' => true,
			'itemCountPerPage' => 15,
			'showColumnFilters' => true 
	); 
	
	// Definition of headers
	protected $headers = array (
			/*'id' => array (
					'title'   => 'POSITION ID',
					'width'   => '100',
					'filters' => 'text' 
			),*/
			'JobPurpose' => array (
					'title'   => 'JOB PURPOSE',
					'filters' => 'text'
			),'positionNam' => array (
					'title'   => 'POSITION NAME',
					'filters' => 'text' 
			),
			// 'active' => array('title' => 'Active' , 'width' => 100 , 'filters' => array( null => 'All' , 1 => 'Active' , 0 => 'Inactive')),
			 'edit' => array (
					'title' => 'EDIT' 
			),/*
			'delete' => array (
					'title' => 'DELETE',
					'width' => '50' 
			)  */
	); 
	
	public function init() { }
	
	protected function initFilters($query) { 		
		if ($value = $this->getParamAdapter()->getValueOfFilter('positionNam')) {
			$query->where ( "positionName like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('JobPurpose')) {
			$query->where ( "JobPurpose like '%" . $value . "%' " );
		}
		
		$this->getHeader ( 'edit' )->getCell ()->addDecorator ( 'link', array (
				'url' => '/positiondescription/edit/%s',
				'vars' => array (
						'id' 
				),
				'txt' => 'Edit' 
		));
		
	}
}