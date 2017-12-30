<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class CommonStatementGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Common Statement list',
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
			'Notes' => array (
					'title' => 'Notes',
					'filters' => 'text' 
			),
			'bankName' => array (
					'title' => 'Bank',
					'filters' => 'text' 
			),
			'headerSerial' => array (
					'title' => 'Header Serial',
					'filters' => 'text'
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
		if ($value = $this->getParamAdapter()->getValueOfFilter('notes')) {
			$query->where ( "notes like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('bankName')) {
			$query->where ( "bankName like '%" . $value . "%' " );
		}if ($value = $this->getParamAdapter()->getValueOfFilter('headerSerial')) {
			$query->where ( "headerSerial like '%" . $value . "%' " );
		}
		$this->getHeader('edit')->getCell()->addDecorator('link', array (
				'url' => '/commonstatement/edit/%s',
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
