<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class PositionLkpGroupGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Lookup Car Rent Group list',
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
			'groupName' => array (
					'title' => 'Group Name',
					'filters' => 'text' 
			),
			'amount' => array (
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
		if ($value = $this->getParamAdapter()->getValueOfFilter('groupName')) {
			$query->where ( "groupName like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('amount')) {
			$query->where ( "amount like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('Notes')) {
			$query->where ( "Notes like '%" . $value . "%' " );
		}
		$this->getHeader('edit')->getCell()->addDecorator('link', array (
				'url' => '/carrentgroup/edit/%s', 
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
