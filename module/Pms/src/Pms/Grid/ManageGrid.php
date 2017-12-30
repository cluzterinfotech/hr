<?php

namespace Pms\Grid;

use ZfTable\AbstractTable;

class ManageGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'PMS Fisical Year List',
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
			'Close_Year' => array (
					'title'   => 'Status',
					//'filters' => 'text' 
			),'Year' => array (
					'title'   => 'Year',
					'filters' => 'text'
			),/*'levelName' => array (
					'title'   => 'LEVEL',
					'filters' => 'text' 
			),'section' => array (
					'title'   => 'SECTION',
					'filters' => 'text'
			),*/
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
		/*if ($value = $this->getParamAdapter()->getValueOfFilter('id')) {
			$query->where ( "id like '%" . $value . "%' " );
		}*/
		if ($value = $this->getParamAdapter()->getValueOfFilter('Year')) {
			$query->where ( "Year like '%" . $value . "%' " );
		}
		/*if ($value = $this->getParamAdapter()->getValueOfFilter('positionNam')) {
			$query->where ( "positionName like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('section')) {
			$query->where ( "section like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('levelName')) {
			$query->where ( "levelName like '%" . $value . "%' " );
		}*/ 
		/*
		 * $value = $this->getParamAdapter()->getValueOfFilter('active');
		 * if ($value != null) {
		 * $query->where("active = '".$value."' ");
		 *
		 * }
		 */
		$this->getHeader ( 'edit' )->getCell ()->addDecorator ( 'link', array (
				'url' => '/manage/edit/%s',
				'vars' => array (
						'id' 
				),
				'txt' => 'Edit' 
		));
		/*$this->getHeader ( 'delete' )->getCell ()->addDecorator ( 'link', array (
				'url' => '/table/delete/id/%s',
				'vars' => array (
						'id' 
				),
				'txt' => '<span class="delete">Delete</span>' 
		)); */
		
	}
}