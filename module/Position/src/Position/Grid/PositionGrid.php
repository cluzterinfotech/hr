<?php

namespace Position\Grid;

use ZfTable\AbstractTable;

class PositionGrid extends AbstractTable {
	protected $config = array (
			'name' => 'Position List',
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
			'levelName' => array (
					'title'   => 'LEVEL',
					//'filters' => 'text' 
			),'positionNam' => array (
					'title'   => 'POSITION NAME',
					'filters' => 'text' 
			),'sectionCode' => array (
					'title'   => 'SECTION',
					//'filters' => 'text'
			),'locationName' => array (
					'title'   => 'Location',
					//'filters' => 'text'
			),'jobGrade' => array (
			    'title'   => 'Job Grade',
			    //'filters' => 'text'
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
		if ($value = $this->getParamAdapter()->getValueOfFilter('id')) {
			$query->where ( "id like '%" . $value . "%' " );
		}
		/*if ($value = $this->getParamAdapter()->getValueOfFilter('empType')) {
			$query->where ( "empType like '%" . $value . "%' " );
		}*/ 
		if ($value = $this->getParamAdapter()->getValueOfFilter('positionNam')) {
			$query->where ( "positionName like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('section')) {
			$query->where ( "section like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('levelName')) {
			$query->where ( "levelName like '%" . $value . "%' " );
		}
		/*
		 * $value = $this->getParamAdapter()->getValueOfFilter('active');
		 * if ($value != null) {
		 * $query->where("active = '".$value."' ");
		 *
		 * }
		 */
		$this->getHeader ( 'edit' )->getCell ()->addDecorator ( 'link', array (
				'url' => '/position/edit/%s',
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