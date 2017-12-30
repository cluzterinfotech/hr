<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class PolicyGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Policy list',
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
					'width' => '20' 
			),
			'title' => array (
					'title' => 'Title',
					'filters' => 'text' ,
			         'width' => '60' 
			),
			'content' => array (
					'title' => 'Content',
			),
			'edit' => array (
					'title' => 'EDIT'
			),'delete' => array (
					'title' => 'DELETE'
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
		if ($value = $this->getParamAdapter()->getValueOfFilter('title')) {
			$query->where ( "title like '%" . $value . "%' " );
		}
		
		$this->getHeader('edit')->getCell()->addDecorator('link', array (
				'url' => '/policymanual/edit/%s',
				'vars' => array (
						'id'
				),
				'txt' => 'Edit'
		) );
		$this->getHeader('delete')->getCell()->addDecorator('link', array(
				'url' => '/policymanual/delete/%s',
				'vars' => array(
						'id'
				),
				'txt' => '<span class="delete">Delete</span>'
		));
	}
}
