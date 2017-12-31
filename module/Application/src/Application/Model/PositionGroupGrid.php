<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class PositionGroupGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Position Group list',
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
			'positionName' => array (
					'title' => 'Position Name',
					'filters' => 'text' 
			),
			'groupName' => array (
					'title' => 'Group Name',
					'filters' => 'text' 
			),
			'Amount' => array (
					'title' => 'Amount',
					'filters' => 'text'
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
		/*if ($value = $this->getParamAdapter()->getValueOfFilter('id')) {
			$query->where ( "id like '%" . $value . "%' " );
		}*/ 
		if ($value = $this->getParamAdapter()->getValueOfFilter('positionName')) {
			$query->where ( "positionName like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('groupName')) {
			$query->where ( "groupName like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('Amount')) {
			$query->where ( "Amount like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('Notes')) {
			$query->where ( "Notes like '%" . $value . "%' " );
		}
		$this->getHeader('edit')->getCell()->addDecorator('link', array (
				'url' => '/carrentposition/edit/%s', 
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
