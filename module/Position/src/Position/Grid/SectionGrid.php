<?php

namespace Position\Grid;

use ZfTable\AbstractTable;

class SectionGrid extends AbstractTable {
	protected $config = array (
			'name' => 'Section List',
			'showPagination' => true,
			'showQuickSearch' => false,
			'showItemPerPage' => true,
			'itemCountPerPage' => 15,
			'showColumnFilters' => true 
	);
	
	// Definition of headers
	protected $headers = array (
			'sectionId' => array (
					'title' => 'Section ID',
					'width' => '100',
					'filters' => 'text' 
			),
			'sectionName' => array (
					'title' => 'Section NAME',
					'filters' => 'text' 
			),
			'sectionCode' => array (
					'title' => 'Section Code',
					'filters' => 'text' 
			),
			
			// 'positionLevelId' => array('title' => 'LEVEL' , 'filters' => 'text'),
			// 'active' => array('title' => 'Active' , 'width' => 100 , 'filters' => array( null => 'All' , 1 => 'Active' , 0 => 'Inactive')),
			'edit' => array (
					'title' => 'EDIT' 
			),
			'delete' => array (
					'title' => 'DELETE',
					'width' => '50' 
			) 
	);
	public function init() {
	}
	protected function initFilters($query) {
		if ($value = $this->getParamAdapter ()->getValueOfFilter ( 'sectionId' )) {
			$query->where ( "sectionId like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter ()->getValueOfFilter ( 'sectionName' )) {
			$query->where ( "sectionName like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter ()->getValueOfFilter ( 'sectionCode' )) {
			$query->where ( "sectionCode like '%" . $value . "%' " );
		}
		/*
		 * if ($value = $this->getParamAdapter()->getValueOfFilter('positionLevelId')) {
		 * $query->where("positionLevelId like '%".$value."%' ");
		 * }
		 */
		
		$this->getHeader ( 'edit' )->getCell ()->addDecorator ( 'link', array (
				'url' => '/section/edit/sectionId/%s',
				'vars' => array (
						'sectionId' 
				),
				'txt' => 'Edit' 
		) );
		$this->getHeader ( 'delete' )->getCell ()->addDecorator ( 'link', array (
				'url' => '/section/delete/sectionId/%s',
				'vars' => array (
						'sectionId' 
				),
				'txt' => '<span class="delete">Delete</span>' 
		) );
		/*
		 * $this->getHeader('name')->getCell()->addDecorator('delete', array(
		 * 'url' => '/table/edit/id/%s',
		 * 'vars' => array('idcustomer'),
		 *
		 * )
		 * );
		 */
	}
}